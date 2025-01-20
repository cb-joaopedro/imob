<?php
if (!getPermissaoUsuario('imoveis', $permissoes, $grupoUsuario, 'CadImoveis')) {
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
        // Formatação do valor para exibição com "R$"
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

// Tratamento do formulário
if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
    $localizacao = filter_input(INPUT_POST, 'localizacao', FILTER_SANITIZE_STRING);
    // Remover todos os caracteres que não são números para garantir que o valor seja numérico
    $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    // A situação não será mais fixada, ela será mantida conforme estava antes
    $situacao = isset($situacao) ? $situacao : '1'; // Mantém a situação existente ao editar

    // Se for novo cadastro
    if (empty($cd)) {
        if ($descricao == '' || $localizacao == '' || $valor == '') {
            echo '<script>Swal.fire({
                    icon: "error",
                    title: "Campo vazio",
                    text: "Preencha os campos obrigatórios!",
                    showConfirmButton: false,
                    timer: 1500     
                });</script>';
        } else {
            // Incluindo a situação no array de dados
            $dados = array($descricao, $localizacao, $valor, $situacao);
            if ($cad->novoImovel($dados)) {
                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Mais um imóvel para nosso catálogo!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/imoveis";
                }, 2000);</script>';
            } else {
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Erro ao Cadastrar o Imóvel",
                            text: "Ocorreu um erro ao tentar cadastrar o imóvel.",
                            confirmButtonText: "Ok"
                        }).then(() => {
                            location.href = "' . $base . '/imoveis";
                        });
                    </script>';
            }
        }
    } else {
        // Se for edição, mantemos a situação existente
        if ($descricao == '' || $localizacao == '' || $valor == '') {
            echo '<script>Swal.fire({
                    icon: "error",
                    title: "Campo vazio",
                    text: "Preencha os campos obrigatórios!",
                    showConfirmButton: false,
                    timer: 1500     
                });</script>';
        } else {
            // Incluindo a situação no array de dados
            $dados = array($descricao, $localizacao, $valor, $situacao, $cd); // A situação é mantida
            if ($cad->editarImovel($dados)) {
                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Imóvel atualizado com sucesso!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/imoveis";
                }, 2000);</script>';
            } else {
                echo '<script>alert("Erro ao atualizar o imóvel."); location.href="' . $base . '/imoveis";</script>';
            }
        }
    }
}
?>

<!-- Formulário HTML -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Cadastro de Imóvel</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <!-- Localização em cima -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="localizacao" type="text" placeholder="Localização" value="<?php echo isset($_POST['localizacao']) ? htmlspecialchars($_POST['localizacao']) : htmlspecialchars($localizacao); ?>" name="localizacao" />
                                    <label for="localizacao">Localização</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Descrição abaixo da localização -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="descricao" name="descricao" rows="4" placeholder="Descrição"><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : htmlspecialchars($descricao); ?></textarea>
                                    <label for="descricao">Descrição do imóvel</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Valor abaixo da descrição -->
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <!-- Valor como numérico e sem permitir "R$" no campo -->
                                    <input class="form-control" id="valor" type="number" placeholder="Valor" value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : htmlspecialchars($valor); ?>" name="valor" step="0.01" min="0" />
                                    <label for="valor">Valor (R$)</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-0">
                            <input type="hidden" name="acao" value="cadastrar" />
                            <input type="hidden" name="cd" value="<?php echo htmlspecialchars($cd); ?>" />
                            <a href="<?php echo $base; ?>/imoveis" class="btn btn-info btn-block">Cancelar</a>
                            <input type="submit" class="btn btn-primary btn-block" value="Salvar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
