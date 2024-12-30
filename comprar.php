<?php
session_start();
include 'conexao.php';

// Exibir erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se produto_id e quantidade foram enviados
    if (isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
        $produto_id = (int)$_POST['produto_id'];
        $quantidade = (int)$_POST['quantidade'];
        $usuario_id = $_SESSION['user_id'];

        // Verificar se o produto já está no carrinho
        $stmt = $pdo->prepare("SELECT * FROM carrinho WHERE usuario_id = :usuario_id AND produto_id = :produto_id");
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':produto_id', $produto_id);
        $stmt->execute();
        $produto_carrinho = $stmt->fetch();

        if ($produto_carrinho) {
            // Atualiza a quantidade no carrinho
            $nova_quantidade = $produto_carrinho['quantidade'] + $quantidade;
            $stmt = $pdo->prepare("UPDATE carrinho SET quantidade = :quantidade WHERE usuario_id = :usuario_id AND produto_id = :produto_id");
            $stmt->bindParam(':quantidade', $nova_quantidade);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':produto_id', $produto_id);
            $stmt->execute();
            echo "Quantidade atualizada para $nova_quantidade no carrinho.";
        } else {
            // Adiciona o produto ao carrinho
            $stmt = $pdo->prepare("INSERT INTO carrinho (usuario_id, produto_id, quantidade) VALUES (:usuario_id, :produto_id, :quantidade)");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':produto_id', $produto_id);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->execute();
            echo "Produto adicionado ao carrinho com quantidade $quantidade.";
        }

        // Redirecionar para o carrinho
        header("Location: carrinho.php");
        exit();
    } else {
        echo "Erro: Produto ou quantidade não foram enviados!";
    }
} else {
    echo "Erro: Método incorreto!";
}
?>
