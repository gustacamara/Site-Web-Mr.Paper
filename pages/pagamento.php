<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/pagamento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <title>Document</title>
</head>
<body>
    <header>
        <div class="busca">
            <img id="papel"src="../img/logo mr paper.jpg" alt="Logo Mr.Paper">
            <img id="name" src="../img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='../index.php'">
        </div>
        <div class="menu">
            <a href="login.html"><i class="fa-solid fa-user"></i></a>
            <a href="carrinho.html"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </header>
    <div class="container">
        <div class="conteudo carrinho">
            <h1>Meus produtos</h1>
            <div class="produtos">
                <div class="itens">
                    <article>
                        <div class="info">
                            <div class="foto">
                                <img src="../img/produtos/harry_potter.jpeg" alt="livro: harry Potter">
                            </div>
                            <div class="descricao">
                                <h3>Harry Potter e a Pedra Filosofal: 1</h3>
                                <p>R$ 49,75</p>
                            </div>
                        </div>
                        <div class="valor">
                            <input type="number" value="1"disabled>
                        </div>
                    </article>
                    <article>
                        <div class="info">
                            <div class="foto">
                                <img src="../img/produtos/como fazer amigos.jpg" alt="livro: como fazer amigos">                              
                            </div>
                            <div class="descricao">
                                <h3>O poder do hábito: Por que fazemos o que fazemos na vida e nos negócios</h3>
                                <p>R$ 55,87</p>
                            </div>
                        </div>
                        <div class="valor">
                            <input type="number" value="1" disabled>       
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="pagamento">
            <div class="conteudo opcoes">
                <form>
                    <h2>Método de pagamento</h2>
                    <div class="formulario_opcoes">
                        <input type="radio" id="credito" name="metodo-pagamento" value="credito">
                        <label for="credito">Cartão de Crédito</label><br>            
                        <input type="radio" id="debito" name="metodo-pagamento" value="debito">
                        <label for="debito">Cartão de Débito</label><br>            
                        <input type="radio" id="pix" name="metodo-pagamento" value="pix">
                        <label for="pix">PIX</label><br>
                    </div>

                    
                </form>
            </div>
            <div class="conteudo card_pix" id="form-pagamentos"  style="display: none;">
                
                <div class="card" id="form-credito" style="display: none;">
                    <h2>Informações do Cartão de Crédito:</h2>
                    <label for="nome-cartao">Nome no Cartão:</label>
                    <input type="text" id="nome-cartao" name="nome-cartao" required><br>        
                    <label for="numero-cartao">Número do Cartão:</label>
                    <input type="text" id="numero-cartao" name="numero-cartao" required><br>        
                    <label for="validade-cartao">Validade do Cartão:</label>
                    <input type="text" id="validade-cartao" name="validade-cartao" required><br>        
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required><br>

                    <button type="button">Finalizar compra</button>
                </div>
            
                <div class="card" id="form-debito" style="display: none;">
                    <h2>Informações do Cartão de Débito:</h2>
                    <label for="nome-cartao">Nome no Cartão:</label>
                    <input type="text" id="nome-cartao" name="nome-cartao" required><br>
                    <label for="numero-cartao">Número do Cartão:</label>
                    <input type="text" id="numero-cartao" name="numero-cartao" required><br>
                    <label for="validade-cartao">Validade do Cartão:</label>
                    <input type="text" id="validade-cartao" name="validade-cartao" required><br>        
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required><br>

                    <button type="button">Finalizar compra</button>
                </div>

            
                <div id="form-pix" style="display: none;">
                    <h2>Chave PIX:</h2>
                    <img src="../img/qr code pix.png" alt="Qr code pix"><br>
                </div>
            </div>
        </div>
        
    </div>
    <script>
        const metodoPagamento = document.getElementsByName('metodo-pagamento');
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



