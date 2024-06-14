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
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/carrinho.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
    <div class="busca">
        <img id="papel" src="../img/logo mr paper.jpg" alt="Logo Mr.Paper">
        <img id="name" src="../img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='../index.php'">
    </div>
    <div class="menu">
        <a href="../conta.php"><i class="fa-solid fa-user"></i></a>
        <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</header>

<div class="container">
    <div class="conteudo carrinho">
        <div class="produtos"> 
            <h1><strong>Produtos no Carrinho</strong></h1>
            <!-- Lista de produtos no carrinho -->
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
                            </div>
                            <div class="valor">
                                <!-- Exibe a quantidade atual sem permitir edição -->
                                <div class="quantidade">
                                    <?php echo $item['quantidade']; ?>
                                </div>
                                <!-- Formulário para atualizar a quantidade (sem botão de enviar) -->
                                <form id="form-<?php echo $produto_id; ?>" method="post" action="atualizar_carrinho.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
                                    <input type="hidden" name="quantidade" value="<?php echo $item['quantidade']; ?>">
                                </form>
                                <!-- Script para enviar o formulário ao alterar a quantidade -->
                                <script>
                                    $(document).ready(function() {
                                        $('#quantidade-<?php echo $produto_id; ?>').on('input', function() {
                                            var quantidade = $(this).val();
                                            $('#form-<?php echo $produto_id; ?> input[name="quantidade"]').val(quantidade);
                                            $('#form-<?php echo $produto_id; ?>').submit();
                                        });
                                    });
                                </script>
                                <!-- Formulário para remover o produto do carrinho -->
                                <form method="post" action="../remover_carrinho.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
                                    <button type="submit">Remover</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <div class="subtotal">
                        <p><strong>Subtotal: R$ <?php echo number_format(calcular_subtotal($carrinho), 2, ',', '.'); ?></strong></p>
                        <a href="../index.php">Continuar comprando</a>
                        <a href="pagamento.php?subtotal=<?php echo calcular_subtotal($carrinho); ?>">Finalizar pedido</a>
                    </div>
                <?php else: ?>
                    <p>Nenhum produto no carrinho.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="../js/script.js"></script>
</body>
</html>
