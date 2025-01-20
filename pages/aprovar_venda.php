<?php
if (!getPermissaoUsuario('aprovar_venda', $permissoes, $grupoUsuario, 'acesso')) {
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
    <h1 class="mt-4 text-center text-dark fw-bold text-uppercase">Setor Financeiro - Aprovar Vendas</h1>
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
            <div>
                <?php
                    $cad = new Cadastro();
                    // Total de imóveis reservados
                    $tot_reservados = $cad->getTotalImoveisReservados(); // Situação 3 = Reservado
                    if (!empty($tot_reservados)) {
                        echo ' <span class="badge bg-white text-warning">Reservados: ' . htmlspecialchars($tot_reservados->QTDE) . '</span>';
                    }
                    // Total de imóveis vendidos
                    $tot_vendidos = $cad->getTotalImoveisVendidos(); // Situação 2 = Vendido
                    if (!empty($tot_vendidos)) {
                        echo ' <span class="badge bg-white text-success">Vendidos: ' . htmlspecialchars($tot_vendidos->QTDE) . '</span>';
                    }
                ?>
            </div>
            <div></div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="min-width: 150px;">Localização</th>
                            <th style="min-width: 100px;">Descrição</th>
                            <th style="min-width: 150px;">Valor</th>
                            <th style="min-width: 150px;">Situação</th>
                            <th style="min-width: 250px;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $lG = ['1' => 'Disponível', '2' => 'Vendido', '3' => 'Reservado'];
                        // Lista imóveis nas situações 2 (Vendido) ou 3 (Reservado)
                        $imoveis = $cad->listaImoveis('2, 3');

                        // Organiza a lista para exibir Reservados (3) antes dos Vendidos (2)
                        usort($imoveis, function($a, $b) {
                            return $b->SITUACAO - $a->SITUACAO;
                        });

                        if (!empty($imoveis)) {
                            foreach ($imoveis as $imovel) {
                                $cliente_nome = '';
                                if ($imovel->SITUACAO == 2 && !empty($imovel->CD_CLIENTE)) {
                                    // Obtém o nome do cliente a partir do código do cliente
                                    $cliente = $cad->getClientePorId($imovel->CD_CLIENTE);
                                    if (!empty($cliente)) {
                                        $cliente_nome = htmlspecialchars($cliente->NOME);
                                    }
                                }
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($imovel->LOCALIZACAO); ?></td>
                                <td><?php echo htmlspecialchars($imovel->DESCRICAO); ?></td>
                                <td><?php echo number_format($imovel->VALOR, 2, ',', '.') . " R$"; ?></td>
                                <td>
                                    <span class="badge 
                                        <?php echo $imovel->SITUACAO == '2' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo $lG[$imovel->SITUACAO]; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($imovel->SITUACAO == 3): ?>
                                        <!-- Aprovar Venda apenas para imóveis Reservados -->
                                        <a href="<?php echo htmlspecialchars(rtrim($base, '/') . '/cadastro_venda/' . $imovel->CD_IMOVEL); ?>" class="btn btn-outline-success btn-sm" onclick="aprovarVenda(event)">
                                            Aprovar <i class="fas fa-handshake"></i>
                                        </a>
                                    <?php elseif ($imovel->SITUACAO == 2): ?>
                                        <!-- Exibe o nome do cliente para imóveis Vendidos -->
                                        <strong style="font-size: 14px;">Comprador(a): <?php echo $cliente_nome ?: 'Cliente não identificado'; ?></strong>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php }}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo $base; ?>/js/alert.js"></script>