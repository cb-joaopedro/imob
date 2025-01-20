<?php
session_start();  // Inicia a sessão aqui, garantindo que a sessão seja acessível globalmente

// Incluir as classes necessárias
require_once('classes/db.class.php');  // Classe para a conexão com o banco de dados
BD::conn();  // Estabelece a conexão com o banco de dados

require_once('classes/login.class.php');  // Classe de login
include_once('classes/cadastro.class.php');  // Classe de cadastro de imóveis e clientes

// Definição da URL base do sistema
$base = 'http://localhost/imobiliaria';  // Altere conforme a URL do seu sistema, se necessário
?>