<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] !== 'funcionario') {
    header("Location: login.php");
    exit();
}

$nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - SaborExpress</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77a3d6 3px solid;
            text-align: center;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 24px;
        }
        .section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            text-align: center;
        }
        .section h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .section a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background: #FFB444;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            transition: background-color 0.3s;
        }
        .section a:hover {
            background: #77a3d6;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #333;
            color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Administração SaborExpress</a></h1>
        </div>
    </header>
    <main class="container">
        <section class="section">
            <h2>Bem-vindo à Administração</h2>
            <a href="cadastrar_produto.php">Cadastrar Produto</a>
            <a href="ver_pedidos.php">Ver Pedidos</a>
        </section>
    </main>
    <footer>
        <p>© 2024 SaborExpress. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
