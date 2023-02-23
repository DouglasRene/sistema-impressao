<?php
//header('Content-type: text/html; charset=iso-8859-1');

$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

require_once("autocomplete.php");

$pesquisa = filter_input(INPUT_GET, "select_busca");
$busca = filter_input(INPUT_GET, "pesquisa");

if ($pesquisa === "update") {
    $formulario = $formularioDao->getformulariobyUserCns($busca, $userData->caps_id);
    if(!$formulario) {
	return $message->setMessage("Cadastro não encontrado!", "error", "?file=listapacientes");
    }
}
if ($pesquisa === "cns") {
    $formulario = $formularioDao->getformularioByUserCns($busca);
    if (!$formulario) {
        return $message->setMessage("Cadastro não encontrado!", "error", "?file=formulario");
    }
} elseif ($pesquisa === "usuario") {
    $formulario = $formularioDao->getformularioByUserName($busca);
    if (!$formulario) {
        return $message->setMessage("Cadastro não encontrado!", "error", "?file=formulario");
    }
}
//echo "<script>window.history.pushState('Object', 'new url', 'https://printraas.candido.org.br/?file=formulario')</script>";
$profissionais = $formularioDao->getProfissForCapsId($userData->caps_id);
$historico = $formularioDao->getHistoricoFromCns($formulario->cns);
?>
<?php if ($pesquisa !== "update" || $formulario->caps_id !== $userData->caps_id): ?>
    <style>
        .check {
            pointer-events: none;
        }
    </style>

<?php endif; ?>
<div class="col-md-12">
    <div class="col-auto mb-4">
        <form class="row" action="assets/process/formulario_process.php" method="post">
            <input type="hidden" name="type" value="pesquisar">
            <input type="hidden" name="file" value="formulario">
            <div class="col-auto">
                <label for="select_busca">Pesquisar por:</label>
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
    <?php if ($formulario->n_prontuario && $formulario->caps_id === $userData->caps_id && $formulario->status == "Ativo") : ?>
        <form action="views/pdf.php" method="post" id="form_pdf">
            <?php foreach ($profissionais as $profissional) : ?>
                <?php if ($formulario->prof_referenc == $profissional["cbo"]) : ?>
                    <input type="hidden" name="nome_profissional" value="<?= $profissional["nome"] ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            <?php foreach ($formulario as $dados => $dado) : ?>
                <input type="hidden" name="<?= $dados ?>" value="<?= $dado ?>">
            <?php endforeach; ?>
            <input type="submit" value="Gerar PDF" onclick="this.form.target='_blank';return true;" class="btn transition gradient gradient-green gradient-hover m-2 " style="float: left;">
        </form>
    <?php endif; ?>
    <form action="assets/process/formulario_process.php" method="post">
        <input type="hidden" name="type" value="update">
        <?php if ($formulario->n_prontuario && $formulario->caps_id === $userData->caps_id && $formulario->status == "Ativo") : ?>
            <input type="submit" value="Atualizar Cadastro" class="btn transition gradient gradient-green gradient-hover m-2 " style="float: right;">
        <?php endif; ?>
        <div class="formulario">
            <div class="cabecalho mb-3">
                <span class="logo"><img src="assets/image/logo.jpg" alt="Logo Candido"></span>
                <div style="text-align: center;">
                    <p class="m-0 p-0">RAAS POR PACIENTE E CONSULTA MÉDICA</p>
                    <p class="m-0 p-0">https://candido.org.br</p>
                </div>
                <span class="logo_sus"><img src="assets/image/logo_sus.JPG" alt="Logo SUS"></span>
            </div>
            <div class="tb-1">
		<table>
		<?php if($pesquisa === "update"): ?>
                    <tr style="border-bottom: 1px solid;">
			<td>CAPS: <strong><?= $formulario->caps ?></strong>
                            <input type="hidden" name="caps_user" value="<?= $userData->caps_id ?>">
                            <input type="hidden" name="caps" value="<?= $formulario->caps ?>">
                        </td>
                        <td colspan="2">CNES: <input class="check checkInativo" type="text" style="width: 80%;" name="cnes" value="<?= $formulario->cnes == "" ? "" : $formulario->cnes ?>" readonly></td>
			<td>Nº Prontuário: <input class="check checkInativo" type="text" style="width: 60%;" name="n_prontuario" value="<?= $formulario->n_prontuario == "" ? "" : $formulario->n_prontuario ?>" readonly></td>
                        <td colspan="2">Mês/Ano Atendimento: <input class="check checkInativo" type="text" style="width: 50%;" name="mes_ano_atend" value="<?= $formulario->mes_ano_atend == "" ? "" : $formulario->mes_ano_atend ?>"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid;">
                        <td colspan="2">Usuário: <input class="check checkInativo checkInativo" type="text" style="width: 80%;" name="usuario" value="<?= $formulario->usuario == "" ? "" : $formulario->usuario ?>"></td>
			<td colspan="2">CNS: <input class="check checkInativo" type="number" style="width: 80%;" name="cns" value="<?= $formulario->cns == "" ? "" : $formulario->cns ?>">
