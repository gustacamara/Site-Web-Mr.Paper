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
        <form method="GET" action="index.php">
            <input type="text" placeholder="Pesquisar" name="pesquisa">   
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
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
        $termoPesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
        $query = "SELECT * FROM produtos";

        if (!empty($termoPesquisa)) {
            $termoPesquisa = $conexao->real_escape_string($termoPesquisa);
            $query .= " WHERE nome LIKE '%$termoPesquisa%' OR descricao LIKE '%$termoPesquisa%'";
        }

        $result = $conexao->query($query);

        while ($row = $result->fetch_assoc()) {
            ?>
            <article class="produto" style="justify-content: space-between;display: flex;flex-direction: column;">
                <div>
                    <img src="img/produtos/<?php echo $row["imagem"]; ?>" alt="<?php echo $row["nome"]; ?>" style='margin: 0px;width: 220px;height: 312.7px;'>
                    <h3><?php echo $row["nome"]; ?></h3>
                    <p>R$ <?php echo number_format($row["preco"], 2, ',', '.'); ?></p>
                </div>
                <form method="POST" action="adicionar_carrinho.php">
                    <input type="hidden" name="produto_id" value="<?php echo $row["id"]; ?>">
                    <button type="submit">Adicionar ao carrinho</button>
                </form>
            </article>
            <?php
        }
        ?>
    </div>
    </div>
</div>
<script src="js/script.js"></script>
</body>
</html>
