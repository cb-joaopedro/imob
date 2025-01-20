<?php
include_once('includes/header.php');

// Verifica se a URL contém o parâmetro cd_imovel
if (isset($_GET['cd_imovel'])) {
    $cd_imovel = $_GET['cd_imovel'];
    
    // Instancia a classe Cadastro (não se esqueça de incluí-la se necessário)
    $cad = new Cadastro();

    // Obtém o imóvel com base no código passado
    $imovel = $cad->getImovelCd($cd_imovel); // Função que retorna o imóvel pelo código

    if (!$imovel) {
        echo '<script>alert("Imóvel não encontrado ou código inválido!"); location.href="' . $base . '/imoveis";</script>';
        exit();
    }

    // Verifica se o imóvel já está vinculado a um cliente
    if (is_null($imovel->CD_CLIENTE)) {
        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['cd_cliente'])) {
                $cd_cliente = $_POST['cd_cliente'];
                
                // Atualiza o imóvel com o cliente selecionado
                if ($cad->vincularImovelCliente($cd_imovel, $cd_cliente)) {
                    echo '<script>alert("Imóvel vinculado com sucesso ao cliente!"); location.href="' . $base . '/imoveis";</script>';
                } else {
                    echo '<script>alert("Erro ao vincular o imóvel ao cliente!");</script>';
                }
            }
        }

        // Lista todos os clientes
        $clientes = $cad->listaClientes(); // Função que retorna todos os clientes cadastrados
        ?>

        <div class="container-fluid px-4">
            <h1 class="mt-4">Vincular Cliente ao Imóvel</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="cliente">Selecione o Cliente:</label>
                    <select class="form-control" name="cd_cliente" id="cliente" required>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente->CD_CLIENTE; ?>"><?php echo htmlspecialchars($cliente->NOME); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-3">Vincular Cliente</button>
            </form>
        </div>
        <?php
    } else {
        echo '<script>alert("Este imóvel já tem um cliente vinculado!"); location.href="' . $base . '/imoveis";</script>';
    }
} else {
    echo '<script>alert("Imóvel não encontrado ou código inválido!"); location.href="' . $base . '/imoveis";</script>';
}

include_once('includes/footer.php');
?>
