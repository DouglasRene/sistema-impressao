<?php

  class Formulario {
    public $caps;
    public $cnes;
    public $n_prontuario;
    public $mes_ano_atend;
    public $usuario;
    public $cns;
    public $dt_admiss_usr;
    public $dt_nasc;
    public $nome_mae;
    public $responsavel;
    public $raca_cor;
    public $etnia_indigena;
    public $sexo;
    public $centro_saude;
    public $telefone;
    public $endereco;
    public $mun_res;
    public $cep;
    public $nacional;
    public $situacao_rua;
    public $origem_outros;
    public $alcool_drogas;
    public $alcool;
    public $crack;
    public $cocaina;
    public $cannabis;
    public $outras_drogas;
    public $demanda_espontanea;
    public $ubs;
    public $serv_u_e;
    public $outro_caps;
    public $hosp_geral;
    public $hosp_psiqui;
    public $cid10_princ;
    public $des_diag_princ;
    public $cid10_caus_assoc;
    public $estrategia_sau_fam;
    public $encaminhamento;
    public $data_fechamento;
    public $prof_referenc;
    public $historico;
    public $status;
    public $caps_id;
  }


  interface FormularioDAOInterface {
    public function buildFormulario($data);
    public function findAllForCapsId($id);
    public function findAllName();
    public function findAllCns();
    public function findAllProntuario();
    public function getLatestFormularios($caps_id);
    public function getformularioByUserCns($cns);
    public function getformularioByProntuario($n_prontuario);
    public function getformularioByUserName($name); 
    public function create(Formulario $formulario);
    public function update(Formulario $formulario, $cns_old);
    public function registerProfi($caps_id);
    public function updateProfi($caps_id);
    public function getProfiFromCbo($cbo);
    public function getProfissForCapsId($caps_id);
    public function deleteProfi($cbo);
    public function checkAtivoInativo($cns, $caps_id);
    public function insertHistoricoFromCns($historico, $cns, $type, $caps_id);
    public function getHistoricoFromCns($cns);
    public function getLastDataHistorico($cns);
    public function transfCapsInativo($data);
  }
