<?php
class BD {
    private static $conn;

    public function __construct() {}

    // Método de conexão ao banco de dados
    public static function conn() {
        if (is_null(self::$conn)) {
            try {
                self::$conn = new PDO('mysql:host=localhost;port=3307;dbname=imoveis;', 'root', '');
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Modo de erro configurado para exceções
            } catch (PDOException $e) {
                // Exibe a mensagem de erro e encerra o script
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
