<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pedido = $_POST['id_pedido'];
    $status_pedido = $_POST['status_pedido'];

    $sql = "UPDATE pedidos SET status_pedido = '$status_pedido' WHERE id = '$id_pedido'";

    if ($conn->query($sql) === TRUE) {
        echo "Status do pedido atualizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

header("Location: ver_pedidos.php");
exit();
?>