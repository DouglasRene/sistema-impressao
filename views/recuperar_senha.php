<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true); 

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($dados['type'] === "recuperar") {
    $query_usuario = "SELECT id,nome, email
                FROM usuarios
                WHERE email = :email
                LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':email',$dados['recuperasenha'],
    PDO::PARAM_STR);
    $result_usuario->execute();
    
    if(($result_usuario) && ($result_usuario->rowCount() != 0)){
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        $chave_recuperar_senha = password_hash($row_usuario['id'], PASSWORD_DEFAULT);
        
        $query_up_usuario = "UPDATE usuarios 
                    SET recuperar_senha =:recuperar_senha 
                    WHERE id =:id 
                    LIMIT 1";
        $result_up_usuario = $conn->prepare($query_up_usuario);
        $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
        $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);

        if($result_up_usuario->execute()){
            $link = "<a href='http://printraas.candido.org.br/?file=atualizar_senha&chave=$chave_recuperar_senha'>Clique aqui</a>";
            try{
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'exemple@exemple.com';                    //SMTP username
                $mail->Password   = 'exemple';                             //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect

                 //Recipients
                $mail->setFrom('exemple@exemple.com', 'Suporte');
                $mail->addAddress($row_usuario['email'], $row_usuario['nome']);     //Add a recipient

                 //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Recupeção de senha';
                $mail->Body    = 'Prazado(a) &nbsp;' .$row_usuario['nome']."<br>Você solicitou alteração de sua senha.<br>
                Para continuar o processo de recuperação de senha, clique no link abaixo: <br><br>" . $link . "<br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha parmanecerá a mesma até que você ative este código.<br>";
                
                $mail->AltBody = 'Olá &nbsp;' .$row_usuario['nome']."\nVocê solicitou alteração de sua senha.\n
                Para continuar o processo de recuperação de senha, clique no link abaixo: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha parmanecerá a mesma até que você ative este código.\n";

                $mail->send();
                $message->setMessage("E-mail enviado com instruções para recuperar senha. Acesso a sua caixa de e-mail para recuperar a senha!", "success", "back");
                header("Location: ?file=login");

            }catch (Exception $e) {
                $message->setMessage("O E-mail não pôde ser enviada. Verifique o email cadastrado", "error", "back");
            }
        }else{
            $message->setMessage("Erro, tente novamente!", "error", "back");
        }
    }else{
        $message->setMessage("Usuario não cadastrado!", "error", "back");
    }
}
?>
<article class="auth">
    <div class="auth_content container content">
        <header class="auth_header">
            <h1>Recuperar Senha</h1>
        </header>
        <form class="auth_form" action="" method="post">
        <input type="hidden" name="type" value="recuperar">
            <label>
                <div><span class="icon-user-tie"> E-mail:</span></div>
                <input type="email" name="recuperasenha" placeholder="Informe seu E-mail:" />
            </label>
            <button type="submit" class="auth_form_btn transition gradient gradient-green gradient-hover">Recuperar</button>
        </form>
    </div>
</article>
