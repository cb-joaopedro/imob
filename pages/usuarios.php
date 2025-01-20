<?php
if (!getPermissaoUsuario('usuarios', $permissoes, $grupoUsuario, 'acesso')) {
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
?>
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center text-dark fw-bold text-uppercase">Gestão de Usuários</h1>
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
            <div>
                <?php
                $cad = new Cadastro();
                $tot_ceos = $cad->getTotalCeos();
                $tot_administradores = $cad->getTotalAdministradores();
                $tot_financeiros = $cad->getTotalFinanceiros();
                $tot_vendedores = $cad->getTotalVendedores();

                if ($tot_ceos) {
                    echo '<span class="badge bg-white text-primary">CEOs: ' . htmlspecialchars($tot_ceos->QTDE) . '</span> ';
                }

                if ($tot_administradores) {
                    echo '<span class="badge bg-white text-secondary">ADMs: ' . htmlspecialchars($tot_administradores->QTDE) . '</span> ';
                }

                if ($tot_financeiros) {
                    echo '<span class="badge bg-white text-info">Finanças: ' . htmlspecialchars($tot_financeiros->QTDE) . '</span> ';
                }

                if ($tot_vendedores) {
                    echo '<span class="badge bg-white text-success">Vendas: ' . htmlspecialchars($tot_vendedores->QTDE) . '</span> ';
                }
                ?>
            </div>
            <?php if (getPermissaoUsuario('usuarios', $permissoes, $grupoUsuario, 'CadUsuario')) { ?>
                <a href="<?php echo htmlspecialchars($base); ?>/cadastro_usuario" class="btn btn-light btn-sm" style="padding: 0.2em 0.5em; font-size: 0.75em; background-color: #fff; color: #000;">
                    <i class="fas fa-plus-circle"></i> Novo Usuário
                </a>
            <?php } ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Usuário</th>
                            <th>Grupo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $lGr = ['C' => 'CEO', 'A' => 'Administrador', 'F' => 'Financeiro', 'V' => 'Vendedor'];

                        $pg = empty($cd) ? 1 : $cd;
                        $maximo = 5;

                        $lista = $cad->listaUsuarios($pg, $maximo);

                        if (!empty($lista)) {
                            foreach ($lista as $linha) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($linha->NOME); ?></td>
                                    <td><?php echo htmlspecialchars($linha->USUARIO); ?></td>
                                    <td><?php echo htmlspecialchars($lGr[$linha->GRUPO]); ?></td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <?php if (getPermissaoUsuario('usuarios', $permissoes, $grupoUsuario, 'editar')) { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/cadastro_usuario/' . $linha->CD_USUARIO); ?>" class="btn btn-outline-success btn-sm" onclick="editarUsuario(event)">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php } ?>
                                        <?php if (getPermissaoUsuario('usuarios', $permissoes, $grupoUsuario, 'excluir')) { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/confirmar/' . $linha->CD_USUARIO . '/1'); ?>" class="btn btn-outline-danger btn-sm" onclick="excluirUsuario(event)">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="4" class="text-muted text-center">Nenhum usuário encontrado</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php
                    $total = $cad->getNumRows();
                    $pags = ceil($total / $maximo);
                    $links = 5;

                    echo '<li class="page-item"><a class="page-link" href="' . $base . '/' . $arquivo . '/1">Primeira</a></li>';
                    for ($i = $pg - $links; $i <= $pg - 1; $i++) {
                        if ($i > 0) {
                            echo '<li class="page-item"><a class="page-link" href="' . $base . '/' . $arquivo . '/' . $i . '">' . $i . '</a></li>';
                        }
                    }
                    echo '<li class="page-item active"><span class="page-link">' . $pg . '</span></li>';
                    for ($i = $pg + 1; $i <= $pg + $links; $i++) {
                        if ($i <= $pags) {
                            echo '<li class="page-item"><a class="page-link" href="' . $base . '/' . $arquivo . '/' . $i . '">' . $i . '</a></li>';
                        }
                    }
                    echo '<li class="page-item"><a class="page-link" href="' . $base . '/' . $arquivo . '/' . $pags . '">Última</a></li>';
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo $base; ?>/js/alert.js"></script>