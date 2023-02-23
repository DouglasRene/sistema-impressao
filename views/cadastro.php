<?php
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$formularioDao = new FormularioDAO($conn, $BASE_URL);

$dados = $formularioDao->getLatestformularios($userData->caps_id);
$profissionais = $formularioDao->getProfissForCapsId($userData->caps_id);


require_once("autocomplete.php");
?>
<style>
    .check {
        pointer-events: none;
    }
</style>
<div class="col-md-12">
    <form action="assets/process/formulario_process.php" method="post">
        <div class="col-auto">
            <a href="<?php $BASE_URL ?>?file=home" class="btn transition gradient gradient-green gradient-hover form-group">Voltar</a>
            <input type="hidden" name="type" value="register">
            <input type="submit" value="Cadastrar" class="btn transition gradient gradient-green gradient-hover form-group" style="float: right;">
        </div>
        <div style="text-align: center; color: red">
            <?php if (count($profissionais) < 1) : ?>
                <h4>Deve cadastrar Profissional de referência para prosseguir com o cadastro</h4>
            <?php endif; ?>
        </div>
        <div class="formulario">
            <div class="cabecalho mb-3">
                <div class="logo"><img src="assets/image/logo.jpg" alt="Logo Candido"></div>
                <div style="text-align: center;">
                    <p class="m-0 p-0">RAAS POR PACIENTE E CONSULTA MÉDICA</p>
                    <p class="m-0 p-0">https://candido.org.br</p>
                </div>
                <div class="logo_sus"><img src="assets/image/logo_sus.JPG" alt="Logo SUS"></div>
            </div>
            <div class="tb-1">
                <table>
                    <tr>
		    <td>CAPS: <input type="text" style="width: 80%;" name="caps" readonly value="<?= $profissionais[0]["caps"] !== "" ? $profissionais[0]["caps"] : $dados["caps"] ?>">
                            <input type="hidden" name="caps_id" value="<?= $userData->caps_id ?>">
                        </td>
                        <td colspan="2">CNES: <input type="text" style="width: 80%;" name="cnes" readonly value="<?= $profissionais[0]["cnes"] !== "" ? $profissionais[0]["cnes"] : $dados["cnes"] ?>"></td>
                        <td>Nº Prontuário: <input type="text" style="width: 60%;" name="n_prontuario" readonly value="<?= $dados["n_prontuario"] + 1 ?>"></td>
                        <td colspan="2">Mês/Ano Atendimento: <input type="text" style="width: 50%;" name="mes_ano_atend" maxlength="7"></td>
                    </tr>
                    <tr>
                        <td colspan="2">Usuário: <input type="text" style="width: 80%;" name="usuario"></td>
                        <td colspan="2">CNS: <input type="number" style="width: 80%;" name="cns"></td>
                        <td colspan="2">Data Admissão Usuário <input type="text" style="width: 50%;" name="dt_admiss_usr" maxlength="10"></td>
                    </tr>
                    <tr>
                        <td colspan="2">Data Nasc: <input type="text" style="width: 80%;" name="dt_nasc"></td>
                        <td colspan="2">Nome da Mãe: <input type="text" style="width: 75%;" name="nome_mae"></td>
                        <td colspan="2">Responsável: <input type="text" style="width: 70%;" name="responsavel"></td>
                    </tr>
                    <tr>
                        <td>Raça / Cor: <input type="text" style="width: 60%;" name="raca_cor"></td>
                        <td>Etnia Indigena: <input type="text" style="width: 60%;" name="etnia_indigena"></td>
                        <td>SEXO: M: <input type="radio" style="width: 15%;" value="M" name="sexo"> F: <input type="radio" style="width: 15%;" value="F" name="sexo"> </td>
                        <td>Tel. Contato: <input type="text" style="width: 60%;" name="telefone"></td>
                        <td colspan="2">
                            <div class="col m-0 p-0 w-100">Centro de saúde:
                                <input type="text" class="autocomplete" style="width: 60%;" id="centro_saude" name="centro_saude" value="<?= $formulario->centro_saude == "" ? "" : $formulario->centro_saude ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Endereço: <input type="text" style="width: 80%;" name="endereco"></td>
                        <td>Mun. Residência: <input type="text" style="width: 40%;" name="mun_res"> UF: SP</td>
                        <td>CEP: <input type="text" style="width: 60%;" name="cep"></td>
                        <td colspan="2">Nacionalidade: <input type="text" style="width: 30%;" name="nacional"> Cód. IBGE Munic: 3509512</td>
                        
                    </tr>
                    <tr style="border: none;">
                        <td colspan="6">Usuário de Álcool e Outras Drogas: <input type="radio" style="width: 1%;" value="S" name="alcool_drogas"> S&nbsp;&nbsp; <input type="radio" style="width: 1%;" value="N" name="alcool_drogas"> N Se SIM:&nbsp;&nbsp; <input type="checkbox" name="alcool" value="S" style="width: 1%;"> Álcool&nbsp;&nbsp; <input type="checkbox" name="crack" value="S" style="width: 1%;"> Crack&nbsp;&nbsp; <input type="checkbox" name="cocaina" value="S" style="width: 1%;"> Cocaina&nbsp;&nbsp; <input type="checkbox" name="cannabis" value="S" style="width: 1%;"> Cannabis&nbsp;&nbsp; <input type="checkbox" style="width: 1%;"> Outras: <input type="text" name="outras_drogas" style="width: 30%;"> Situação de Rua:&nbsp;&nbsp; <input type="radio" style="width: 1%;" value="S" name="situacao_rua"> S <input type="radio" style="width: 1%;" value="N" name="situacao_rua"> N </td>
                    </tr>
                    <tr style="border: none;">
                        <td colspan="6">Origem:&nbsp;&nbsp; <input type="checkbox" name="demanda_espontanea" value="S" style="width: 1%;"> Demanda Espntânea&nbsp;&nbsp; <input type="checkbox" name="ubs" value="S" style="width: 1%;"> UBS&nbsp;&nbsp; <input type="checkbox" name="serv_u_e" value="S" style="width: 1%;"> Serv. U/E&nbsp;&nbsp; <input type="checkbox" name="outro_caps" value="S" style="width: 1%;"> Outro CAPS&nbsp;&nbsp; <input type="checkbox" name="hosp_geral" value="S" style="width: 1%;"> Hosp. Geral&nbsp;&nbsp; <input type="checkbox" name="hosp_psiqui" value="S" style="width: 1%;"> Hosp. Psiquiátrico&nbsp;&nbsp; <input type="checkbox" style="width: 1%;"> Outro: <input type="text" name="origem_outros" style="width: 40%;"> </td>
                    </tr>
                </table>
                <table border="1" class="tb-2 mt-2">
                    <tr style="border: none;">
                        <td colspan="18">
                            <div class="col m-0 p-0" style="width: 100%;">
                                CID10 Principal:
                                <input type="text" class="autocomplete" id="cid10_princ" name="cid10_princ" style="width: 80%;">
                            </div>
                        </td>
                    </tr>
                    <tr style="border-top: 1px solid;">
                        <td colspan="18">
                            <div class="col m-0 p-0" style="width: 100%;">
                                CID 10 Causas Associadas:
                                <input type="text" class="autocomplete" id="cid10_caus_assoc" name="cid10_caus_assoc" style="width: 70%;">
                            </div>
                    </tr>
                    <tr>
                        <td colspan="6">Existe Estratégia de Saúde da Familia: <input type="radio" name="estrategia_sau_fam" value="S" style="width: 10%; margin-top: 2px"> S <input type="radio" name="estrategia_sau_fam" value="N" style="width: 10%;"> N</td>
                        <td colspan="12">CNS:</td>
                    </tr>
                    <tr>
                        <td colspan="18">Encaminhamento: <input type="radio" name="encaminhamento" value="cont_acomp_caps" style="width: 2%; margin-top: 2px">Continuidade do Acomp. em CAPS&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="encaminhamento" value="cont_aten_basica" style="width: 2%; margin-top: 2px"> Continuidade na Atenção Básica&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="encaminhamento" value="alta" style="width: 2%; margin-top: 2px; pointer-events: none;"> Alta &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="encaminhamento" value="obito" style="width: 2%; margin-top: 2px; pointer-events: none;"> Óbito&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="encaminhamento" value="abandono" style="width: 2%; margin-top: 2px; pointer-events: none;"> Abandono</td>
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
                    <tr style="border: none;">
                        <td colspan="7">Profissional Referência: <select name="prof_referenc" style="width: 80%;">
                                <option value="">Selecione</option>
                                <?php foreach ($profissionais as $profissional) : ?>
                                    <option value="<?= $profissional["cbo"] ?>"><?= $profissional["nome"] ?></option>
                                <?php endforeach; ?>
                            </select></td>
                        <td colspan="8">DATA DE FECHAMENTO:___/___/____</td>
                        <td colspan="2">RAAS-SSCF</td>
                    </tr>
                </table>
            </div>
            <div class="">
                <table>
                </table>
            </div>
        </div>
    </form>
</div>
<script>
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
