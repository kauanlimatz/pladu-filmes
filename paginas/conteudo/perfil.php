<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Perfil</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Editar Perfil</h3>
            </div>

            <!-- Formulário -->
            <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label>Nome</label>
                  <input type="text" class="form-control" name="nome" id="nome" required value="<?php echo $nome_user; ?>">
                </div>

                <div class="form-group">
                  <label>E-mail</label>
                  <input type="email" class="form-control" name="email" id="email" required value="<?php echo $email_user; ?>">
                </div>

                <div class="form-group">
                  <label>Senha</label>
                  <input type="password" class="form-control" name="senha" placeholder="**************************">
                </div>

                <div class="form-group">
                  <label>Avatar do usuário</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="foto" id="foto">
                      <label class="custom-file-label" for="foto">Arquivo de imagem</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <button type="submit" name="upPerfil" class="btn btn-primary">Alterar dados do usuário</button>
              </div>
            </form>

<?php
include('../config/conexao.php'); // Conexão com o banco

if (isset($_POST['upPerfil'])) {

  // Recebendo dados do formulário
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha_nova = $_POST['senha'];

  // Buscar dados antigos do usuário
  $query = "SELECT email_user, senha_user, foto_user FROM tb_user WHERE id_user=:id";
  $stmt = $conect->prepare($query);
  $stmt->bindParam(':id', $id_user, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $email_antigo = $row['email_user'];
  $senha_antiga = $row['senha_user'];
  $foto_user = $row['foto_user'];

  // Caminho da pasta correta
  $pasta = "../img/user/";
  $novoNome = $foto_user; // padrão: mantém a antiga

  // Se enviou nova imagem
  if (!empty($_FILES['foto']['name'])) {
    $formatosPermitidos = ["png", "jpg", "jpeg", "gif"];
    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    if (in_array($extensao, $formatosPermitidos)) {
      $temporario = $_FILES['foto']['tmp_name'];
      $novoNome = uniqid("user_") . ".$extensao";

      // Apaga imagem antiga (se existir e não for o padrão)
      if ($foto_user != "avatar-padrao.png" && file_exists($pasta . $foto_user)) {
        unlink($pasta . $foto_user);
      }

      // Move o novo arquivo
      if (!move_uploaded_file($temporario, $pasta . $novoNome)) {
        echo '<div class="alert alert-danger mt-3">Erro ao enviar o arquivo de imagem.</div>';
        $novoNome = $foto_user; // volta para antiga
      }
    } else {
      echo '<div class="alert alert-warning mt-3">Formato inválido! Use apenas JPG, JPEG, PNG ou GIF.</div>';
    }
  }

  // Se senha nova foi digitada, troca
  if (!empty($senha_nova)) {
    $senha = password_hash($senha_nova, PASSWORD_DEFAULT);
  } else {
    $senha = $senha_antiga;
  }

  // Atualiza banco
  $update = "UPDATE tb_user 
             SET foto_user=:foto, nome_user=:nome, email_user=:email, senha_user=:senha 
             WHERE id_user=:id";
  try {
    $result = $conect->prepare($update);
    $result->bindParam(':id', $id_user, PDO::PARAM_STR);
    $result->bindParam(':foto', $novoNome, PDO::PARAM_STR);
    $result->bindParam(':nome', $nome, PDO::PARAM_STR);
    $result->bindParam(':email', $email, PDO::PARAM_STR);
    $result->bindParam(':senha', $senha, PDO::PARAM_STR);
    $result->execute();

    if ($result->rowCount() > 0) {
      echo '<div class="alert alert-success mt-3">Perfil atualizado com sucesso!</div>';

      // Se alterou email ou senha → força logout
      if ($email !== $email_antigo || $senha !== $senha_antiga) {
        header("Location: ?sair");
        exit;
      } else {
        header("Refresh: 2; home.php?acao=perfil");
        exit;
      }
    } else {
      echo '<div class="alert alert-warning mt-3">Nenhuma alteração feita.</div>';
    }
  } catch (PDOException $e) {
    echo '<div class="alert alert-danger mt-3">Erro no banco de dados: ' . $e->getMessage() . '</div>';
  }
}
?>
          </div>
        </div>

        <!-- Coluna Direita -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Dados do Usuário</h3>
            </div>
            <div class="card-body p-0 text-center" style="margin-bottom: 98px;">
              <?php
              if ($show->foto_user == 'avatar-padrao.png') {
                echo '<img src="../img/avatar_p/' . $show->foto_user . '" style="width:200px; border-radius:100%; margin-top:30px">';
              } else {
                echo '<img src="../img/user/' . $show->foto_user . '" style="width:200px; border-radius:100%; margin-top:30px">';
              }
              ?>
              <h1><?php echo $nome_user; ?></h1>
              <strong><?php echo $email_user; ?></strong>
            </div>
          </div>
        </div>

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
</div>
