<article class="auth">
    <div class="auth_content container content">
        <header class="auth_header">
            <h1>Atualizar Senha</h1>
        </header>
        <?php
        $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
        if (!empty($chave)) {

            $query_usuario = "SELECT id
                                FROM usuarios
                                WHERE recuperar_senha = :recuperar_senha
                                LIMIT 1";
            $result_usuario = $conn->prepare($query_usuario);
            $result_usuario->bindParam(':recuperar_senha', $chave, PDO::PARAM_STR);
            $result_usuario->execute();

            if (($result_usuario) && ($result_usuario->rowCount() != 0)) {
                $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($dados['SendNovaSenha'])) {
                    $password = password_hash($dados['password'], PASSWORD_DEFAULT);
                    $recuperar_senha = 'NULL';

                    $query_up_usuario = "UPDATE usuarios 
                                        SET password =:password,
                                        recuperar_senha =:recuperar_senha 
                                        WHERE id =:id 
                                        LIMIT 1";
                    $result_up_usuario = $conn->prepare($query_up_usuario);
                    $result_up_usuario->bindParam(':password', $password, PDO::PARAM_STR);
                    $result_up_usuario->bindParam(':recuperar_senha', $recuperar_senha);
                    $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);

                    if ($result_up_usuario->execute()) {
                        $message->setMessage("Senha Atualizada com sucesso", "success", "back");
                        header("Location: ?file=login");
                    } else {
                        $message->setMessage("Erro, tente novamente!", "error", "back");
                    }
                }
            } else {
                $message->setMessage("Link invalido! Solicite um novo link para atualizar a senha!", "error", "back");
                header("Location: ?file=recuperar_senha");
            }
        } else {
            $message->setMessage("Link invalido! Solicite um novo link para atualizar a senha!", "error", "back");
            header("Location: ?file=recuperar_senha");
        }
        ?>

        <form class="auth_form" action="" method="POST">

            <input type="hidden" name="SendNovaSenha" value="Atualizar">
            <label>
                <div><span class="icon-user-tie"> Nova senha:</span></div>
                <input type="password" name="password" placeholder="Digite a nova senha"/>
            </label>
            <button type="submit" class="auth_form_btn transition gradient gradient-green gradient-hover">Atualizar</button>
        </form>
    </div>
</article>