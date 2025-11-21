<?php
// Inicia o buffer de saída
ob_start();

// Inicia a sessão apenas se ainda não tiver sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se as variáveis de sessão estão definidas
if (!isset($_SESSION['loginUser'])) {
    // Redireciona para a página inicial com a mensagem de acesso negado
    header("Location: ../index.php?acao=negado");
    exit;
}

// Inclui o script de saída
include_once('sair.php');
?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>filmes</title>
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="../dist/css/estilo.css">
  
  <style>
    :root {
      --primary: #e50914;
      --primary-dark: #b2070f;
      --secondary: #f5c518;
      --dark: #141414;
      --darker: #0a0a0a;
      --light: #ffffff;
      --gray: #8c8c8c;
      --dark-gray: #2d2d2d;
    }
    
    /* Navbar Superior */
    .main-header {
      background: linear-gradient(135deg, var(--dark), var(--darker)) !important;
      border-bottom: 3px solid var(--primary);
    }
    
    .navbar-white {
      background: transparent !important;
    }
    
    .navbar-light .navbar-nav .nav-link {
      color: var(--light) !important;
    }
    
    .navbar-light .navbar-nav .nav-link:hover {
      color: var(--secondary) !important;
    }
    
    /* Sidebar */
    .main-sidebar {
      background: linear-gradient(180deg, #1a1a1a, var(--darker)) !important;
    }
    
    .brand-link {
      border-bottom: 2px solid var(--primary);
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }
    
    .brand-text {
      color: var(--light) !important;
      font-weight: 700;
      font-size: 1.3rem;
    }
    
    /* User Panel */
    .user-panel {
      border-bottom: 1px solid var(--dark-gray);
    }
    
    .user-panel .image img {
      border: 3px solid var(--primary);
    }
    
    .user-panel .info a {
      color: var(--light);
      font-weight: 600;
    }
    
    /* Menu Navigation */
    .nav-sidebar > .nav-item {
      margin-bottom: 5px;
    }
    
    .nav-sidebar .nav-link {
      color: var(--light);
      border-radius: 8px;
      margin: 2px 10px;
      transition: all 0.3s ease;
    }
    
    .nav-sidebar .nav-link:hover {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--light);
      transform: translateX(5px);
    }
    
    .nav-sidebar .nav-link.active {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--light);
    }
    
    .nav-sidebar .nav-icon {
      color: var(--secondary);
    }
    
    body {
      background: linear-gradient(135deg, var(--darker), var(--dark));
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--light);
    }
    
    .content-wrapper {
      background: transparent !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
// Inclui o arquivo de configuração de conexão com o banco de dados
include_once('../config/conexao.php');

// Obtém o email do usuário logado a partir da sessão
$usuarioLogado = $_SESSION['loginUser'];

// Define a consulta SQL para selecionar todos os campos do usuário com base no email
$selectUser = "SELECT * FROM tb_user WHERE email_user=:emailUserLogado";

try {
    // Prepara a consulta SQL
    $resultadoUser = $conect->prepare($selectUser);
    
    // Vincula o parâmetro :emailUserLogado ao valor da variável $usuarioLogado
    $resultadoUser->bindParam(':emailUserLogado', $usuarioLogado, PDO::PARAM_STR);
    
    // Executa a consulta preparada
    $resultadoUser->execute();

    // Conta o número de linhas retornadas pela consulta
    $contar = $resultadoUser->rowCount();
    
    // Se houver uma ou mais linhas retornadas
    if ($contar > 0) {
        // Obtém a próxima linha do conjunto de resultados como um objeto
        $show = $resultadoUser->fetch(PDO::FETCH_OBJ);
        
        // Atribui os valores dos campos do usuário às variáveis PHP
        $id_user = $show->id_user;
        $foto_user = $show->foto_user;
        $nome_user = $show->nome_user;
        $email_user = $show->email_user;
    } else {
        // Exibe uma mensagem de aviso se não houver dados de perfil
        echo '<div class="alert alert-danger"><strong>Aviso!</strong> Não há dados de perfil :(</div>';
    }
} catch (PDOException $e) {
    // Registra a mensagem de erro no log do servidor em vez de exibi-la ao usuário
    error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
    
    // Exibe uma mensagem de erro genérica para o usuário
    echo '<div class="alert alert-danger"><strong>Aviso!</strong> Ocorreu um erro ao tentar acessar os dados do perfil.</div>';
}
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Perfil e Saída">
          <i class="fas fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="home.php?acao=perfil" class="dropdown-item">
          <i class="fas fa-user-alt mr-2"></i> Alterar Perfil
          </a>
          <div class="dropdown-divider"></div>
          <a href="?sair" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Sair da Agenda
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
      <span class="brand-text font-weight-light">seus filmes</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php
            if ($foto_user == 'avatar-padrao.png') {
                echo '<img src="../img/avatar_p/' . $foto_user . '" alt="' . $foto_user . '" title="' . $foto_user . '" style="width: 40px; border-radius: 100%;">';
            } else {
                echo '<img src="../img/user/' . $foto_user . '" alt="' . $foto_user . '" title="' . $foto_user . '" style="width: 40px; border-radius: 100%;">';
            }
          ?>
        </div>
        <div class="info">
          <a href="home.php?acao=perfil" class="d-block"><?php echo $nome_user; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="home.php?acao=bemvindo" class="nav-link <?php echo (!isset($_GET['acao']) || $_GET['acao'] == 'bemvindo') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Principal</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="home.php?acao=relatorio" class="nav-link <?php echo (isset($_GET['acao']) && $_GET['acao'] == 'relatorio') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>Agendamentos</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- ✅✅✅ PARTE QUE ESTAVA FALTANDO ✅✅✅ -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
    // Verifica qual conteúdo carregar baseado no parâmetro 'acao'
    $acao = isset($_GET['acao']) ? $_GET['acao'] : 'bemvindo';
    
    switch ($acao) {
        case 'relatorio':
            // AGORA VAI CARREGAR OS AGENDAMENTOS
            if (file_exists('conteudo/agendamentos.php')) {
                include('conteudo/agendamentos.php');
            } else {
                echo '<div class="container-fluid mt-4">';
                echo '<div class="alert alert-danger">';
                echo '<h4><i class="fas fa-exclamation-triangle"></i> Arquivo não encontrado!</h4>';
                echo '<p>O arquivo <strong>conteudo/agendamentos.php</strong> não foi encontrado.</p>';
                echo '<p>Verifique se o arquivo existe na pasta correta.</p>';
                echo '</div>';
                echo '</div>';
            }
            break;
            
        case 'perfil':
            if (file_exists('conteudo/perfil.php')) {
                include('conteudo/perfil.php');
            } else {
                echo '<div class="alert alert-warning">Página de perfil em desenvolvimento</div>';
            }
            break;
     case 'bemvindo':
default:
    // INCLUI DIRETAMENTE O CÓDIGO DOS FILMES QUE JÁ EXISTE
    if (file_exists('conteudo/cadastro_contato.php')) {
        include('conteudo/cadastro_contato.php');
    } else {
        // SE NÃO EXISTIR, MOSTRA APENAS O TÍTULO COMPACTO
        echo '<section class="content" style="padding: 10px; margin: 0;">';
        echo '<div class="container-fluid" style="padding: 0; margin: 0;">';
        echo '<h1 style="color: #f5c518; margin: 0; text-align: center;">Agendar Sessão</h1>';
        echo '</div>';
        echo '</section>';
    }
    break;
    }
    ?>
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2024 Meus Filmes.</strong> Todos os direitos reservados.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>