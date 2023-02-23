<?php
$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

if ($userData->adm !== "S") {
  $message->setMessage("Acesso restrito!", "error", "?file=home");
}

$users = $userDao->findAll();

?>
<style>
 .table-striped thead tr:nth-of-type(odd) {
    background-color: #75c594;
  }

    .actions-column {
        display: flex;
        flex-direction: row;
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
<div class="m-5 g-contas">
  <h2>Contas de usuários</h2>
  <div class="col-md-12">
    <table class="table table-striped table-white w-100">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col"><i class="fas fa-user"></i> Usuário</th>
          <th scope="col"><i class="fas fa-envelope"></i> E-mail</th>
          <th scope="col"><i class="fas fa-place-of-worship"></i> Caps</th>
          <th scope="col"><i class="fas fa-times mr-2"></i> Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) : ?>
          <form action="<?php $BASE_URL ?>assets/process/user_process.php" method="POST">
            <tr>
              <td scope="row"><?= $user->id ?></td>
              <td><?= $user->name ?></td>
              <td><?= $user->email ?></td>
              <td>
                <div class="form-group">
                  <select name="caps" id="caps" class="form-control w-50">
                    <option value="">Selecione</option>
                    <option value="12" <?= $user->caps_id === 12 ? "selected" : "" ?>>Caps A. Orlando</option>
                    <option value="11" <?= $user->caps_id === 11 ? "selected" : "" ?>>Caps Reviver</option>
                    <option value="10" <?= $user->caps_id === 10 ? "selected" : "" ?>>Caps Esperança</option>
                    <option value="9" <?= $user->caps_id === 9 ? "selected" : "" ?>>Caps Toninho</option>
                    <option value="8" <?= $user->caps_id === 8 ? "selected" : "" ?>>Caps independencia</option>
                    <option value="7" <?= $user->caps_id === 7 ? "selected" : "" ?>>Caps Integração</option>
                    <option value="6" <?= $user->caps_id === 6 ? "selected" : "" ?>>Caps Estação</option>
                    <option value="5" <?= $user->caps_id === 5 ? "selected" : "" ?>>Caps David</option>
                    <option value="4" <?= $user->caps_id === 4 ? "selected" : "" ?>>Caps Carretel</option>
                    <option value="3" <?= $user->caps_id === 3 ? "selected" : "" ?>>Caps Criativo</option>
                    <option value="2" <?= $user->caps_id === 2 ? "selected" : "" ?>>Caps Novo Tempo</option>
                    <option value="1" <?= $user->caps_id === 1 ? "selected" : "" ?>>Sede</option>
                  </select>
                </div>
              <td class="actions-column">
                <input type="hidden" name="type" value="update_usr">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <button type="submit" class="btn btn-primary">Atualizar</button>
          </form>
          <form action="<?php $BASE_URL ?>assets/process/user_process.php" method="POST">
            <input type="hidden" name="type" value="delete">
            <input type="hidden" name="id" value="<?= $user->id ?>">
            <button type="submit" class="btn btn-danger">Deletar</button>
          </form>
          </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