<input type="hidden" name="cns_old" value="<?= $formulario->cns ?>"></td>
                        <td colspan="2">Data Admissão Usuário <input class="check checkInativo" type="text" style="width: 50%;" name="dt_admiss_usr" value="<?= $formulario->dt_admiss_usr == "" ? "" : $formulario->dt_admiss_usr ?>"></td>
		    </tr>
		<?php endif; ?>
                    <tr style="border-bottom: 1px solid;">
                        <td colspan="2">Data Nasc: <input class="check checkInativo" type="text" style="width: 80%;" name="dt_nasc" value="<?= $formulario->dt_nasc == "" ? "" : $formulario->dt_nasc ?>"></td>
                        <td colspan="2">Nome da Mãe: <input class="check checkInativo" type="text" style="width: 75%;" name="nome_mae" value="<?= $formulario->nome_mae == "" ? "" : $formulario->nome_mae ?>"></td>
                        <td colspan="2">Responsável: <input class="check checkInativo" type="text" style="width: 70%;" name="responsavel" value="<?= $formulario->responsavel == "" ? "" : $formulario->responsavel ?>"></td>
                    </tr>
                    <tr style="border-bottom: 1px solid;">
                        <td>Raça / Cor: <input class="check checkInativo" type="text" style="width: 60%;" name="raca_cor" value="<?= $formulario->raca_cor == "" ? "" : $formulario->raca_cor ?>"></td>
                        <td>Etnia Indigena: <input class="check checkInativo" type="text" style="width: 60%;" name="etnia_indigena" value="<?= $formulario->etnia_indigena == "" ? "" : $formulario->etnia_indigena ?>"></td>
                        <td>SEXO: M: <input class="check checkInativo" type="radio" id="M" style="width: 15%;" value="M" name="sexo" <?= $formulario->sexo == "M" ? "checked" : "false" ?>> F: <input class="check checkInativo" type="radio" style="width: 15%;" value="F" id="F" name="sexo" <?= $formulario->sexo == "F" ? "checked" : "false" ?>> </td>
                        <td>Tel. Contato: <input class="check checkInativo" type="text" style="width: 60%;" name="telefone" value="<?= $formulario->telefone == "" ? "" : $formulario->telefone ?>"></td>
                        <td colspan="2">
                            <div class="col m-0 p-0 w-100">Centro de saúde:
                                <input class="check checkInativo" type="text" class="autocomplete" style="width: 60%;" id="centro_saude" name="centro_saude" value="<?= $formulario->centro_saude == "" ? "" : $formulario->centro_saude ?>">
                            </div>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid;">
                        <td colspan="3">Endereço: <input class="check checkInativo" type="text" style="width: 80%;" name="endereco" value="<?= $formulario->endereco == "" ? "" : $formulario->endereco ?>"></td>
                        <td>Mun. Residência: <input class="check checkInativo" type="text" style="width: 40%;" name="mun_res" value="<?= $formulario->mun_res == "" ? "" : $formulario->mun_res ?>"> &nbsp; UF: SP</td>
                        <td>CEP: <input class="check checkInativo" type="text" style="width: 60%;" name="cep" value="<?= $formulario->cep == "" ? "" : $formulario->cep ?>"></td>
			<td>Nacionalidade: <input class="check checkInativo" type="text" style="width: 50%;" name="nacional" value="<?= $formulario->nacional == "" ? "" : $formulario->nacional ?>"></td>
                    </tr>
                    <tr style="border: none;">
                        <td colspan="6">Usuário de Álcool e Outras Drogas: <input class="check checkInativo" type="radio" style="width: 1%;" name="alcool_drogas" value="S" <?= $formulario->alcool_drogas == "S" ? "checked" : "false" ?>> S&nbsp;&nbsp; <input class="check checkInativo" type="radio" style="width: 1%;" name="alcool_drogas" value="N" <?= $formulario->alcool_drogas == "N" ? "checked" : "false" ?>> N Se SIM:&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="alcool" value="S" style="width: 1%;" <?= $formulario->alcool == "S" ? "checked" : "false" ?>> Álcool&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="crack" value="S" style="width: 1%;" <?= $formulario->crack == "S" ? "checked" : "false" ?>> Crack&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="cocaina" value="S" style="width: 1%;" <?= $formulario->cocaina == "S" ? "checked" : "false" ?>> Cocaina&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="cannabis" value="S" style="width: 1%;" <?= $formulario->cannabis == "S" ? "checked" : "false" ?>> Cannabis&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" style="width: 1%;" <?= $formulario->outras_drogas !== "" ? "checked" : "false" ?>> Outras: <input class="check checkInativo" type="text" style="width: 30%;" name="outras_drogas" value="<?= $formulario->outras_drogas == "" ? "" : $formulario->outras_drogas ?>"> &nbsp;&nbsp;&nbsp;&nbsp;Situação de Rua:&nbsp;&nbsp; <input class="check checkInativo" type="radio" style="width: 1%;" value="S" name="situacao_rua" <?= $formulario->situacao_rua == "S" ? "checked" : "false" ?>> S <input class="check checkInativo" type="radio" style="width: 1%;" value="N" name="situacao_rua" <?= $formulario->situacao_rua == "N" ? "checked" : "false" ?>> N </td>
                    </tr>
                    <tr style="border: none;">
                        <td colspan="6">Origem:&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="demanda_espontanea" value="S" style="width: 1%;" <?= $formulario->demanda_espontanea == "S" ? "checked" : "false" ?>> Demanda Espntânea&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="ubs" value="S" style="width: 1%;" <?= $formulario->ubs == "S" ? "checked" : "false" ?>> UBS&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="serv_u_e" value="S" style="width: 1%;" <?= $formulario->serv_u_e == "S" ? "checked" : "false" ?>> Serv. U/E&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="outro_caps" value="S" style="width: 1%;" <?= $formulario->outro_caps == "S" ? "checked" : "false" ?>> Outro CAPS&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="hosp_geral" value="S" style="width: 1%;" <?= $formulario->hosp_geral == "S" ? "checked" : "false" ?>> Hosp. Geral&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" name="hosp_psiqui" value="S" style="width: 1%;" <?= $formulario->hosp_psiqui == "S" ? "checked" : "false" ?>> Hosp. Psiquiátrico&nbsp;&nbsp; <input class="check checkInativo" type="checkbox" style="width: 1%;" <?= $formulario->origem_outros !== "" ? "checked" : "false" ?>> Outro: <input class="check checkInativo" type="text" style="width: 30%;" name="origem_outros" value="<?= $formulario->origem_outros == "" ? "" : $formulario->origem_outros ?>"> </td>
                    </tr>
                </table>
                <table border="1" class="tb-2 mt-2">
                    <tr style="border: none;">
                        <td colspan="16">
                            <div class="col m-0 p-0" style="width: 100%;">
                                CID10 Principal:
                                <input class="check checkInativo" type="text" class="autocomplete" id="cid10_princ" name="cid10_princ" style="width: 80%;" value="<?= $formulario->cid10_princ == "" ? "" : $formulario->cid10_princ ?>">
                            </div>
			</td>
			<td colspan="2">Cód. IBGE Munic:<strong> 3509512 </strong></td>
                    </tr>
                    <tr style="border-top: 1px solid;">
                        <td colspan="18">
                            <div class="col m-0 p-0" style="width: 100%;">
                                CID 10 Causas Associadas:
                                <input class="check checkInativo" type="text" class="autocomplete" id="cid10_caus_assoc" name="cid10_caus_assoc" style="width: 70%;" value="<?= $formulario->cid10_caus_assoc == "" ? "" : $formulario->cid10_caus_assoc ?>">
                            </div>
                    </tr>
                    <tr>
                        <td colspan="6">Existe Estratégia de Saúde da Familia: <input class="check checkInativo" type="radio" name="estrategia_sau_fam" value="S" style="width: 5%; margin-top: 2px" <?= $formulario->estrategia_sau_fam == "S" ? "checked" : "false" ?>> S <input class="check checkInativo" type="radio" name="estrategia_sau_fam" value="N" style="width: 5%;" <?= $formulario->estrategia_sau_fam == "N" ? "checked" : "false" ?>> N</td>
                        <td colspan="12">CNS: <strong><?= $formulario->cns ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="8">Encaminhamento: &nbsp;<input class="check" type="radio" name="encaminhamento" value="cont_acomp_caps" style="width: 2%; margin-top: 2px" <?= $formulario->encaminhamento == "cont_acomp_caps" ? "checked" : "false" ?>>&nbsp;Continuidade do Acomp. em CAPS&nbsp;&nbsp;&nbsp;&nbsp;<input class="check" type="radio" name="encaminhamento" value="cont_aten_basica" style="width: 2%; margin-top: 2px" <?= $formulario->encaminhamento == "cont_aten_basica" ? "checked" : "false" ?>> &nbsp;Continuidade na Atenção Básica&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="check" type="radio" name="encaminhamento" value="alta" style="width: 2%; margin-top: 2px" <?= $formulario->encaminhamento == "alta" ? "checked" : "false" ?>> &nbsp;Alta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="check" type="radio" name="encaminhamento" value="obito" style="width: 2%; margin-top: 2px" <?= $formulario->encaminhamento == "obito" ? "checked" : "false" ?>> &nbsp;Óbito&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="radio" name="encaminhamento" class="check" value="abandono" style="width: 2%; margin-top: 2px;" <?= $formulario->encaminhamento == "abandono" ? "checked" : "false" ?>> Abandono
                        </td>
                        <td colspan="10">
                            <div class="d-flex flex-row">
                                <label for="Ativo">Ativo</label>
                                <input type="radio" id="Ativo" name="status" value="Ativo" class="m-1" <?= $formulario->status == "Ativo" ? "checked" : "false" ?>>
                                <label for="Inativo">Inativo</label>
                                <input type="radio" id="Inativo" name="status" value="Inativo" class="ml-1" <?= $formulario->status == "Inativo" ? "checked" : "false" ?>>
                                <div style="width: 10%; height: 20px;">
                                    <?php if ($formulario->status === "Inativo" && $formulario->caps_id === $userData->caps_id) : ?>
                                        <button class="btn btn-primary ml-3" style="font-size: 10px; height: 20px; position: absolute; display: flex; justify-content: center; align-items:center;">Ativar</button>
                                    <?php endif; ?>
                                    <?php if ($formulario->status === "Ativo" && $formulario->caps_id === $userData->caps_id) : ?>
                                        <button class="btn btn-danger ml-3" style="font-size: 10px; height: 20px; position: absolute; display: flex; justify-content: center; align-items:center;">Desativar</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="align-center">
                        <td>ACOLH. <br> NOTURNO</td>
                        <td>ACOLH. <br> DIURNO</td>
                        <td>ATEND. <br> INDIV</td>
                        <td>ATEND. <br> GRUPO</td>
                        <td>ATEND. <br> FAM.</td>
                        <td>ATEND. <br> DOMIC.</td>
                        <td>PRAT. <br> CORP.</td>
                        <td>PRAT. <br> EXP./COM.</td>
                        <td>ATENÇÂO <br> CRISE</td>
                        <td>AÇÔES REAB. <br> PSICOSSOCIAL</td>
                        <td>PROM. <br> CONTRAT.</td>
                        <td rowspan="2" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td rowspan="2">Carimbo / Assinatura</td>
                        <td rowspan="2" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CBO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="font-size: 8px;">Local Ação <br> </td>
                    </tr>
                    <tr class="align-center">
                        <td>030108002-0</td>
                        <td>030108019-4</td>
                        <td>030108020-8</td>
                        <td>030108021-6</td>
                        <td>030108022-4</td>
                        <td>030108024-0</td>
                        <td>030108027-5</td>
                        <td>030108028-3</td>
                        <td>030108029-1</td>
                        <td>030108034-8</td>
                        <td>030108035-6</td>
                        <td style="font-size: 8px;">C-CAPS <br> T - Território</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td></td>
                    </tr>
                    <tr style="border: none; font-size: 12px;">
                        <td colspan="10">Profissional Referência:
                            <select class="check checkInativo" name="prof_referenc" style="width: 50%;">
                                <option value="">Selecione</option>
                                <?php foreach ($profissionais as $profissional) : ?>
                                    <option value="<?= $profissional["cbo"] ?>" <?= $formulario->prof_referenc == $profissional["cbo"] ? "selected" : "" ?>><?= $profissional["nome"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td colspan="5">DATA DE FECHAMENTO:___/___/____</td>
                        <td colspan="2">RAAS-SSCF</td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <?php
    if (count($historico) > 0) : ?>
        <?php foreach ($historico as $hist) : ?>
            <div class="historico">
                <span style="color: <?= $hist["type"] ?>; font-size: 12px; font-weight: bold; text-transform: uppercase;"><?= $hist["historico"]  ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
    document.getElementById("select_busca").addEventListener("click", () => {
        if (document.getElementById("select_busca").value === "usuario") {
            autocomplete(document.getElementById("myInput"), countries_name);
        }
        if (document.getElementById("select_busca").value === "cns") {
            autocomplete(document.getElementById("myInput"), countries_cns);
        }
        if (document.getElementById("select_busca").value === "prontuario") {
            autocomplete(document.getElementById("myInput"), countries_prontuario);
        }
    })

    document.getElementById("cid10_princ").addEventListener("input", () => {
        texxto = document.getElementById("cid10_princ").value
        if (texxto.length > 1) {
            if (texxto[1] > 1) {
                autocomplete(document.getElementById("cid10_princ"), countries_cid_10_f2)
            } else {
                autocomplete(document.getElementById("cid10_princ"), countries_cid_10_f1)
            }
        }
    })

    document.getElementById("cid10_caus_assoc").addEventListener("input", () => {
        texxto = document.getElementById("cid10_caus_assoc").value
        if (texxto.length > 1) {
            if (texxto[1] > 1) {
                autocomplete(document.getElementById("cid10_caus_assoc"), countries_cid_10_f2)
            } else {
                autocomplete(document.getElementById("cid10_caus_assoc"), countries_cid_10_f1)
            }
        }
    })
    autocomplete(document.getElementById("centro_saude"), countries_centros_saude)
</script>

