<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mr. Paper</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/reset.css">
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
        <?php if (isset($_SESSION['nome'])): ?>
            <a href="conta.php"><i class="fa-solid fa-user"></i></a>
        <?php else: ?>
            <a href="pages/login.php"><i class="fa-solid fa-user"></i></a>
        <?php endif; ?>
        <a href="pages/carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</header>

<div class="content">
    <div class="itens">
        <?php
        $result = $conexao->query("SELECT * FROM produtos");
        while ($row = $result->fetch_assoc()) {
            echo '<article class="produto">';
            echo '<img src="img/produtos/' . $row["imagem"] . '" alt="' . $row["nome"] . '">';
            echo '<h3>' . $row["nome"] . '</h3>';
            echo '<p>R$ ' . number_format($row["preco"], 2, ',', '.') . '</p>';
            echo '<form action="adicionar_carrinho.php" method="POST">';
            echo '<input type="hidden" name="produto_id" value="' . $row["id"] . '">';
            echo '<button type="submit">Adicionar ao carrinho</button>';
            echo '</form>';
            echo '</article>';
        }
        ?>
    </div>
</div>
<script src="js/script.js"></script>
</body>
</html>
