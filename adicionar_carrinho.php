<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: pages/login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
    $produto_id = $_POST['produto_id'];
    $usuario_id = $_SESSION['usuario_id']; // Certifique-se de que o ID do usuário está corretamente definido na sessão

    // Verifica se o produto já está no carrinho do usuário
    $sql_check = "SELECT * FROM carrinho WHERE usuario_id = ? AND produto_id = ?";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->bind_param('ii', $usuario_id, $produto_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Se o produto já está no carrinho, atualiza a quantidade
        $sql_update = "UPDATE carrinho SET quantidade = quantidade + 1 WHERE usuario_id = ? AND produto_id = ?";
        $stmt_update = $conexao->prepare($sql_update);
        $stmt_update->bind_param('ii', $usuario_id, $produto_id);
        $stmt_update->execute();
    } else {
        // Se o produto não está no carrinho, insere um novo registro
        $sql_insert = "INSERT INTO carrinho (usuario_id, produto_id, quantidade) VALUES (?, ?, 1)";
        $stmt_insert = $conexao->prepare($sql_insert);
        $stmt_insert->bind_param('ii', $usuario_id, $produto_id);
        $stmt_insert->execute();
    }

    header('Location: pages/carrinho.php');
    exit();
} else {
    header('Location: index.php'); // Redireciona para a página inicial se não houver POST ou produto_id não definido
    exit();
}
?>
