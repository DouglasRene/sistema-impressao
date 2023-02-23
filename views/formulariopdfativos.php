<?php
require __DIR__ . "/../assets/process/globals.php";
require __DIR__ . "/../assets/process/db.php";
require_once __DIR__ . "/../assets/dao/FormularioDAO.php";
$formularioDao = new FormularioDAO($conn, $BASE_URL);

$caps_id = filter_input(INPUT_POST, "caps_id");
$qtd_total = filter_input(INPUT_POST, "qtd_total");
$limit = filter_input(INPUT_POST, "limit");
$filtro_prof = filter_input(INPUT_POST, "filtro_prof");
$passaporte = filter_input(INPUT_GET, "passaporte");
$qtd_total2 = filter_input(INPUT_GET, "qtd_total");
$caps_id2 = filter_input(INPUT_GET, "caps_id");
$filtro_prof2 = filter_input(INPUT_GET, "filtro_prof2"); 

$limit = 0;

if ($passaporte >= 1) {
    $limit = $passaporte * 10;
}

if (empty($caps_id)) {
    $caps_id = $caps_id2;
}

if (empty($passaporte)) {
    $passaporte = 1;
} else {
    $passaporte += 1;
}

if (empty($qtd_total2)) {
    $qtd_total2 = $qtd_total;
}

if(empty($filtro_prof2)) {
    $filtro_prof2 = $filtro_prof;
}

if($filtro_prof2 == "todos") {
    $formularios = $formularioDao->getAllFormAtivo($caps_id, $limit, 10, $filtro_prof2);
} else {
    if($passaporte == 1) {
        $qtd_total2 = $formularioDao->countProfissional($filtro_prof2, $caps_id)[0];
    }
    $formularios = $formularioDao->getAllFormAtivo($caps_id, $limit, 10, $filtro_prof2);
    if(empty($qtd_total2)) {
        echo "<script>alert('Não existe pacientes para este profissional!')</script>";
        echo "<script>close()</script>";
    }
}

