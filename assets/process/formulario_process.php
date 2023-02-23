<?php
require_once __DIR__."/globals.php";
require_once __DIR__."/db.php";
require_once __DIR__."/../dao/FormularioDAO.php";
require_once __DIR__."/../models/Formulario.php";
require_once __DIR__."/../models/Message.php";

$message = new Message($BASE_URL);
$formularioDao = new FormularioDAO($conn, $BASE_URL); 

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");
$file = filter_input(INPUT_POST, "file");

if ($type === "pesquisar") {

  $pesquisa = filter_input(INPUT_POST, "select_busca");
  $busca = filter_input(INPUT_POST, "pesquisa");

  if ((empty($pesquisa) || $pesquisa === "") || (empty($busca) || $busca === "")) {
    $message->setMessage("Preencha todos os campos!", "error", "");
  } else {
    if ($pesquisa === "cns") {
      $formulario = $formularioDao->getformularioByUserCns($busca);
    if (!$formulario) {
        return $message->setMessage("Cadastro não encontrado!", "error", "");
    }
      header("Location: $BASE_URL?file=formulario&select_busca=$pesquisa&pesquisa=$busca");
    } else if ($pesquisa === "usuario") {
      $formulario = $formularioDao->getformularioByUserName($busca);
      if (!$formulario) {
          return $message->setMessage("Cadastro não encontrado!", "error", "");
      }
      header("Location: $BASE_URL?file=formulario&select_busca=$pesquisa&pesquisa=$busca");
    }
  }
}
// // Verifica o tipo do formulário
else if ($type === "register") {

  $caps = filter_input(INPUT_POST, "caps");
  $cnes = filter_input(INPUT_POST, "cnes");
  $n_prontuario = filter_input(INPUT_POST, "n_prontuario");
  $mes_ano_atend = filter_input(INPUT_POST, "mes_ano_atend");
  $usuario = filter_input(INPUT_POST, "usuario");
  $cns = trim(filter_input(INPUT_POST, "cns"));
  $dt_admiss_usr = filter_input(INPUT_POST, "dt_admiss_usr");
  $dt_nasc = filter_input(INPUT_POST, "dt_nasc");
  $nome_mae = filter_input(INPUT_POST, "nome_mae");
  $responsavel = filter_input(INPUT_POST, "responsavel");
  $raca_cor = filter_input(INPUT_POST, "raca_cor");
  $etnia_indigena = filter_input(INPUT_POST, "etnia_indigena");
  $sexo = filter_input(INPUT_POST, "sexo");
  $centro_saude = filter_input(INPUT_POST, "centro_saude");
  $telefone = filter_input(INPUT_POST, "telefone");
  $endereco = filter_input(INPUT_POST, "endereco");
  $mun_res = filter_input(INPUT_POST, "mun_res");
  $cep = filter_input(INPUT_POST, "cep");
  $nacional = filter_input(INPUT_POST, "nacional");
  $situacao_rua = filter_input(INPUT_POST, "situacao_rua");
  $origem = filter_input(INPUT_POST, "origem");
  $origem_outros = filter_input(INPUT_POST, "origem_outros");
  $alcool_drogas = filter_input(INPUT_POST, "alcool_drogas");
  $alcool = filter_input(INPUT_POST, "alcool");
  $crack = filter_input(INPUT_POST, "crack");
  $cocaina = filter_input(INPUT_POST, "cocaina");
  $cannabis = filter_input(INPUT_POST, "cannabis");
  $outras_drogas = filter_input(INPUT_POST, "outras_drogas");
  $demanda_espontanea = filter_input(INPUT_POST, "demanda_espontanea");
  $ubs = filter_input(INPUT_POST, "ubs");
  $serv_u_e = filter_input(INPUT_POST, "serv_u_e");
  $outro_caps = filter_input(INPUT_POST, "outro_caps");
  $hosp_geral = filter_input(INPUT_POST, "hosp_geral");
  $hosp_psiqui = filter_input(INPUT_POST, "hosp_psiqui");
  $cid10_princ = filter_input(INPUT_POST, "cid10_princ");
  $des_diag_princ = filter_input(INPUT_POST, "des_diag_princ");
  $cid10_caus_assoc = filter_input(INPUT_POST, "cid10_caus_assoc");
  $estrategia_sau_fam = filter_input(INPUT_POST, "estrategia_sau_fam");
  $encaminhamento = filter_input(INPUT_POST, "encaminhamento");
  $prof_referenc = filter_input(INPUT_POST, "prof_referenc");
  $status = filter_input(INPUT_POST, "status");
  $caps_id = filter_input(INPUT_POST, "caps_id");

  // Verifica dados minimos
  if ($caps_id !== "" && $cnes !== "" && $cns !== "") {

    // Verificar se o e-mail já está cadastrdo no sistema
    if ($formularioDao->getformularioByUserCns($cns, $caps_id) === false) {

      $formulario = new Formulario();
      
      $formulario->caps = $caps;
      $formulario->cnes = $cnes;
      $formulario->n_prontuario = $n_prontuario;
      $formulario->mes_ano_atend = $mes_ano_atend;
      $formulario->usuario = $usuario;
      $formulario->cns = $cns;
      $formulario->dt_admiss_usr = $dt_admiss_usr;
      $formulario->dt_nasc = $dt_nasc;
      $formulario->nome_mae = $nome_mae;
      $formulario->responsavel = $responsavel;
      $formulario->raca_cor = $raca_cor;
      $formulario->etnia_indigena = $etnia_indigena;
      $formulario->sexo = $sexo;
      $formulario->centro_saude = $centro_saude;
      $formulario->telefone = $telefone;
      $formulario->endereco = $endereco;
      $formulario->mun_res = $mun_res;
      $formulario->cep = $cep;
      $formulario->nacional = $nacional;
      $formulario->situacao_rua = $situacao_rua;
      $formulario->origem_outros = $origem_outros;
      $formulario->alcool_drogas = $alcool_drogas;
      $formulario->alcool = $alcool;
      $formulario->crack = $crack;
      $formulario->cocaina = $cocaina;
      $formulario->cannabis = $cannabis;
      $formulario->outras_drogas = $outras_drogas;
      $formulario->demanda_espontanea = $demanda_espontanea;
      $formulario->ubs = $ubs;
      $formulario->serv_u_e = $serv_u_e;
      $formulario->outro_caps = $outro_caps;
      $formulario->hosp_geral = $hosp_geral;
      $formulario->hosp_psiqui = $hosp_psiqui;
      $formulario->cid10_princ = $cid10_princ;
      $formulario->des_diag_princ = $des_diag_princ;
      $formulario->cid10_caus_assoc = $cid10_caus_assoc;
      $formulario->estrategia_sau_fam = $estrategia_sau_fam;
      $formulario->encaminhamento = $encaminhamento;
      $formulario->data_fechamento = "";
      $formulario->prof_referenc = $prof_referenc;
      $formulario->status = $status;
      $formulario->caps_id = $caps_id;
      
      // print_r($formulario);exit;
      $formularioDao->create($formulario);
    } else {

      // Enviar uma msg de erro, usuário já existe
      $message->setMessage("Usuário já cadastrado, tente outro CNS.", "error", "back");
    }
  } else {

    // Enviar uma msg de erro, de dados faltantes
    $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
  }
} else if ($type === "update") {
  $caps = filter_input(INPUT_POST, "caps");
  $cnes = filter_input(INPUT_POST, "cnes");
  $n_prontuario = filter_input(INPUT_POST, "n_prontuario");
  $mes_ano_atend = filter_input(INPUT_POST, "mes_ano_atend");
  $usuario = filter_input(INPUT_POST, "usuario");
  $cns = filter_input(INPUT_POST, "cns");
  $dt_admiss_usr = filter_input(INPUT_POST, "dt_admiss_usr");
  $dt_nasc = filter_input(INPUT_POST, "dt_nasc");
  $nome_mae = filter_input(INPUT_POST, "nome_mae");
  $responsavel = filter_input(INPUT_POST, "responsavel");
  $raca_cor = filter_input(INPUT_POST, "raca_cor");
  $etnia_indigena = filter_input(INPUT_POST, "etnia_indigena");
  $sexo = filter_input(INPUT_POST, "sexo");
  $centro_saude = filter_input(INPUT_POST, "centro_saude");
  $telefone = filter_input(INPUT_POST, "telefone");
  $endereco = filter_input(INPUT_POST, "endereco");
  $mun_res = filter_input(INPUT_POST, "mun_res");
  $cep = filter_input(INPUT_POST, "cep");
  $nacional = filter_input(INPUT_POST, "nacional");
  $situacao_rua = filter_input(INPUT_POST, "situacao_rua");
  $origem = filter_input(INPUT_POST, "origem");
  $origem_outros = filter_input(INPUT_POST, "origem_outros");
  $alcool_drogas = filter_input(INPUT_POST, "alcool_drogas");
  $alcool = filter_input(INPUT_POST, "alcool");
  $crack = filter_input(INPUT_POST, "crack");
  $cocaina = filter_input(INPUT_POST, "cocaina");
  $cannabis = filter_input(INPUT_POST, "cannabis");
  $outras_drogas = filter_input(INPUT_POST, "outras_drogas");
  $demanda_espontanea = filter_input(INPUT_POST, "demanda_espontanea");
  $ubs = filter_input(INPUT_POST, "ubs");
  $serv_u_e = filter_input(INPUT_POST, "serv_u_e");
  $outro_caps = filter_input(INPUT_POST, "outro_caps");
  $hosp_geral = filter_input(INPUT_POST, "hosp_geral");
  $hosp_psiqui = filter_input(INPUT_POST, "hosp_psiqui");
  $cid10_princ = filter_input(INPUT_POST, "cid10_princ");
  $des_diag_princ = filter_input(INPUT_POST, "des_diag_princ");
  $cid10_caus_assoc = filter_input(INPUT_POST, "cid10_caus_assoc");
  $estrategia_sau_fam = filter_input(INPUT_POST, "estrategia_sau_fam");
  $encaminhamento = filter_input(INPUT_POST, "encaminhamento");
  $data_fechamento = filter_input(INPUT_POST, "data_fechamento");
  $prof_referenc = filter_input(INPUT_POST, "prof_referenc");
  $status = filter_input(INPUT_POST, "status");
  $caps_id = filter_input(INPUT_POST, "caps_id");
  $caps_user = filter_input(INPUT_POST, "caps_user");
  $cns_old = filter_input(INPUT_POST, "cns_old");

  // Verifica dados minimos //
  if ($caps_id !== "" && $cnes !== "" && $cns !== "") {
    // Verificar se o cns já está cadastrdo no sistema
    if ($formularioDao->getformularioByUserCns($cns_old, $caps_id)) {
      $formulario = new Formulario();

      
      $formulario->caps = $caps;
      $formulario->cnes = $cnes;
      $formulario->n_prontuario = $n_prontuario;
      $formulario->mes_ano_atend = $mes_ano_atend;
      $formulario->usuario = $usuario;
      $formulario->cns = $cns;
      $formulario->dt_admiss_usr = $dt_admiss_usr;
      $formulario->dt_nasc = $dt_nasc;
      $formulario->nome_mae = $nome_mae;
      $formulario->responsavel = $responsavel;
      $formulario->raca_cor = $raca_cor;
      $formulario->etnia_indigena = $etnia_indigena;
      $formulario->sexo = $sexo;
      $formulario->centro_saude = $centro_saude;
      $formulario->telefone = $telefone;
      $formulario->endereco = $endereco;
      $formulario->mun_res = $mun_res;
      $formulario->cep = $cep;
      $formulario->nacional = $nacional;
      $formulario->situacao_rua = $situacao_rua;
      $formulario->origem_outros = $origem_outros;
      $formulario->alcool_drogas = $alcool_drogas;
      $formulario->alcool = $alcool;
      $formulario->crack = $crack;
      $formulario->cocaina = $cocaina;
      $formulario->cannabis = $cannabis;
      $formulario->outras_drogas = $outras_drogas;
      $formulario->demanda_espontanea = $demanda_espontanea;
      $formulario->ubs = $ubs;
      $formulario->serv_u_e = $serv_u_e;
      $formulario->outro_caps = $outro_caps;
      $formulario->hosp_geral = $hosp_geral;
      $formulario->hosp_psiqui = $hosp_psiqui;
      $formulario->cid10_princ = $cid10_princ;
      $formulario->des_diag_princ = $des_diag_princ;
      $formulario->cid10_caus_assoc = $cid10_caus_assoc;
      $formulario->estrategia_sau_fam = $estrategia_sau_fam;
      $formulario->encaminhamento = $encaminhamento;
      $formulario->data_fechamento = $data_fechamento;
      $formulario->prof_referenc = $prof_referenc;
      $formulario->status = $status;
      $formulario->caps_id = $caps_user;
      $motivo = ["obito", "alta", "abandono"];
//      if($caps_user !== $formulario->caps_id) {
//	    $formulario->data_fechamento = "";
//	    $formulario->prof_referenc = "";
//          $formulario->historico = "Transferido para: ".$formulario->caps.", Data: ".date('m/Y');
//	    $formularioDao->insertHistoricoFromCns($formulario->historico, $formulario->cns, "black");
//	    $formularioDao->regisPassagem($formulario->cns, $formulario->caps_id);
//            $formularioDao->update($formulario, $cns_old);
      //      } 
      if($formulario->status === "Ativo" && $formulario->status === $formularioDao->checkAtivoInativo($cns_old, $formulario->caps_id)) {
	  if(!in_array($formulario->encaminhamento, $motivo)) {
          $formularioDao->update($formulario, $cns_old);
        } else {
          $message->setMessage("Para mudar o tipo do encaminhamento para conclusão, Altere o status para Inativo e informe a data!.", "error", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");
        }
      } else if($formulario->status == "Ativo" && $formulario->status !== $formularioDao->checkAtivoInativo($cns_old, $formulario->caps_id)) { 
        if(!in_array($formulario->encaminhamento, $motivo)) {
            $formulario->data_fechamento = "";
            $formulario->historico = "Ativado pelo Caps: ".$formulario->caps.", Data: ".date('m/Y');
	    $formularioDao->insertHistoricoFromCns($formulario->historico, $formulario->cns, "blue", $formulario->caps_id);
            $formularioDao->update($formulario, $cns_old);
          } else {
            $message->setMessage("Para ativar mude o encaminhamento!.", "error", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");    
          }
      } else if($formulario->status === "Inativo" && $formulario->status === $formularioDao->checkAtivoInativo($cns_old, $formulario->caps_id)) {
          $message->setMessage("O paciente está inativo, ative-o se deseja atualiza-lo!.", "error", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");    
      } else {
        if(!in_array($formulario->encaminhamento, $motivo)) {
          $message->setMessage("Motivo para desativar incorreto!.", "error", "?file=formulario&select_busca=update&pesquisa=$formulario->cns");    
        }else if($formulario->prof_referenc == "") {
          $message->setMessage("Paciente precisa ter profissional de referência!.", "error", "?file=formulario&select_busca=update&pesquisa=$formulario->cns"); 
	}else {
	  $profissional = $formularioDao->getProfiFromCbo($formulario->prof_referenc);
	  $formulario->historico = "Desativado na data ".date('m/Y')."&nbsp;&nbsp;-&nbsp;&nbsp; Profissional de referencia: ".$profissional["nome"]."&nbsp;&nbsp;-&nbsp;&nbsp; CNS: ".$profissional["cbo"]."&nbsp;&nbsp;-&nbsp;&nbsp; Caps: ".$formulario->caps."&nbsp;&nbsp;-&nbsp;&nbsp; motivo: ".$formulario->encaminhamento;
	  $formularioDao->insertHistoricoFromCns($formulario->historico, $formulario->cns, "red", $formulario->caps_id);
          $formulario->prof_referenc = "";
          $formularioDao->update($formulario, $cns_old);
        }
      }
    }
  } else {
    $message->setMessage("Informações inválidas!.", "error", "index.php?file=home");
  }
} else if($type === "cad_profi") {

  $nome = filter_input(INPUT_POST, "nome");
  $caps_id = filter_input(INPUT_POST, "caps_id");
  $cbo = filter_input(INPUT_POST, "cbo");

  $data["nome"] = $nome;
  $data["caps_id"] = $caps_id;
  $data["cbo"] = $cbo;

  if(!empty($nome) && !empty($cbo) && !empty($caps_id)) {
    
    if($formularioDao->getProfiFromCbo($cbo) === false) {
      $formularioDao->registerProfi($data);
    } else {
      $message->setMessage("CNS já cadastrado!", "error", "?file=profissionais");  
    }
  }else {
    $message->setMessage("Preencha Nome e CNS!", "error", "?file=profissionais");
  }

} else if($type === "edit_profi") {

  $nome = filter_input(INPUT_POST, "nome");
  $caps_id = filter_input(INPUT_POST, "caps_id");
  $cbo = filter_input(INPUT_POST, "cbo");
  $cbo_orig = filter_input(INPUT_POST, "cbo_orig");

  $data["nome"] = $nome;
  $data["caps_id"] = $caps_id;
  $data["cbo"] = $cbo;
  $data["cbo_orig"] = $cbo_orig;
  

  if(!empty($nome) && !empty($cbo) && !empty($caps_id) && !empty($cbo_orig)) {
    if($formularioDao->getProfiFromCbo($cbo) === false) {
      $formularioDao->updateProfi($data);
    } else if ($cbo !== $cbo_orig) {
      $message->setMessage("CNS já cadastrado!.", "error", "?file=profissionais");  
    } else {
      $formularioDao->updateProfi($data);
    }
  }else {
    $message->setMessage("Preencha Nome e CNS!.", "error", "?file=profissionais");
  }

} else if($type === "del_profi") {

  $caps_id = filter_input(INPUT_POST, "caps_id");
  $cbo = filter_input(INPUT_POST, "cbo");

  $data["caps_id"] = $caps_id;
  $data["cbo_orig"] = $cbo;

  if(!empty($cbo) && !empty($caps_id)) {
    if($formularioDao->getProfiFromCbo($cbo)) {
      $formularioDao->deleteProfi($data);
    } else {
      $message->setMessage("Cadastro não encontrado!.", "error", "?file=profissionais");  
    }
  }else {
    $message->setMessage("Algo deu errado, tente novamente!.", "error", "?file=profissionais");
  }

} else {
  // Enviar uma msg de erro, de dados faltantes
  $message->setMessage("Informações inválidas!.", "error", "index.php?file=home");
}
