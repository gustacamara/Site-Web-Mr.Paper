<?php
session_start();
include_once('../config.php');

// Verifica se o usuário não está logado
if (!isset($_SESSION['nome'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$subtotal = isset($_GET['subtotal']) ? $_GET['subtotal'] : 0;

if ($subtotal <= 0) {
    echo "Erro: Subtotal inválido.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Processa o pagamento
    $metodo_pagamento = $_POST['metodo_pagamento'];

    // Aqui você pode adicionar a lógica de processamento de pagamento
    // (esta parte é opcional e depende da integração com gateways de pagamento)

    // Redireciona para a página de confirmação
    header('Location: confirmacao.php');
    exit();
} else {
    // Exibe as opções de pagamento
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/reset.css">
        <link rel="stylesheet" href="../css/pagamento.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <title>Pagamento</title>
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
                <h1>Meus produtos</h1>
                <div class="produtos">
                    <div class="itens">
                        <!-- Lista de produtos do carrinho -->
                        <?php
                        $sql = "SELECT p.id, p.nome, p.preco, c.quantidade, p.imagem 
                                FROM carrinho c 
                                JOIN produtos p ON c.produto_id = p.id 
                                WHERE c.usuario_id = ?";
                        $stmt = $conexao->prepare($sql);
                        $stmt->bind_param('i', $usuario_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<article>
                                    <div class="info">
                                        <div class="foto">
                                            <img src="../img/produtos/' . $row['imagem'] . '" alt="Produto: ' . $row['nome'] . '">
                                        </div>
                                        <div class="descricao">
                                            <h3>' . $row['nome'] . '</h3>
                                            <p>R$ ' . number_format($row['preco'], 2, ',', '.') . '</p>
                                        </div>
                                    </div>
                                    <div class="valor">
                                        <input type="number" value="' . $row['quantidade'] . '" disabled>
                                    </div>
                                </article>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="conteudo pagamento">
                <div class="opcoes">
                    <form id="form-pagamento" method="post" action="pagamento.php?subtotal=<?php echo $subtotal; ?>">
                        <h2>Método de pagamento</h2>
                        <div class="formulario_opcoes">
                            <input type="radio" id="credito" name="metodo_pagamento" value="credito" required>
                            <label for="credito">Cartão de Crédito</label><br>
                            <input type="radio" id="debito" name="metodo_pagamento" value="debito" required>
                            <label for="debito">Cartão de Débito</label><br>
                            <input type="radio" id="pix" name="metodo_pagamento" value="pix" required>
                            <label for="pix">PIX</label><br>
                        </div>
                    </form>
                </div>

                <div class="card_pix" id="form-pagamentos" style="display: none;">
                    <div class="card" id="form-credito" style="display: none;">
                        <h2>Informações do Cartão de Crédito:</h2>
                        <label for="nome-cartao">Nome no Cartão:</label>
                        <input type="text" id="nome-cartao" name="nome-cartao" form="form-pagamento" required><br>
                        <label for="numero-cartao">Número do Cartão:</label>
                        <input type="text" id="numero-cartao" name="numero-cartao" form="form-pagamento" required><br>
                        <label for="validade-cartao">Validade do Cartão:</label>
                        <input type="text" id="validade-cartao" name="validade-cartao" form="form-pagamento" required><br>
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" form="form-pagamento" required><br>
                        <button type="submit" form="form-pagamento"onclick="window.location.href='confirmacao.php'">Finalizar compra</button>
                    </div>

                    <div class="card" id="form-debito" style="display: none;">
                        <h2>Informações do Cartão de Débito:</h2>
                        <label for="nome-cartao">Nome no Cartão:</label>
                        <input type="text" id="nome-cartao" name="nome-cartao" form="form-pagamento" required><br>
                        <label for="numero-cartao">Número do Cartão:</label>
                        <input type="text" id="numero-cartao" name="numero-cartao" form="form-pagamento" required><br>
                        <label for="validade-cartao">Validade do Cartão:</label>
                        <input type="text" id="validade-cartao" name="validade-cartao" form="form-pagamento" required><br>
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" form="form-pagamento" required><br>
                        <button type="submit" form="form-pagamento" onclick="window.location.href='confirmacao.php'">Finalizar compra</button>
                    </div>

                    <div id="form-pix" style="display: none;">
                        <h2>Chave PIX:</h2>
                        <img src="../img/qr code pix.png" alt="Qr code pix"><br>
                        <button type="submit" form="form-pagamento" onclick="window.location.href='confirmacao.php'">Finalizar compra</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const metodoPagamento = document.getElementsByName('metodo_pagamento');
            const formCredito = document.getElementById('form-credito');
            const formDebito = document.getElementById('form-debito');
            const formPix = document.getElementById('form-pix');
            const formPagamentos = document.getElementById('form-pagamentos');

            for (let i = 0; i < metodoPagamento.length; i++) {
                metodoPagamento[i].addEventListener('change', function() {
                    if (this.value === 'credito') {
                        formCredito.style.display = 'block';
                        formDebito.style.display = 'none';
                        formPix.style.display = 'none';
                        formPagamentos.style.display = 'block';
                    } else if (this.value === 'debito') {
                        formCredito.style.display = 'none';
                        formDebito.style.display = 'block';
                        formPix.style.display = 'none';
                        formPagamentos.style.display = 'block';
                    } else if (this.value === 'pix') {
                        formCredito.style.display = 'none';
                        formDebito.style.display = 'none';
                        formPix.style.display = 'block';
                        formPagamentos.style.display = 'block';
                    }
                });
            }
        </script>
    </body>
    </html>
    <?php
}
?>
