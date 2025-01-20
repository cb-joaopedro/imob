<?php
if (!getPermissaoUsuario('usuarios', $permissoes, $grupoUsuario, 'CadUsuario')){
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

$cad = new Cadastro;
if (!empty($cd)) {
    $dados = $cad->getUsuarioCd($cd);
    if (!$dados) {
        $cd = '';
        $nome = '';
        $usuario = '';
        $grupo = 'V';
    } else {
        $nome = $dados->NOME;
        $usuario = $dados->USUARIO;
        $grupo = $dados->GRUPO;
    }
} else {
    $cd = '';
    $nome = '';
    $usuario = '';
    $grupo = 'V';
}

if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $status = '0';
    $cd = strip_tags($_POST['cd']);
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $usuario = strip_tags(filter_input(INPUT_POST, 'usuario'));
    $grupo = strip_tags(filter_input(INPUT_POST, 'grupo'));
    $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
    $confirma = strip_tags(filter_input(INPUT_POST, 'confirma'));

    if (!empty($senha) && $senha != $confirma) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "As senhas não coincidem!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Retorna para a página de edição
                    location.href = "' . $base . '/cadastro_usuario";
                });
            </script>'; // Volta para a página anterior
        exit();
    }

    if (empty($cd)) {
        if ($nome == '' || $usuario == '') {
            echo '<script>Swal.fire({
                    icon: "error",
                    title: "Campo vazio",
                    text: "Preencha os campos obrigatórios!",
                    showConfirmButton: false,
                    timer: 1500     
                });</script>';
        } else {
            $dados = empty($senha) ? array($usuario, $nome, $grupo, null) : array($usuario, $nome, $grupo, $senha);

            if ($cad->novoUsuario($dados)) {
                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Usuário cadastrado com sucesso!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/usuarios";
                }, 2000);</script>';
            } else {
                echo '<script>alert("Erro ao cadastrar o usuário. Verifique os logs do servidor para mais detalhes.");</script>';
            }
        }
    } else {
        if ($nome == '' || $usuario == '') {
            echo '<script>Swal.fire({
                    icon: "error",
                    title: "Campo vazio",
                    text: "Preencha os campos obrigatórios!",
                    showConfirmButton: false,
                    timer: 1500     
                });</script>';
        } else {
            if (empty($senha)) {
                $dados = array($usuario, $nome, $grupo, $cd);
                $editaSenha = false;
            } else {
                $dados = array($usuario, $nome, $grupo, $senha, $cd);
                $editaSenha = true;
            }

            if ($cad->editarUsuario($dados, $editaSenha)) {
                echo '<script>Swal.fire({
                    icon: "success",
                    title: "Parabéns",
                    text: "Usuário atualizado com sucesso!",
                    showConfirmButton: false,
                });
                // Redireciona após o tempo do SweetAlert
                setTimeout(() => {
                    location.href = "' . $base . '/usuarios";
                }, 2000);</script>';
            } else {
                echo '<script>alert("Erro ao atualizar o usuário");location.href="' . $base . '/usuarios";</script>';
            }
        }
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Cadastro de Usuário</h3></div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputFirstName" type="text" value="<?php echo $usuario; ?>" placeholder="Usuário" name="usuario" />
                                    <label for="inputFirstName">Usuário</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <input class="form-control" id="inputLastName" type="text" placeholder="Nome" value="<?php echo $nome; ?>" name="nome"/>
                                    <label for="inputLastName">Nome</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select name="grupo" class="form-control">
                                        <?php
                                        $lGr = array('C' => 'CEO', 'A' => 'Administrador', 'F' => 'Financeiro', 'V' => 'Vendedor');
                                        foreach ($lGr as $k => $v) {
                                            $sel = ($k == $grupo) ? 'Selected="selected"' : '';
                                            echo '<option ' . $sel . ' value="' . $k . '">' . $v . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="inputFirstName">Grupo</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputPassword" type="password" name="senha" placeholder="Senha" />
                                    <label for="inputPassword">Senha</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputPasswordConfirm" type="password" name="confirma" placeholder="Confirme a Senha" />
                                    <label for="inputPasswordConfirm">Confirme a Senha</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 mb-0">
                            <input type="hidden" name="acao" value="cadastrar"/>
                            <input type="hidden" name="cd" value="<?php echo $cd; ?>"/>
                            <a href="<?php echo $base; ?>/usuarios" class="btn btn-info btn-block">Cancelar</a>
                            <input type="submit" class="btn btn-primary btn-block" value="Salvar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
