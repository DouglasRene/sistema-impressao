<?php
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

// require_once("assets/dao/FormularioDAO.php");
require_once("views/autocomplete.php");

?>
<div class="col-md-12">
    <div class="col-auto">
        <form class="row" action="assets/process/formulario_process.php" method="post">
            <input type="hidden" name="type" value="pesquisar">
            <input type="hidden" name="file" value="home">
            <div class="col-auto">
                <label for="select_busca">Buscar por:</label>
                <select name="select_busca" id="select_busca" class="form-control">
                    <option value="">Selecione</option>
                    <option value="cns">CNS</option>
                    <option value="usuario">Usuário</option>
                </select>
            </div>
            <div class="col-md-4">
                <label style="color:transparent;" for="pesquisa">Buscar</label>
                <input type="text" class="form-control autocomplete" id="myInput" name="pesquisa" placeholder="Pesquisar...">
            </div>
            <div class="col-auto">
                <label style="color:transparent;">botao</label>
                <input type="submit" value="Pesquisar" class="btn transition gradient gradient-green gradient-hover mt-4">
            </div>
            <div class="col-auto" style="float: right;">
                <label style="color:transparent;">botao</label>
                <a href="<?php $BASE_URL ?>?file=cadastro" class="btn transition gradient gradient-green gradient-hover mt-4">Cadastrar</a>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("select_busca").addEventListener("click", () => {
        if (document.getElementById("select_busca").value === "usuario") {
            autocomplete(document.getElementById("myInput"), countries_name);
        } if(document.getElementById("select_busca").value === "cns") {
            autocomplete(document.getElementById("myInput"), countries_cns);
        } if(document.getElementById("select_busca").value === "prontuario") {
            autocomplete(document.getElementById("myInput"), countries_prontuario);
        }
    })
</script> 
