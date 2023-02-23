<?php
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

?>
<style>
    select:disabled {
        background: #fff;
        color: #000;
    }
</style>
<h3 style="text-align: center;" class="mt-3">Altere seus dados no formulário abaixo:</h3>
<div id="main-container" class="container-fluid">
    <div class="col-md-12 edit-profile-page">
        <form action="<?php $BASE_URL ?>assets/process/user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <h1><?= $fullName ?></h1>
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite o seu nome" value="<?= $userData->email ?>">
            </div>
            <div class="form-group">
                <label for="caps">Caps:</label>
                <select name="caps" id="caps" class="form-control" <?php if ($userData->adm !== "S") echo "disabled" ?>>
                    <option value="">Selecione</option>
                    <option value="12" <?= $userData->caps_id === 12 ? "selected" : "" ?>>Caps A. Orlando</option>
                    <option value="11" <?= $userData->caps_id === 11 ? "selected" : "" ?>>Caps Reviver</option>
                    <option value="10" <?= $userData->caps_id === 10 ? "selected" : "" ?>>Caps Esperança</option>
                    <option value="9" <?= $userData->caps_id === 9 ? "selected" : "" ?>>Caps Toninho</option>
                    <option value="8" <?= $userData->caps_id === 8 ? "selected" : "" ?>>Caps independencia</option>
                    <option value="7" <?= $userData->caps_id === 7 ? "selected" : "" ?>>Caps Integração</option>
                    <option value="6" <?= $userData->caps_id === 6 ? "selected" : "" ?>>Caps Estação</option>
                    <option value="5" <?= $userData->caps_id === 5 ? "selected" : "" ?>>Caps David</option>
                    <option value="4" <?= $userData->caps_id === 4 ? "selected" : "" ?>>Caps Carretel</option>
                    <option value="3" <?= $userData->caps_id === 3 ? "selected" : "" ?>>Caps Criativo</option>
                    <option value="2" <?= $userData->caps_id === 2 ? "selected" : "" ?>>Caps Novo Tempo</option>
                    <?php if ($userData->adm === "S") : ?><option value="1" <?= $userData->caps_id === 1 ? "selected" : "" ?>>Sede</option><?php endif; ?>
                </select>
            </div>
            <input type="submit" class="btn btn-primary mb-5" value="Alterar">
        </form>
        <div id="change-password-container">
            <h3>Alterar a senha:</h3>
            <p class="">Digite a nova senha e confirme, para alterar sua senha:</p>
            <form action="<?php $BASE_URL ?>assets/process/user_process.php" method="POST">
                <input type="hidden" name="type" value="changepassword">
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua nova senha">
                </div>
                <div class="form-group">
                    <label for="confirmpassword">Confirmação de senha:</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a sua nova senha">
                </div>
                <input type="submit" class="btn btn-primary mb-5" value="Alterar Senha">
            </form>
        </div>
    </div>
</div>
