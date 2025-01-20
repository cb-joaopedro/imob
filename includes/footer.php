</main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
						<div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Gestão de Imóveis 2024</div>
                            <div>
                                <a href="#">Política de Privacidade</a>
                                &middot;
                                <a href="#">Termos de uso</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        
		<script src="js/scripts.js"></script>
		<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch dos dados do backend
        fetch("get_vendas.php")
            .then(response => response.json())
            .then(data => {
                const nomes = data.map(item => item.nome_comprador);
                const valores = data.map(item => parseFloat(item.valor_imovel));

                // Configuração do gráfico
                const ctx = document.getElementById("myLineChart").getContext("2d");
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: nomes,
                        datasets: [{
                            label: "Valor do Imóvel (R$)",
                            data: valores,
                            borderColor: "rgba(75,192,192,1)",
                            backgroundColor: "rgba(75,192,192,0.2)",
                            borderWidth: 2,
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(75,192,192,1)"
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                ticks: {
                                    autoSkip: false
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return "R$ " + value.toLocaleString("pt-BR");
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR");
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Erro ao carregar dados do gráfico:", error));
    });


    

</script>

    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo $base; ?>/js/alert.js"></script>


