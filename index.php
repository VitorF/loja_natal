<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['tipo'] == 'admin') {
    header("Location: admin.php");
    exit();
}

// Exibir os produtos na página principal para usuários
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Natal</title>
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
        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome h2 {
            font-size: 2em;
            color: #ff0000;
            margin-bottom: 10px;
        }
        .welcome p {
            font-size: 1.2em;
            color: #ffffff;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .product {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            width: calc(33.333% - 20px);
            text-align: center;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
        }
        .product:hover {
            transform: translateY(-5px);
        }
        .product::before {
            content: '🎄';
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
        }
        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .product h3 {
            color: #0c3b2e;
            font-size: 1.4em;
            margin-bottom: 10px;
        }
        .product p {
            color: #1a5c4a;
            margin-bottom: 10px;
        }
        .product .price {
            font-size: 1.2em;
            color: #ff0000;
            font-weight: bold;
        }
        .quantity-input {
            width: 60px;
            padding: 5px;
            margin-right: 5px;
            border: 1px solid #1a5c4a;
            border-radius: 3px;
        }
        footer {
            background-color: #1a5c4a;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
        }
        @media (max-width: 768px) {
            .product {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .product {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Loja de Natal</h1>
        <div>
            <form action="carrinho.php" method="GET" style="display: inline;">
                <button type="submit" class="btn">🛒 Ver Carrinho</button>
            </form>
            <form action="logout.php" method="POST" style="display: inline;">
                <button type="submit" class="btn">🚪 Sair</button>
            </form>
        </div>
    </header>

    <div class="container">
        <div class="welcome">
            <h2>Bem-vindo à Nossa Loja de Natal, <?php echo ucfirst($_SESSION['nome']); ?>! 🎅</h2>
            <p>Encontre os melhores presentes para esta temporada festiva! ❄️🎁</p>
        </div>

        <div class="products">
            <?php foreach ($produtos as $produto): ?>
                <div class="product">
                    <img src="<?php echo $produto['foto']; ?>" alt="<?php echo $produto['nome']; ?>">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                    <p class="price">R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></p>
                    <p>Quantidade disponível: <?php echo (int)$produto['quantidade']; ?></p>

                    <form action="comprar.php" method="POST">
                        <input type="hidden" name="produto_id" value="<?php echo (int)$produto['id']; ?>">
                        <input type="number" name="quantidade" class="quantity-input" min="1" max="<?php echo (int)$produto['quantidade']; ?>" value="1" required>
                        <button type="submit" class="btn">🎁 Comprar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Loja de Natal. Todos os direitos reservados. 🎄</p>
    </footer>
</body>
</html>