<?php
    if (!getPermissaoUsuario('home', $permissoes, $grupoUsuario, 'acesso')){
        echo '<script>alert("Você não tem acesso a esta funcionalidade!");location.href="'.$base.'"</script>';
    }

$cad = new Cadastro;
$lst_users = $cad->listaUsuarios(1,500);

if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
    $grupo = strip_tags(filter_input(INPUT_POST, 'grupo'));
    $cd_user = strip_tags(filter_input(INPUT_POST, 'cd_user'));

    if (!empty($cd_user) && !empty($grupo)){
        $sql = "UPDATE `usuario` SET `GRUPO` = '$grupo' WHERE `usuario`.`CD_USUARIO` = $cd_user";
        try {
            $stmt = BD::conn()->prepare($sql);
            if ($stmt->execute()){
                echo '<script>alert("Permissão atualizada com sucesso!");location.href="' . $base . '";</script>';
            }else{
                echo '<script>alert("Erro ao atualizar permissão do usuário");location.href="' . $base . '";</script>';
            }
        } catch (PDOException $e) {
            echo '<script>alert("Erro ao atualizar permissão do usuário");location.href="' . $base . '";</script>';
        }

    }else{
        echo '<script>alert("Selecione o Usuário e Grupo");location.href="' . $base . '/configuracoes";</script>';
    }

}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Controle de Promoções</h3></div>
                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        
                        <div class="row mb-3">
                        <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select name="cd_user" class="form-control">
                                        <option value="">Selecione o Usuário</option>
                                        <?php
                                        
                                        foreach ($lst_users as $v) {
                                            echo '<option  value="' . $v->CD_USUARIO . '">' . $v->USUARIO . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="inputFirstName">Usuários</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select name="grupo" class="form-control">
                                        <?php
                                        $sel = '';
                                        $lGr = array(''=>'Selecione o Grupo', 'C' => 'CEO', 'A' => 'Administrador', 'F' => 'Financeiro', 'V' => 'Vendedor');
                                        foreach ($lGr as $k => $v) {
                                            
                                            echo '<option ' . $sel . ' value="' . $k . '">' . $v . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="inputFirstName">Grupo</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="mt-4 mb-0">
                            <input type="hidden" name="acao" value="cadastrar"/>
                            <a href="<?php echo $base; ?>" class="btn btn-info btn-block">Cancelar</a>
                            <input type="submit" class="btn btn-primary btn-block" value="Salvar"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
