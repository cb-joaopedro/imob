<?php
    if (!getPermissaoUsuario('home', $permissoes, $grupoUsuario, 'acesso')) {
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
    <h1 class="mt-4 text-center text-dark fw-bold text-uppercase">Dashboard CEO - Controle estatístico</h1>
    <div class="row">
        <!-- Quantidade total de Clientes Cadastrados -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo htmlspecialchars($base); ?>/clientes" style="text-decoration: none;">
                <div class="card text-white" id="cardClientes" style="background-color: #1b5f15; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size:1.3em;">Clientes Cadastrados</h5>
                        <div class="card-text">
                            <span class="number" style="font-size:1.5em; color: #fff;">
                                <?php
                                    $cad = new Cadastro;
                                    $tot_clientes = $cad->getTotalClientesCadastrados(); 
                                    if (!empty($tot_clientes)){
                                        echo $tot_clientes->QTDE;
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Quantidade total de Imóveis Cadastrados -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo htmlspecialchars($base); ?>/imoveis" style="text-decoration: none;">
                <div class="card text-white" id="cardImoveis" style="background-color: #5b125b; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size:1.3em;">Imóveis Cadastrados</h5>
                        <div class="card-text">
                            <span class="number" style="font-size:1.5em; color: #fff;">
                                <?php
                                    $tot_imoveis = $cad->getTotalImoveisCadastrados(); 
                                    if (!empty($tot_imoveis)){
                                        echo $tot_imoveis->QTDE;
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Quantidade total de Usuários -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo htmlspecialchars($base); ?>/usuarios" style="text-decoration: none;">
                <div class="card text-white" id="cardUsuarios" style="background-color: #05017f; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size:1.3em;">Usuários Cadastrados</h5>
                        <div class="card-text">
                            <span class="number" style="font-size:1.5em; color: #fff;">
                                <?php
                                    $tot_usuarios = $cad->getTotalUsuariosCadastrados(); 
                                    if (!empty($tot_usuarios)){
                                        echo $tot_usuarios->QTDE;
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Faturamento Total -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo htmlspecialchars($base); ?>/imoveis" style="text-decoration: none;">
                <div class="card text-white" id="cardFaturamento" style="background-color: #9fae00; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size:1.3em;">Faturamento Total</h5>
                        <div class="card-text">
                            <span class="number" style="font-size:1.5em; color: #fff;">
                                <?php
                                    $valor_vendido = $cad->getValorImoveisVendidos();
                                    if ($valor_vendido > 0) {
                                        echo "R$ " . number_format($valor_vendido, 2, ',', '.');
                                    } else {
                                        echo "R$ 0,00"; 
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
<!-- Gráfico -->
<div class="card mb-4">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Recuperar os dados dos compradores
            var compradores = <?php 
                $compradores = []; 
                $imoveis = $cad->listaImoveis('2'); // Filtra imóveis vendidos (Situação 2)

                foreach ($imoveis as $imovel) {
                    $cliente_nome = '';
                    $valor_imovel = $imovel->VALOR; // Valor do imóvel
                    if ($imovel->SITUACAO == 2 && !empty($imovel->CD_CLIENTE)) {
                        $cliente = $cad->getClientePorId($imovel->CD_CLIENTE);
                        if (!empty($cliente)) {
                            $cliente_nome = $cliente->NOME;
                        }
                        // Armazena a quantidade de imóveis e o valor total gasto por cada cliente
                        if (!isset($compradores[$cliente_nome])) {
                            $compradores[$cliente_nome] = array('quantidade' => 0, 'valor_total' => 0);
                        }
                        $compradores[$cliente_nome]['quantidade']++;
                        $compradores[$cliente_nome]['valor_total'] += $valor_imovel;
                    }
                }

                echo json_encode($compradores);
            ?>;

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Cliente'); // Cliente no eixo Y
            data.addColumn('number', 'Gestão de Venda'); // Linha para mostrar o valor gasto
            data.addColumn({type: 'string', role: 'tooltip', p: {html: true}}); // Tooltip para mostrar o valor gasto

            // Preencher os dados para o gráfico
            for (var cliente in compradores) {
                if (compradores.hasOwnProperty(cliente)) {
                    var quantidade = compradores[cliente].quantidade;
                    var valorGasto = compradores[cliente].valor_total;

                    // Formatar o valor gasto com R$ e vírgulas
                    var valorFormatado = 'R$ ' + valorGasto.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, '$1.');

                    // Criar o conteúdo do tooltip (valor gasto)
                    var tooltip = '<div><strong>Cliente: ' + cliente + '</strong></div>';
                    tooltip += '<div><strong>Imóveis Comprados: ' + quantidade + '</strong></div>';
                    tooltip += '<div><strong>Valor Investido: ' + valorFormatado + '</strong></div>';

                    // Adicionando linha de dados ao gráfico
                    data.addRow([cliente, valorGasto, tooltip]);
                }
            }

            var options = {
                title: 'Gráfico com o controle de imóveis comprados por cliente e valor investido em nossa imobiliária',
                titleTextStyle: {
                    color: '#FFFFFF', // Cor do título
                    fontSize: 17, // Tamanho da fonte
                    fontName: 'Roboto', // Nome da fonte
                    bold: true, // Negrito
                    italic: false // Itálico
                },
                chartArea: {width: '80%', height: '80%'}, // Ajuste no tamanho do gráfico
                tooltip: {
                    isHtml: true, 
                    trigger: 'focus', 
                    textStyle: {
                        color: '#000', // Cor do texto na tooltip
                        fontSize: 12,  // Tamanho da fonte
                        fontName: 'Arial', // Fonte
                    },
                    showColorCode: true // Mostrar o código de cor
                },
                bar: {groupWidth: '60%'}, // Ajuste na largura das barras
                isStacked: false, // Não empilhar
                series: {
                    0: {color: '#00C0B5', targetAxisIndex: 0}, // Cor do gráfico
                },
                annotations: {
                    alwaysOutside: false, // Coloca o texto dentro da linha
                    textStyle: {
                        color: '#FFFFFF',   // Cor dos textos de anotações
                        fontSize: 12,       // Tamanho da fonte
                        fontName: 'Arial',  // Tipo da fonte
                        bold: true,         // Negrito
                        italic: false,      // Não itálico
                    }
                },
                hAxis: {
                    textStyle: {
                        color: '#FFFFFF', // Cor dos nomes dos clientes no eixo horizontal
                        fontSize: 14,
                        fontName: 'Roboto',
                    },
                    gridlines: {color: '#333333'}, // Linhas de grade escuras
                    titleTextStyle: {
                        color: '#FFFFFF', // Cor do título do eixo horizontal
                        fontSize: 14,
                        bold: true,
                    },
                },
                vAxis: {
                    textStyle: {
                        color: '#FFFFFF', // Cor dos valores no eixo vertical
                        fontSize: 14,
                        fontName: 'Roboto',
                    },
                    gridlines: {color: '#333333'}, // Linhas de grade escuras
                    titleTextStyle: {
                        color: '#FFFFFF', // Cor do título do eixo vertical
                        fontSize: 14,
                        bold: true,
                    },
                },
                orientation: 'horizontal', // Gráfico de barras horizontais
                curveType: 'function', // Curvar as linhas
                backgroundColor: '#121212', // Cor de fundo escura para estilo futurista
                legend: {
                    position: 'none' // Esconder a legenda
                },
                focusTarget: 'category', // Focar nas barras ao passar o mouse
                animation: {
                    startup: true, // Animação ao carregar o gráfico
                    duration: 1000,
                    easing: 'inAndOut'
                },
            };

            var chart = new google.visualization.ComboChart(document.getElementById('myChart'));
            chart.draw(data, options);
        }
    </script>

    <!-- Contêiner do gráfico -->
    <div id="myChart" style="min-height: 350px;"></div>

    <!-- Título abaixo do gráfico -->
    <div style="text-align: center; font-family: Arial, sans-serif; color: white; font-size: 16px; margin-top: 10px;">
        Controle de Clientes Compradores
    </div>
</div>
<!-- JavaScript para Hover e Oscilação de Cor nos Cartões -->
<script>
    // Defina as cores originais para cada card
    const originalColors = {
        cardImoveis: '#5b125b',
        cardUsuarios: '#05017f',
        cardClientes: '#1b5f15',
        cardFaturamento: '#9fae00'
    };

    // Função para adicionar a oscilação de cor
    function setCardHoverEffect(cardId, hoverColor) {
        const card = document.getElementById(cardId);
        card.style.transition = 'background-color 0.3s ease'; // Transição suave de cor

        card.addEventListener('mouseenter', function() {
            this.style.backgroundColor = hoverColor; // Cor ao passar o mouse
        });

        card.addEventListener('mouseleave', function() {
            this.style.backgroundColor = originalColors[cardId]; // Retorna à cor original
        });
    }

    // Adiciona o efeito de oscilação de cor aos cartões específicos
    setCardHoverEffect('cardImoveis', '#5b1d99'); // Oscilação de cor para Imóveis Cadastrados
    setCardHoverEffect('cardUsuarios', '#0074b4'); // Oscilação de cor para Usuários Cadastrados
    setCardHoverEffect('cardClientes', '#00b34c'); // Oscilação de cor para Clientes Cadastrados
    setCardHoverEffect('cardFaturamento', '#ffd41f'); // Oscilação de cor para Faturamento Total
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo $base; ?>/js/alert.js"></script>
