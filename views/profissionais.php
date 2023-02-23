<?php
$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$formularioDao = new FormularioDAO($conn, $BASE_URL);
$users = $formularioDao->getProfissForCapsId($userData->caps_id);

?>
<style>
  .table-striped thead tr:nth-of-type(odd) {
    background-color: #75c594;
  }

  .actions-column {
    display: flex;
    flex-direction: row;
    justify-content: center;
  }

  .btn {
    width: 30px;
    height: 30px;
    margin: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>

<div style="text-align: center;">
  <?php if ($_POST["type_profi"] === "atualizar") : ?>
    <h2 class="mt-3">Editar</h2>
    <div style="width: 70%; margin: 0 auto;" class="mt-3">
      <table class="table table-striped table-white">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">CNS Profissional</th>
            <th scope="col">Editar</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <form action="<?php $BASE_URL ?>assets/process/formulario_process.php" method="post">
              <td><input type="text" name="nome" value="<?= $_POST['nome'] ?>" class="form-control" placeholder="Nome Profissional Referencia"></td>
              <td><input type="text" name="cbo" value="<?= $_POST['cbo'] ?>" class="form-control" placeholder="CNS Profissional Referencia"></td>
              <td class="actions-column">
                <input type="hidden" name="type" value="edit_profi">
                <input type="hidden" name="caps_id" value="<?= $userData->caps_id ?>">
                <input type="hidden" name="cbo_orig" value="<?= $_POST["cbo"] ?>">
                <button type="submit" class="btn btn-primary">Editar</button>
            </form>
            <form action="" method="post">
              <input type="hidden" name="type_profi" value="cadastrar">
              <button type="submit" class="btn btn-secondary">Cancelar</button>
            </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php else : ?>
    <h2 class="mt-3">Cadastrar</h2>
    <div style="width: 70%; margin: 0 auto;" class="mt-3">
      <table class="table table-striped table-white">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">CNS Profissional</th>
            <th scope="col">Cadastrar</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <form action="<?php $BASE_URL ?>assets/process/formulario_process.php" method="post">
            <td><input type="text" name="nome" class="form-control" placeholder="Nome Profissional Referencia"></td>
            <td><input type="number" name="cbo" class="form-control" placeholder="CNS Profissional Referencia"></td>
            <td class="actions-column">
                <input type="hidden" name="type" value="cad_profi">
                <input type="hidden" name="caps_id" value="<?= $userData->caps_id ?>">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
<div style="text-align: center;" class="mb-5">
  <h2 class="mt-3">Profissionais de Referencia</h2>
  <div style="width: 70%; margin: 0 auto;" class="mt-3">
    <table class="table table-striped table-white">
      <thead>
        <th scope="col">Nome</th>
        <th scope="col">CNS Profissional</th>
        <th scope="col">Ações</th>
      </thead>
      <tbody>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td scope="row"><?= $user["nome"] ?></td>
            <td><?= $user["cbo"] ?></td>
            <td class="actions-column">
              <form action="" method="POST">
                <input type="hidden" name="type_profi" value="atualizar">
                <input type="hidden" name="nome" value="<?= $user["nome"] ?>">
                <input type="hidden" name="cbo" value="<?=$user["cbo"]?>">
                <button type="submit" class="btn btn-primary">Atualizar</button>
              </form>
              <form action="<?php $BASE_URL ?>assets/process/formulario_process.php" method="POST">
                <input type="hidden" name="type" value="del_profi">
                <input type="hidden" name="cbo" value="<?=$user["cbo"]?>">
                <input type="hidden" name="caps_id" value="<?= $userData->caps_id ?>">
                <button type="submit" class="btn btn-danger">Deletar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>