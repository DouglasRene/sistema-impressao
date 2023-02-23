<?php
require_once __DIR__ . "/../models/Formulario.php";
require_once __DIR__ . "/../models/Message.php";


class FormularioDAO implements FormularioDAOInterface
{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildformulario($data)
    {

        $formulario =  new Formulario();

        $formulario->caps = $data["caps"];
        $formulario->cnes = $data["cnes"];
        $formulario->n_prontuario = $data["n_prontuario"];
        $formulario->mes_ano_atend = $data["mes_ano_atend"];
        $formulario->usuario = $data["usuario"];
        $formulario->cns = $data["cns"];
        $formulario->dt_admiss_usr = $data["dt_admiss_usr"];
        $formulario->dt_nasc = $data["dt_nasc"];
        $formulario->nome_mae = $data["nome_mae"];
        $formulario->responsavel = $data["responsavel"];
        $formulario->raca_cor = $data["raca_cor"];
        $formulario->etnia_indigena = $data["etnia_indigena"];
        $formulario->sexo = $data["sexo"];
        $formulario->centro_saude = $data["centro_saude"];
        $formulario->telefone = $data["telefone"];
        $formulario->endereco = $data["endereco"];
        $formulario->mun_res = $data["mun_res"];
        $formulario->cep = $data["cep"];
        $formulario->nacional = $data["nacional"];
        $formulario->situacao_rua = $data["situacao_rua"];
        $formulario->origem_outros = $data["origem_outros"];
        $formulario->alcool_drogas = $data["alcool_drogas"];
        $formulario->alcool = $data["alcool"];
        $formulario->crack = $data["crack"];
        $formulario->cocaina = $data["cocaina"];
        $formulario->cannabis = $data["cannabis"];
        $formulario->outras_drogas = $data["outras_drogas"];
        $formulario->demanda_espontanea = $data["demanda_espontanea"];
        $formulario->ubs = $data["ubs"];
        $formulario->serv_u_e = $data["serv_u_e"];
        $formulario->outro_caps = $data["outro_caps"];
        $formulario->hosp_geral = $data["hosp_geral"];
        $formulario->hosp_psiqui = $data["hosp_psiqui"];
        $formulario->cid10_princ = $data["cid10_princ"];
        $formulario->des_diag_princ = $data["des_diag_princ"];
        $formulario->cid10_caus_assoc = $data["cid10_caus_assoc"];
        $formulario->estrategia_sau_fam = $data["estrategia_sau_fam"];
        $formulario->encaminhamento = $data["encaminhamento"];
        $formulario->data_fechamento = $data["data_fechamento"];
        $formulario->prof_referenc = $data["prof_referenc"];
        $formulario->historico = $data["historico"];
        $formulario->status = $data["status"];
        $formulario->caps_id = $data["caps_id"];


        return $formulario;
    }

    public function findAllForCapsId($caps_id)
    {
        $formularios = [];

        $stmt = $this->conn->prepare("SELECT * FROM formulario$caps_id WHERE caps_id = :caps_id ORDER BY usuario ASC");

        $stmt->bindParam(":caps_id", $caps_id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formulariosArray = $stmt->fetchAll();

            foreach ($formulariosArray as $formulario) {
                $formularios[] =  $this->buildformulario($formulario);
            }
        }

        return $formularios;
    }

    public function findAllName()
    {
        $formulario = [];

        $stmt = $this->conn->query("SELECT usuario FROM formulario ORDER BY usuario ASC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formulariosArray = $stmt->fetchAll();

            foreach ($formulariosArray as $formularios) {
                $formulario[] = $formularios["usuario"];
            }
        }

        return $formulario;
    }

    public function findAllCns()
    {
        $formulario = [];

        $stmt = $this->conn->query("SELECT cns FROM formulario ORDER BY cns ASC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formulariosArray = $stmt->fetchAll();

            foreach ($formulariosArray as $formularios) {
                $formulario[] = $formularios["cns"];
            }
        }

        return $formulario;
    }

    public function findAllProntuario()
    {
        $formulario = [];

        $stmt = $this->conn->query("SELECT n_prontuario FROM formulario ORDER BY n_prontuario ASC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formulariosArray = $stmt->fetchAll();

            foreach ($formulariosArray as $formularios) {
                $formulario[] = $formularios["n_prontuario"];
            }
        }

        return $formulario;
    }

