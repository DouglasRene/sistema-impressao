<?php
$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);
$formularioDao = new FormularioDAO($conn, $BASE_URL);
$formularios = $formularioDao->findAllForCapsId($userData->caps_id);
$profissionais = $formularioDao->getProfissForCapsId($userData->caps_id);
$passagem = count($formularios);
$ativos = array_count_values(array_column($formularios, 'status'))['Ativo'];
$inativos = array_count_values(array_column($formularios, 'status'))['Inativo'];
$filtro_centro_saude_ = [];
$filtro_entrada_saida_ = [];
foreach ($formularios as $formulario) {
    $filtro_centro_saude_[] = $formulario->centro_saude;
    $filtro_entrada_saida_[] = $formularioDao->getLastDataHistorico($formulario->cns)[0];
}
$filtro_centro_saude[] = array_unique($filtro_centro_saude_, SORT_REGULAR);
$filtro_entrada_saida[] = array_unique($filtro_entrada_saida_);
$formularios_page = array_chunk($formularios, 30);
$page = filter_input(INPUT_GET, "page");
if (empty($page)) {
    $page = 0;
}
?>
<style>
    tbody tr:hover {
        cursor: pointer;
    }

    .table-striped thead tr:nth-of-type(odd) {
        cursor: pointer;
        background-color: #75c594;
    }

    th {
        text-align: center;
        align-items: center;
    }

    input::placeholder {
        text-align: center;
    }

    .pdf_gera {
        display: flex;
        flex-direction: column;
        width: 270px;
        justify-content: center;
        text-align: center;
        align-items: center;
    }

    .pdf_gera span {
        font-size: 14px;
        font-weight: 700;
        margin: 5px;
    }

    .pdf_gera .limit {
        width: 50%;
    }

    select {
        width: 80%;
        height: 30px;
        border-radius: 10px;
        background-color: #75c594;
        font-weight: bold;
    }
