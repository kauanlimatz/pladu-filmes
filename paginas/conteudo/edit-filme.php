<?php
include('../../config/conexao.php');

// DEBUG - Mostrar que a página está carregando
echo "<!-- DEBUG: Página edit-filme.php carregada -->";
echo "<!-- DEBUG: ID recebido: " . (isset($_GET['id']) ? $_GET['id'] : 'NENHUM') . " -->";

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    echo '<div class="alert alert-danger">ID não especificado!</div>';
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    echo '<div class="alert alert-danger">ID inválido!</div>';
    exit;
}

// Busca os dados do FILME
$select = "SELECT * FROM tb_filmes WHERE id = :id";
try {
    $resultado = $conect->prepare($select);
    $resultado->bindParam(':id', $id, PDO::PARAM_INT);
    $resultado->execute();

    if ($resultado->rowCount() > 0) {
        $filme = $resultado->fetch(PDO::FETCH_OBJ);
        echo "<!-- DEBUG: Filme encontrado: " . $filme->titulo . " -->";
    } else {
        echo '<div class="alert alert-danger">Agendamento não encontrado!</div>';
        exit;
    }
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Erro ao buscar dados: ' . $e->getMessage() . '</div>';
    exit;
}

// Processa a atualização do FILME
if (isset($_POST['atualizar_filme'])) {
    echo "<!-- DEBUG: Formulário submetido -->";
    
    $nome_usuario = $_POST['nome_usuario'];
    $titulo = $_POST['titulo'];
    $horario = $_POST['horario'];
    $local_cinema = $_POST['local_cinema'];
    $genero = $_POST['genero'];
    $classificacao = $_POST['classificacao'];
    $duracao = $_POST['duracao'];

    // Define o cartaz baseado no filme
    if ($titulo == "THUNDERBOLTS") {
        $cartaz = "thunderbolts_fixed.jpg";
    } elseif ($titulo == "BAILARINA") {
        $cartaz = "bailarina_fixed.jpg";
    } else {
        $cartaz = "padrao_filme.png";
    }

    try {
        $update = "UPDATE tb_filmes SET 
                  nome_usuario = :nome_usuario,
                  titulo = :titulo, 
                  horario = :horario, 
                  local_cinema = :local_cinema, 
                  genero = :genero, 
                  classificacao = :classificacao, 
                  duracao = :duracao,
                  cartaz = :cartaz
                  WHERE id = :id";

        $result = $conect->prepare($update);
        $result->bindValue(':nome_usuario', $nome_usuario);
        $result->bindValue(':titulo', $titulo);
        $result->bindValue(':horario', $horario);
        $result->bindValue(':local_cinema', $local_cinema);
        $result->bindValue(':genero', $genero);
        $result->bindValue(':classificacao', $classificacao);
        $result->bindValue(':duracao', $duracao);
        $result->bindValue(':cartaz', $cartaz);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount() > 0) {
            echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                    Agendamento atualizado com sucesso! Redirecionando...
                  </div>';
            echo '<script>setTimeout(function(){ window.location.href = "../home.php"; }, 2000);</script>';
        } else {
            echo '<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Aviso!</h5>
                    Nenhuma alteração foi realizada.
                  </div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Erro!</h5>
                Erro ao atualizar: ' . $e->getMessage() . '
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Editar Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0a0a0a, #141414);
            color: white;
            min-height: 100vh;
            padding: 20px;
        }
        .card {
            background: #1a1a1a;
            border: 2px solid #e50914;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #e50914, #b2070f);
            color: white;
            border-radius: 13px 13px 0 0 !important;
            padding: 15px 20px;
        }
        .form-control {
            background: #2d2d2d;
            border: 1px solid #444;
            color: white;
            padding: 10px 15px;
        }
        .form-control:focus {
            background: #333;
            border-color: #e50914;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #e50914, #b2070f);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #b2070f, #e50914);
            transform: translateY(-2px);
        }
        label {
            color: #f5c518;
            font-weight: 600;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <!-- Content Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-edit me-2"></i>Editar Agendamento</h1>
            <p class="text-muted">Modifique os dados do seu agendamento de filme</p>
        </div>
    </div>

    <!-- Main content -->
    <div class="row">
        <!-- Formulário de Edição -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-film me-2"></i>Editar: <?php echo htmlspecialchars($filme->titulo); ?>
                    </h3>
                </div>
                
                <form role="form" action="" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-user me-2"></i>Nome do Usuário</label>
                                    <input type="text" class="form-control" name="nome_usuario" required 
                                           value="<?php echo htmlspecialchars($filme->nome_usuario); ?>">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-film me-2"></i>Filme</label>
                                    <select class="form-control" name="titulo" required>
                                        <option value="THUNDERBOLTS" <?php echo $filme->titulo == 'THUNDERBOLTS' ? 'selected' : ''; ?>>THUNDERBOLTS</option>
                                        <option value="BAILARINA" <?php echo $filme->titulo == 'BAILARINA' ? 'selected' : ''; ?>>BAILARINA</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-clock me-2"></i>Horário</label>
                                    <select class="form-control" name="horario" required>
                                        <option value="14:00" <?php echo $filme->horario == '14:00' ? 'selected' : ''; ?>>14:00</option>
                                        <option value="16:30" <?php echo $filme->horario == '16:30' ? 'selected' : ''; ?>>16:30</option>
                                        <option value="19:00" <?php echo $filme->horario == '19:00' ? 'selected' : ''; ?>>19:00</option>
                                        <option value="21:30" <?php echo $filme->horario == '21:30' ? 'selected' : ''; ?>>21:30</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-map-marker-alt me-2"></i>Local/Cinema</label>
                                    <select class="form-control" name="local_cinema" required>
                                        <option value="Cinema Shopping Center" <?php echo $filme->local_cinema == 'Cinema Shopping Center' ? 'selected' : ''; ?>>Cinema Shopping Center</option>
                                        <option value="Cinema Downtown" <?php echo $filme->local_cinema == 'Cinema Downtown' ? 'selected' : ''; ?>>Cinema Downtown</option>
                                        <option value="Cinema Plaza" <?php echo $filme->local_cinema == 'Cinema Plaza' ? 'selected' : ''; ?>>Cinema Plaza</option>
                                        <option value="Cinema Metrópole" <?php echo $filme->local_cinema == 'Cinema Metrópole' ? 'selected' : ''; ?>>Cinema Metrópole</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-tag me-2"></i>Gênero</label>
                                    <select class="form-control" name="genero" required>
                                        <option value="Ação" <?php echo $filme->genero == 'Ação' ? 'selected' : ''; ?>>Ação</option>
                                        <option value="Aventura" <?php echo $filme->genero == 'Aventura' ? 'selected' : ''; ?>>Aventura</option>
                                        <option value="Comédia" <?php echo $filme->genero == 'Comédia' ? 'selected' : ''; ?>>Comédia</option>
                                        <option value="Drama" <?php echo $filme->genero == 'Drama' ? 'selected' : ''; ?>>Drama</option>
                                        <option value="Suspense" <?php echo $filme->genero == 'Suspense' ? 'selected' : ''; ?>>Suspense</option>
                                        <option value="Terror" <?php echo $filme->genero == 'Terror' ? 'selected' : ''; ?>>Terror</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-certificate me-2"></i>Classificação</label>
                                    <select class="form-control" name="classificacao" required>
                                        <option value="Livre" <?php echo $filme->classificacao == 'Livre' ? 'selected' : ''; ?>>Livre</option>
                                        <option value="10 anos" <?php echo $filme->classificacao == '10 anos' ? 'selected' : ''; ?>>10 anos</option>
                                        <option value="12 anos" <?php echo $filme->classificacao == '12 anos' ? 'selected' : ''; ?>>12 anos</option>
                                        <option value="14 anos" <?php echo $filme->classificacao == '14 anos' ? 'selected' : ''; ?>>14 anos</option>
                                        <option value="16 anos" <?php echo $filme->classificacao == '16 anos' ? 'selected' : ''; ?>>16 anos</option>
                                        <option value="18 anos" <?php echo $filme->classificacao == '18 anos' ? 'selected' : ''; ?>>18 anos</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label><i class="fas fa-hourglass-half me-2"></i>Duração (minutos)</label>
                                    <input type="number" class="form-control" name="duracao" required 
                                           value="<?php echo $filme->duracao; ?>" min="60" max="240">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer text-center">
                        <button type="submit" name="atualizar_filme" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-save me-2"></i> Atualizar Agendamento
                        </button>
                        <a href="../home.php" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Visualização do Filme -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Detalhes do Agendamento
                    </h3>
                </div>
                <div class="card-body text-center">
                    <?php if ($filme->titulo == "THUNDERBOLTS"): ?>
                        <img src="/index/2k25-main/filmes/Thunderbolts.jpg" 
                             class="img-fluid rounded mb-3" 
                             alt="THUNDERBOLTS"
                             style="max-height: 250px; width: 100%; object-fit: cover;">
                    <?php elseif ($filme->titulo == "BAILARINA"): ?>
                        <img src="/index/2k25-main/filmes/Bailarina.jpeg" 
                             class="img-fluid rounded mb-3" 
                             alt="BAILARINA"
                             style="max-height: 250px; width: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-dark rounded mb-3 d-flex align-items-center justify-content-center" 
                             style="height: 250px;">
                            <i class="fas fa-film fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h4 class="text-warning"><?php echo $filme->titulo; ?></h4>
                    <div class="text-start">
                        <p><strong>Horário:</strong> <span class="text-info"><?php echo $filme->horario; ?></span></p>
                        <p><strong>Local:</strong> <?php echo $filme->local_cinema; ?></p>
                        <p><strong>Gênero:</strong> <?php echo $filme->genero; ?></p>
                        <p><strong>Classificação:</strong> <span class="text-warning"><?php echo $filme->classificacao; ?></span></p>
                        <p><strong>Duração:</strong> <?php echo $filme->duracao; ?> minutos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>