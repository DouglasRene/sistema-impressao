<article class="auth">
        <div class="auth_content container content">
            <header class="auth_header">
                <h1>Fazer Login</h1>
            </header>
            <form class="auth_form" action="<?php $BASE_URL ?>assets/process/auth_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="login">
                <label>
                    <div><span class="icon-user-tie"> Login:</span></div>
                    <input type="email" name="email" placeholder="Informe seu login:" />
                </label>
                <label>
                    <div class="unlock-alt">
                        <span class="icon-unlocked"> Senha:</span>
                        <a href="?file=recuperar_senha" class="esqueceu-senha">Esqueceu a senha?</a>
                    </div>
                    <input type="password" name="password" placeholder="Informe sua senha:" />
                </label>
                <label class="check">
                    <input type="checkbox" name="save" />
                    <span>Lembrar dados?</span>
                </label>
                <button class="auth_form_btn transition gradient gradient-green gradient-hover">Entrar</button>
            </form>
        </div>
    </article> 
