<?php
if (!getPermissaoUsuario('aprovar_venda', $permissoes, $grupoUsuario, 'CadVenda')){
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Acesso Negado",
                text: "Você não tem acesso a esta funcionalidade!",
                confirmButtonText: "Ok"
            }).then(() => {
                location.href = "' . $base . '";
            });
        </script>';
        exit;
    }

$cad = new Cadastro();

// Inicialização das variáveis
if (!empty($cd)) {
    // Obter dados do imóvel
    $dados = $cad->getImovelCd($cd);
    if (!$dados) {
        $cd = '';
        $descricao = '';
        $localizacao = '';
        $valor = '';
        $situacao = '1';  // Situação será '1' por padrão (disponível)
    } else {
        $descricao = $dados->DESCRICAO;
        $localizacao = $dados->LOCALIZACAO;
        $valor = number_format($dados->VALOR, 2, ',', '.'); // Exemplo: 1000,00
        $situacao = $dados->SITUACAO;
    }
} else {
    $cd = '';
    $descricao = '';
    $localizacao = '';
    $valor = '';
    $situacao = '1'; // Situação será '1' por padrão (disponível)
}

// Obtenção dos clientes cadastrados
$clientes = $cad->listaClientes(); // Aqui assumimos que o método listaClientes retorna todos os clientes

// Tratamento do formulário
if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_SANITIZE_NUMBER_INT);

    // Verificar se o cliente foi selecionado
    if (empty($cliente_id)) {
        echo '<script>alert("Por favor, selecione um comprador.");</script>';
        exit();
    }

    // Realizando o vínculo entre o imóvel e o cliente (compra)
    if ($cad->vincularCompraImovel($cd, $cliente_id)) {
        echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Imóvel vendido com sucesso!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/aprovar_venda";
                }, 1500);</script>';
    } else {
        echo '<script>alert("Erro ao vincular o imóvel com o comprador.");</script>';
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Cadastro de Venda de Imóvel</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <!-- Localização em cima -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="localizacao" type="text" placeholder="Localização" value="<?php echo htmlspecialchars($localizacao); ?>" readonly />
                                    <label for="localizacao">Localização</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Descrição abaixo da localização -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="descricao" name="descricao" rows="4" readonly><?php echo htmlspecialchars($descricao); ?></textarea>
                                    <label for="descricao">Descrição do imóvel</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Valor abaixo da descrição -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="valor" type="text" placeholder="Valor" value="<?php echo htmlspecialchars($valor); ?>" readonly />
                                    <label for="valor">Valor (R$)</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Seletor de Cliente -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="cliente_id" name="cliente_id" required>
                                        <option value="">Selecione um comprador</option>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?php echo $cliente->CD_CLIENTE; ?>"><?php echo htmlspecialchars($cliente->NOME); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="cliente_id">Comprador</label>
                                </div>
                            </div>
                        </div>

                        <!-- Centralizando os botões -->
                        <div class="d-flex justify-content-center mt-4 mb-0">
                            <input type="hidden" name="acao" value="cadastrar" />
                            <input type="hidden" name="cd" value="<?php echo htmlspecialchars($cd); ?>" />
                            <a href="<?php echo $base; ?>/aprovar_venda" class="btn btn-info btn-sm mx-2">Cancelar</a>
                            <input type="submit" class="btn btn-primary btn-sm mx-2" value="Vender Imóvel" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
