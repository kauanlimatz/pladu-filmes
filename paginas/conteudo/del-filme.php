<?php
include('../../config/conexao.php');

if(isset($_GET['idDel'])){
    $id = $_GET['idDel'];

    try {
        // Primeiro verifica se o agendamento existe
        $select = "SELECT cartaz FROM tb_filmes WHERE id = :id";
        $result = $conect->prepare($select);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount() > 0) {
            $filme = $result->fetch(PDO::FETCH_OBJ);
            $cartaz = $filme->cartaz;
            
            // Se não for uma imagem padrão, deleta o arquivo
            if ($cartaz != 'thunderbolts_fixed.jpg' && $cartaz != 'bailarina_fixed.jpg' && $cartaz != 'padrao_filme.png') {
                $filePath = "../../img/cartaz/" . $cartaz;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Deleta o registro do banco
            $delete = "DELETE FROM tb_filmes WHERE id = :id";
            $result_delete = $conect->prepare($delete);
            $result_delete->bindValue(':id', $id, PDO::PARAM_INT);
            $result_delete->execute();

            if ($result_delete->rowCount() > 0) {
                header("Location: ../home.php?success=Agendamento cancelado com sucesso!");
            } else {
                header("Location: ../home.php?error=Erro ao cancelar agendamento");
            }
        } else {
            header("Location: ../home.php?error=Agendamento não encontrado");
        }
        
    } catch (PDOException $e) {
        header("Location: ../home.php?error=Erro: " . $e->getMessage());
    }
} else {
    header("Location: ../home.php");
}
exit();
?>