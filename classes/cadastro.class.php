<?php
// A classe Cadastro estende a classe BD para utilizar o método de conexão PDO na classe Cadastro
class Cadastro extends BD {
    private $table;
    private $numRows;

    // Construtor único para definir a tabela
    public function __construct($tabela = 'USUARIO') {
        $this->table = $tabela;
        $this->numRows = 0;
    }

    private function setNumRows($nr) {
        $this->numRows = $nr;
    }

    public function getNumRows() {
        return $this->numRows;
    }

    private function crip($senha) {
        return md5($senha);
    }

    /**
     * Métodos de gerenciamento de usuários
     */
    
     public function getTotalCeos() {
        $sql = "SELECT COUNT(*) AS QTDE FROM usuario WHERE GRUPO = 'C'"; // 'C' = CEO
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar CEO\'s: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalAdministradores() {
        $sql = "SELECT COUNT(*) AS QTDE FROM usuario WHERE GRUPO = 'A'"; // 'A' = Administrador
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar Administradores: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalFinanceiros() {
        $sql = "SELECT COUNT(*) AS QTDE FROM usuario WHERE GRUPO = 'F'"; // 'F' = Financeiro
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar Financeiros: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalVendedores() {
        $sql = "SELECT COUNT(*) AS QTDE FROM usuario WHERE GRUPO = 'V'"; // 'V' = Vendedor
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar Vendedores: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }    
    

    public function getUsuarioCd($cd) {
        $sql = "SELECT * FROM USUARIO WHERE CD_USUARIO = :cd";
        try {
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':cd', $cd, PDO::PARAM_INT);
            $stmt->execute();
            $this->setNumRows($stmt->rowCount());
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao buscar usuário: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function listaUsuarios($pg,$max) {

        $t = $this->getTotalUsuariosCadastrados();
        $this->setNumRows($t->QTDE);

        $sql = "SELECT * FROM usuario limit " . (($pg * $max)-$max).', '.$max;
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Erro ao listar usuários: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function novoUsuario($dados = []) {
        $sql = "INSERT INTO USUARIO (USUARIO, NOME, GRUPO, SENHA) VALUES (?, ?, ?, ?)";
        try {
            $stmt = self::conn()->prepare($sql);
            return $stmt->execute($dados);
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar usuário: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function editarUsuario($dados = [], $senha = true) {
        $sql = $senha
            ? "UPDATE USUARIO SET USUARIO = ?, NOME = ?, GRUPO = ?, SENHA = ? WHERE CD_USUARIO = ?"
            : "UPDATE USUARIO SET USUARIO = ?, NOME = ?, GRUPO = ? WHERE CD_USUARIO = ?";

        try {
            $stmt = self::conn()->prepare($sql);
            return $stmt->execute($dados);
        } catch (PDOException $e) {
            echo 'Erro ao editar usuário: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalUsuariosCadastrados() {
        $sql = "SELECT COUNT(CD_USUARIO) AS QTDE FROM usuario";
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            //echo 'Erro ao contar usuários: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }
    /**
     * Métodos de gerenciamento de imóveis
     */

    public function getImovelCd($cd_imovel) {
        try {
            $sql = "SELECT * FROM IMOVEL WHERE CD_IMOVEL = :cd_imovel";
            $stmt = BD::conn()->prepare($sql);
            $stmt->bindParam(':cd_imovel', $cd_imovel, PDO::PARAM_INT);
            $stmt->execute();
            $imovel = $stmt->fetch(PDO::FETCH_OBJ);
            
            return $imovel ?: false;
        } catch (PDOException $e) {
            echo 'Erro ao buscar imóvel: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function novoImovel($dados = []) {
        if (count($dados) !== 4) {
            throw new Exception('O número de dados não corresponde aos parâmetros esperados.');
        }

        $sql = "INSERT INTO IMOVEL (DESCRICAO, LOCALIZACAO, VALOR, SITUACAO) VALUES (?, ?, ?, ?)";
        try {
            $stmt = self::conn()->prepare($sql);
            if ($stmt->execute($dados)) {
                return true;
            } else {
                throw new Exception('Erro ao cadastrar o imóvel.');
            }
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar o imóvel: ' . htmlspecialchars($e->getMessage());
            return false;
        } catch (Exception $e) {
            echo 'Erro: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function editarImovel($dados = []) {
        if (count($dados) !== 5) {
            throw new Exception('O número de dados não corresponde aos parâmetros esperados.');
        }
    
        // A situação será atualizada apenas se houver um valor novo para ela
        $sql = "UPDATE IMOVEL SET DESCRICAO = ?, LOCALIZACAO = ?, VALOR = ?, SITUACAO = IFNULL(?, SITUACAO) WHERE CD_IMOVEL = ?";
        
        try {
            $stmt = self::conn()->prepare($sql);
            if ($stmt->execute($dados)) {
                return true;
            } else {
                throw new Exception('Erro ao atualizar o imóvel.');
            }
        } catch (PDOException $e) {
            echo 'Erro ao atualizar o imóvel: ' . htmlspecialchars($e->getMessage());
            return false;
        } catch (Exception $e) {
            echo 'Erro: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }    

    public function listaImoveis($situacoes = '',$descricao_localizacao='',$pg=1,$max=0) {
                
        $filtro='';
        if (!empty($situacoes)) {
            $filtro .= " WHERE SITUACAO IN ($situacoes)";
        }else{
            if (!empty($descricao_localizacao)) {
                $filtro .= " WHERE DESCRICAO like '%$descricao_localizacao%' or LOCALIZACAO like '%$descricao_localizacao%'";
            }
        }

        if ($max > 0){
            $sql = "SELECT * FROM imovel $filtro limit " . (($pg * $max)-$max).', '.$max;
        }else{
            $sql = "SELECT * FROM imovel $filtro";
        }

        $t = $this->getTotalImoveisCadastrados($filtro);
        $this->setNumRows($t->QTDE);
        
        try {
            $stmt = self::conn()->prepare($sql);
            
            $stmt->execute();
            if ($max == 0){
                $this->setNumRows($stmt->rowCount());
            }
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Erro ao listar imóveis: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalImoveisCadastrados($filtro='') {
        $sql = "SELECT COUNT(CD_IMOVEL) AS QTDE FROM imovel $filtro";
        
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar imóveis: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }
    

    public function getTotalImoveisDisponiveis() {
        $sql = "SELECT COUNT(CD_IMOVEL) AS QTDE FROM IMOVEL WHERE SITUACAO = 1"; // Situação 1 = Disponivel
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar imóveis reservados: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }


    public function getTotalImoveisReservados() {
        $sql = "SELECT COUNT(CD_IMOVEL) AS QTDE FROM IMOVEL WHERE SITUACAO = 3"; // Situação 3 = Reservado
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar imóveis reservados: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalImoveisVendidos() {
        $sql = "SELECT COUNT(CD_IMOVEL) AS QTDE FROM IMOVEL WHERE SITUACAO = 2"; // Situação 2 = Vendido
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar imóveis vendidos: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }
    

    public function getValorImoveisVendidos() {
        $situacao = 2; // Código para 'Vendido'
        $sql = "SELECT SUM(VALOR) AS total_vendido FROM IMOVEL WHERE SITUACAO = :situacao";
        try {
            $stmt = self::conn()->prepare($sql);
            $stmt->bindParam(':situacao', $situacao, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result->total_vendido : 0;
        } catch (PDOException $e) {
            echo 'Erro ao calcular o valor dos imóveis vendidos: ' . htmlspecialchars($e->getMessage());
            return 0;
        }
    }

    public function venderImovel($id_imovel) {
        $sql = "UPDATE IMOVEL SET SITUACAO = 2 WHERE CD_IMOVEL = ?";
        try {
            $stmt = self::conn()->prepare($sql);
            $stmt->bindParam(1, $id_imovel, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao vender imóvel: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function reservarImovel($id_imovel) {
        $sql = "UPDATE IMOVEL SET SITUACAO = 3 WHERE CD_IMOVEL = ?";
        try {
            $stmt = self::conn()->prepare($sql);
            $stmt->bindParam(1, $id_imovel, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao reservar imóvel: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function vincularCompraImovel($id_imovel, $id_cliente) {
        // SQL para atualizar o imóvel, associando o cliente comprador
        $dt_venda = date('Y/m/d H:i:s');
        $sql = "UPDATE IMOVEL SET SITUACAO = 2, DT_VENDA='$dt_venda', CD_CLIENTE = ? WHERE CD_IMOVEL = ?";
        
        try {
            // Prepara a query
            $stmt = self::conn()->prepare($sql);
            // Vincula os parâmetros
            $stmt->bindParam(1, $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_imovel, PDO::PARAM_INT);
            
            // Executa a query e retorna o resultado
            return $stmt->execute();
        } catch (PDOException $e) {
            // Caso ocorra algum erro
            echo 'Erro ao vincular compra do imóvel: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }
    


    public function getComprasPorCliente() {
        // Exemplo de consulta para pegar a quantidade de imóveis comprados e o valor total gasto por cliente
        $sql = "
            SELECT 
                c.NOME AS cliente_nome,
                COUNT(i.CD_IMOVEL) AS quantidade_imoveis,
                SUM(i.VALOR) AS valor_total
            FROM imoveis i
            JOIN vendas v ON i.CD_IMOVEL = v.CD_IMOVEL
            JOIN clientes c ON v.CD_CLIENTE = c.CD_CLIENTE
            WHERE v.DATA_VENDA IS NOT NULL
            GROUP BY c.CD_CLIENTE
            ORDER BY valor_total DESC
        ";
    
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);  // Retorna como um array de objetos
    }

    /**
     * Métodos de gerenciamento de clientes
     */


    public function getClientePorId($cd_cliente) {
        $sql = "SELECT NOME FROM CLIENTES WHERE CD_CLIENTE = :cd_cliente";
        try {
            $stmt = self::conn()->prepare($sql);
            $stmt->bindParam(':cd_cliente', $cd_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao buscar cliente: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function listaClientes($pg=1,$max=500) {
        
        $t = $this->getTotalClientesCadastrados();
        $this->setNumRows($t->QTDE);

        $sql = "SELECT * FROM clientes limit " . (($pg * $max)-$max).', '.$max;
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Erro ao listar clientes: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function novoCliente($dados = []) {
        $sql = "INSERT INTO CLIENTES (NOME, CPF, TELEFONE) VALUES (?, ?, ?)";
        try {
            $stmt = self::conn()->prepare($sql);
            return $stmt->execute($dados);
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar cliente: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function editarCliente($dados = []) {
        $sql = "UPDATE CLIENTES SET NOME = ?, CPF = ?, TELEFONE = ? WHERE CD_CLIENTE = ?";
        try {
            $stmt = self::conn()->prepare($sql);
            return $stmt->execute($dados);
        } catch (PDOException $e) {
            echo 'Erro ao editar cliente: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getClienteCd($cd) {
        $sql = "SELECT * FROM CLIENTES WHERE CD_CLIENTE = :cd";
        try {
            $stmt = self::conn()->prepare($sql);
            $stmt->bindValue(':cd', $cd, PDO::PARAM_INT);
            $stmt->execute();
            $this->setNumRows($stmt->rowCount());
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao buscar cliente: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getTotalClientesCadastrados() {
        $sql = "SELECT COUNT(CD_CLIENTE) AS QTDE FROM clientes";
        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            echo 'Erro ao contar clientes: ' . htmlspecialchars($e->getMessage());
            return false;
        }
    }


    public function getTotalVendasMes(){
        $sql ="SELECT DT_VENDA
FROM imovel
WHERE DT_VENDA IS NOT NULL
ORDER BY DT_VENDA";

        try {
            $stmt = self::conn()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }

    }
}
?>
