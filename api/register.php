<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO info_usuario (nome, cpf, email, senha, telefone) VALUES ('$nome', '$cpf', '$email', '$senha', '$telefone')";

    if ($conn->query($sql) === TRUE) {
        echo "Cadastro realizado com sucesso!";
        header("Location: index.html");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>