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

$usuario_id = $_SESSION['user_id'];

// Consulta para buscar os itens do carrinho, incluindo o produto_id
$stmt = $pdo->prepare("
    SELECT produtos.nome, produtos.valor, produtos.id AS produto_id, carrinho.quantidade, (produtos.valor * carrinho.quantidade) AS total
    FROM carrinho
    JOIN produtos ON carrinho.produto_id = produtos.id
    WHERE carrinho.usuario_id = :usuario_id
");
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$itens_carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcula o valor total do carrinho
$total_carrinho = 0;
foreach ($itens_carrinho as $item) {
    $total_carrinho += $item['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho - Loja de Natal</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0c3b2e;
            color: #ffffff;
            margin: 0;
            padding: 0;
            background-image: url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/snowflakes-background.png');
            background-repeat: repeat;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #1a5c4a;
            padding: 20px;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        h1 {
            margin: 0;
            font-size: 2.5em;
            color: #ff0000;
            text-shadow: 2px 2px 4px #000000;
        }
        .btn {
            background-color: #ff0000;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn:hover {
            background-color: #cc0000;
            transform: scale(1.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        th {
            background-color: #1a5c4a;
            color: #ffffff;
            font-weight: bold;
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .total {
            font-size: 1.2em;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            color: #ff0000;
        }
        .empty-cart {
            text-align: center;
            font-size: 1.2em;
            margin-top: 50px;
        }
        footer {
            background-color: #1a5c4a;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Meu Carrinho de Natal 🎅🛒</h1>
        <div>
            <form action="index.php" method="GET" style="display: inline;">
                <button type="submit" class="btn">🏠 Voltar à Loja</button>
            </form>
            <form action="logout.php" method="POST" style="display: inline;">
                <button type="submit" class="btn">🚪 Sair</button>
            </form>
        </div>
    </header>

    <div class="container">
        <?php if (count($itens_carrinho) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens_carrinho as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($item['valor'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($item['total'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="delete.php?delete_id=<?php echo $item['produto_id']; ?>" 
                               onclick="return confirm('Tem certeza que deseja remover este produto?');"
                               class="btn" style="background-color: #cc0000;">
                                🗑️ Remover
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total">
                Total do Carrinho: R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <p>Seu carrinho está vazio. 🎄</p>
                <p>Que tal adicionar alguns presentes de Natal? 🎁</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2023 Loja de Natal. Todos os direitos reservados. 🎄</p>
    </footer>
</body>
</html>