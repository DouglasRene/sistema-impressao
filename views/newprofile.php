<?php 
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true); 

if($userData->adm !== "S") {
    $message->setMessage("Acesso restrito!", "error", "?file=home");
}
?>

<div>
    <h2 style="text-align: center;" class="mt-3">Criar Conta</h2>
<div class="col-md-12" id="register-container">
    <form action="<?php $BASE_URL ?>assets/process/auth_process.php" method="post">
        <input type="hidden" name="type" value="register">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail">
        </div>
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome">
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite o a senha">
        </div>
        <div class="form-group">
            <label for="confirmpassword">Confirmação de senha:</label>
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a senha">
        </div>
        <div class="form-group">
            <label for="caps">Caps:</label>
            <select name="caps" id="caps" class="form-control">
                <option value="">Selecione</option>
                <option value="12">Caps A. Orlando</option>
                <option value="11">Caps Reviver</option>
                <option value="10">Caps Esperança</option>
                <option value="9">Caps Toninho</option>
                <option value="8">Caps independencia</option>
                <option value="7">Caps Integração</option>
                <option value="6">Caps Estação</option>
                <option value="5">Caps David</option>
                <option value="4">Caps Carretel</option>
                <option value="3">Caps Criativo</option>
                <option value="2">Caps Novo Tempo</option>
                <option value="1">Sede</option>
            </select>
        </div>
        <div class="form-group">
            <label for="adm">ADM:</label>
            <select name="adm" id="adm" class="form-control">
                <option value="">Selecione</option>
                <option value="S">Sim</option>
                <option value="N">Não</option>
            </select>
        </div>
        <input type="submit" value="Registrar" class="btn btn-primary mb-5">
    </form>
</div>
</div>