</style>
<div class="m-5 g-contas">
    <div style="float: right;">
        <p>
            <span style="color: green; border: 1px solid; padding: 5px;">Cadastrados: <b><?= $passagem ?></b></span>
        </p>
        <hr>
        <p>
            <span style="color: green; border: 1px solid; padding: 5px;">Ativos: <b><?= $ativos != "" ? $ativos : "0"  ?></b></span>
        </p>
        <hr>
        <p>
            <span style="color: red; border: 1px solid; padding: 5px;">Inativos: <b><?= $inativos != "" ? $inativos : "0" ?></b></span>
        </p>
        <hr>
    </div>
    <h2 style="text-align: center;">Lista de Pacientes</h2>
    <div class="mb-4">
        <form action="views/formulariopdfativos.php" method="post" class="pdf_gera">
            <input type="hidden" name="limit" value="0">
            <input type="hidden" name="caps_id" id="caps_id" value="<?= $userData->caps_id ?>">
            <input type="hidden" name="qtd_total" value="<?= count($formularios); ?>">
            <span>Slecione para gerar por profissional</span>
            <select name="filtro_prof" id="filtro_prof" style="width: 80%;">
                <option selected name="profssional" value="todos">Todos</option>
                <?php foreach ($profissionais as $profissional) : ?>
                    <option name="profssional" value="<?= $profissional["cbo"] ?>"><?= $profissional["nome"] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Gerar" class="btn transition gradient gradient-green gradient-hover m-3 w-50" onclick="this.form.target='_blank';return true;">
        </form>
    </div>
    <nav style="display: flex; justify-content: flex-end !important;">
        <ul class="pagination">
            <li class="page-item">
                <a href="index.php?file=listapacientes&page=<?= $page > 3 ? $page - 2 : 1 ?>" style="text-decoration: none;"><span class="page-link" style="background-color: #777; color: #FFF;">Previous</span></a>
            </li>
            <?php if ($page == 1) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=1" style="background-color: #777; color: #FFF;">1</a></li>
                <li class="page-item"> &nbsp;&nbsp;</li>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page - 2 : 1 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page - 2 : 1 ?></a></li>
            <?php endif;
            if ($page == 2) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link">2</span></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page - 1 : 2 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page - 1 : 2 ?></a>
                </li>
            <?php endif;
            if ($page > 3) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link"><?= $page > 3 ? $page : 3 ?></span></li>
            <?php elseif ($page == 3) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link">3</span></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page : 3 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page : 3 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 1) : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page + 1 : 4 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page + 1 : 4 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 2) : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page + 2 : 5 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page + 2 : 5 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 3) : ?>
                <li class="page-item"> &nbsp;&nbsp;</li>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= count($formularios_page) - 1 ?>" style="background-color: #777; color: #FFF;"><?= count($formularios_page) - 1 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?file=listapacientes&page=<?= $page + 1 ?>" style="background-color: #777; color: #FFF;">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="col-md-12">
        <table class="table table-striped table-white" id="tabela">
            <thead>
                <tr>
                    <th scope="col">Nome: </th>
                    <th scope="col">CNS: </th>
                    <th scope="col">Profissional Ref: </th>
                    <th scope="col">Centro de Saúde: </th>
                    <th scope="col">Ativo / Inativo: </th>
                    <th scope="col">Entrada / Saida: </th>
                </tr>
                <tr>
                    <th scope="col"><input type="text" id="usuario" style="width: 80%;"></th>
                    <th scope="col"><input type="text" id="cns" style="width: 80%;"></th>
                    <th scope="col">
                        <select name="cns_prof" class="cns_prof" id="filtroColuna_3">
                            <option value="Todos">Todos</option>

                        </select>
                    </th>
                    <th scope="col">
                        <select name="centros_saude" class="centros_saude" id="filtroColuna_4">
                            <option value="Todos">Todos</option>
                        </select>
                    </th>
                    <th scope="col">
                        <select name="ativo_inativo" class="ativo_inativo" id="filtroColuna_5">
                            <option value="Todos">Todos</option>
                            <option value="A">A</option>
                            <option value="I">I</option>
                        </select>
                    </th>
                    <th scope="col">
                        <select name="entrada_saida" class="entrada_saida" id="filtroColuna_6">
                            <option value="Todos">Todos</option>

                        </select>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if ($formularios) : ?>
                    <?php foreach ($formularios_page[$page] as $formulario) : ?>
                        <tr class="filtrado" onclick="location.href='?file=formulario&select_busca=update&pesquisa=<?= $formulario->cns ?>'" style="text-align: center;">
                            <td scope="row"><?= $formulario->usuario ?></td>
                            <td><?= $formulario->cns ?></td>
                            <?php if ($formulario->prof_referenc === "" || $formulario->prof_referenc === "NULL" || empty($formulario->prof_referenc)) : ?>
                                <td>Sem Referência!</td>
                            <?php else : ?>
                                <?php foreach ($profissionais as $profissional) : ?>
                                    <?php if ($formulario->prof_referenc == $profissional["cbo"]) : ?>
                                        <td><?= $profissional["nome"] ?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <td><?= $formulario->centro_saude ?></td>
                            <td><?= $formulario->status === "Inativo" ? "I" : "A" ?></td>
                            <td><?= $formularioDao->getLastDataHistorico($formulario->cns)[0] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <td colspan="6">Não possui pacientes!</td>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav style="display: flex; justify-content: flex-end !important;">
        <ul class="pagination">
            <li class="page-item">
                <a href="index.php?file=listapacientes&page=<?= $page > 3 ? $page - 2 : 1 ?>" style="text-decoration: none;"><span class="page-link" style="background-color: #777; color: #FFF;">Previous</span></a>
            </li>
            <?php if ($page == 1) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <?php elseif ($page > 3) : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=1" style="background-color: #777; color: #FFF;">1</a></li>
                <li class="page-item"> &nbsp;&nbsp;</li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page - 2 : 1 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page - 2 : 1 ?></a></li>
            <?php endif;
            if ($page == 2) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link">2</span></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page - 1 : 2 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page - 1 : 2 ?></a>
                </li>
            <?php endif;
            if ($page > 3) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link"><?= $page > 3 ? $page : 3 ?></span></li>
            <?php elseif ($page == 3) : ?>
                <li class="page-item active" aria-current="page"><span class="page-link">3</span></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page : 3 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page : 3 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 1) : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page + 1 : 4 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page + 1 : 4 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 2) : ?>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= $page > 3 ? $page + 2 : 5 ?>" style="background-color: #777; color: #FFF;"><?= $page > 3 ? $page + 2 : 5 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 3) : ?>
                <li class="page-item"> &nbsp;&nbsp;</li>
                <li class="page-item"><a class="page-link" href="index.php?file=listapacientes&page=<?= count($formularios_page) - 1 ?>" style="background-color: #777; color: #FFF;"><?= count($formularios_page) - 1 ?></a></li>
            <?php endif;
            if ($page < count($formularios_page) - 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?file=listapacientes&page=<?= $page + 1 ?>" style="background-color: #777; color: #FFF;">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<script src="../assets/js/listapacientes.js"></script>