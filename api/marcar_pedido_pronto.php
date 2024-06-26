<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "UPDATE pedidos SET status_pedido = 'Pedido em Rota' WHERE cliente_id = '{$_SESSION['usuario_id']}' ORDER BY data_hora DESC LIMIT 1";
$conn->query($sql);

$conn->close();

header("Location: status_pedido.php");
exit();
?>