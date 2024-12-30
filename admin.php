<?php
session_start();
include 'conexao.php';

// Verifica se o usuário é administrador
if ($_SESSION['tipo'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Cadastrar novo produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $foto = $_POST['foto'];
    $quantidade = $_POST['quantidade'];

    $stmt = $pdo->prepare("INSERT INTO produtos (nome, valor, foto, quantidade) VALUES (:nome, :valor, :foto, :quantidade)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->execute();

    echo "Produto cadastrado com sucesso!";
}

// Excluir produto
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location: admin.php"); // Redireciona após a exclusão
    exit();
}

// Exibir os produtos cadastrados
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Produtos - Tema Natalino</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9; /* Cor de fundo neutra */
            color: #333;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 20px;
            justify-content: flex-start;
        }

        /* Barra de navegação */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        nav h1 {
            color: #b8336a; /* Título com tom suave de vermelho */
            font-weight: 600;
            text-align: left;
        }

        nav .form-prod {
            display: flex;
            align-items: center;
        }

        nav button {
            padding: 10px 20px;
            background-color: #e60012;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        nav button:hover {
            background-color: #ff8ca9;
        }

        /* Formulário de cadastro */
        .form-prod {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 50%;
            margin: 0 auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, button {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        input[type="text"] {
            background-color: #f9f9f9;
        }

        button {
            background-color: #6a8f56; /* Verde suave para o botão */
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5b7a4d;
        }

        .btn {
            padding: 10px 20px;
            background-color: #9f0028;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #b8336a;
        }

        /* Tabela de produtos */
        table {
            width: 90%;
            margin-top: 30px;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #6a8f56;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            position: relative;
            width: 100%;
            bottom: 0;
        }

        footer a {
            color: #6a8f56;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
        #edit-btn{
            background-color: #4d4d4d;
        }
        #edit-btn:hover{
            background-color: #6b6b6b;
        }
        #delete-btn{
            background-color: #9f0028;
        }
        #delete-btn:hover{
            background-color: #820021;
        }
        #sair-btn{
            background-color: #9f0028;
        }
        #sair-btn:hover{
            background-color: #820021;
        }
    </style>
</head>
<body>

<!-- Barra de navegação com título à esquerda e botão "Sair" à direita -->
<nav>
    <h1>Administração de Produtos</h1>
    <form method="POST" action="logout.php">
        <button id="sair-btn" type="submit">Sair</button>
    </form>
</nav>

<!-- Fa -->
<form class="form-prod" method="POST" action="">
    <h2>Cadastrar Produto</h2>
    <input type="text" name="nome" placeholder="Nome do Produto" required>
    <input type="text" name="valor" placeholder="Valor" required>
    <input type="text" name="foto" placeholder="URL da Imagem" required>
    <input type="text" name="quantidade" placeholder="Quantidade" required>
    <button type="submit" name="cadastrar">Cadastrar Produto</button>
</form><br><br>

<!-- Tabela com todos os produtos cadastrados -->
<h2>Lista de Produtos</h2><br>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Valor</th>
            <th>Foto</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?php echo $produto['id']; ?></td>
                <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                <td>R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></td>
                <td><img src="<?php echo $produto['foto']; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>"></td>
                <td><?php echo $produto['quantidade']; ?></td>
                <td>
                    <a id="edit-btn" href="editar_produto.php?id=<?php echo $produto['id']; ?>" class="btn">Editar</a> |
                    <a id="delete-btn" href="admin.php?delete_id=<?php echo $produto['id']; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br><br>

</body>
</html>
