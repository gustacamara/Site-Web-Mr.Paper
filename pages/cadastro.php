<?php

    if(isset($_POST['submit']))
    {

        include_once('../config.php');

        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        $data_nasc = $_POST['data_nascimento'];

        $result = mysqli_query($conexao,"INSERT INTO usuarios(nome,sobrenome,senha,email,data_nasc) 
        VALUES ('$nome','$sobrenome','$senha','$email','$data_nasc')");

        header('Location: login.php');
    }

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
    <form action="cadastro.php" method="POST">
        <h1>Cadastro</h1>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" placeholder="Nome">

        <label for="sobrenome">Sobrenome</label>
        <input type="text" id="sobrenome" name="sobrenome" placeholder="sobrenome">

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="E-mail">

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Senha">

        <label for="data_nascimento">Data de nascimento</label>
        <input type="date" id="data_nascimento" name="data_nascimento" placeholder="Data de nascimento">

        <div class="botoes">
            <button type="submit" id="submit" name="submit">Cadastrar</button>
            <a href="login.php"><button type="button" id="botao_login" name="botao_login">Login</button></a>
            <button type="button" id="botao_atualizar" name="botao_atualizar" onclick="atualizar_usuario()">Atualizar</button>
        </div>
        <div class="apagar_usuario">
            <button type="button" class="apagar_usuario" id="apagar_usuario" name="apagar_usuario" >Apagar Conta</button>
        </div>
    </form>
</body>
</html>