$formularios = $formularioDao->getAllFormAtivo($caps_id, $limit, 10, $filtro_prof2);
$profissionais = $formularioDao->getProfissForCapsId($caps_id);
$img_logo = file_get_contents("https://portalcolaborador.candido.org.br/teste/sisraas/assets/image/logo.jpg");
$img64_logo = base64_encode($img_logo);
$img_sus = file_get_contents("https://portalcolaborador.candido.org.br/teste/sisraas/assets/image/logo_sus.JPG");
$img64_sus = base64_encode($img_sus);
?>
<!DOCTYPE html>
<html lang="pt-br">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700;900&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .formulario1 {
        width: 100%;
        padding: 20px;
    }

    * {
        color: #000;
        font-weight: 500;
    }

    .formulario2 {
        width: 100%;
        padding: 20px;
    }

    table {
        width: 100%;
    }

    .cabecalho {
        margin-bottom: 40px;
        height: 30px;
    }

    .align-center {
        text-align: center;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no">
    <title>PRINTSRAAS - Sistema de Impressão prontuário</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/boot.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<div class="div-loaded" style="background-color: rgba(0, 0, 0, 0.8); position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; display: flex; display: flex; justify-content: center; align-items: center; z-index: 1;"><span id="loaded" style="width: 50px; height: 25px; background-color: #fff; text-align: center;"></span><b style="color: #FFF; margin: 0 5px 0 5px;">%</b><span style="width: 50px; height: 25px; background-color: #fff; text-align: center;"><?= $passaporte ?> / <?= round($qtd_total2 / 10) +1 ?></span><img style="width: 200px; height: 200px;" src="../assets/image/engrenagem.gif"></div>
<input type="hidden" name="qtd_total" id="qtd_total" value="<?= $qtd_total2 ?>">
<input type="hidden" name="passaporte" id="passaporte" value="<?= $passaporte ?>">
<input type="hidden" name="caps_id" id="caps_id" value="<?= $caps_id ?>">
<input type="hidden" name="filtro_prof2" id="filtro_prof2" value="<?= $filtro_prof2 ?>">
<script>
    pdfId = []
</script>

<body id="body">
    <?php
    $pdfPage = 0;
    $pdfPage1 = 0;
    foreach ($formularios as $dados) : ?>
        <div class="formulario1" id="pdf-<?= $pdfPage += 1 ?>">
            <?php echo "<script>pdfId.push('pdf-" . $pdfPage . "')</script>"; ?>
            <div class="cabecalho">
                <span style="float: left;"><img src="data:image/jpg;base64,<?= $img64_logo ?>" alt="Logo Candido" style="width: 80px; height: 50px; margin-top: 10px;"></span>
                <div style="text-align: center;">
                    <p class="m-0 p-0" style="font-size: 16px;">RAAS POR PACIENTE E CONSULTA MÉDICA</p>
                    <p style="font-size: 10px;" class="m-0 p-0">https://candido.org.br</p>
                </div>
                <span style="float: right;"><img src="data:image/jpg;base64,<?= $img64_sus ?>" alt="Logo SUS" style="width: 100px; margin-bottom: 15px; margin-top: 20px;"></span>
            </div>
            <table style="font-size: 10px;">
                <tr>
                    <td style="border-bottom: 1px solid;">CAPS: <strong><?= $dados["caps"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">CNES: <strong><?= $dados["cnes"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Nº Prontuário: <strong><?= $dados["n_prontuario"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Mês/Ano Atendimento: <strong><?= $dados["mes_ano_atend"] ?></strong></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;" colspan="2">Usuário: <strong><?= $dados["usuario"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">CNS: <strong><?= $dados["cns"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Data Admissãao Usuário: <strong><?= $dados["dt_admiss_usr"] ?></strong></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;" colspan="2">Data Nasc: <strong><?= $dados["dt_nasc"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Nome da Mãe: <strong><?= $dados["nome_mae"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Responsável: <strong><?= $dados["responsavel"] ?></strong></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;">Raça / Cor: <strong><?= $dados["raca_cor"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Etnia Indigena: <strong><?= $dados["etnia_indigena"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">SEXO: M: (<strong><?= $dados["sexo"] == "M" ? "X" : "&nbsp;" ?></strong>) F: (<strong><?= $dados["sexo"] == "F" ? "X" : "&nbsp;" ?></strong>)</td>
                    <td style="border-bottom: 1px solid;" colspan="2">Tel. Contato: <strong><?= $dados["telefone"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Centro de Saúde: <strong><?= $dados["centro_saude"] ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-bottom: 1px solid;">Endereço: <strong><?= $dados["endereco"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Mun. Residência: <strong><?= $dados["mun_res"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">UF: <strong>SP</strong></td>
                    <td style="border-bottom: 1px solid;">CEP: <strong><?= $dados["cep"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Nacionalidade: <strong><?= $dados["nacional"] ?></strong></td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6">Usuário de Álcool e Outras Drogas: ( <strong><?= $dados["alcool_drogas"] == "S" ? "X" : "&nbsp;" ?></strong> ) S&nbsp;&nbsp; ( <strong><?= $dados["alcool_drogas"] == "N" ? "X" : "&nbsp;" ?></strong> ) N Se SIM:&nbsp;&nbsp; ( <strong><?= $dados["alcool"] == "S" ? "X" : "&nbsp;" ?></strong> ) Álcool&nbsp;&nbsp; ( <strong><?= $dados["crack"] == "S" ? "X" : "&nbsp;" ?></strong> ) Crack&nbsp;&nbsp; ( <strong><?= $dados["cocaina"] == "S" ? "X" : "&nbsp;" ?></strong> ) Cocaina&nbsp;&nbsp; ( <strong><?= $dados["cannabis"] == "S" ? "X" : "&nbsp;" ?></strong> ) Cannabis&nbsp;&nbsp; ( <strong><?= $dados["outras_drogas"] !== "" ? "X" : "&nbsp;" ?></strong> ) Outras: <strong><?= $dados["outras_drogas"] == "" ? "&nbsp;" : $dados["outras_drogas"] ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;Situação de Rua:&nbsp;&nbsp; ( <strong><?= $dados["situacao_rua"] == "S" ? "X" : "&nbsp;" ?></strong> ) S ( <strong><?= $dados["situacao_rua"] == "N" ? "X" : "&nbsp;" ?></strong> ) N </td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6">Origem:&nbsp;&nbsp; ( <strong><?= $dados["demanda_espontanea"] == "S" ? "X" : "&nbsp;" ?></strong> ) Demanda Espntânea&nbsp;&nbsp; ( <strong><?= $dados["ubs"] == "S" ? "X" : "&nbsp;" ?></strong> ) UBS&nbsp;&nbsp; ( <strong><?= $dados["serv_u_e"] == "S" ? "X" : "&nbsp;" ?></strong> ) Serv. U/E&nbsp;&nbsp; ( <strong><?= $dados["outro_caps"] == "S" ? "X" : "&nbsp;" ?></strong> ) Outro CAPS&nbsp;&nbsp; ( <strong><?= $dados["hosp_geral"] == "S" ? "X" : "&nbsp;" ?></strong> ) Hosp. Geral&nbsp;&nbsp; ( <strong><?= $dados["hosp_psiqui"] == "S" ? "X" : "&nbsp;" ?></strong> ) Hosp. Psiquiátrico&nbsp;&nbsp; ( <strong><?= $dados["origem_outros"] !== "" ? "X" : "&nbsp;" ?></strong> ) Outro: <strong><?= $dados["origem_outros"] == "" ? "" : $dados["origem_outros"] ?></strong> </td>
                </tr>
            </table>
            <table border="1" style="font-size: 10px;">
                <tr>
                    <td colspan="17" style="border: none;">CID10 Principal: <strong><?= $dados["cid10_princ"] == "" ? "" : $dados["cid10_princ"] ?></strong></td>
                    <td colspan="4">Cód. IBGE Munic: <strong>3509512</strong></td>
                </tr>
                <tr>
                    <td colspan="21" style="border-left: none; border-right: none;">CID 10 Causas Associadas: <strong><?= $dados["cid10_caus_assoc"] == "" ? "" : utf8_encode($dados["cid10_caus_assoc"]) ?></strong> </td>
                </tr>
                <tr>
                    <td colspan="8">Existe Estratégia de Saúde da Familia: ( <strong><?= $dados["estrategia_sau_fam"] == "S" ? "X" : "&nbsp;" ?></strong> ) S ( <strong><?= $dados["estrategia_sau_fam"] == "N" ? "X" : "&nbsp;" ?></strong> ) N</td>
                    <td colspan="13">CNS: <strong><?= $dados["cns"] ?></strong></td>
                </tr>
                <tr>
                    <td colspan="21">Encaminhamento: ( <strong><?= $dados["encaminhamento"] === "cont_acomp_caps" ?  "X" : " " ?></strong> ) &nbsp;Continuidade do Acomp. em CAPS&nbsp;&nbsp;&nbsp;&nbsp;( <strong><?= $dados["encaminhamento"] === "cont_aten_basica" ?  "X" : " " ?></strong> ) &nbsp;Continuidade na Atenção Básica&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alta &nbsp;( <strong><?= $dados["encaminhamento"] === "alta" ?  "X" : " " ?></strong> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Óbito( <strong><?= $dados["encaminhamento"] === "obito" ?  "X" : " " ?></strong> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abandono ( <strong><?= $dados["encaminhamento"] === "abandono" ?  "X" : " " ?></strong> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data Conclusão ______/______/_______ </td>
                </tr>
            </table>
            <table border="1" style="font-size: 9px;">
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
                    <td rowspan="2" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td rowspan="2" colspan="2">Carimbo / Assinatura</td>
                    <td rowspan="2" colspan="3" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CBO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="font-size: 8px;">Local Ação</td>
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
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6">Profissional Referência:
                        <?php foreach ($profissionais as $profissional) : ?>
                            <strong><?= $dados["prof_referenc"] == $profissional["cbo"] ? $profissional["nome"] : "" ?></strong>
                        <?php endforeach; ?>
                    </td>
                    <td colspan="7">CNS: <strong><?= $dados["prof_referenc"] ?></strong></td>
                    <td colspan="5">DATA DE FECHAMENTO:______/______/_______</td>
                    <td colspan="3">RAAS-SSCF</td>
                </tr>
            </table>
        </div>
        <div class="formulario2" id="pdf-<?= $pdfPage += 1 ?>">
            <?php echo "<script>pdfId.push('pdf-" . $pdfPage . "')</script>"; ?>
            <table border="1" style="font-size: 9px;">
                <tr>
                    <td colspan="21" style="border: none;">USUÁRIO (Nome completo): <strong><?= $dados["usuario"] ?></strong></td>
                </tr>
                <tr>
                    <td colspan="21" style="border-left: none; border-right: none;">DN: <strong><?= $dados["dt_nasc"] ?></strong></td>
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
                    <td rowspan="2" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DATA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td rowspan="2" colspan="2">Carimbo / Assinatura</td>
                    <td rowspan="2" colspan="3" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CBO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="font-size: 8px;">Local Ação</td>
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
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="4"></td>
                    <td colspan="2"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr style="border: none; font-size: 8px;">
                    <td colspan="6">Profissional Referência:
                        <?php foreach ($profissionais as $profissional) : ?>
                            <strong><?= $dados["prof_referenc"] == $profissional["cbo"] ? $profissional["nome"] : "" ?></strong>
                        <?php endforeach; ?>
                    </td>
                    <td colspan="7">CNS: <strong><?= $dados["prof_referenc"] ?></strong></td>
                    <td colspan="5"> <span> DATA DE FECHAMENTO:______/______/_______</span></td>
                    <td colspan="3">RAAS-SSCF</td>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        promisePrint = async (pdfId) => {
            var pdf = new jsPDF({
                orientation: "l",
                unit: "mm",
                format: "a4",
                compression: true
            });

            var i = 1;

            for (let k = 0; k < pdfId.length; k++) {
                await Promise.resolve(html2canvas(document.getElementById(pdfId[k]), {
                        scale: 2,
                        logging: true
                    })
                    .then(async (canvas) => {
                        const data = canvas.toDataURL("image/jpeg")
                        pdf.addImage(data, "JPEG", 0, 0, 297, 210, undefined, "FAST")
                        pdf.addPage()
                        let porcentagem = k * 100 / pdfId.length;
                        $("#loaded").html(Math.round(porcentagem))
                        console.log(k)
                        if (k == (pdfId.length - 1)) {
                            pdf.save("printraas")
                            $("#loaded").html("100")
                        }
                    }))
            };
        }


        $(document).ready(() => {
            let qtd_total = $("#qtd_total").val()
            let passaporte = $("#passaporte").val()
            let caps_id = $("#caps_id").val() 
            let filtro_prof2 = $("#filtro_prof2").val()
            promisePrint(pdfId).then(() => {
                if (passaporte > Math.round(qtd_total / 10)+ 1) {
                    close()
                } else {
                    setTimeout(() => {
                        window.location = "https://printraas.candido.org.br/teste/views/formulariopdfativos.php?qtd_total=" + qtd_total + "&passaporte=" + passaporte + "&caps_id=" + caps_id + "&filtro_prof2=" + filtro_prof2
                    }, 1000)
                }

            })
        })
    </script>
</body>

</html>