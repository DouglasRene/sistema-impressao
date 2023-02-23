<?php
require_once __DIR__."/../models/User.php";
require_once __DIR__."/../models/Message.php";
require __DIR__. '/../../views/PHPMailer/src/Exception.php';
require __DIR__. '/../../views/PHPMailer/src/PHPMailer.php';
require __DIR__. '/../../views/PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserDAO implements UserDAOInterface
{

  private $conn;
  private $url;
  private $message;

  public function __construct(PDO $conn, $url)
  {
    $this->conn = $conn;
    $this->url = $url;
    $this->message = new Message($url);
  }

  public function buildUser($data)
  {

    $user =  new User();

    $user->id = $data["id"];
    $user->name = $data["nome"];
    $user->email = $data["email"];
    $user->password = $data["password"];
    $user->token = $data["token"];
    $user->adm = $data["adm"];
    $user->caps_id = $data["caps_id"];

    return $user;
  }

  public function create(User $user, $authUser = false)
  {

    $stmt = $this->conn->prepare("INSERT INTO usuarios(
      nome, email, password, token, adm, caps_id
      ) VALUES (
        :nome, :email, :password, :token, :adm, :caps_id
      )");

    $stmt->bindParam(":nome", $user->name);
    $stmt->bindParam(":email", $user->email);
    $stmt->bindParam(":password", $user->password);
    $stmt->bindParam(":token", $user->token);
    $stmt->bindParam(":adm", $user->adm);
    $stmt->bindParam(":caps_id", $user->caps_id);

    $stmt->execute();

    // Autenticar usuário, caso auth seja true
    if ($authUser) {
      $this->setTokenToSession($user->token);
    }
    $this->message->setMessage("Conta cadastrada com sucesso!", "success", "?file=newprofile");
  }

  public function update(User $user, $redirect = "editprofile")
  {

    $stmt = $this->conn->prepare("UPDATE usuarios SET 
      nome = :nome,
      email = :email,
      token = :token,
      caps_id = :caps_id
      WHERE id = :id
    ");

    $stmt->bindParam(":nome", $user->name);
    $stmt->bindParam(":email", $user->email);
    $stmt->bindParam(":token", $user->token);
    $stmt->bindParam(":caps_id", $user->caps_id);
    $stmt->bindParam(":id", $user->id);
    
    $stmt->execute();

    if ($redirect) {
      $this->message->setMessage("Dados atualizados com sucesso!", "success", "?file=$redirect");
    }

  }

  public function verifyToken($protected = false)
  {

    if (!empty($_SESSION["token"])) {

      // Pega o token da session
      $token = $_SESSION["token"];
      $user = $this->findByToken($token);

      if ($user) {
        return $user;
      } else if ($protected) {

        // Redireciona usuário não autenticado
        $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "?file=login");
      }
    } else if ($protected) {

      // Redireciona usuário não autenticado
      $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "?file=login");
    }
  }

  public function setTokenToSession($token, $redirect = true)
  {

    // Salver token na session
    $_SESSION["token"] = $token;

    if ($redirect) {

      // Redireciona para o perfil do usuário
      $this->message->setMessage("Seja bem-vindo!", "success", "index.php");
    }
  }

  public function authenticateUser($email, $password)
  {

    $user  = $this->findByEmail($email);

    if($user) {

      // Checar se as senhas batem
      if(password_verify($password, $user->password)) {

        // Gerar um token e inserir na session
        $token = $user->generateToken();

        $this->setTokenToSession($token, false);

        // Atualizar token no usuário
        $user->token = $token;

        $this->update($user, false);

        return true;

      } else {
        return false;
      }
    } else {
      return false;
    }

  }

  public function findByEmail($email)
  {

    if ($email != "") {

      $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email");
      $stmt->bindParam(":email", $email);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    }
  }

  public function findById($id)
  {
    if ($id != "") {

      $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    }
  }

  public function findAll() {
    $users = [];
    $stmt = $this->conn->prepare("SELECT * FROM usuarios ORDER BY caps_id" );
      $stmt->bindParam(":id", $id);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $userArray = $stmt->fetchAll();

        foreach ($userArray as $user) {
            $users[] = $this->buildUser($user);
        }
    }
    return $users;
  }

  public function findByToken($token)
  {

    if ($token != "") {

      $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE token = :token");
      $stmt->bindParam(":token", $token);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {

        $data = $stmt->fetch();
        $user = $this->buildUser($data);

        return $user;
      } else {
        return false;
      }
    }
  }

  public function destroyToken()
  {

    // Remove o token da session
    $_SESSION["token"] = "";
    $this->message->setMessage("Você fez o logout com sucesso!", "success", " ");
  }

  public function changePassword(User $user)  {
    $stmt = $this->conn->prepare("UPDATE usuarios SET password = :password WHERE id = :id");

    $stmt->bindParam(":password", $user->password);
    $stmt->bindParam(":id", $user->id);

    $stmt->execute();

    $this->message->setMessage("Senha alterada com sucesso!", "success", "?file=editprofile");

  }

  public function delete($id) {
    $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");

    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $this->message->setMessage("Conta excluida com sucesso!", "success", "?file=gerenciarcontas");
  }

  public function recuperarSenhar($email) {

    $mail = new PHPMailer(true);

    $result_usuario = $this->conn->prepare("SELECT id,nome, email FROM usuarios WHERE email = :email LIMIT 1");
    $result_usuario->bindParam(':email',$email, PDO::PARAM_STR);
    $result_usuario->execute();
    
    if(($result_usuario) && ($result_usuario->rowCount() != 0)){
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        $chave_recuperar_senha = password_hash($row_usuario['id'], PASSWORD_DEFAULT);
        
        $result_up_usuario = $this->conn->prepare("UPDATE usuarios SET recuperar_senha =:recuperar_senha WHERE id =:id LIMIT 1");
        $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
        $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);

        if($result_up_usuario->execute()){
            $link = "<a href='http://portalcolaborador.candido.org.br/teste/sisraas/?file=atualizar_senha&chave=$chave_recuperar_senha'>Clique aqui</a>";
            try{
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'ti@candido.org.br';                    //SMTP username
                $mail->Password   = '8EpB1Sth';                             //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect

                 //Recipients
                $mail->setFrom('ti@candido.org.br', 'Suporte');
                $mail->addAddress($row_usuario['email'], $row_usuario['nome']);     //Add a recipient

                 //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Recupeção de senha';
                $mail->Body    = 'Prazado(a) &nbsp;' .$row_usuario['nome']."<br>Você solicitou alteração de sua senha.<br>
                Para continuar o processo de recuperação de senha, clique no link abaixo: <br><br>" . $link . "<br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha parmanecerá a mesma até que você ative este código.<br>";
                
                $mail->AltBody = 'Olá &nbsp;' .$row_usuario['nome']."\nVocê solicitou alteração de sua senha.\n
                Para continuar o processo de recuperação de senha, clique no link abaixo: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha parmanecerá a mesma até que você ative este código.\n";

                $mail->send();
                $this->message->setMessage("E-mail enviado com instruções para recuperar senha. Acesso a sua caixa de e-mail para recuperar a senha!", "success", "back");
                header("Location: ?file=login");

            }catch (Exception $e) {
                $this->message->setMessage("O E-mail não pôde ser enviada. Verifique o email cadastrado", "error", "back");
            }
        }else{
            $this->message->setMessage("Erro, tente novamente!", "error", "back");
        }
    }else{
        $this->message->setMessage("Usuario não cadastrado!", "error", "back");
    }
  }
}
