<?php
session_start();
include_once('config.php');

// Verifica se o usuário não está logado
if (!isset($_SESSION['nome'])) {
    header('Location: login.php');
    exit();
}

// Verifica se o produto_id foi enviado via POST
if (!isset($_POST['produto_id'])) {
    // Redireciona de volta para o carrinho ou para outra página de erro
    header('Location: pages/carrinho.php');
    exit();
}

// Obtém o ID do produto a ser removido
$produto_id = $_POST['produto_id'];
$usuario_id = $_SESSION['usuario_id'];

// Verifica se o produto está no carrinho do usuário
$sql = "SELECT quantidade FROM carrinho WHERE usuario_id = ? AND produto_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('ii', $usuario_id, $produto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Obtém a quantidade atual do produto no carrinho
    $row = $result->fetch_assoc();
    $quantidade_atual = $row['quantidade'];

    // Verifica se há mais de uma unidade para poder remover
    if ($quantidade_atual > 1) {
        // Remove apenas uma unidade do produto do carrinho
        $nova_quantidade = $quantidade_atual - 1;
        $sql_update = "UPDATE carrinho SET quantidade = ? WHERE usuario_id = ? AND produto_id = ?";
        $stmt_update = $conexao->prepare($sql_update);
        $stmt_update->bind_param('iii', $nova_quantidade, $usuario_id, $produto_id);
        $stmt_update->execute();
    } else {
        // Se houver apenas uma unidade, remove o produto inteiro do carrinho
        $sql_delete = "DELETE FROM carrinho WHERE usuario_id = ? AND produto_id = ?";
        $stmt_delete = $conexao->prepare($sql_delete);
        $stmt_delete->bind_param('ii', $usuario_id, $produto_id);
        $stmt_delete->execute();
    }

    // Redireciona de volta para o carrinho após a atualização/remoção
    header('Location: pages/carrinho.php');
    exit();
} else {
    // Produto não encontrado no carrinho
    header('Location: pages/carrinho.php');
    exit();
}
?>
