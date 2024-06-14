<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Login</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<body>
    <header>
        <div class="busca">
            <img id="papel"src="../img/logo mr paper.jpg" alt="Logo Mr.Paper">
            <img id="name" src="../img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='../index.php'">
        </div>
        <div class="menu">
            <a href="login.php"><i class="fa-solid fa-user"></i></a>
            <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>      
        </div>
    </header>

    <form action="testlogin.php" method="POST">
        <h1>Login</h1>
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="nome" placeholder="ex: (nome.sobrenome)">

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Senha">
        <div class="botoes">
            <button type="submit" id="logar" name="logar">Logar</button>
            <a href="cadastro.php"><button type="button" id="botao_cadastro" name="botao_cadastro">Cadastro</button></a>
        </div>
    </form>
    <script src="js/script.js"></script>
</body>
</html>