<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: login.php');
    exit();
}

// Inclui o arquivo de configuração do banco de dados
include_once('config.php');

// Recupera informações da sessão
$nome = $_SESSION['nome'];
$sobrenome = $_SESSION['sobrenome'];
$email = $_SESSION['email'];

// Verifica se o botão de logout foi acionado
if (isset($_POST['logout'])) {
    // Destrói a sessão atual
    session_destroy();
    // Redireciona para a página de login após o logout
    header('Location: pages/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações da Conta</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/conta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="busca">
            <img id="papel" src="img/logo mr paper.jpg" alt="Logo Mr.Paper">
            <img id="name" src="img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='index.php'">
            <input type="text" placeholder="Pesquisar" name="Pesquisar">   
        </div>
        <div class="menu">
            <a href="conta.php"><i class="fa-solid fa-user"></i></a>
            <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>      
        </div>
    </header>

    <div class="content">
        <h1>Informações da Conta</h1>
        <div class="info-usuario">
            <p><strong>Nome:</strong> <?php echo $nome . ' ' . $sobrenome; ?></p>
            <p><strong>E-mail:</strong> <?php echo $email; ?></p>
            <!-- Adicione mais informações conforme necessário -->
        </div>

        <!-- Formulário para o botão de logout -->
        <form method="post">
            <button type="submit" name="logout">Encerrar Sessão</button>
        </form>
    </div>

    <footer>
        <p>Contato: (11) 1234-5678 | email@minhaloja.com</p>
    </footer>
</body>
</html>
