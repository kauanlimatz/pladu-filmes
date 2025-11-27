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
<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>catálogo de filmes</title>
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
    
    /* CORREÇÃO DO ESPAÇO NO RODAPÉ */
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    
    .wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    
    .content-wrapper {
      flex: 1;
      margin-bottom: 0 !important;
      padding-bottom: 0 !important;
    }
    
    .main-footer {
      margin-top: auto;
      padding: 10px 0;
      background: var(--darker);
      border-top: 1px solid var(--primary);
      position: relative;
      bottom: 0;
      width: 100%;
    }
    
    /* APENAS CORES - ESTRUTURA MANTIDA */
    .main-header {
      background: linear-gradient(135deg, var(--dark), var(--darker)) !important;
      border-bottom: 3px solid var(--primary);
    }
    
    .navbar-light .navbar-nav .nav-link {
      color: var(--light) !important;
    }
    
    .navbar-light .navbar-nav .nav-link:hover {
      color: var(--secondary) !important;
    }
    
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
    }
    
    .user-panel {
      border-bottom: 1px solid var(--dark-gray);
    }
    
    .user-panel .info a {
      color: var(--light);
    }
    
    .nav-sidebar .nav-link {
      color: var(--light);
    }
    
    .nav-sidebar .nav-link:hover {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--light);
    }
    
    .nav-sidebar .nav-link.active {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--light);
    }
    
    body {
      background: linear-gradient(135deg, var(--darker), var(--dark));
      color: var(--light);
    }

    /* Estilos para o formulário de agendamento */
    .custom-card {
      border: none;
      border-radius: 10px;
      background: rgba(30, 30, 30, 0.8);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    .card-header-custom {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: var(--light);
      border-bottom: none;
    }
    
    .form-control-custom, .form-select-custom {
      background: rgba(40, 40, 40, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--light);
    }
    
    .form-control-custom:focus, .form-select-custom:focus {
      background: rgba(50, 50, 50, 0.9);
      border-color: var(--primary);
      color: var(--light);
      box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
    }
    
    .btn-custom-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      color: var(--light);
      font-weight: 600;
    }
    
    .btn-custom-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
    }

    /* NOVOS ESTILOS PARA A PÁGINA DE BOAS-VINDAS */
    .welcome-container {
      min-height: 60vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }
    
    .welcome-card {
      background: linear-gradient(135deg, rgba(30, 30, 30, 0.9), rgba(20, 20, 20, 0.95));
      border: none;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(229, 9, 20, 0.2);
      padding: 50px 40px;
      text-align: center;
      max-width: 600px;
      width: 100%;
      border: 1px solid rgba(229, 9, 20, 0.3);
    }
    
    .welcome-icon {
      font-size: 4rem;
      color: var(--primary);
      margin-bottom: 20px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .welcome-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 15px;
      background: linear-gradient(135deg, var(--light), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .welcome-subtitle {
      font-size: 1.2rem;
      color: var(--gray);
      margin-bottom: 30px;
      line-height: 1.6;
    }
    
    .user-greeting {
      font-size: 1.1rem;
      color: var(--secondary);
      margin-bottom: 25px;
      padding: 15px;
      background: rgba(229, 9, 20, 0.1);
      border-radius: 10px;
      border-left: 4px solid var(--primary);
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

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
      <!-- Notifications Dropdown Menu -->
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
        </div>
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
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">filmes</span>
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
            <a href="home.php?acao=bemvindo" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Principal</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="home.php?acao=relatorio" class="nav-link">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>Agendamentos</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
    $acao = isset($_GET['acao']) ? $_GET['acao'] : 'bemvindo';
    
    switch ($acao) {
        case 'relatorio':
            // Conteúdo dos AGENDAMENTOS
            echo '<div class="container-fluid p-4">';
            echo '<h1>Meus Agendamentos</h1>';
            echo '<p>Conteúdo dos agendamentos aqui...</p>';
            echo '</div>';
            break;
            
        case 'bemvindo':
        default:
            // Conteúdo da PÁGINA INICIAL (boas-vindas)
            echo '<div class="welcome-container">';
            echo '<div class="welcome-card">';
            echo '<div class="welcome-icon">';
            echo '<i class="fas fa-film"></i>';
            echo '</div>';
            echo '<h1 class="welcome-title">Bem-vindo ao Seu Catálogo</h1>';
            echo '<p class="welcome-subtitle">';
            echo 'Gerencie sua coleção de filmes favoritos e agende suas próximas sessões de cinema';
            echo '</p>';
            echo '<div class="user-greeting">';
            echo '<i class="fas fa-user-circle mr-2"></i>';
            echo 'Olá, <strong>'.$nome_user.'</strong>! Pronto para explorar o mundo do cinema?';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            break;
    }
    ?>
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2025 Meus Filmes.</strong> Todos os direitos reservados.
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