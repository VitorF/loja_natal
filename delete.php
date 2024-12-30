<?php
session_start();
include 'conexao.php';

// exibe todos os erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

// verifica se o parâmetro delete_id está presente na URL
if (isset($_GET['delete_id'])) {
    $produto_id = (int)$_GET['delete_id'];

    // exclui o produto do carrinho do usuário
    $stmt = $pdo->prepare("DELETE FROM carrinho WHERE usuario_id = :usuario_id AND produto_id = :produto_id");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':produto_id', $produto_id);
    $stmt->execute();

    // redireciona de volta para o carrinho após a exclusão
    header("Location: carrinho.php");
    exit();
} else {
    echo "Nenhum produto foi selecionado para exclusão.";
}
?>
