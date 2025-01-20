<?php
class LoginAdmin extends BD {
    private $tabela;
    private $prefixo;

    public function __construct($table = 'usuario', $pref = 'imoveis_') {
        $this->tabela = $table;
        $this->prefixo = $pref;        
    }

    private function criptar($senha) {
        return $senha; // Retorne a senha diretamente sem alterações
    }

    private function validar($usuario, $senha) {
        $senha = $this->criptar($senha);
        $verificar = self::conn()->prepare("SELECT * FROM `".$this->tabela."` WHERE USUARIO = ? AND SENHA = ?");
        $verificar->execute(array($usuario, $senha));    
        return $verificar->rowCount() > 0;
    }

    public function logar($usuario, $senha) {
        if ($this->validar($usuario, $senha)) {
            //$stmt = self::conn()->prepare("SELECT GRUPO FROM `" . $this->tabela . "` WHERE USUARIO = ?");
            //$stmt->execute([$usuario]);
            //$dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
            //$grupo=$dadosUsuario['GRUPO'];

            $stmt = self::conn()->query("SELECT GRUPO FROM `" . $this->tabela . "` WHERE USUARIO = '$usuario'");
            $user = $stmt->fetchObject();
            $_SESSION[$this->prefixo . 'usuario'] = $usuario;
            $_SESSION[$this->prefixo . 'grupo'] = $user->GRUPO;
            return true;
        } else {
            return false;
        }
    }

    public function isLogado() {
        return isset($_SESSION[$this->prefixo.'usuario']);
    }

    public function sair() {
        if ($this->isLogado()) {
            unset($_SESSION[$this->prefixo.'usuario'], $_SESSION[$this->prefixo.'grupo']);
            session_destroy();
            return true;
        } else {
            return false;    
        }
    }
}
?>