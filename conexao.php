<?php
$host = 'localhost';     // Host do MySQL
$port = '3306';          // Porta do MySQL
$dbname = 'loja_virtual'; // Nome do banco de dados
$user = 'root';          // Usuário do MySQL
$pass = '';              // Senha do MySQL

try {
    // Conexão com o banco de dados usando as variáveis
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>