    public function getLatestformularios($caps_id)
    {

        $stmt = $this->conn->query("SELECT n_prontuario ,(SELECT cnes FROM caps WHERE id = $caps_id) AS 'cnes', caps FROM formulario$caps_id ORDER BY n_prontuario DESC LIMIT 1");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formulario = $stmt->fetch();
        }

        return $formulario;
    }

    public function getFormularioByProntuario($cns)
    {

        $formulario = [];

        $stmt = $this->conn->prepare("SELECT cns FROM formulario WHERE cns = :cns");

        $stmt->bindParam(":cns", $cns);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formularioData = $stmt->fetch();
            $formulario = $this->buildformulario($formularioData);
        } else {
            $formulario = false;
        }

        return $formulario;
    }

    public function getformularioByUserCns($cns, $caps_id = "")
    {

        $formulario = [];

        $stmt = $this->conn->prepare("SELECT * FROM formulario$caps_id WHERE cns = :cns");

        $stmt->bindParam(":cns", $cns);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formularioData = $stmt->fetch();

            $formulario = $this->buildformulario($formularioData);
        } else {
            return false;
        }

        return $formulario;
    }

    public function getformularioByUserName($name)
    {

        $formulario = [];

        $stmt = $this->conn->prepare("SELECT * FROM formulario WHERE usuario = :usuario");

        $stmt->bindParam(":usuario", $name);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $formularioData = $stmt->fetch();

            $formulario = $this->buildformulario($formularioData);
        } else {
            return false;
        }
        return $formulario;
    }


    public function create(Formulario $formulario)
    {
        $stmt = $this->conn->prepare("INSERT INTO formulario$formulario->caps_id (cnes, caps, mes_ano_atend, cns, usuario, dt_admiss_usr, dt_nasc, nome_mae, responsavel, raca_cor, etnia_indigena, sexo, centro_saude, telefone, endereco, mun_res, cep, nacional, situacao_rua, origem_outros, alcool_drogas, alcool, crack, cocaina, cannabis, outras_drogas, demanda_espontanea, ubs, serv_u_e, outro_caps, hosp_geral, hosp_psiqui, cid10_princ, des_diag_princ, cid10_caus_assoc, estrategia_sau_fam, encaminhamento, data_fechamento, prof_referenc, status, caps_id) VALUES ('$formulario->cnes', (SELECT nome_caps FROM caps WHERE id = '$formulario->caps_id'), '$formulario->mes_ano_atend', '$formulario->cns', '$formulario->usuario', '$formulario->dt_admiss_usr', '$formulario->dt_nasc', '$formulario->nome_mae', '$formulario->responsavel', '$formulario->raca_cor', '$formulario->etnia_indigena', '$formulario->sexo', '$formulario->centro_saude', '$formulario->telefone', '$formulario->endereco', '$formulario->mun_res', '$formulario->cep', '$formulario->nacional', '$formulario->situacao_rua', '$formulario->origem_outros', '$formulario->alcool_drogas', '$formulario->alcool', '$formulario->crack', '$formulario->cocaina', '$formulario->cannabis', '$formulario->outras_drogas', '$formulario->demanda_espontanea', '$formulario->ubs', '$formulario->serv_u_e', '$formulario->outro_caps', '$formulario->hosp_geral', '$formulario->hosp_psiqui', '$formulario->cid10_princ', '$formulario->des_diag_princ', '$formulario->cid10_caus_assoc', '$formulario->estrategia_sau_fam', '$formulario->encaminhamento', '$formulario->data_fechamento', '$formulario->prof_referenc', 'Ativo', '$formulario->caps_id')");

        try {
            $stmt->execute();

            $this->regisPassagem($formulario->cns, $formulario->caps_id);

            $formulario->historico = "Cadastro criado na Data: " . date('m/Y') . ", pelo Caps: " . $formulario->caps;
            $this->insertHistoricoFromCns($formulario->historico, $formulario->cns, "blue", $formulario->caps_id);

            $this->insertInFormulario($formulario);

            $this->message->setMessage("Cadastro efetuado com sucesso!", "success", "?file=cadastro");
        } catch (PDOException $e) {
            //echo $e->getMessage();exit;
            $this->message->setMessage("Algo deu errado contate a equipe de TI, se o problema continuar!", "success", "?file=cadastro");
            // $this->message->setMessage("Cadastro efetuado com sucesso!", "success", "?file=cadastro");
        }
    }

    public function updateOrInsertInFormulario($formulario, $cns_old = "")
    {
        if (!$this->getFormularioByProntuario($formulario->cns)) {

            $stmt = $this->conn->prepare("INSERT INTO formulario (cnes, caps, mes_ano_atend, cns, usuario, dt_admiss_usr, dt_nasc, nome_mae, responsavel, raca_cor, etnia_indigena, sexo, centro_saude, telefone, endereco, mun_res, cep, nacional, situacao_rua, origem_outros, alcool_drogas, alcool, crack, cocaina, cannabis, outras_drogas, demanda_espontanea, ubs, serv_u_e, outro_caps, hosp_geral, hosp_psiqui, cid10_princ, des_diag_princ, cid10_caus_assoc, estrategia_sau_fam, encaminhamento, data_fechamento, prof_referenc, status, caps_id) VALUES ('', '', '', '$formulario->cns', '$formulario->usuario', '', '$formulario->dt_nasc', '$formulario->nome_mae', '$formulario->responsavel', '$formulario->raca_cor', '$formulario->etnia_indigena', '$formulario->sexo', '$formulario->centro_saude', '$formulario->telefone', '$formulario->endereco', '$formulario->mun_res', '$formulario->cep', '$formulario->nacional', '$formulario->situacao_rua', '$formulario->origem_outros', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0')");

            $stmt->execute();

            $this->transfHist($cns_old, $formulario->cns, "insert", $formulario->caps_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE formulario SET cns = '$formulario->cns', usuario = '$formulario->usuario', dt_nasc = '$formulario->dt_nasc', nome_mae = '$formulario->nome_mae', responsavel = '$formulario->responsavel', raca_cor = '$formulario->raca_cor', etnia_indigena = '$formulario->etnia_indigena', sexo = '$formulario->sexo', centro_saude = '$formulario->centro_saude', telefone = '$formulario->telefone', endereco = '$formulario->endereco', mun_res = '$formulario->mun_res', cep = '$formulario->cep', nacional = '$formulario->nacional', situacao_rua = '$formulario->situacao_rua' WHERE cns = '$formulario->cns'");

            $stmt->execute();
        }
    }

    function insertInFormulario(Formulario $formulario, $cns_old = "")
    {

        if (!$this->getFormularioByProntuario($formulario->cns)) {

            $stmt = $this->conn->prepare("INSERT INTO formulario (cnes, caps, mes_ano_atend, cns, usuario, dt_admiss_usr, dt_nasc, nome_mae, responsavel, raca_cor, etnia_indigena, sexo, centro_saude, telefone, endereco, mun_res, cep, nacional, situacao_rua, origem_outros, alcool_drogas, alcool, crack, cocaina, cannabis, outras_drogas, demanda_espontanea, ubs, serv_u_e, outro_caps, hosp_geral, hosp_psiqui, cid10_princ, des_diag_princ, cid10_caus_assoc, estrategia_sau_fam, encaminhamento, data_fechamento, prof_referenc, status, caps_id) VALUES ('', '', '', '$formulario->cns', '$formulario->usuario', '', '$formulario->dt_nasc', '$formulario->nome_mae', '$formulario->responsavel', '$formulario->raca_cor', '$formulario->etnia_indigena', '$formulario->sexo', '$formulario->centro_saude', '$formulario->telefone', '$formulario->endereco', '$formulario->mun_res', '$formulario->cep', '$formulario->nacional', '$formulario->situacao_rua', '$formulario->origem_outros', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '$formulario->caps_id')");

            $stmt->execute();
        }
    }

    public function update(Formulario $formulario, $cns_old)
    {
        if ($formulario->cns != $cns_old) {
            $res = $this->verifyCnsExists($formulario->cns, $formulario->caps_id);
            if ($res === 1) {
                $stmt = $this->conn->prepare("UPDATE formulario$formulario->caps_id SET cnes = (SELECT cnes from caps WHERE id = $formulario->caps_id), caps = (SELECT nome_caps from caps WHERE id = $formulario->caps_id), mes_ano_atend = '$formulario->mes_ano_atend', cns = '$formulario->cns', usuario = '$formulario->usuario', dt_admiss_usr = '$formulario->dt_admiss_usr', dt_nasc = '$formulario->dt_nasc', nome_mae = '$formulario->nome_mae', responsavel = '$formulario->responsavel', raca_cor = '$formulario->raca_cor', etnia_indigena = '$formulario->etnia_indigena', sexo = '$formulario->sexo', centro_saude = '$formulario->centro_saude', telefone = '$formulario->telefone', endereco = '$formulario->endereco', mun_res = '$formulario->mun_res', cep = '$formulario->cep', nacional = '$formulario->nacional', situacao_rua = '$formulario->situacao_rua', caps_id = '$formulario->caps_id', origem_outros ='$formulario->origem_outros', alcool_drogas ='$formulario->alcool_drogas', alcool ='$formulario->alcool', crack ='$formulario->crack', cocaina ='$formulario->cocaina', cannabis ='$formulario->cannabis', outras_drogas ='$formulario->outras_drogas', demanda_espontanea ='$formulario->demanda_espontanea', ubs ='$formulario->ubs', serv_u_e ='$formulario->serv_u_e', outro_caps ='$formulario->outro_caps', hosp_geral ='$formulario->hosp_geral', hosp_psiqui ='$formulario->hosp_psiqui', cid10_princ ='$formulario->cid10_princ', des_diag_princ = '$formulario->des_diag_princ', cid10_caus_assoc ='$formulario->cid10_caus_assoc', estrategia_sau_fam ='$formulario->estrategia_sau_fam', encaminhamento ='$formulario->encaminhamento', data_fechamento ='$formulario->data_fechamento', status ='$formulario->status', prof_referenc ='$formulario->prof_referenc' WHERE cns = '$cns_old'");

                try {
                    $stmt->execute();
                    if ($this->getHistoricoFromCns($formulario->cns)) {
                        $this->transfHist($cns_old, $formulario->cns, "update", $formulario->caps_id);
                    }
                    $this->updateOrInsertInFormulario($formulario, $cns_old);
                    //$this->updateHistPass($formulario->cns, $cns_old);
                    $this->message->setMessage("Cadastro Atualizado!", "success", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit;
                    $this->message->setMessage("Algo deu errado contate a equipe de TI, se o problema continuar!", "success", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");
                }
            } else {
                $this->message->setMessage("CNS já existe!", "success", "?file=formulario&select_busca=update&pesquisa=$cns_old");
            }
        } else {
            $stmt = $this->conn->prepare("UPDATE formulario$formulario->caps_id SET cnes = (SELECT cnes from caps WHERE id = $formulario->caps_id), caps = (SELECT nome_caps from caps WHERE id = $formulario->caps_id), mes_ano_atend = '$formulario->mes_ano_atend', cns = '$formulario->cns', usuario = '$formulario->usuario', dt_admiss_usr = '$formulario->dt_admiss_usr', dt_nasc = '$formulario->dt_nasc', nome_mae = '$formulario->nome_mae', responsavel = '$formulario->responsavel', raca_cor = '$formulario->raca_cor', etnia_indigena = '$formulario->etnia_indigena', sexo = '$formulario->sexo', centro_saude = '$formulario->centro_saude', telefone = '$formulario->telefone', endereco = '$formulario->endereco', mun_res = '$formulario->mun_res', cep = '$formulario->cep', nacional = '$formulario->nacional', situacao_rua = '$formulario->situacao_rua', caps_id = '$formulario->caps_id', origem_outros ='$formulario->origem_outros', alcool_drogas ='$formulario->alcool_drogas', alcool ='$formulario->alcool', crack ='$formulario->crack', cocaina ='$formulario->cocaina', cannabis ='$formulario->cannabis', outras_drogas ='$formulario->outras_drogas', demanda_espontanea ='$formulario->demanda_espontanea', ubs ='$formulario->ubs', serv_u_e ='$formulario->serv_u_e', outro_caps ='$formulario->outro_caps', hosp_geral ='$formulario->hosp_geral', hosp_psiqui ='$formulario->hosp_psiqui', cid10_princ ='$formulario->cid10_princ', des_diag_princ = '$formulario->des_diag_princ', cid10_caus_assoc ='$formulario->cid10_caus_assoc', estrategia_sau_fam ='$formulario->estrategia_sau_fam', encaminhamento ='$formulario->encaminhamento', data_fechamento ='$formulario->data_fechamento', status ='$formulario->status', prof_referenc ='$formulario->prof_referenc' WHERE cns = '$cns_old'");

            try {
                $stmt->execute();
                $this->updateOrInsertInFormulario($formulario, $cns_old);
                // $this->updateHistPass($formulario->cns, $cns_old);
                $this->message->setMessage("Cadastro Atualizado!", "success", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit;
                $this->message->setMessage("Algo deu errado contate a equipe de TI, se o problema continuar!", "success", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");
            }
        }
    }

    public function transfHist($cns_old, $cns, $type, $caps_id = "")
    {
        if ($type === "update") {
            $qtdHist = $this->getHistoricoFromCnsCapsId($cns_old, $caps_id);
            echo $qtdHist;
            print_r($qtdHist);
            if ($qtdHist) {
                $this->removeHistFromCns($cns, $caps_id);
                foreach ($qtdHist as $hist) {
                    $this->updateHist($hist[1], $cns, $hist[4], $caps_id);
                }
            }
        }
        if ($type === "insert") {
            $qtdHist = $this->getHistoricoFromCns($cns_old);
            if ($qtdHist) {
                foreach ($qtdHist as $hist) {
                    $this->insertHistoricoFromCns($hist[1], $cns, $hist[4], $caps_id);
                }
            }
        }
    }

    public function registerProfi($data)
    {
        $nome = $data["nome"];
        $caps_id = $data["caps_id"];
        $cbo = $data["cbo"];

        $stmt = $this->conn->prepare("INSERT INTO profissionais (nome, caps_id, cbo) values ('$nome', $caps_id, '$cbo')");
        $stmt->execute();

        $this->message->setMessage("Cadastrado com sucesso!", "success", "?file=profissionais");
    }
    public function updateProfi($data)
    {
        $nome = $data["nome"];
        $caps_id = $data["caps_id"];
        $cbo = $data["cbo"];
        $cbo_orig = $data["cbo_orig"];

        $stmt = $this->conn->query("UPDATE profissionais SET cbo = '$cbo', nome = '$nome' WHERE cbo = $cbo_orig AND caps_id = $caps_id");
        $stmt->execute();
        $this->updateProfiForm($data);
        $this->message->setMessage("Atualizado com sucesso!", "success", "?file=profissionais");
    }

    public function updateProfiForm($data)
    {
        $caps_id = $data["caps_id"];
        $cbo = $data["cbo"];
        $cbo_orig = $data["cbo_orig"];
        $stmt = $this->conn->query("UPDATE formulario SET prof_referenc = '$cbo' WHERE prof_referenc = $cbo_orig AND caps_id = $caps_id");
        $stmt->execute();
    }

    public function deleteProfForm($data)
    {
        // print_r($data);
        $caps_id = $data["caps_id"];
        $cbo_orig = $data["cbo_orig"];
        $stmt = $this->conn->query("UPDATE `formulario` SET `prof_referenc` = 'NULL' WHERE `prof_referenc` = '$cbo_orig' AND `caps_id` = $caps_id");

        $stmt->execute();
    }

    public function getProfiFromCbo($cbo)
    {
        $stmt = $this->conn->query("SELECT * FROM profissionais WHERE cbo = $cbo");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $profissional = $stmt->fetch();
        } else {
            $profissional = false;
        }

        return $profissional;
    }

    public function getProfissForCapsId($caps_id)
    {
        $stmt = $this->conn->query("SELECT *, (SELECT cnes FROM caps WHERE id = $caps_id) AS 'cnes', (SELECT nome_caps FROM caps WHERE id = $caps_id) AS 'caps' FROM profissionais WHERE caps_id = $caps_id");

        $stmt->execute();

        $profissionais = [];

        if ($stmt->rowCount() > 0) {
            $profissionaisArray = $stmt->fetchAll();

            foreach ($profissionaisArray as $profissional) {
                $profissionais[] = $profissional;
            }
        }

        return $profissionais;
    }

    public function deleteProfi($data)
    {
        $caps_id = $data["caps_id"];
        $cbo = $data["cbo_orig"];

        $stmt = $this->conn->prepare("DELETE FROM profissionais WHERE cbo = $cbo AND caps_id = $caps_id");

        $stmt->execute();

        $this->deleteProfForm($data);
        $this->message->setMessage("Cadastro removido com sucesso!", "success", "?file=profissionais");
    }

    public function checkAtivoInativo($cns, $caps_id)
    {
        $stmt = $this->conn->query("SELECT status FROM formulario$caps_id WHERE cns = $cns");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $status = $stmt->fetch();
        }

        return $status[0];
    }

    public function insertHistoricoFromCns($historico, $cns, $type, $caps_id = "")
    {
        $data = date('m/Y');
        $stmt = $this->conn->prepare("INSERT INTO historico (historico, cns, data, type, caps_id) values ('$historico', '$cns', '$data', '$type', '$caps_id')");
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getHistoricoFromCnsCapsId($cns, $caps_id)
    {

        $stmt = $this->conn->prepare("SELECT * FROM historico WHERE cns = $cns AND caps_id = $caps_id ORDER BY cns ASC");

        $stmt->execute();

        $historico = [];

        if ($stmt->rowCount() > 0) {
            $historicoArray = $stmt->fetchAll();

            foreach ($historicoArray as $hist) {
                $historico[] = $hist;
            }
        } else {
            $historico = false;
        }

        return $historico;
    }

    public function getHistoricoFromCns($cns)
    {
        $stmt = $this->conn->prepare("SELECT * FROM historico WHERE cns = $cns ORDER BY cns ASC");

        $stmt->execute();

        $historico = [];

        if ($stmt->rowCount() > 0) {
            $historicoArray = $stmt->fetchAll();

            foreach ($historicoArray as $hist) {
                $historico[] = $hist;
            }
        } else {
            $historico = false;
        }

        return $historico;
    }

    public function getLastDataHistorico($cns)
    {
        $stmt = $this->conn->prepare("SELECT data FROM historico WHERE cns = $cns ORDER BY cns DESC LIMIT 1");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $historico = $stmt->fetch();
        }

        return $historico;
    }

    public function transfCapsInativo($data)
    {
        $novoCaps = $data["novo_caps"];
        $capsAntigo = $data["caps_antigo"];
        $cns = $data["cns"];
        $n_prontuario = $data["n_prontuario"];

        $stmt = $this->conn->prepare("UPDATE formulario SET caps = (SELECT nome_caps FROM caps WHERE id = '$novoCaps'), caps_id = '$novoCaps' WHERE cns = '$cns' AND caps_id = '$capsAntigo'");

        $stmt->execute();
        $this->message->setMessage("Cadastro Transferido!", "success", "?file=formulario&pesquisar=pesquisar&select_busca=prontuario&pesquisa=$n_prontuario");
    }

    public function regisPassagem($cns, $caps_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO passagem (cns, caps_id) VALUES ($cns, $caps_id)");

        $stmt->execute();
    }


    public function removeHistFromCns($cns, $caps_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM historico WHERE cns = '$cns' AND caps_id = '$caps_id'");
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function updateHist($historico, $cns, $type, $caps_id = "")
    {
        $data = date('m/Y');
        $stmt = $this->conn->prepare("INSERT INTO historico (historico, cns, data, type, caps_id) values ('$historico', '$cns', '$data', '$type', '$caps_id')");
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function updatePass($cns, $cns_old)
    {
        $stmt = $this->conn->prepare("UPDATE passagem SET cns = $cns WHERE cns = '$cns_old'");

        $stmt->execute();
    }

    public function verifyCnsExists($cns, $caps_id)
    {
        $stmt = $this->conn->prepare("SELECT cns FROM formulario$caps_id WHERE cns = '$cns'");

        $stmt->execute();

        $result = $stmt->fetch();

        if (empty($result)) {
            return 1;
        } else {
            return 2;
        }
    }

    public function countProfissional($cbo, $caps_id)
    {
        $stmt = $this->conn->prepare("SELECT COUNT($cbo) AS 'total_prof' FROM formulario$caps_id WHERE prof_referenc = '$cbo' AND caps_id = '$caps_id'");

        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }

    public function getAllFormAtivo($caps_id, $limit1, $limit2, $profissional = "todos")
    {
        $formularios = [];

        if ($profissional === "todos") {
            $stmt = $this->conn->prepare("SELECT * FROM formulario$caps_id WHERE status = 'Ativo' AND caps_id = '$caps_id' ORDER BY usuario ASC LIMIT $limit1, $limit2");

            $stmt->execute();

            $formularios = [];

            if ($stmt->rowCount() > 0) {
                $formularioArray = $stmt->fetchAll();

                foreach ($formularioArray as $formulario) {
                    $formularios[] = $formulario;
                }
            }
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM formulario$caps_id WHERE status = 'Ativo' AND prof_referenc = '$profissional' ORDER BY usuario ASC LIMIT $limit1, $limit2");

            $stmt->execute();

            $formularios = [];

            if ($stmt->rowCount() > 0) {
                $formularioArray = $stmt->fetchAll();

                foreach ($formularioArray as $formulario) {
                    $formularios[] = $formulario;
                }
            }
        }
        
        return $formularios;
    }
}
