<?php
if (!getPermissaoUsuario('imoveis', $permissoes, $grupoUsuario, 'acesso')) {
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
    <h1 class="mt-4 text-center text-dark fw-bold text-uppercase">Catálogo de Imóveis</h1>
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
            <div>
                <?php
                $cad = new Cadastro();
                $tot_disponiveis = $cad->getTotalImoveisDisponiveis();
                $tot_vendidos = $cad->getTotalImoveisVendidos();
                $tot_reservados = $cad->getTotalImoveisReservados();

                if (!empty($tot_disponiveis)) {
                    echo '<span class="badge bg-white text-primary">Disponíveis: ' . htmlspecialchars($tot_disponiveis->QTDE) . '</span>';
                }
                if (!empty($tot_vendidos)) {
                    echo ' <span class="badge bg-white text-success">Vendidos: ' . htmlspecialchars($tot_vendidos->QTDE) . '</span>';
                }
                if (!empty($tot_reservados)) {
                    echo ' <span class="badge bg-white text-warning">Reservados: ' . htmlspecialchars($tot_reservados->QTDE) . '</span>';
                }
                ?>
            </div>
            <?php if (getPermissaoUsuario('imoveis', $permissoes, $grupoUsuario, 'CadImoveis')) { ?>
                <a href="<?php echo htmlspecialchars($base); ?>/cadastro_imovel" class="btn btn-light btn-sm" style="padding: 0.2em 0.5em; font-size: 0.75em; background-color: #fff; color: #000">
                    <i class="fas fa-plus-circle"></i> Novo Cadastro
                </a>
            <?php } ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Localização</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Situação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $lG = ['1' => 'Disponível', '2' => 'Vendido', '3' => 'Reservado'];
                        $pg = empty($cd) ? 1 : $cd;
                        $maximo = 5;

                        $imoveis = $cad->listaImoveis(null, $filtro_imovel, $pg, $maximo);
                        if (!empty($imoveis)) {
                            foreach ($imoveis as $imovel) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($imovel->LOCALIZACAO); ?></td>
                                    <td><?php echo htmlspecialchars($imovel->DESCRICAO); ?></td>
                                    <td><?php echo number_format($imovel->VALOR, 2, ',', '.') . " R$"; ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php echo $imovel->SITUACAO == '1' ? 'bg-primary' : ($imovel->SITUACAO == '2' ? 'bg-success' : 'bg-warning'); ?>">
                                            <?php echo $lG[$imovel->SITUACAO]; ?>
                                        </span>
                                    </td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <?php if (getPermissaoUsuario('imoveis', $permissoes, $grupoUsuario, 'editar')) { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/cadastro_imovel/' . $imovel->CD_IMOVEL); ?>" class="btn btn-outline-success btn-sm" onclick="editarImovel(event)">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php } ?>
                                        <?php if (getPermissaoUsuario('imoveis', $permissoes, $grupoUsuario, 'excluir')) { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/confirmar/' . $imovel->CD_IMOVEL . '/2'); ?>" class="btn btn-outline-danger btn-sm" onclick="excluirImovel(event)">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } ?>
                                        <?php if (getPermissaoUsuario('imoveis', $permissoes, $grupoUsuario, 'reservar') && $imovel->SITUACAO == '1') { ?>
                                            <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/confirmar/' . $imovel->CD_IMOVEL . '/4'); ?>" class="btn btn-outline-warning btn-sm" onclick="reservarImovel(event)">
                                                <i class="fas fa-calendar-check"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo '<tr><td colspan="5" class="text-muted text-center">Nenhum imóvel cadastrado</td></tr>';
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