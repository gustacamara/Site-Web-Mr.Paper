<?php
session_start();
include_once('../config.php');

// Verifica se o usuário não está logado
if (!isset($_SESSION['nome'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT p.id, p.nome, p.preco, p.imagem, c.quantidade 
        FROM carrinho c 
        JOIN produtos p ON c.produto_id = p.id 
        WHERE c.usuario_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$carrinho = [];
while ($row = $result->fetch_assoc()) {
    $carrinho[$row['id']] = [
        'nome' => $row['nome'],
        'preco' => $row['preco'],
        'imagem' => $row['imagem'],
        'quantidade' => $row['quantidade']
    ];
}

// Função para calcular o subtotal
function calcular_subtotal($carrinho) {
    $subtotal = 0;
    foreach ($carrinho as $item) {
        $subtotal += $item['preco'] * $item['quantidade'];
    }
    return $subtotal;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/pagamento.css"> <!-- Arquivo de estilos personalizados -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
    <div class="busca">
        <img id="papel" src="../img/logo mr paper.jpg" alt="Logo Mr.Paper">
        <img id="name" src="../img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='../index.php'">
    </div>
    <div class="menu">
        <a href="conta.php"><i class="fa-solid fa-user"></i></a>
        <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</header>

<div class="container">
    <div class="conteudo finalizar-pedido">
        <h1><strong>Finalizar Pedido</strong></h1>
        <div class="resumo-pedido">
            <h2>Resumo do Pedido</h2>
            <div class="itens">
                <?php if (!empty($carrinho) && is_array($carrinho)): ?>
                    <?php foreach ($carrinho as $produto_id => $item): ?>
                        <article>
                            <div class="info">
                                <div class="foto">
                                    <img src="../img/produtos/<?php echo $item['imagem']; ?>" alt="<?php echo $item['nome']; ?>">
                                </div>
                                <div class="descricao">
                                    <h3><?php echo $item['nome']; ?></h3>
                                    <p>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                                </div>
                                <div class="quantidade">
                                    Quantidade: <?php echo $item['quantidade']; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <div class="subtotal">
                        <p><strong>Subtotal: R$ <?php echo number_format(calcular_subtotal($carrinho), 2, ',', '.'); ?></strong></p>
                    </div>
                <?php else: ?>
                    <p>Nenhum produto no carrinho.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="formulario-pedido">
            <h2>Informações de Entrega e Pagamento</h2>
            <form action="processar_pedido.php" method="POST">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" required>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" required>

                <label for="pagamento">Forma de Pagamento:</label>
                <select id="pagamento" name="pagamento" required>
                    <option value="cartao_credito">Cartão de Crédito</option>
                    <option value="boleto">Boleto Bancário</option>
                    <option value="pix">PIX</option>
                </select>

                <button type="submit">Finalizar Pedido</button>
            </form>
        </div>
    </div>
</div>

<script src="../js/script.js"></script>
</body>
</html>
