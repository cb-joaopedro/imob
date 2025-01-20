<?php
include_once('includes/header.php');

// Verifica se os parâmetros necessários estão presentes
if (isset($cd) && isset($acao)) {
    try {
        $cad = new Cadastro();
        $redirect = $base; // Página de redirecionamento padrão

        // Determina a ação com base no parâmetro $acao
        switch ($acao) {
            case 1:
                // Excluir usuário
                $sql = "DELETE FROM `USUARIO` WHERE CD_USUARIO = :cd";
                $redirect = $base . '/usuarios';
                break;

            case 2:
                // Excluir imóvel
                $sql = "DELETE FROM `IMOVEL` WHERE CD_IMOVEL = :cd";
                $redirect = $base . '/imoveis';
                break;

            case 3:
                // Excluir cliente
                $sql = "DELETE FROM `CLIENTES` WHERE CD_CLIENTE = :cd";
                $redirect = $base . '/clientes';
                break;

            case 4:
                // Reservar imóvel
                $sql = "UPDATE `IMOVEL` SET SITUACAO = 3 WHERE CD_IMOVEL = :cd";
                $redirect = $base . '/imoveis';
                break;

            default:
                throw new Exception('Ação inválida!');
        }

        
        // Executa o SQL diretamente
        $stmt = BD::conn()->prepare($sql);
        $stmt->bindParam(':cd', $cd, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona após a execução
        echo '<script>';
        echo 'location.href = "' . $redirect . '";';
        echo '</script>';
    } catch (PDOException $e) {
        echo '<script>';
        echo 'location.href = "' . $base . '";';
        echo '</script>';
    } catch (Exception $e) {
        echo '<script>';
        echo 'location.href = "' . $base . '";';
        echo '</script>';
    }
} else {
    // Redireciona se os parâmetros não forem válidos
    echo '<script>';
    echo 'location.href = "' . $base . '";';
    echo '</script>';
    exit();
}

include_once('includes/footer.php');
