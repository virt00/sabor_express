<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_prod = $_POST['nome_prod'];
    $categoria = $_POST['categoria'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];

    $sql = "INSERT INTO produto (nome_prod, categoria, preco, descricao, imagem) VALUES ('$nome_prod', '$categoria', '$preco', '$descricao', '$imagem')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo produto cadastrado com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
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
        .form-section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
        }
        .form-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            background: #FFB444;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background: #77a3d6;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Cadastro de Produtos</a></h1>
        </div>
    </header>

    <section class="form-section container">
        <h2>Adicionar Novo Produto</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="nome_prod">Nome do Produto</label>
                <input type="text" id="nome" name="nome_prod" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <input type="text" id="categoria" name="categoria" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" step="0.01" id="preco" name="preco" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagem">URL da Imagem</label>
                <input type="text" id="imagem" name="imagem">
            </div>
            <button type="submit" class="submit-btn">Cadastrar Produto</button>
        </form>
    </section>
</body>
</html>
