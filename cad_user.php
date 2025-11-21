<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Catálogo de Filmes | Cadastro de Usuário</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
      display: flex;
      justify-content: center;
      align-items: center;
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

    .register-container {
      width: 100%;
      max-width: 500px;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .register-card {
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
    .register-card::before {
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

    /* Estilização do campo de arquivo */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .file-upload-container {
      border: 2px dashed var(--dark-gray);
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      transition: all 0.3s ease;
      background: rgba(45, 45, 45, 0.5);
      cursor: pointer;
    }

    .file-upload-container:hover {
      border-color: var(--primary);
      background: rgba(60, 60, 60, 0.6);
    }

    .file-upload-label {
      display: flex;
      flex-direction: column;
      align-items: center;
      cursor: pointer;
      color: var(--gray);
    }

    .file-upload-icon {
      font-size: 2rem;
      margin-bottom: 10px;
      color: var(--secondary);
    }

    .file-upload-text {
      font-weight: 600;
      color: var(--light);
    }

    .file-upload-hint {
      font-size: 0.85rem;
      margin-top: 5px;
    }

    .file-input {
      display: none;
    }

    .file-name {
      margin-top: 10px;
      font-size: 0.9rem;
      color: var(--secondary);
      font-weight: 500;
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
      margin-bottom: 1.5rem;
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
      .curtain {
        width: 10%;
      }
      .screen {
        left: 15%;
        width: 70%;
      }
      .register-container {
        max-width: 90%;
        padding: 0 15px;
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


<div class="register-container">

  <!-- IMAGEM DE CINEMA -->
  <img src="https://cdn-icons-png.flaticon.com/512/2798/2798007.png" class="cinema-img" alt="Cinema">

  <h1 class="mt-1 fw-bold">Cadastre-se no Catálogo de Filmes</h1>
  <p class="subtitle">Crie sua conta para gerenciar seus filmes favoritos</p>

  <div class="register-card">

    <?php
    include_once('config/conexao.php');

    if (isset($_POST['botao'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        if (!empty($_FILES['foto']['name'])) {
            $formatosPermitidos = array("png", "jpg", "jpeg", "gif");
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

            if (in_array(strtolower($extensao), $formatosPermitidos)) {
                $pasta = "img/user/";
                $temporario = $_FILES['foto']['tmp_name'];
                $novoNome = uniqid() . ".$extensao";

                if (move_uploaded_file($temporario, $pasta . $novoNome)) {
                    // Sucesso no upload da imagem
                } else {
                    echo '<div class="alert alert-danger text-center">
                            <i class="fas fa-exclamation-triangle"></i> Não foi possível fazer o upload do arquivo.
                          </div>';
                    exit();
                }
            } else {
                echo '<div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle"></i> Formato de arquivo não permitido.
                      </div>';
                exit();
            }
        } else {
            $novoNome = 'avatar-padrao.png';
        }

        $cadastro = "INSERT INTO tb_user (foto_user, nome_user, email_user, senha_user) VALUES (:foto, :nome, :email, :senha)";

        try {
            $result = $conect->prepare($cadastro);
            $result->bindParam(':nome', $nome, PDO::PARAM_STR);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->bindParam(':senha', $senha, PDO::PARAM_STR);
            $result->bindParam(':foto', $novoNome, PDO::PARAM_STR);
            $result->execute();
            $contar = $result->rowCount();

            if ($contar > 0) {
    echo '<div class="alert alert-success text-center">
            <i class="fas fa-check"></i> Cadastro realizado com sucesso! Redirecionando para login...
          </div>';
    echo '<script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 3000);
          </script>';
    exit();

                header("Refresh: 3; url=index.php");
            } else {
                echo '<div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle"></i> Erro ao realizar cadastro.
                      </div>';
            }
        } catch (PDOException $e) {
            error_log("ERRO DE PDO: " . $e->getMessage());
            echo '<div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle"></i> Ocorreu um erro ao tentar cadastrar.
                  </div>';
        }
    }
    ?>

    <p class="text-center mb-4" style="color:#b8b8c7; font-size:0.95rem;">
      Preencha todos os dados para criar sua conta
    </p>

    <form action="" method="post" enctype="multipart/form-data">
      
      <!-- Campo de upload de foto estilizado -->
      <div class="form-group">
        <div class="file-upload-container" onclick="document.getElementById('foto').click()">
          <label class="file-upload-label">
            <i class="fas fa-camera file-upload-icon"></i>
            <span class="file-upload-text">Foto do Perfil</span>
            <span class="file-upload-hint">Clique para selecionar uma imagem</span>
            <span class="file-upload-hint">Formatos: PNG, JPG, JPEG, GIF</span>
          </label>
          <input type="file" class="file-input" name="foto" id="foto" accept="image/*">
          <div class="file-name" id="fileName">Nenhum arquivo selecionado</div>
        </div>
      </div>

      <div class="input-group mb-3">
        <input type="text" name="nome" class="form-control" placeholder="Digite seu Nome Completo..." required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-user input-icon"></span>
          </div>
        </div>
      </div>

      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Digite seu E-mail..." required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-envelope input-icon"></span>
          </div>
        </div>
      </div>
      
      <div class="input-group mb-3">
        <input type="password" name="senha" class="form-control" placeholder="Digite sua Senha..." required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock input-icon"></span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12" style="margin-bottom: 25px">
          <button type="submit" name="botao" class="btn btn-primary btn-block">
            <i class="fas fa-ticket-alt"></i> Finalizar Cadastro
          </button>
        </div>
      </div>
    </form>

    <p style="text-align: center; margin-top: 20px;">
      <a href="index.php" class="text-center">
        <i class="fas fa-arrow-left"></i> Voltar para o Login
      </a>
    </p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>