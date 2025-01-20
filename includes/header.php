<?php
// Inclui o arquivo de configuração e inicia a sessão
include_once('config.php');
// Verifica se o usuário está logado
$login = new LoginAdmin();
if ($login->isLogado()) {
    // Obtém o grupo do usuário logado
    // comentamos na construção do projeto, para poder testar sem precisar fazer logoff
    //$grupoUsuario = $_SESSION['imoveis_grupo'];

    //buscamos o grupo de usuário na hora, para poder validar as permissões de forma mais ágil
    $stmt = BD::conn()->query("SELECT GRUPO FROM `usuario` WHERE USUARIO = '".$_SESSION['imoveis_usuario']."'");
    $user = $stmt->fetchObject();
    $grupoUsuario = $user->GRUPO;

} else {
    // Redireciona para a página de login
    header("Location: login/index.php");
    exit; // Interrompe a execução do script após o redirecionamento
}

//['C', 'A', 'F', 'V']

// Páginas permitidas
$permissoes[] = array(
    'link' => 'home',
    'leg' => 'Painel - CEO',
    'acesso' => ['C'], // Grupos com acesso ao menu
    'icone' => 'bar-chart-line-fill',
    'editar' => ['C'] // Grupos com permissão para editar
);
$permissoes[] = array(
    'link' => 'imoveis',
    'leg' => 'Imóveis',
    'acesso' => ['C', 'A', 'V', 'F'], // Grupos com acesso ao menu
    'icone' => 'houses-fill',
    'editar' => ['C','A'], // Grupos com permissão para editar
    'excluir' => ['C','A'], // Grupos com permissão para excluir
    'reservar' => ['C', 'V'], // Grupos com permissão para reservar
    'CadImoveis' => ['C','A'] // Grupos com permissão para cadastrar
);
$permissoes[] = array(
    'link' => 'usuarios',
    'leg' => 'Usuários',
    'acesso' => ['C', 'A'], // Grupos com acesso ao menu
    'icone' => 'person-bounding-box',
    'editar' => ['C', 'A'], // Grupos com permissão para editar
    'excluir' => ['C','A'], // Grupos com permissão para excluir
    'CadUsuario' => ['C','A'] // Grupos com permissão para cadastrar
);
$permissoes[] = array(
    'link' => 'clientes',
    'leg' => 'Clientes',
    'acesso' => ['C', 'V'], // Grupos com acesso ao menu
    'icone' => 'people-fill',
    'editar' => ['C', 'V'], // Grupos com permissão para editar
    'excluir' => ['C','V'], // Grupos com permissão para excluir
    'CadCliente' => ['C','V'] // permissão para cadastrar
);
$permissoes[] = array(
    'link' => 'aprovar_venda',
    'leg' => 'Aprovar Vendas',
    'acesso' => ['C', 'F'], // Grupos com acesso ao menu
    'icone' => 'cash-coin',
    'CadVenda' => ['C','F'] // Grupos com permissão para vender
);

function getPermissaoUsuario($link, $permissoes, $gr, $acao = 'editar') {
    $per = false;
    foreach ($permissoes as $menu) {
        if (in_array($gr, $menu['acesso']) && $link == $menu['link']) {
            if (isset($menu[$acao]) && in_array($gr, $menu[$acao])) {
                $per = true;
            }
        }
    }
    return $per;
}


$filtro_imovel='';
if (isset($_POST['filtro_imovel'])){
    $filtro_imovel = strip_tags($_POST['filtro_imovel']);
    $_SESSION['filtro_imovel']=$filtro_imovel;
}else{
    if (isset( $_SESSION['filtro_imovel'])){
        $filtro_imovel = $_SESSION['filtro_imovel'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Imob. Operacional de Elite</title>
    <link href="<?php echo $base; ?>/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link para o script SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Link para o script alert.js -->
    <script src="<?php //echo $base; ?>/js/alert.js"></script>
    <link rel="shortcut icon" href="images/casa-nova.png" type="image/png">
</head>
<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="<?php echo $base; ?>/home_equipe">
            <i class="fa fa-home me-2" style="font-size: 1.5rem; color: #fff;"></i>
            Gestão Imobiliária
        </a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" type="button">
    <i class="fas fa-bars"></i>
</button>

        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="post" action="<?php echo $base; ?>/imoveis">
            <div class="input-group">
                <input class="form-control" type="text" name="filtro_imovel" value="<?php echo $filtro_imovel;?>" placeholder="Buscar imóveis..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo $base; ?>/configuracoes" >Configurações</a></li>

                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="confirmarLogout(event, '<?php echo $base; ?>/logout')">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <!-- Menu inteligente com o nível de permissão do usuário -->
                        <?php 
                            foreach($permissoes as $menu){
                            if (in_array($grupoUsuario, $menu['acesso'])) { 
                                echo '<a class="nav-link" href="'. $base.'/'.$menu['link'].'">
                                    <div class="sb-nav-link-icon"><i class="bi bi-'.$menu['icone'].'"></i></div>
                                    '.$menu['leg'].'
                                </a>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logado:</div>
                    <?php
                    if ($login->isLogado()) {
                        echo strtoupper($_SESSION['imoveis_usuario']);
                    }
                    ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const body = document.body;

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function () {
                        body.classList.toggle('sb-sidenav-toggled');
                    });
                }
            });
            </script>
