<?php
session_start();

include '../config.php';



function adicionarLivro($nome, $descricao, $preco, $imagemName) {
    global $conexao;
    $imagemDestino = "../img/produtos/" . basename($imagemName);
    
    if (move_uploaded_file($_FILES['adicionar-foto-livro']['tmp_name'], $imagemDestino)) {
        $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES ('$nome', '$descricao', '$preco', '$imagemName')";
        if ($conexao->query($sql) === TRUE) {
            echo "Novo livro adicionado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conexao->error;
        }
    } else {
        echo "Erro ao carregar a imagem.";
    }
}

function removerLivro($nome) {
    global $conexao;
    $sql = "SELECT imagem FROM produtos WHERE nome='$nome'";
    $result = $conexao->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagem = $row['imagem'];
        $imagemPath = "../img/produtos/" . $imagem;
        if (unlink($imagemPath)) {
            $sql = "DELETE FROM produtos WHERE nome='$nome'";
            if ($conexao->query($sql) === TRUE) {
                echo "Livro removido com sucesso!";
            } else {
                echo "Erro: " . $sql . "<br>" . $conexao->error;
            }
        } else {
            echo "Erro ao remover a imagem.";
        }
    } else {
        echo "Livro não encontrado.";
    }
}

function atualizarLivro($nome, $novaDescricao, $novoPreco, $novaImagem) {
    global $conexao;
    $imagemDestino = "../img/produtos/" . basename($novaImagem);
    
    if (move_uploaded_file($_FILES['atualizar-foto-livro']['tmp_name'], $imagemDestino)) {
        $sql = "UPDATE produtos SET descricao='$novaDescricao', preco='$novoPreco', imagem='$novaImagem' WHERE nome='$nome'";
        if ($conexao->query($sql) === TRUE) {
            echo "Livro atualizado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conexao->error;
        }
    } else {
        echo "Erro ao carregar a nova imagem.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar-botao_cadastro'])) {
        $nome = $_POST['livro'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['adicionar-preco'];
        $imagem = $_FILES['adicionar-foto-livro']['name'];
        adicionarLivro($nome, $descricao, $preco, $imagem);
    } elseif (isset($_POST['remover-remover'])) {
        $nome = $_POST['remover-livro'];
        removerLivro($nome);
    } elseif (isset($_POST['atualizar-botao_atualizar'])) {
        $nome = $_POST['atualizar-livro'];
        $novaDescricao = $_POST['nova-descricao'];
        $novoPreco = $_POST['atualizar-preco'];
        $novaImagem = $_FILES['atualizar-foto-livro']['name'];
        atualizarLivro($nome, $novaDescricao, $novoPreco, $novaImagem);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/administrador.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="busca">
            <img id="papel" src="../img/logo mr paper.jpg" alt="Logo Mr.Paper">
            <img id="name" src="../img/escrita mr paper.jpg" alt="Template Mr. Paper" onclick="window.location.href='../index.php'">
        </div>
        <div class="menu">
            <a href="login.php"><i class="fa-solid fa-user"></i></a>
            <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i></a>      
        </div>
    </header>
    <div class="container">
        <div class="formulario_opcoes">
            <input type="button" id="adicionar" name="opcao-edicao" value="adicionar">  
            <input type="button" id="remover" name="opcao-edicao" value="remover">
            <input type="button" id="atualizar" name="opcao-edicao" value="atualizar">
            <div class="cadastrar">
                <form id="livro_adicionar" action="administrador.php" method="POST" enctype="multipart/form-data" style="display: none;">
                    <h1>Adicionar livro</h1>
                    <label for="livro">Livro</label>
                    <input type="text" id="livro" name="livro" placeholder="Nome do livro">
                    <label for="descricao">Descrição</label>
                    <input type="text" id="descricao" name="descricao" placeholder="Descrição do livro">
                    <label for="adicionar-preco">Preço</label>
                    <input type="number" id="adicionar-preco" name="adicionar-preco" placeholder="Preço do livro">
                    <label for="adicionar-foto-livro">Imagem</label>
                    <input type="file" id="adicionar-foto-livro" name="adicionar-foto-livro" accept=".jpg, .jpeg, .png">
                    <div class="botoes">
                        <button type="submit" name="adicionar-botao_cadastro" style="width: 100%;">Cadastrar Livro</button>
                    </div>
                </form>
            </div>
            <div class="remover">
                <form id="livro_remover" action="administrador.php" method="POST" style="display: none;">
                    <h1>Remover livro</h1>
                    <label for="remover-livro">Livro</label>
                    <input type="text" id="remover-livro" name="remover-livro" placeholder="Nome do livro">
                    <div class="botoes">
                        <button type="submit" name="remover-remover" style="width: 100%;">Remover livro</button>
                    </div>
                </form>
            </div>
            <div class="atualizar">
                <form id="livro_atualizar" action="administrador.php" method="POST" enctype="multipart/form-data" style="display: none;">
                    <h1>Atualizar livro</h1>
                    <label for="atualizar-livro">Livro</label>
                    <input type="text" id="atualizar-livro" name="atualizar-livro" placeholder="Nome do livro">
                    <label for="nova-descricao">Nova Descrição</label>
                    <input type="text" id="nova-descricao" name="nova-descricao" placeholder="Nova descrição do livro">
                    <label for="atualizar-preco">Preço</label>
                    <input type="number" id="atualizar-preco" name="atualizar-preco" placeholder="Novo preço do livro">
                    <label for="atualizar-foto-livro">Imagem</label>
                    <input type="file" id="atualizar-foto-livro" name="atualizar-foto-livro" accept=".jpg, .jpeg, .png">
                    <div class="botoes">
                        <button type="submit" name="atualizar-botao_atualizar" style="width: 100%;">Atualizar Livro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const opcaoEdicao = document.getElementsByName('opcao-edicao');
        const formAdicionar = document.getElementById('livro_adicionar');
        const formRemover = document.getElementById('livro_remover');
        const formAtualizar = document.getElementById('livro_atualizar');
        document.getElementById('adicionar').classList.add('opcao-selecionada');
        formAdicionar.style.display = 'block';  

        for (let i = 0; i < opcaoEdicao.length; i++) {
            opcaoEdicao[i].addEventListener('click', function() {
                if (this.value === 'adicionar') {
                    formAdicionar.style.display = 'block';
                    formRemover.style.display = 'none';
                    formAtualizar.style.display = 'none';
                    document.getElementById('adicionar').classList.add('opcao-selecionada');
                    document.getElementById('remover').classList.remove('opcao-selecionada');
                    document.getElementById('atualizar').classList.remove('opcao-selecionada');
                } else if (this.value === 'remover') {
                    formAdicionar.style.display = 'none';
                    formRemover.style.display = 'block';
                    formAtualizar.style.display = 'none';
                    document.getElementById('adicionar').classList.remove('opcao-selecionada');
                    document.getElementById('remover').classList.add('opcao-selecionada');
                    document.getElementById('atualizar').classList.remove('opcao-selecionada');
                } else if (this.value === 'atualizar') {
                    formAdicionar.style.display = 'none';
                    formRemover.style.display = 'none';
                    formAtualizar.style.display = 'block';
                    document.getElementById('adicionar').classList.remove('opcao-selecionada');
                    document.getElementById('remover').classList.remove('opcao-selecionada');
                    document.getElementById('atualizar').classList.add('opcao-selecionada');
                }
            });
        }
    </script>
    <script src="../js/script.js"></script>
</body>
</html>
