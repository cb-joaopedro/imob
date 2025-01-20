# Sistema Imobiliário
Este repositório contém o código-fonte de um Sistema Imobiliário desenvolvido para a Imobiliária Operacional de Elite. O sistema oferece uma plataforma completa para a gestão de imóveis, incluindo funcionalidades de cadastro, vendas e reservas.

## Tecnologias utilizadas:

#### Frontend:

    HTML5: Estruturação da página.
    CSS3 (via Bootstrap): Estilização e layout responsivo.
    JavaScript: Interatividade e lógica no frontend.
    Chart.js: Geração de gráficos de desempenho e métricas.
    SweetAlert2: Exibição de alertas estilizados.

#### Backend:

    PHP: Linguagem principal utilizada para lógica do sistema e controle das operações de backend.
    PDO (PHP Data Objects): Para comunicação segura com o banco de dados MySQL.

#### Banco de Dados:

    MySQL: Sistema gerenciador de banco de dados utilizado para armazenar dados de imóveis, clientes, e transações.

## Usuários de acesso: 

O sistema utiliza um login simples para acessar a interface administrativa. Aqui estão as credenciais para os testes:

#### Usuário padrão:

    Nome de usuário: admin
    Senha: admin

#### O sistema tem diferentes permissões para usuários com diferentes papéis:

    CEO: Acesso total.
    Administrador: Imóveis (Cadastro, Edição e Exclusão) e Usuários (Cadastro, Edição e Exclusão).
    Vendedor: Imóveis (Reservar) e Clientes (Cadastro, Edição e Exclusão).
    Financeiro: Imóveis (Apenas Visualizar) e Aprovar Vendas (Vincular Venda ao Cliente).

Para testar com um usuário de cada grupo, adicione-os diretamente na tabela GRUPO no banco de dados, se necessário.

##### 'C' => 'CEO', 'A' => 'Administrador', 'F' => 'Financeiro', 'V' => 'Vendedor'

## Como Executar:

#### 1. Baixar Banco de Dados:

O banco de dados será disponibilizado em um arquivo .sql. Baixe e importe-o para o seu servidor MySQL. (nome do BD 'imoveis')

#### 2. Configuração do Ambiente:

Clone este repositório em seu ambiente local:

git clone https://github.com/cb-joaopedro/imob.git

No diretório raiz do projeto, configure o arquivo de conexão ao banco de dados:

    Arquivo: config.php
    Parâmetros de Conexão:
        Host: localhost
        Porta: 3307
        Banco de Dados: imoveis
        Usuário: root
        Senha: (deixe vazio ou insira a senha configurada no MySQL)

#### 3. Funcionalidades para Testes:

    Index de Login
    (header)  'Gestão Imobiliária' é a tela de início
              'Menu de expansão' utilizando os três tracinhos
              'Logout' encerra a sessão
              'Configurações' altera o nível de permissão dos usuários
    Imóveis (Cadastro, Edição, Exclusão e Reserva).
    Usuários (Cadastro, Edição e Exclusão).
    Clientes (Cadastro, Edição e Exclusão).
    Aprovar Vendas (Vincular venda ao cliente).
    Painel - CEO (Cards e Gráfico com informações).
    
    Controle de Acesso: Teste as permissões de acesso para diferentes grupos de usuários.



>>>>>>> 9d6c751fa9a0476fc6c497fda59bb4e97a2822e0
