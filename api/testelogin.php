<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o email e a senha são de funcionário
    if ($email == 'saborexpress@gmail.com' && $senha == 'saborexpress') {
        $_SESSION['usuario_id'] = 'funcionario';
        $_SESSION['nome'] = 'Funcionario';
        header("Location: home_funcionario.php");
        exit();
    }

    // Verificar as credenciais no banco de dados
    $sql = "SELECT id_usuario, nome FROM info_usuario WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $user['id_usuario'];
        $_SESSION['nome'] = $user['nome'];
        header("Location: home_cliente.php");
        exit();
    } else {
        echo "Login ou senha incorretos.";
    }
}

$conn->close();
?>
