<?php 
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['loginUser']) && $_SESSION['senhaUser'] === true) {
    header("Location: paginas/home.php");
    exit;
}

include_once('config/conexao.php');

// Processa o login ANTES de qualquer HTML
$message = '';

if (isset($_POST['login'])) {
    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

    if ($login && $senha) {
        $select = "SELECT * FROM tb_user WHERE email_user = :emailLogin";

        try {
            $resultLogin = $conect->prepare($select);
            $resultLogin->bindParam(':emailLogin', $login, PDO::PARAM_STR);
            $resultLogin->execute();

            if ($resultLogin->rowCount() > 0) {
                $user = $resultLogin->fetch(PDO::FETCH_ASSOC);

                if (password_verify($senha, $user['senha_user'])) {
                    $_SESSION['loginUser'] = $login;
                    $_SESSION['senhaUser'] = $user['id_user'];
                    
                    // REDIRECIONA IMEDIATAMENTE - ANTES DE QUALQUER HTML
                    header("Location: paginas/home.php?acao=bemvindo");
                    exit;
                } else {
                    $message = '<div class="alert alert-danger text-center">Senha incorreta!</div>';
                }
            } else {
                $message = '<div class="alert alert-danger text-center">E-mail não encontrado!</div>';
            }

        } catch (PDOException $e) {
            $message = '<div class="alert alert-danger text-center">Erro ao tentar logar. Tente mais tarde.</div>';
        }

    } else {
        $message = '<div class="alert alert-danger text-center">Todos os campos são obrigatórios.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Seu Gerenciador de Filmes Favoritos | Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

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
    
    body {
      background: linear-gradient(135deg, var(--darker), var(--dark));
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      color: var(--light);
      overflow-x: hidden;
      position: relative;
    }

    /* Efeito de luzes de cinema */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, 
        transparent 0%, 
        var(--primary) 20%, 
        var(--secondary) 40%, 
        var(--primary) 60%, 
        var(--secondary) 80%, 
        transparent 100%);
      box-shadow: 0 0 15px var(--primary), 0 0 30px var(--primary);
      z-index: 10;
      animation: lightBar 3s infinite linear;
    }

    @keyframes lightBar {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .main-container {
      display: flex;
      min-height: 100vh;
      align-items: center;
    }

    .cinema-section {
      flex: 1;
      background: linear-gradient(135deg, rgba(229, 9, 20, 0.1), rgba(245, 197, 24, 0.1));
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }

    .cinema-content {
      text-align: center;
      max-width: 600px;
      z-index: 2;
      position: relative;
    }

    .cinema-poster {
      background: linear-gradient(135deg, rgba(20, 20, 20, 0.9), rgba(10, 10, 10, 0.9));
      border-radius: 15px;
      padding: 3rem 2.5rem;
      border: 3px solid var(--secondary);
      box-shadow: 0 0 30px rgba(245, 197, 24, 0.3);
      position: relative;
      overflow: hidden;
    }

    .cinema-poster::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, 
        var(--primary) 0%, 
        var(--secondary) 50%, 
        var(--primary) 100%);
    }

    .cinema-logo {
      font-size: 3rem;
      color: var(--secondary);
      margin-bottom: 0.5rem;
      text-shadow: 0 0 20px rgba(245, 197, 24, 0.5);
    }

    .cinema-title {
      font-size: 2.2rem;
      font-weight: bold;
      color: var(--light);
      margin-bottom: 0.5rem;
      background: linear-gradient(to right, var(--light), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .cinema-subtitle {
      font-size: 1.4rem;
      color: var(--primary);
      margin-bottom: 2rem;
      font-weight: 300;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .main-message {
      font-size: 2.5rem;
      color: var(--secondary);
      margin: 2rem 0;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 2px;
      line-height: 1.2;
      text-shadow: 0 0 10px rgba(245, 197, 24, 0.5);
      animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
      from {
        text-shadow: 0 0 10px rgba(245, 197, 24, 0.5);
      }
      to {
        text-shadow: 0 0 20px rgba(245, 197, 24, 0.8), 0 0 30px rgba(245, 197, 24, 0.6);
      }
    }

    .info-text {
      color: var(--gray);
      margin-top: 1.5rem;
      font-size: 1rem;
      line-height: 1.5;
    }

    .period-info {
      color: var(--secondary);
      font-weight: bold;
      margin-top: 1rem;
      font-size: 1.1rem;
    }

    .login-section {
      width: 450px;
      padding: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      width: 100%;
      max-width: 450px;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .login-card {
      background: rgba(20, 20, 20, 0.9);
      border-radius: 15px;
      padding: 2.5rem 2rem;
      margin-top: 20px;
      box-shadow: 0 10px 35px rgba(0,0,0,0.8);
      animation: fadeIn 0.5s ease;
      color: var(--light);
      border: 1px solid var(--dark-gray);
      position: relative;
      overflow: hidden;
    }

    /* Efeito de cortina de cinema */
    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, 
        var(--primary) 0%, 
        var(--secondary) 50%, 
        var(--primary) 100%);
      z-index: 1;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .cinema-img {
      width: 140px;
      margin-bottom: 15px;
      filter: drop-shadow(0 5px 15px rgba(229, 9, 20, 0.5));
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }

    h1 {
      color: var(--light);
      text-shadow: 0 2px 10px rgba(0,0,0,0.7);
      font-weight: 700;
      margin-bottom: 0.5rem;
      background: linear-gradient(to right, var(--light), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .subtitle {
      color: var(--gray);
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
    }

    label {
      font-weight: 600;
      margin-bottom: 8px;
      text-align: left;
      width: 100%;
      color: var(--light);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-control {
      height: 50px;
      border-radius: 8px;
      background: rgba(45, 45, 45, 0.7);
      border: 1px solid var(--dark-gray);
      color: var(--light);
      padding-left: 15px;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      background: rgba(60, 60, 60, 0.8);
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(229, 9, 20, 0.25);
      color: var(--light);
    }

    .form-control::placeholder {
      color: var(--gray);
    }

    .input-icon {
      color: var(--gray);
      width: 20px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      font-size: 1.1rem;
      font-weight: 600;
      padding: 12px;
      border-radius: 8px;
      margin-top: 15px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(229, 9, 20, 0.4);
      position: relative;
      overflow: hidden;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(229, 9, 20, 0.6);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-primary::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: 0.5s;
    }

    .btn-primary:hover::after {
      left: 100%;
    }

    a {
      color: var(--secondary);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    a:hover { 
      color: var(--primary); 
      text-decoration: none;
    }

    .alert {
      border-radius: 8px;
      border: none;
      font-weight: 500;
    }

    .alert-success {
      background-color: rgba(40, 167, 69, 0.2);
      color: #28a745;
      border-left: 4px solid #28a745;
    }

    .alert-danger {
      background-color: rgba(220, 53, 69, 0.2);
      color: #dc3545;
      border-left: 4px solid #dc3545;
    }

    .alert-warning {
      background-color: rgba(255, 193, 7, 0.2);
      color: #ffc107;
      border-left: 4px solid #ffc107;
    }

    /* Efeito de cortina lateral */
    .curtain {
      position: fixed;
      top: 0;
      width: 20%;
      height: 100%;
      background: linear-gradient(to right, rgba(20, 20, 20, 0.9), rgba(20, 20, 20, 0.7));
      z-index: 1;
    }

    .curtain-left {
      left: 0;
      background: linear-gradient(to right, rgba(20, 20, 20, 0.9), transparent);
    }

    .curtain-right {
      right: 0;
      background: linear-gradient(to left, rgba(20, 20, 20, 0.9), transparent);
    }

    /* Efeito de tela de cinema */
    .screen {
      position: fixed;
      top: 20%;
      left: 25%;
      width: 50%;
      height: 10px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      box-shadow: 0 0 60px 30px rgba(255, 255, 255, 0.1);
      z-index: 1;
    }

    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
      }
      .cinema-section {
        order: 2;
        padding: 1rem;
      }
      .login-section {
        width: 100%;
        order: 1;
      }
      .curtain {
        width: 10%;
      }
      .screen {
        left: 15%;
        width: 70%;
      }
    }
  </style>
</head>
<body>

  <!-- Efeito de cortinas laterais -->
  <div class="curtain curtain-left"></div>
  <div class="curtain curtain-right"></div>

  <!-- Efeito de tela de cinema -->
  <div class="screen"></div>

<div class="main-container">
  <!-- SEÇÃO DO CINEMA (SIMPLIFICADA) -->
  <div class="cinema-section">
    <div class="cinema-content">
      <div class="cinema-poster">
        <div class="cinema-logo">🎬</div>
        <h1 class="cinema-title">GRUPO CINE</h1>
        <h2 class="cinema-subtitle">CINEMAS</h2>
        
        <div class="main-message">
          FILMES<br>
          CONFIRA OS<br>
          EM CARTAZ
        </div>

        <p class="info-text">
          Confira a disponibilidade de filmes na nossa unidade. 
          Faça login para ver a programação completa.
        </p>
        
        <div class="period-info">De 1 a 22 de dezembro</div>
      </div>
    </div>
  </div>

  <!-- SEÇÃO DO LOGIN (ORIGINAL - MANTIDA INTACTA) -->
  <div class="login-section">
    <div class="login-container">
      <!-- IMAGEM DE CINEMA -->
      <img src="https://cdn-icons-png.flaticon.com/512/2798/2798007.png" class="cinema-img" alt="Cinema">

      <h1 class="mt-1 fw-bold">Bem-vindo ao Catálogo de Filmes</h1>
      <p class="subtitle">Gerencie e organize seus filmes favoritos facilmente</p>

      <div class="login-card">

        <?php
        // Exibe mensagens de GET (ações como negado, sair)
        if (isset($_GET['acao'])) {
            if ($_GET['acao'] == 'negado') {
                echo '<div class="alert alert-danger text-center">Erro ao acessar o sistema! Efetue o login.</div>';
            } elseif ($_GET['acao'] == 'sair') {
                echo '<div class="alert alert-warning text-center">Você saiu do sistema!</div>';
            }
        }

        // Exibe mensagens do processamento do login
        echo $message;
        ?>

        <p class="text-center mb-4" style="color:#b8b8c7; font-size:0.95rem;">
          Para acessar, é necessário um e-mail e senha válidos.
        </p>

        <form method="post" class="mt-2">

          <label for="email">
            <i class="fas fa-envelope input-icon"></i> Email
          </label>
          <input type="email" id="email" name="email" class="form-control mb-3" placeholder="seuemail@gmail.com" required>

          <label for="senha">
            <i class="fas fa-lock input-icon"></i> Senha
          </label>
          <input type="password" id="senha" name="senha" class="form-control mb-3" placeholder="Sua senha" required>

          <button type="submit" name="login" class="btn btn-primary w-100">
            <i class="fa-solid fa-ticket"></i> Acessar os Filmes
          </button>

        </form>

        <p class="text-center mt-3">
          <a href="cad_user.php">Ainda não tem cadastro? Clique aqui!</a>
        </p>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Código JavaScript removido pois não é mais necessário para as pipocas
  document.addEventListener('DOMContentLoaded', function() {
    // Aqui você pode adicionar outros efeitos se desejar
    console.log('Página carregada com sucesso!');
  });
  // 
</script>
<!-- commit -->
 <!--  -->
</body>
</html>