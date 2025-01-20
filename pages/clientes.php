<?php
if (!getPermissaoUsuario('clientes', $permissoes, $grupoUsuario, 'acesso')) {
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
    <h1 class="mt-4 text-center text-dark fw-bold text-uppercase">Clientes Cadastrados</h1>
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
            <div>
                <?php
                $cad = new Cadastro();
                $tot_users = $cad->getTotalClientesCadastrados();
                if (!empty($tot_users)) {
                    echo '<span class="badge bg-white text-primary">Total de clientes: ' . htmlspecialchars($tot_users->QTDE) . '</span>';
                }
                ?>
            </div>
            <?php if (getPermissaoUsuario('clientes', $permissoes, $grupoUsuario, 'CadCliente')) { ?>
                <a href="<?php echo htmlspecialchars($base); ?>/cadastro_cliente" class="btn btn-light btn-sm" style="padding: 0.2em 0.5em; font-size: 0.75em; background-color: #fff; color: #000">
                    <i class="fas fa-plus-circle"></i> Novo Cadastro
                </a>
            <?php } ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Paginação
                        $pg = empty($cd) ? 1 : $cd;
                        $maximo = 5;
                        $clientes = $cad->listaClientes($pg, $maximo);

                        if (!empty($clientes)) {
                            foreach ($clientes as $cliente) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($cliente->NOME); ?></td>
                                    <td><?php echo formatarCPF($cliente->CPF); ?></td>
                                    <td><?php echo formatarTelefone($cliente->TELEFONE); ?></td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <?php if (getPermissaoUsuario('clientes', $permissoes, $grupoUsuario, 'editar')) { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/cadastro_cliente/' . $cliente->CD_CLIENTE); ?>" class="btn btn-outline-success btn-sm" onclick="editarCliente(event)">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php } ?>
                                        <?php if (getPermissaoUsuario('clientes', $permissoes, $grupoUsuario, 'excluir')) { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/confirmar/' . $cliente->CD_CLIENTE . '/3'); ?>" class="btn btn-outline-danger btn-sm" onclick="excluirCliente(event)">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo '<tr><td colspan="4" class="text-muted text-center">Nenhum cliente cadastrado</td></tr>';
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

<?php
// Funções de formatação de CPF e Telefone
function formatarCPF($cpf) {
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function formatarTelefone($telefone) {
    if (strlen($telefone) == 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) == 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    }
    return $telefone;
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo $base; ?>/js/alert.js"></script>