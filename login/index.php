<?php
require_once("../config.php"); // Arquivo que já inicia a sessão
require_once("../classes/db.class.php");
require_once("../classes/login.class.php");

$log = new LoginAdmin();

if (isset($_POST['acao']) && $_POST['acao'] == 'logar') {
    $usuario = strip_tags(filter_input(INPUT_POST, 'usuario'));
    $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
    
    if ($usuario != '') { // O campo de senha não é obrigatório
        if ($log->logar($usuario, $senha)) {
            header("Location: index.php?success=true"); // Redireciona com sucesso
            exit;
        } else {
            header("Location: index.php?error=login"); // Redireciona com erro de login
            exit;
        }
    } else {
        header("Location: index.php?error=empty"); // Redireciona com erro de campo vazio
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Imobiliária O&E</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<section class="background-radial-gradient overflow-hidden vh-100 d-flex align-items-center">
  <style>
    .background-radial-gradient {
      background-color: hsl(218, 41%, 15%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(218, 41%, 35%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(218, 41%, 45%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%);
    }

    #radius-shape-1 {
      height: 220px;
      width: 220px;
      top: -60px;
      left: -130px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    #radius-shape-2 {
      border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
      bottom: -60px;
      right: -110px;
      width: 300px;
      height: 300px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    .bg-glass {
      background-color: hsla(0, 0%, 100%, 0.9) !important;
      backdrop-filter: saturate(200%) blur(25px);
    }
  </style>

  <div class="container px-4 py-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <h1 class="my-5 display-6 fw-bold ls-tight text-light">
          Imobiliária Operacional de Elite <br />
          <span style="color: hsl(218, 81%, 75%)">Tornando sonhos em realidade</span>
        </h1>
        <p class="text-light opacity-75">
          Acesse o sistema utilizando seu usuário e senha.
        </p>
      </div>

      <div class="col-lg-5">
        <div id="radius-shape-2" class="position-absolute shadow-5-strong" style="bottom: 0px; right: 0px;"></div>
        
        <div class="card bg-glass">
          <div class="card-body px-4 py-5">
            <form method="post">
              <div class="form-outline mb-4">
              <label class="form-label" for="usuario">Nome de usuário</label>
                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="usuário" />
              </div>

              <div class="form-outline mb-4">
                <label class="form-label" for="senha">Senha de acesso</label>
                <input type="password" id="senha" name="senha" class="form-control" placeholder="senha" />
              </div>

              <input type="hidden" name="acao" value="logar" />
              <button type="submit"  class="btn btn-lg col-lg-12" style="background-color: blue; color: white; padding: revert; font-weight: bold; text-transform: uppercase;">Entrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
    // Verifica se há um erro na URL
    <?php if (isset($_GET['error'])): ?>
        var error = "<?php echo $_GET['error']; ?>";
        if (error == "login") {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Usuário ou senha incorretos.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.href = "<?php echo $base; ?>"; // Redireciona após exibir a mensagem
            });
        } else if (error == "empty") {
            Swal.fire({
                icon: 'warning',
                title: 'Campos vazios!',
                text: 'Por favor, preencha o campo de usuário.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.href = "<?php echo $base; ?>"; // Redireciona após exibir a mensagem
            });
        }
    <?php elseif (isset($_GET['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Bem-vindo ao Sistema!',
            text: 'Você foi autenticado com sucesso!',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            location.href = "<?php echo $base; ?>"; // Redireciona após exibir a mensagem
        });
    <?php endif; ?>
</script>
</body>
</html>
