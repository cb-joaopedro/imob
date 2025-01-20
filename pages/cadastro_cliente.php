<?php
if (!getPermissaoUsuario('clientes', $permissoes, $grupoUsuario, 'CadCliente')) {
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
    $dados = $cad->getClienteCd($cd);
    if (!$dados) {
        $cd = '';
        $nome = '';
        $cpf = '';
        $telefone = '';
    } else {
        $nome = $dados->NOME;
        $cpf = $dados->CPF;
        $telefone = $dados->TELEFONE;
    }
} else {
    $cd = '';
    $nome = '';
    $cpf = '';
    $telefone = '';
}

// Tratamento do formulário
if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    // Remover pontuação do CPF e telefone
    $cpf = preg_replace('/\D/', '', filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING)); // Remove qualquer caractere não numérico
    $telefone = preg_replace('/\D/', '', filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING)); // Remove qualquer caractere não numérico

    if (empty($cd)) {
        if ($nome == '' || $cpf == '' || $telefone == '') {
            echo '<script>Swal.fire({
                    icon: "error",
                    title: "Campo vazio",
                    text: "Preencha os campos obrigatórios!",
                    showConfirmButton: false,
                    timer: 1500     
                });</script>';
        } else {
            $dados = array($nome, $cpf, $telefone);
            if ($cad->novoCliente($dados)) {
                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Mais um cliente cadastrado!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/clientes";
                }, 2000);</script>';
            } else {
                echo '<script>alert("Erro ao cadastrar o cliente.");</script>';
            }
        }
    } else {
        if ($nome == '' || $cpf == '' || $telefone == '') {
            echo '<script>Swal.fire({
                    icon: "error",
                    title: "Campo vazio",
                    text: "Preencha os campos obrigatórios!",
                    showConfirmButton: false,
                    timer: 1500     
                });</script>';
        } else {
            $dados = array($nome, $cpf, $telefone, $cd);
            if ($cad->editarCliente($dados)) {
                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Dados atualizados com sucesso!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/clientes";
                }, 2000);</script>';
            } else {
                echo '<script>alert("Erro ao atualizar o Cliente."); location.href="'.$base.'/clientes";</script>';
            }
        }
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Cadastro de Cliente</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <div class="form-floating">
                                <input class="form-control" id="nome" type="text" value="<?php echo htmlspecialchars($nome); ?>" placeholder="nome" name="nome" required />
                                <label for="nome">Nome do Cliente</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input class="form-control" id="cpf" type="text" maxlength="11" required pattern="\d{11}"  placeholder="Digite seu CPF (11 dígitos)" value="<?php echo htmlspecialchars($cpf); ?>" name="cpf"/>
                                <label for="cpf">CPF (11 dígitos)</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input class="form-control" id="telefone" type="text" maxlength="11" required pattern="\d{11}" placeholder="Telefone" value="<?php echo htmlspecialchars($telefone); ?>" name="telefone"/>
                                <label for="telefone">Telefone (11 dígitos)</label>
                            </div>
                        </div>

                        <div class="mt-4 mb-0">
                            <input type="hidden" name="acao" value="cadastrar" />
                            <input type="hidden" name="cd" value="<?php echo htmlspecialchars($cd); ?>" />
                            <a href="<?php echo $base; ?>/clientes" class="btn btn-info btn-block">Cancelar</a>
                            <input type="submit" class="btn btn-primary btn-block" value="Salvar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>