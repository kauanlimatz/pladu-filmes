<?php
// conteudo/agendamentos.php

// Consulta para buscar todos os agendamentos
$sel_agendamentos = "SELECT * FROM tb_filmes ORDER BY id DESC";
try {
    $resultado_agendamentos = $conect->prepare($sel_agendamentos);
    $resultado_agendamentos->execute();
    $total_agendamentos = $resultado_agendamentos->rowCount();
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Erro ao carregar agendamentos: ' . $e->getMessage() . '</div>';
}
?>

<!-- Incluir as bibliotecas para PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<style>
    .ingresso-card {
        background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
        border: 3px solid #f5c518;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    
    .ingresso-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(245, 197, 24, 0.3);
    }
    
    .ingresso-header {
        background: linear-gradient(135deg, #e50914, #b2070f);
        color: white;
        padding: 15px;
        text-align: center;
        position: relative;
    }
    
    .ingresso-header::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: repeating-linear-gradient(90deg, transparent, transparent 10px, #f5c518 10px, #f5c518 20px);
        transform: translateY(-50%);
    }
    
    .ingresso-body {
        padding: 20px;
    }
    
    .movie-poster-ingresso {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e50914;
        margin-bottom: 15px;
    }
    
    .info-ingresso {
        background: rgba(229, 9, 20, 0.1);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between; /* ✅ CORREÇÃO AQUI */
        margin-bottom: 8px;
        padding: 5px 0;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
    }
    
    .info-label {
        color: #f5c518;
        font-weight: 600;
        min-width: 120px;
    }
    
    .info-value {
        color: white;
        flex: 1;
        text-align: right; /* ✅ MELHOR ALINHAMENTO */
    }
    
    .btn-ingresso {
        background: linear-gradient(135deg, #e50914, #b2070f);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 5px;
    }
    
    .btn-ingresso:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
        color: white;
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    .btn-pdf:hover {
        background: linear-gradient(135deg, #229954, #1e9c82);
    }
    
    .btn-print-all {
        background: linear-gradient(135deg, #f5c518, #d4af37);
        color: #141414;
        font-size: 1.1rem;
        padding: 12px 30px;
    }
    
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 20px;
    }
    
    /* Estilo específico para PDF */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .ingresso-card {
            border: 2px solid #000;
            margin: 10px;
            break-inside: avoid;
        }
        
        .btn-ingresso {
            display: none !important;
        }
    }
    
    .ingresso-qrcode {
        text-align: center;
        padding: 10px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        margin-top: 10px;
    }
    
    .qrcode-placeholder {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #e50914, #f5c518);
        margin: 0 auto;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
    }

    /* ✅ ADICIONEI ESTILOS PARA MELHOR VISUALIZAÇÃO */
    .content-header {
        margin-bottom: 20px;
    }
    
    .card-tools .badge {
        font-size: 1rem;
        padding: 8px 12px;
    }
</style>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="background: linear-gradient(135deg, #1a1a1a, #2d2d2d); border: none;">
                    <div class="card-header" style="background: linear-gradient(135deg, #e50914, #b2070f);">
                        <h3 class="card-title text-white">
                            <i class="fas fa-ticket-alt mr-2"></i>Meus Ingressos - Filmes Agendados
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-light">
                                <i class="fas fa-film mr-1"></i> <?php echo $total_agendamentos; ?> ingressos
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- ✅ ADICIONEI UMA MENSAGEM DE DEBUG -->
                        <div class="alert alert-info no-print">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Página carregada com sucesso!</strong> Total de agendamentos: <?php echo $total_agendamentos; ?>
                        </div>

                        <!-- Controles Gerais -->
                        <div class="text-center mb-4 no-print">
                            <div class="alert alert-warning d-inline-block">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Ingressos Disponíveis para Impressão</strong> - Clique em "Gerar PDF" para baixar seu ingresso
                            </div>
                            <br>
                            <button onclick="gerarPDFTodos()" class="btn-print-all btn-ingresso">
                                <i class="fas fa-download mr-2"></i> Baixar Todos os Ingressos (PDF)
                            </button>
                        </div>

                        <?php if ($total_agendamentos > 0): ?>
                            <div class="row">
                                <?php while ($agendamento = $resultado_agendamentos->fetch(PDO::FETCH_OBJ)): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="ingresso-card" id="ingresso-<?php echo $agendamento->id; ?>">
                                        
                                        <!-- Cabeçalho do Ingresso -->
                                        <div class="ingresso-header">
                                            <h4 class="mb-0">
                                                <i class="fas fa-film mr-2"></i>
                                                <?php echo htmlspecialchars($agendamento->titulo); ?>
                                            </h4>
                                            <small>INGRESSO CINEMÁTICO</small>
                                        </div>
                                        
                                        <div class="ingresso-body">
                                            <!-- Poster do Filme -->
                                            <div class="text-center">
                                                <?php if ($agendamento->titulo == "THUNDERBOLTS"): ?>
                                                    <img src="/index/2k25-main/filmes/Thunderbolts.jpg" 
                                                         class="movie-poster-ingresso" 
                                                         alt="<?php echo $agendamento->titulo; ?>">
                                                <?php elseif ($agendamento->titulo == "BAILARINA"): ?>
                                                    <img src="/index/2k25-main/filmes/Bailarina.jpeg" 
                                                         class="movie-poster-ingresso" 
                                                         alt="<?php echo $agendamento->titulo; ?>">
                                                <?php else: ?>
                                                    <img src="../img/cartaz/<?php echo $agendamento->cartaz; ?>" 
                                                         class="movie-poster-ingresso" 
                                                         alt="<?php echo $agendamento->titulo; ?>">
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Informações do Ingresso -->
                                            <div class="info-ingresso">
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-user"></i> Nome:</span>
                                                    <span class="info-value"><?php echo htmlspecialchars($agendamento->nome_usuario); ?></span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-clock"></i> Horário:</span>
                                                    <span class="info-value text-warning"><?php echo htmlspecialchars($agendamento->horario); ?></span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-map-marker-alt"></i> Cinema:</span>
                                                    <span class="info-value text-info"><?php echo htmlspecialchars($agendamento->local_cinema); ?></span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-tag"></i> Gênero:</span>
                                                    <span class="info-value"><?php echo htmlspecialchars($agendamento->genero); ?></span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-certificate"></i> Classificação:</span>
                                                    <span class="info-value text-warning"><?php echo htmlspecialchars($agendamento->classificacao); ?></span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-hourglass-half"></i> Duração:</span>
                                                    <span class="info-value"><?php echo htmlspecialchars($agendamento->duracao); ?> min</span>
                                                </div>
                                            </div>
                                            
                                            <!-- QR Code Placeholder -->
                                            <div class="ingresso-qrcode">
                                                <div class="qrcode-placeholder">
                                                    QR CODE
                                                </div>
                                                <small class="text-muted mt-2">Apresente este ingresso na entrada</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Rodapé com Ações -->
                                        <div class="card-footer text-center no-print" style="background: rgba(0,0,0,0.3);">
                                            <button onclick="gerarPDFIngresso(<?php echo $agendamento->id; ?>)" 
                                                    class="btn-ingresso btn-pdf">
                                                <i class="fas fa-file-pdf mr-1"></i> Gerar PDF
                                            </button>
                                            
                                            <a href="conteudo/del-filme.php?idDel=<?php echo $agendamento->id; ?>" 
                                               onclick="return confirm('Tem certeza que deseja cancelar este ingresso?')"
                                               class="btn-ingresso">
                                                <i class="fas fa-trash mr-1"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                            
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-ticket-alt"></i>
                                <h4 class="text-muted">Nenhum ingresso encontrado</h4>
                                <p class="text-muted mb-4">Você ainda não possui filmes agendados.</p>
                                <a href="home.php" class="btn-ingresso">
                                    <i class="fas fa-plus mr-2"></i> Fazer Primeiro Agendamento
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Função para gerar PDF de ingresso individual
function gerarPDFIngresso(id) {
    const element = document.getElementById(`ingresso-${id}`);
    const titulo = element.querySelector('.ingresso-header h4').textContent.trim();
    
    // Mostrar loading
    const originalHTML = element.innerHTML;
    element.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Gerando PDF...</div>';
    
    html2canvas(element, {
        scale: 2, // Melhor qualidade
        useCORS: true,
        allowTaint: true
    }).then(canvas => {
        // Restaurar conteúdo original
        element.innerHTML = originalHTML;
        
        const imgData = canvas.toDataURL('image/png', 1.0);
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        
        const imgWidth = 190;
        const imgHeight = canvas.height * imgWidth / canvas.width;
        
        // Centralizar na página A4
        const x = (210 - imgWidth) / 2;
        const y = (297 - imgHeight) / 2;
        
        pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
        pdf.save(`Ingresso-${titulo}.pdf`);
    }).catch(error => {
        console.error('Erro ao gerar PDF:', error);
        element.innerHTML = originalHTML;
        alert('Erro ao gerar PDF. Tente novamente.');
    });
}

// Função para gerar PDF com todos os ingressos
function gerarPDFTodos() {
    const elements = document.querySelectorAll('.ingresso-card');
    
    if (elements.length === 0) {
        alert('Não há ingressos para exportar!');
        return;
    }

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');
    
    elements.forEach((element, index) => {
        if (index > 0) {
            pdf.addPage();
        }

        html2canvas(element, {
            scale: 2,
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png', 1.0);
            const imgWidth = 190;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            
            // Centralizar na página
            const x = (210 - imgWidth) / 2;
            const y = (297 - imgHeight) / 2;
            
            pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
            
            // Se é o último elemento, salva o PDF
            if (index === elements.length - 1) {
                pdf.save('Todos-Ingressos.pdf');
            }
        });
    });
}
</script>