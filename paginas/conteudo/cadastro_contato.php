<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cinema Premium | Agendar Sessão</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

 <style>
    :root {
      --primary: #e50914;
      --primary-dark: #b2070f;
      --primary-light: rgba(229, 9, 20, 0.1);
      --secondary: #f5c518;
      --dark: #0a0a0a;
      --darker: #050505;
      --light: #ffffff;
      --gray: #8c8c8c;
      --dark-gray: #1a1a1a;
      --card-bg: rgba(30, 30, 30, 0.7);
      --card-border: rgba(255, 255, 255, 0.08);
      --accent: #8b0000;
      --gradient: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
    }
    
    * {
      box-sizing: border-box;
    }
    
    body {
      background: var(--gradient);
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
      color: var(--light);
      overflow-x: hidden;
      position: relative;
    }

    /* Efeito de partículas no fundo */
    #particles-js {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -2;
    }

    /* Efeito de brilho sutil */
    .glow-effect {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 30%, rgba(229, 9, 20, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(245, 197, 24, 0.05) 0%, transparent 50%);
      z-index: -1;
      pointer-events: none;
    }

    .content-wrapper {
      background: transparent !important;
      padding: 20px 10px;
      position: relative;
      z-index: 1;
    }

    /* Header Styles - ALINHADO À ESQUERDA */
    .content-header {
      position: relative;
      padding: 20px 0;
      margin-bottom: 30px;
      text-align: left;
    }

    .content-header::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100px;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), transparent);
    }

    .content-header h1 {
      color: var(--light);
      font-weight: 700;
      font-family: 'Montserrat', sans-serif;
      font-size: 2.8rem;
      letter-spacing: -0.5px;
      margin-bottom: 10px;
      position: relative;
      display: inline-block;
      text-align: left;
    }

    .content-header h1::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100px;
      height: 2px;
      background: var(--primary);
    }

    .content-header p {
      color: var(--gray);
      font-size: 1.1rem;
      max-width: 600px;
      margin: 0;
      text-align: left;
    }

    /* Card Styles */
    .custom-card {
      border: none;
      border-radius: 16px;
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 1px solid var(--card-border);
      margin-bottom: 30px;
    }

    .custom-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }

    .custom-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      z-index: 1;
    }

    .card-header-custom {
      background: rgba(20, 20, 20, 0.8);
      border-radius: 16px 16px 0 0;
      border-bottom: 1px solid var(--card-border);
      padding: 1.5rem;
      position: relative;
      overflow: hidden;
    }

    .card-header-custom::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(229, 9, 20, 0.05), transparent);
      z-index: 0;
    }

    .card-header-custom h3 {
      color: var(--light);
      font-weight: 600;
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      font-size: 1.4rem;
      position: relative;
      z-index: 1;
      text-align: left;
    }

    .card-body-custom {
      background: transparent;
      padding: 2rem;
    }

    /* Form Styles */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      font-weight: 500;
      color: var(--light);
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: 'Montserrat', sans-serif;
      font-size: 0.95rem;
      text-align: left;
    }

    .form-control-custom {
      height: 50px;
      border-radius: 10px;
      background: rgba(40, 40, 40, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--light);
      padding: 12px 15px;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    .form-control-custom:focus {
      background: rgba(50, 50, 50, 0.8);
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.15);
      color: var(--light);
    }

    .form-control-custom::placeholder {
      color: var(--gray);
    }

    .form-select-custom {
      height: 50px;
      border-radius: 10px;
      background: rgba(40, 40, 40, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--light);
      padding: 12px 15px;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    .form-select-custom:focus {
      background: rgba(50, 50, 50, 0.8);
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.15);
      color: var(--light);
    }

    /* Button Styles */
    .btn-custom-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      font-size: 1.1rem;
      font-weight: 600;
      padding: 14px 25px;
      border-radius: 10px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(229, 9, 20, 0.3);
      position: relative;
      overflow: hidden;
      color: var(--light);
      font-family: 'Montserrat', sans-serif;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-custom-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(229, 9, 20, 0.5);
      color: var(--light);
    }

    .btn-custom-primary:active {
      transform: translateY(0);
    }

    .btn-custom-success {
      background: linear-gradient(135deg, #27ae60, #229954);
      border: none;
      color: var(--light);
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: 500;
      transition: all 0.3s ease;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-custom-success:hover {
      background: linear-gradient(135deg, #229954, #27ae60);
      transform: translateY(-2px);
      color: var(--light);
    }

    .btn-custom-danger {
      background: linear-gradient(135deg, #e74c3c, #c0392b);
      border: none;
      color: var(--light);
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: 500;
      transition: all 0.3s ease;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-custom-danger:hover {
      background: linear-gradient(135deg, #c0392b, #e74c3c);
      transform: translateY(-2px);
      color: var(--light);
    }

    /* CONTAINER DA IMAGEM CORRIGIDO - MAIS LARGO */
    .movie-card-img-container {
      position: relative;
      overflow: hidden;
      height: 320px; /* Altura reduzida para ficar mais proporcional */
      border-radius: 12px 12px 0 0;
    }

    .movie-card-img {
      height: 100%;
      width: 100%;
      object-fit: cover;
      object-position: center center; /* Centraliza melhor a imagem */
      transition: transform 0.5s ease;
    }

    /* Overlay para o nome do filme CORRIGIDO */
    .movie-card-overlay {
      background: linear-gradient(transparent 10%, rgba(0,0,0,0.8) 60%, rgba(0,0,0,0.95));
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 40px 15px 15px 15px; /* Padding reduzido */
      text-align: left;
    }

    .movie-card-title {
      color: var(--light);
      font-weight: 700;
      font-family: 'Montserrat', sans-serif;
      font-size: 1.2rem; /* Tamanho reduzido */
      margin: 0;
      text-align: left;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.9);
      line-height: 1.2;
      letter-spacing: 0.5px;
    }

    /* Informações do filme CORRIGIDAS */
    .movie-info {
      color: var(--light);
      font-size: 0.85rem; /* Tamanho reduzido */
      padding: 15px 12px; /* Padding reduzido */
      background: rgba(15, 15, 15, 0.95);
      border-top: 1px solid rgba(255,255,255,0.1);
      text-align: left;
    }

    .movie-info p {
      margin-bottom: 8px; /* Espaço reduzido */
      display: flex;
      align-items: center;
      gap: 8px;
      line-height: 1.3;
      text-align: left;
    }

    .movie-info b {
      color: var(--secondary);
      font-weight: 600;
      min-width: 80px; /* Largura reduzida */
      font-size: 0.8rem;
    }

    .movie-info .small {
      font-size: 0.8rem;
    }

    /* Card completo CORRIGIDO */
    .movie-card {
      border: none;
      border-radius: 12px;
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
      height: 100%;
      position: relative;
      border: 1px solid var(--card-border);
      margin: 0 0 2rem 0;
      display: flex;
      flex-direction: column;
    }

    .movie-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(229, 9, 20, 0.2);
    }

    .movie-card:hover .movie-card-img {
      transform: scale(1.08);
    }

    /* Footer do card */
    .card-footer:last-child {
      background: rgba(10, 10, 10, 0.95) !important;
      border-top: 1px solid var(--card-border) !important;
      padding: 12px !important; /* Padding reduzido */
      text-align: left;
      margin-top: auto;
    }

    /* Badge estilo Centerplex */
    .badge {
      font-weight: 600;
      font-size: 0.8rem; /* Tamanho reduzido */
      padding: 6px 12px; /* Padding reduzido */
      border-radius: 20px;
      letter-spacing: 0.5px;
    }

    /* FILMES COM LAYOUT CORRIGIDO */
    .col-md-6.col-lg-4 {
      flex: 0 0 auto;
      width: 100%;
      padding-left: 0 !important;
    }

    @media (min-width: 576px) {
      .col-md-6.col-lg-4 {
        width: 50%;
      }
    }

    @media (min-width: 768px) {
      .col-md-6.col-lg-4 {
        width: 33.333%;
      }
    }

    @media (min-width: 1200px) {
      .col-md-6.col-lg-4 {
        width: 25%;
        padding: 0 12px 0 0 !important;
      }
    }

    /* Alert Styles */
    .alert-custom {
      border-radius: 10px;
      border: none;
      font-weight: 500;
      margin-bottom: 1.5rem;
      font-family: 'Inter', sans-serif;
      backdrop-filter: blur(10px);
      text-align: left;
    }

    .alert-success-custom {
      background-color: rgba(40, 167, 69, 0.15);
      color: #28a745;
      border-left: 4px solid #28a745;
    }

    .alert-danger-custom {
      background-color: rgba(220, 53, 69, 0.15);
      color: #dc3545;
      border-left: 4px solid #dc3545;
    }

    /* Melhorar responsividade */
    @media (max-width: 768px) {
      .content-header h1 {
        font-size: 2.2rem;
      }
      .btn-custom-primary {
        font-size: 1rem;
        padding: 12px 20px;
      }
      .card-body-custom {
        padding: 1.5rem;
      }
      .movie-card-img-container {
        height: 280px;
      }
      .movie-card-title {
        font-size: 1.1rem;
      }
      .movie-info {
        padding: 12px 10px;
      }
    }

    /* Efeito de brilho nos ícones */
    .fa-film, .fa-calendar-plus, .fa-calendar-check {
      filter: drop-shadow(0 0 5px rgba(245, 197, 24, 0.5));
    }

    /* Efeito de destaque nos cards de filmes */
    .movie-highlight {
      position: relative;
    }

    .movie-highlight::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      border-radius: 12px;
      padding: 2px;
      background: linear-gradient(45deg, var(--primary), var(--secondary), var(--primary));
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    /* Placeholder para imagens que não carregarem */
    .movie-card-img {
      background: linear-gradient(135deg, #2d2d2d, #1a1a1a);
    }
  </style>
</head>
<body>

  <!-- Efeito de partículas -->
  <div id="particles-js"></div>
  
  <!-- Efeito de brilho sutil -->
  <div class="glow-effect"></div>

  <!-- Content Wrapper -->
  <div class="content-wrapper">

    <!-- Content Header - ALINHADO À ESQUERDA -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-12">
            <h1>
              <i class="fas fa-film me-3"></i>Agendar Sessão
            </h1>
            <p class="mt-2">
              Escolha seu filme e faça sua reserva com facilidade e segurança
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content - ESTRUTURA REORGANIZADA -->
    <section class="content">
      <div class="container-fluid">
        <!-- SEÇÃO 1: AGENDAR FILME -->
        <div class="row mb-5">
          <div class="col-12">
            <div class="custom-card">
              <div class="card-header-custom">
                <h3>
                  <i class="fas fa-calendar-plus me-2"></i>Agendar Filme
                </h3>
              </div>

              <!-- Formulário de Agendamento -->
              <form role="form" action="" method="post">
                <div class="card-body-custom">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><i class="fas fa-user" style="color: var(--primary);"></i>Seu Nome</label>
                        <input type="text" class="form-control-custom form-control" name="nome_usuario" required placeholder="Digite seu nome completo">
                      </div>

                      <div class="form-group">
                        <label><i class="fas fa-film" style="color: var(--primary);"></i>Filme Escolhido</label>
                        <select class="form-select-custom form-select" name="filme_escolhido" required>
                          <option value="">Selecione um filme</option>
                          <option value="THUNDERBOLTS">THUNDERBOLTS</option>
                          <option value="BAILARINA">BAILARINA</option>
                          <option value="AINDA ESTOU AQUI">AINDA ESTOU AQUI</option>
                          <option value="ANORA">ANORA</option>
                          <option value="COMO TREINAR O SEU DRAGÃO">COMO TREINAR O SEU DRAGÃO</option>
                          <option value="PECADORES">PECADORES</option>
                          <option value="OUTRO">Outro filme</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label><i class="fas fa-clock" style="color: var(--primary);"></i>Horário da Sessão</label>
                        <select class="form-select-custom form-select" name="horario" required>
                          <option value="">Selecione o horário</option>
                          <option value="14:00">14:00</option>
                          <option value="16:30">16:30</option>
                          <option value="19:00">19:00</option>
                          <option value="21:30">21:30</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i>Local/Cinema</label>
                        <select class="form-select-custom form-select" name="local" required>
                          <option value="">Selecione o cinema</option>
                          <option value="Cinema Shopping Center">Cinema Shopping Center</option>
                          <option value="Cinema Downtown">Cinema Downtown</option>
                          <option value="Cinema Plaza">Cinema Plaza</option>
                          <option value="Cinema Metrópole">Cinema Metrópole</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label><i class="fas fa-tag" style="color: var(--primary);"></i>Gênero do Filme</label>
                        <select class="form-select-custom form-select" name="genero" required>
                          <option value="">Selecione o gênero</option>
                          <option value="Ação">Ação</option>
                          <option value="Aventura">Aventura</option>
                          <option value="Comédia">Comédia</option>
                          <option value="Drama">Drama</option>
                          <option value="Suspense">Suspense</option>
                          <option value="Terror">Terror</option>
                          <option value="Ficção Científica">Ficção Científica</option>
                          <option value="Romance">Romance</option>
                          <option value="Animação">Animação</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label><i class="fas fa-certificate" style="color: var(--primary);"></i>Classificação</label>
                        <select class="form-select-custom form-select" name="classificacao" required>
                          <option value="">Selecione a classificação</option>
                          <option value="Livre">Livre</option>
                          <option value="10 anos">10 anos</option>
                          <option value="12 anos">12 anos</option>
                          <option value="14 anos">14 anos</option>
                          <option value="16 anos">16 anos</option>
                          <option value="18 anos">18 anos</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label><i class="fas fa-clock" style="color: var(--primary);"></i>Duração (minutos)</label>
                        <input type="number" class="form-control-custom form-control" name="duracao" required placeholder="Ex: 120" min="60" max="240">
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="id_user" value="<?php echo $id_user ?>">

                </div>

                <div class="card-footer" style="background: rgba(20, 20, 20, 0.8); border-radius: 0 0 16px 16px; border-top: 1px solid var(--card-border); padding: 1.5rem;">
                  <button type="submit" name="agendar" class="btn-custom-primary btn w-100 py-3">
                    <i class="fas fa-ticket-alt"></i>Confirmar Agendamento
                  </button>
                </div>
              </form>

              <?php
              include('../config/conexao.php');

              if (isset($_POST['agendar'])) {

                $nome_usuario = $_POST['nome_usuario'];
                $filme_escolhido = $_POST['filme_escolhido'];
                $horario = $_POST['horario'];
                $local = $_POST['local'];
                $genero = $_POST['genero'];
                $classificacao = $_POST['classificacao'];
                $duracao = $_POST['duracao'];
                $id_usuario = $_POST['id_user'];

                // Definir a imagem do cartaz baseado no filme escolhido
                $cartaz = "padrao_filme.png"; // padrão
                
                if ($filme_escolhido == "THUNDERBOLTS") {
                  $cartaz = "Thunderbolts.jpg";
                } elseif ($filme_escolhido == "BAILARINA") {
                  $cartaz = "Bailarina.jpeg";
                } elseif ($filme_escolhido == "AINDA ESTOU AQUI") {
                  $cartaz = "AindaEstouAqui.jpg";
                } elseif ($filme_escolhido == "ANORA") {
                  $cartaz = "Anora.jpg";
                } elseif ($filme_escolhido == "COMO TREINAR O SEU DRAGÃO") {
                  $cartaz = "ComoTreinaroSeuDragao.jpg";
                } elseif ($filme_escolhido == "PECADORES") {
                  $cartaz = "Pecadores.jpg";
                }

                $cad = "INSERT INTO tb_filmes (titulo, duracao, genero, classificacao, cartaz, id_user, nome_usuario, horario, local_cinema)
                        VALUES (:titulo, :duracao, :genero, :classificacao, :cartaz, :id_user, :nome_usuario, :horario, :local_cinema)";

                try {
                  $r = $conect->prepare($cad);
                  $r->bindParam(':titulo', $filme_escolhido);
                  $r->bindParam(':duracao', $duracao);
                  $r->bindParam(':genero', $genero);
                  $r->bindParam(':classificacao', $classificacao);
                  $r->bindParam(':cartaz', $cartaz);
                  $r->bindParam(':id_user', $id_usuario);
                  $r->bindParam(':nome_usuario', $nome_usuario);
                  $r->bindParam(':horario', $horario);
                  $r->bindParam(':local_cinema', $local);
                  $r->execute();

                  echo '<div class="alert-custom alert-success-custom p-3">
                          <i class="fas fa-check me-2"></i> Agendamento realizado com sucesso!
                        </div>';

                } catch (PDOException $e) {
                  echo '<div class="alert-custom alert-danger-custom p-3">
                          <i class="fas fa-exclamation-triangle me-2"></i> Erro: ' . $e->getMessage() . '
                        </div>';
                }
              }
              ?>

            </div>
          </div>
        </div>

        <!-- SEÇÃO 2: FILMES DISPONÍVEIS -->
        <div class="row mb-5">
          <div class="col-12">
            <div class="custom-card">
              <div class="card-header-custom" style="background: rgba(229, 9, 20, 0.1);">
                <h3>
                  <i class="fas fa-film me-2"></i>Filmes em Cartaz
                </h3>
              </div>

              <div class="card-body-custom">
               <div class="row">

                  <!-- THUNDERBOLTS -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card movie-highlight">
                      <div class="movie-card-img-container">
                        <img src="/index/2k25-main/filmes/Thunderbolts.jpg" 
                            class="movie-card-img" 
                            alt="Thunderbolts">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title">THUNDERBOLTS</h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Duração:</b> 142 min</p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> Ação, Aventura</p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> 14 anos</p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-center">
                          <span class="badge bg-success">EM CARTAZ</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- BAILARINA -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card movie-highlight">
                      <div class="movie-card-img-container">
                        <img src="/index/2k25-main/filmes/Bailarina.jpeg" 
                            class="movie-card-img" 
                            alt="Bailarina">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title">BAILARINA</h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Duração:</b> 118 min</p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> Ação, Suspense</p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> 16 anos</p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-center">
                          <span class="badge bg-success">EM CARTAZ</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- AINDA ESTOU AQUI -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card movie-highlight">
                      <div class="movie-card-img-container">
                        <img src="/index/2k25-main/filmes/AindaEstouAqui.jpg" 
                            class="movie-card-img" 
                            alt="Ainda Estou Aqui">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title">AINDA ESTOU AQUI</h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Duração:</b> 135 min</p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> Drama, Suspense</p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> 14 anos</p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-center">
                          <span class="badge bg-success">EM CARTAZ</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- ANORA -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card movie-highlight">
                      <div class="movie-card-img-container">
                        <img src="/index/2k25-main/filmes/Anora.jpg" 
                            class="movie-card-img" 
                            alt="Anora">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title">ANORA</h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Duração:</b> 128 min</p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> Drama, Romance</p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> 16 anos</p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-center">
                          <span class="badge bg-success">EM CARTAZ</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- COMO TREINAR O SEU DRAGÃO -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card movie-highlight">
                      <div class="movie-card-img-container">
                        <img src="/index/2k25-main/filmes/ComoTreinaroSeuDragao.jpg" 
                            class="movie-card-img" 
                            alt="Como Treinar o Seu Dragão">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title">COMO TREINAR O SEU DRAGÃO</h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Duração:</b> 104 min</p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> Animação, Aventura</p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> Livre</p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-center">
                          <span class="badge bg-success">EM CARTAZ</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- PECADORES -->
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card movie-highlight">
                      <div class="movie-card-img-container">
                        <img src="/index/2k25-main/filmes/Pecadores.jpg" 
                            class="movie-card-img" 
                            alt="Pecadores">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title">PECADORES</h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Duração:</b> 112 min</p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> Terror, Suspense</p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> 18 anos</p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-center">
                          <span class="badge bg-success">EM CARTAZ</span>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SEÇÃO 3: MEUS AGENDAMENTOS -->
        <div class="row">
          <div class="col-12">
            <div class="custom-card">
              <div class="card-header-custom" style="background: rgba(39, 174, 96, 0.1);">
                <h3>
                  <i class="fas fa-calendar-check me-2"></i>Meus Agendamentos
                </h3>
              </div>

              <div class="card-body-custom">
                <div class="row">

                  <?php
                  $sel = "SELECT * FROM tb_filmes WHERE id_user = :id_user ORDER BY id DESC LIMIT 6";

                  try {
                    $r = $conect->prepare($sel);
                    $r->bindParam(":id_user", $id_user);
                    $r->execute();

                    if ($r->rowCount() > 0) {
                      while ($f = $r->fetch(PDO::FETCH_OBJ)) {
                  ?>

                  <!-- CARD DOS AGENDAMENTOS DO USUÁRIO -->
                  <div class="col-md-6 mb-4">
                    <div class="movie-card">
                      <div class="movie-card-img-container">
                        <?php 
                        $imagePath = "/index/2k25-main/filmes/";
                        if ($f->titulo == "THUNDERBOLTS") {
                          $imagePath .= "Thunderbolts.jpg";
                        } elseif ($f->titulo == "BAILARINA") {
                          $imagePath .= "Bailarina.jpeg";
                        } elseif ($f->titulo == "AINDA ESTOU AQUI") {
                          $imagePath .= "AindaEstouAqui.jpg";
                        } elseif ($f->titulo == "ANORA") {
                          $imagePath .= "Anora.jpg";
                        } elseif ($f->titulo == "COMO TREINAR O SEU DRAGÃO") {
                          $imagePath .= "ComoTreinaroSeuDragao.jpg";
                        } elseif ($f->titulo == "PECADORES") {
                          $imagePath .= "Pecadores.jpg";
                        } else {
                          $imagePath = "../img/cartaz/" . $f->cartaz;
                        }
                        ?>
                        <img src="<?php echo $imagePath ?>" class="movie-card-img" alt="<?php echo $f->titulo ?>">
                        <div class="movie-card-overlay d-flex align-items-end">
                          <h5 class="movie-card-title"><?php echo $f->titulo ?></h5>
                        </div>
                      </div>

                      <div class="card-body d-flex flex-column" style="background: transparent;">
                        <div class="movie-info mt-auto">
                          <p class="mb-2"><i class="fas fa-user me-2" style="color: var(--secondary);"></i><b>Reservado por:</b> <?php echo $f->nome_usuario ?></p>
                          <p class="mb-2"><i class="fas fa-clock me-2" style="color: var(--primary);"></i><b>Horário:</b> <?php echo $f->horario ?></p>
                          <p class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: #e74c3c;"></i><b>Local:</b> <?php echo $f->local_cinema ?></p>
                          <p class="mb-2"><i class="fas fa-tag me-2" style="color: var(--secondary);"></i><b>Gênero:</b> <?php echo $f->genero ?></p>
                          <p class="mb-2"><i class="fas fa-certificate me-2" style="color: #f39c12;"></i><b>Classificação:</b> <?php echo $f->classificacao ?></p>
                        </div>
                      </div>

                      <div class="card-footer border-top-0" style="background: transparent; border-top: 1px solid var(--card-border); padding: 1rem;">
                        <div class="d-flex justify-content-between align-items-center">
                          <a href="home.php?acao=editar&id=<?php echo $f->id ?>" 
                            class="btn-custom-success btn btn-sm" 
                            title="Editar agendamento">
                            <i class="fas fa-edit me-1"></i> Editar
                          </a>

                          <a href="conteudo/del-filme.php?idDel=<?php echo $f->id ?>"
                            onclick="return confirm('Tem certeza que deseja cancelar este agendamento?')"
                            class="btn-custom-danger btn btn-sm"
                            title="Cancelar agendamento">
                            <i class="fas fa-trash me-1"></i> Cancelar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                      }
                    } else {
                      echo '<div class="col-12 text-center py-4">
                              <i class="fas fa-film fa-3x mb-3" style="color: var(--gray);"></i>
                              <h4 style="color: var(--gray);">Nenhum agendamento encontrado</h4>
                              <p style="color: var(--gray);">Faça seu primeiro agendamento usando o formulário acima.</p>
                            </div>';
                    }

                  } catch (PDOException $e) {
                    echo '<div class="alert-custom alert-danger-custom p-3 m-3">
                            <i class="fas fa-exclamation-triangle me-2"></i> Erro: ' . $e->getMessage() . '
                          </div>';
                  }
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

  <script>
    // Inicializar partículas
    document.addEventListener('DOMContentLoaded', function() {
      particlesJS("particles-js", {
        particles: {
          number: { value: 80, density: { enable: true, value_area: 800 } },
          color: { value: "#ffffff" },
          shape: { type: "circle" },
          opacity: { value: 0.1, random: true },
          size: { value: 3, random: true },
          line_linked: {
            enable: true,
            distance: 150,
            color: "#ffffff",
            opacity: 0.1,
            width: 1
          },
          move: {
            enable: true,
            speed: 2,
            direction: "none",
            random: true,
            straight: false,
            out_mode: "out",
            bounce: false
          }
        },
        interactivity: {
          detect_on: "canvas",
          events: {
            onhover: { enable: true, mode: "repulse" },
            onclick: { enable: true, mode: "push" },
            resize: true
          }
        },
        retina_detect: true
      });
    });
  </script>
</body>
</html>