<div class="container-fluid px-4">
    <h1 class="mt-4 text-center text-dark fw-bold text-uppercase">IMOBILIÁRIA Operacional de Elite</h1>
    <div class="text-center mt-4">
        <p class="lead text-dark font-weight-bold">
            "Juntos, construímos sonhos, alcançamos metas e transformamos o mercado imobiliário. Cada passo que damos é um avanço na busca pela excelência. A Imobiliária Operacional de Elite não é apenas um nome, é a nossa missão!"
        </p>
    </div>
    <!-- Gráficos -->
    <div class="row justify-content-center">
    <!-- Primeiro Gráfico: Vendas por Mês -->
    <div class="col-lg-5">
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-chart-bar me-1"></i>
                Acompanhe o resultado de nosso desempenho
            </div>
            <div class="card-body">
                <canvas id="myBarChart" width="100%" height="50"></canvas>
            </div>
            <div class="text-center card-footer small text-muted">Gráfico de vendas por mês</div>
        </div>
    </div>
    <!-- Segundo Gráfico: Situação dos Imóveis -->
    <div class="col-lg-5">
        <div class="card mb-4 shadow-lg">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-chart-pie me-1"></i>
                Painel de controle dos nossos imóveis
            </div>
            <div class="card-body">
                <canvas id="myPolarAreaChart" width="100%" height="50"></canvas>
            </div>
            <div class="text-center card-footer small text-muted">Gráfico de situação dos imóveis</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<?php
$cad = new Cadastro();
$lst = $cad->getTotalVendasMes(); // Método que retorna todas as vendas com a data de venda

$valores = [];
$legendas = [];
$maior = 0;

// Mapeamento dos meses
$meses = [
    '1' => 'Janeiro',
    '2' => 'Fevereiro',
    '3' => 'Março',
    '4' => 'Abril',
    '5' => 'Maio',
    '6' => 'Junho',
    '7' => 'Julho',
    '8' => 'Agosto',
    '9' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro',
];

// Inicializa um array para contar as vendas por mês/ano
$vendasPorMes = [];

// Agrupando as vendas por mês/ano
foreach ($lst as $ln) {
    $dataVenda = strtotime($ln->DT_VENDA);
    $mes = date("n", $dataVenda); // Mês numérico
    $ano = date("Y", $dataVenda); // Ano

    $chave = $ano . '-' . $mes;

    if (!isset($vendasPorMes[$chave])) {
        $vendasPorMes[$chave] = 0;
    }

    $vendasPorMes[$chave]++;
}

// Preparando os dados para o gráfico
foreach ($vendasPorMes as $chave => $quantidade) {
    list($ano, $mes) = explode('-', $chave);

    // Monta legenda como "Mês/Ano"
    $legenda = $meses[$mes] . '/' . $ano;
    $legendas[] = '"' . $legenda . '"';
    $valores[] = $quantidade;

    // Atualiza o maior valor de vendas
    $maior = max($maior, $quantidade);
}

$maior += 5; // Ajuste para a escala
$legendasStr = implode(", ", $legendas);
$valoresStr = implode(", ", $valores);

// Gráfico em pizza 

$tot_disponiveis = $cad->getTotalImoveisDisponiveis();
$tot_vendidos = $cad->getTotalImoveisVendidos();
$tot_reservados = $cad->getTotalImoveisReservados();

// Verifica se os valores existem e cria as variáveis de quantidade
$disponiveis = !empty($tot_disponiveis) ? $tot_disponiveis->QTDE : 0;
$vendidos = !empty($tot_vendidos) ? $tot_vendidos->QTDE : 0;
$reservados = !empty($tot_reservados) ? $tot_reservados->QTDE : 0;

$legendasPizzaStr = '"Disponíveis", "Vendidos", "Reservados"';
$valoresPizzaStr = "$disponiveis, $vendidos, $reservados";
?>

<script>
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [<?php echo $legendasStr; ?>],
    datasets: [{
      label: "Vendas",
      backgroundColor: "#0275d8",
      borderColor: "#0274d8",
      data: [<?php echo $valoresStr; ?>],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        grid: {
          display: false // Remove as linhas de grade do eixo X
        },
        ticks: {
          display: false // Remove os rótulos (meses) do eixo X
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php echo $maior; ?>,
          stepSize: Math.ceil(<?php echo $maior; ?> / 12),
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
// Gráfico 2: Pizza
var ctxPol = document.getElementById("myPolarAreaChart");
    var myPieChart = new Chart(ctxPol, {
        type: 'polarArea',
        data: {
    labels: [
        'Disponíveis', 
        'Vendidos', 
        'Reservados'
    ],
    datasets: [{
      data: [
        <?php echo htmlspecialchars($tot_disponiveis->QTDE); ?>,
        <?php echo htmlspecialchars($tot_vendidos->QTDE); ?>,
        <?php echo htmlspecialchars($tot_reservados->QTDE); ?>
      ],
      backgroundColor: [
        'rgba(0, 123, 255, 0.5)',  // Cor para Disponíveis (Azul)
        'rgba(40, 167, 69, 0.5)',  // Cor para Vendidos (Verde)
        'rgba(255, 193, 7, 0.5)'   // Cor para Reservados (Amarelo)
      ],
      borderColor: [
        'rgba(0, 123, 255, 1)',    // Cor de borda para Disponíveis
        'rgba(40, 167, 69, 1)',    // Cor de borda para Vendidos
        'rgba(255, 193, 7, 1)'     // Cor de borda para Reservados
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      tooltip: {
        callbacks: {
          label: function(tooltipItem) {
            return tooltipItem.label + ': ' + tooltipItem.raw + ' imóveis';
          }
        }
      }
    },
    scales: {
      r: {
        angleLines: {
          display: true
        },
        suggestedMin: 0
      }
    }
  }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo $base; ?>/js/alert.js"></script>