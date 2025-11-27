<?php
include_once('../includes/header.php');

// Sanitização de entrada
$acao = filter_var(isset($_GET['acao']) ? $_GET['acao'] : 'bemvindo', FILTER_SANITIZE_STRING);

// Definir caminhos em variáveis
$paginas = [
    'bemvindo' => 'conteudo/cadastro_contato.php',
    'editar-filme' => 'conteudo/edit-filme.php',
    'perfil' => 'conteudo/perfil.php',
    'relatorio' => 'conteudo/agendamentos.php'
];

// Verificar se a ação existe no array, caso contrário, usar a página padrão
$pagina_incluir = isset($paginas[$acao]) ? $paginas[$acao] : $paginas['bemvindo'];

// Verificar se o arquivo existe antes de incluir
if (file_exists($pagina_incluir)) {
    include_once($pagina_incluir);
} else {
    // ⚠️ CORREÇÃO: MOSTRAR APENAS O ERRO, NÃO INCLUIR OUTRA PÁGINA
    echo '<div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> 
            Página não encontrada: ' . htmlspecialchars($pagina_incluir) . '
          </div>';
    // ⚠️ REMOVIDO: include_once($paginas['bemvindo']);
}

include_once('../includes/footer.php');
?>