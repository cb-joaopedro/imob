<?php
// Inclui o arquivo de configuração e inicializa a sessão
include_once('config.php');

// Inclui o arquivo de cabeçalho
include_once('includes/header.php');

// Cria a instância de LoginAdmin
$login = new LoginAdmin();

// Verifica se o usuário está logado
if (!$login->isLogado()) {
    header("Location: login/index.php");
    exit;
}

// Obtém os parâmetros da URL
$url = isset($_GET['url']) ? strip_tags(addslashes($_GET['url'])) : '';
$parametros = explode('/', $url);

// Define os parâmetros
$arquivo = $parametros[0] ?? ''; // Primeiro parâmetro
$cd = $parametros[1] ?? ''; // Segundo parâmetro
$acao = $parametros[2] ?? ''; // Terceiro parâmetro

// Páginas permitidas
$paginas = [
    'home', 'cadastro_venda', 'vincular_cliente', 'aprovar_venda', 'login', 'vender',
    'confirmar', 'cadastro_imovel', 'cadastro_cliente', 'usuarios', 'home_equipe',
    'imoveis', 'clientes', 'situacoes_venda', 'cadastro_usuario','configuracoes'
];

// Verifica e inclui a página de busca
if (isset($_POST['s']) && $_POST['s'] != '') {
    include "pages/busca.php";
    exit;
}

// Verifica e inclui a página de confirmação (action based)
if (isset($cd) && !empty($cd)) {
    if (isset($acao) && !empty($acao)) {
        include "includes/confirmar.php";
        exit;
    }
}

// Verifica se a página solicitada está na lista permitida
if (isset($arquivo) && in_array($arquivo, $paginas)) {
    include "pages/$arquivo.php";
    exit;
}

// Logout do usuário
if (isset($arquivo) && $arquivo == 'logout') {
    if ($login->sair()) {
        echo '<script>location.href="' . $base . '/login/index.php";</script>';
    } exit;
}

// Redireciona para a home se não houver nenhum arquivo especificado
if (empty($arquivo)) {
    include "pages/home_equipe.php";
    exit;
}

// Exibe erro para qualquer outra página não permitida
echo '<script>alert("Página não localizada ou não autorizada..."); location.href="' . $base . '";</script>';
exit();

include_once('includes/footer.php');

?>
