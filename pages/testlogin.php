<?php
session_start();

if(isset($_POST['logar']) && !empty($_POST['nome']) && !empty($_POST['senha']))
{
    include_once('../config.php');
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Consulta SQL para buscar o usuário pelo nome e senha
    $sql = "SELECT * FROM usuarios WHERE nome = '$nome' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if($result && $result->num_rows > 0) {
        // Se encontrou o usuário, recuperar os dados
        $usuario = $result->fetch_assoc();
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['sobrenome'] = $usuario['sobrenome'];  // Incluir sobrenome na sessão
        $_SESSION['email'] = $usuario['email'];          // Incluir email na sessão
        $_SESSION['senha'] = $senha;
        $_SESSION['usuario_id'] = $usuario['id'];

        header('Location: ../index.php');
        exit();
    } else {
        $error = "Usuário ou senha incorretos!";
    }
} else {
    $error = "Preencha o usuário e senha.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Login</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="busca">
            <img id="papel" src="../img/logo mr paper.jpg" alt="Logo Mr.Paper">
            <img id="name" src="../img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='../index.php'">
        </div>
        <div class="menu">
            <a href="login.html"><i class="fa-solid fa-user"></i></a>
            <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>      
        </div>
    </header>

    <form action="testlogin.php" method="POST">
        <h1>Login</h1>
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="nome" placeholder="ex: (nome.sobrenome)">

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Senha">
        <span style="color: red;"><?php echo isset($error) ? $error : ''; ?></span>
        <div class="botoes">
            <button type="submit" id="logar" name="logar">Logar</button>
            <a href="cadastro.php"><button type="button" id="botao_cadastro" name="botao_cadastro">Cadastro</button></a>
        </div>
    </form>
    <script src="js/script.js"></script>
</body>
</html>
