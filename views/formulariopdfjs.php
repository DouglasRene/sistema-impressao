<?php
$img_logo = file_get_contents("https://portalcolaborador.candido.org.br/teste/sisraas/assets/image/logo.jpg");
$img64_logo = base64_encode($img_logo);
$img_sus = file_get_contents("https://portalcolaborador.candido.org.br/teste/sisraas/assets/image/logo_sus.JPG");
$img64_sus = base64_encode($img_sus);
?>
<!DOCTYPE html>
<html lang="pt-br">
<style>
    .formulario1 {
        margin: 0;
        padding: 0;
    }

    .cabecalho {
        margin-bottom: 25px;
        padding: 0;
        font-size: 20px;
    }

    .tb-1 {
        font-size: 16px;
    }

    .align-center {
        text-align: center;
    }
</style>

<head>
    <meta charset="UTF-8">
    <title>PRINTRAAS - Sistema de Impressão prontuário</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/boot.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="formulario1">
        <div class="cabecalho">
            <span style="float: left;"><img src="data:image/jpg;base64,<?= $img64_logo ?>" alt="Logo Candido" class="logo-pdf"></span>
            <div style="text-align: center;">
                <p class="m-0 p-0">RAAS&nbsp; POR&nbsp; PACIENTE&nbsp; E&nbsp; CONSULTA&nbsp; MÉDICA</p>
                <p style="font-size: 10px;" class="m-0 p-0">https://candido.org.br</p>
            </div>
            <span style="float: right;"><img src="data:image/jpg;base64,<?= $img64_sus ?>" alt="Logo SUS" class="logo-pdf" style="margin-top: 20px;"></span>
        </div>
        <div class="tb-1">
        <table>
                <tr>
                    <td style="border-bottom: 1px solid;">CAPS: <strong><?= $_POST["caps"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">CNES: <strong><?= $_POST["cnes"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Nº Prontuário: <strong><?= $_POST["n_prontuario"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Mês/Ano Atendimento: <strong><?= $_POST["mes_ano_atend"] ?></strong></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;" colspan="2">Usuário: <strong><?= ($_POST["usuario"]) ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">CNS: <strong><?= $_POST["cns"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Data Admissão Usuário <strong><?= $_POST["dt_admiss_usr"] ?></strong></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;" colspan="2">Data Nasc: <strong><?= $_POST["dt_nasc"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Nome da Mãe: <strong><?= $_POST["nome_mae"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Responsável: <strong><?= $_POST["responsavel"] ?></strong></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid;">Raça / Cor: <strong><?= $_POST["raca_cor"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Etnia Indigena: <strong><?= $_POST["etnia_indigena"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">SEXO: M: (<strong><?= $_POST["sexo"] == "M" ? "X" : " " ?></strong>) F: (<strong><?= $_POST["sexo"] == "F" ? "X" : " " ?>) </strong></td>
                    <td style="border-bottom: 1px solid;">Celular: <strong><?= $_POST["celular"] ?></strong></td>
                    <td style="border-bottom: 1px solid;" colspan="2">Tel. Contato: <strong><?= $_POST["telefone"] ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border-bottom: 1px solid;">Endereço: <strong><?= $_POST["endereco"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Mun. Residência: <strong><?= $_POST["mun_res"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">UF: <strong>SP</strong></td>
                    <td style="border-bottom: 1px solid;">CEP: <strong><?= $_POST["cep"] ?></strong></td>
                    <td style="border-bottom: 1px solid;">Nacionalidade: <strong><?= $_POST["nacional"] ?></strong></td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6">Usuário de Álcool e Outras Drogas: ( <strong><?= $_POST["alcool_drogas"] == "S" ? "X" : " " ?></strong> ) S&nbsp;&nbsp; ( <strong><?= $_POST["alcool_drogas"] == "N" ? "X" : " " ?></strong> ) N Se SIM:&nbsp;&nbsp; ( <strong><?= $_POST["alcool"] == "S" ? "X" : " " ?></strong> ) Álcool&nbsp;&nbsp; ( <strong><?= $_POST["crack"] == "S" ? "X" : " " ?></strong> ) Crack&nbsp;&nbsp; ( <strong><?= $_POST["cocaina"] == "S" ? "X" : " " ?></strong> ) Cocaina&nbsp;&nbsp; ( <strong><?= $_POST["cannabis"] == "S" ? "X" : " " ?></strong> ) Cannabis&nbsp;&nbsp; ( <strong><?= $_POST["outras_drogas"] !== "" ? "X" : " " ?></strong> ) Outras: <strong><?= $_POST["outras_drogas"] == "" ? "" : $_POST["outras_drogas"] ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;Situação de Rua:&nbsp;&nbsp; ( <strong><?= $_POST["situacao_rua"] == "S" ? "X" : " " ?></strong> ) S ( <strong><?= $_POST["situacao_rua"] == "N" ? "X" : " " ?></strong> ) N </td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6">Origem:&nbsp;&nbsp; ( <strong><?= $_POST["demanda_espontanea"] == "S" ? "X" : " " ?></strong> ) Demanda Espntânea&nbsp;&nbsp; ( <strong><?= $_POST["ubs"] == "S" ? "X" : " " ?></strong> ) UBS&nbsp;&nbsp; ( <strong><?= $_POST["serv_u_e"] == "S" ? "X" : " " ?></strong> ) Serv. U/E&nbsp;&nbsp; ( <strong><?= $_POST["outro_caps"] == "S" ? "X" : " " ?></strong> ) Outro CAPS&nbsp;&nbsp; ( <strong><?= $_POST["hosp_geral"] == "S" ? "X" : " " ?></strong> ) Hosp. Geral&nbsp;&nbsp; ( <strong><?= $_POST["hosp_psiqui"] == "S" ? "X" : " " ?></strong> ) Hosp. Psiquiátrico&nbsp;&nbsp; ( <strong><?= $_POST["origem_outros"] !== "" ? "X" : " " ?></strong> ) Outro: <strong><?= $_POST["origem_outros"] == "" ? "" : $_POST["origem_outros"] ?></strong> </td>
                </tr>
            </table>
            <table border="1" style="font-size: 10px;">
                <tr>
		    <td colspan="17" style="border: none;">CID10 Principal: <strong><?= $_POST["cid10_princ"] == "" ? "" : $_POST["cid10_princ"] ?></strong></td>
		    <td colspan="4">Cód. IBGE Munic: <strong>3509512 </strong></td>
                </tr>
                <tr>
                    <td colspan="21" style="border-left: none; border-right: none;">CID 10 Causas Associadas: <strong><?= $_POST["cid10_caus_assoc"] == "" ? "" : $_POST["cid10_caus_assoc"] ?></strong> </td>
                </tr>
                <tr>
                    <td colspan="8">Existe Estratégia de Saúde da Familia: ( <strong><?= $_POST["estrategia_sau_fam"] == "S" ? "X" : " " ?></strong> ) S ( <strong><?= $_POST["estrategia_sau_fam"] == "N" ? "X" : " " ?></strong> ) N</td>
                    <td colspan="13">CNS: <strong><?= $_POST["cns"] ?></strong></td>
                </tr>
                <tr>
                    <td colspan="21">Encaminhamento: ( <strong><?= $_POST["encaminhamento"] === "cont_acomp_caps" ?  "X" : " " ?></strong> ) &nbsp;Continuidade do Acomp. em CAPS&nbsp;&nbsp;&nbsp;&nbsp;( <strong><?= $_POST["encaminhamento"] === "cont_aten_basica" ?  "X" : " " ?></strong> ) &nbsp;Continuidade na Atenção Básica&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alta &nbsp;( <strong><?= $_POST["encaminhamento"] === "alta" ?  "X" : " " ?></strong> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Óbito( <strong><?= $_POST["encaminhamento"] === "obito" ?  "X" : " " ?></strong> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abandono ( <strong><?= $_POST["encaminhamento"] === "abandono" ?  "X" : " " ?></strong> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data Conclusão ______/______/_______ </td>
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
                    <td rowspan="2" colspan="3">DATA</td>
                    <td rowspan="2" colspan="3">Carimbo / Assinatura</td>
                    <td rowspan="2" colspan="3" style="text-align: center;">CBO</td>
                    <td style="font-size: 6px;">Local Ação <br> </td>
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
                    <td style="font-size: 6px;">C-CAPS <br> T - Território</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
		</tr>
<tr>
                    <td>&nbsp;&nbsp; <br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6">Profissional Referência: <strong><?= $_POST["nome_profissional"] ?></strong></td>
                    <td colspan="7">CNS: <strong><?= $_POST["prof_referenc"] ?></strong></td>
                    <td colspan="5">DATA DE FECHAMENTO:______/______/_______</td>
                    <td colspan="3">RAAS-SSCF</td>
                </tr>
            </table>
            <table border="1" style="font-size: 12px; margin-top: 125px;">
                <tr>
                    <td colspan="21" style="border: none;">USUÁRIO (Nome completo): <strong><?= $_POST["usuario"] ?></strong></td>
                </tr>
                <tr>
                    <td colspan="21" style="border-left: none; border-right: none;">DN: <strong><?= $_POST["dt_nasc"] ?></strong></td>
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
                    <td rowspan="2" colspan="3">DATA</td>
                    <td rowspan="2" colspan="3">Carimbo / Assinatura</td>
                    <td rowspan="2" colspan="3" style="text-align: center;">CBO</td>
                    <td style="font-size: 6px;">Local Ação <br> </td>
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
                    <td style="font-size: 6px;">C-CAPS <br> T - Território</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
		</tr>
                <tr>
                    <td>&nbsp;&nbsp;<br> &nbsp;&nbsp;<br> &nbsp;&nbsp;</td>
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
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td></td>
                </tr>
                <tr style="border: none; font-size: 8px;">
                    <td colspan="6">Profissional Referência: <strong><?= $_POST["nome_profissional"] ?></strong> </td>
                    <td colspan="7">CNS: <strong><?= $_POST["prof_referenc"] ?></strong></td>
                    <td colspan="5"> <span> DATA DE FECHAMENTO:______/______/_______</span></td>
                    <td colspan="3">RAAS-SSCF</td>
                </tr>
            </table>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        function generatePDF() {
            var doc = new jsPDF('landscape', 'pt', 'landscape');
            var margin = 10;
            var scale = (doc.internal.pageSize.width - margin * 2) / document.body.scrollWidth;
            console.log(scale)
            doc.html(document.body, {
                x: margin,
                y: margin,
                html2canvas: {
                    scale: scale
                },
                callback: (doc) => {
                    // doc.output('dataurlnewwindow', {filename: 'pdf.pdf'})
                    doc.autoPrint()
                    doc.save();
                }
            })
            setTimeout(() => {
                close();
            }, 3000)
        }
        generatePDF()
    </script>
</body>

</html>
