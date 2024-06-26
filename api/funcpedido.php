<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, nome_cliente, data_hora FROM pedidos GROUP BY id, nome_cliente ORDER BY data_hora DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos dos Funcionários</title>
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
        .orders-section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
        }
        .orders-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-summary {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .order-summary h3 {
            margin: 0;
        }
        .order-summary p {
            margin: 5px 0;
        }
        .order-summary .details-btn {
            display: block;
            width: 100%;
            background: #FFB444;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            margin-top: 10px;
        }
        .order-summary .details-btn:hover {
            background: #77a3d6;
        }
        .order-details {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 5px 4px 10px black;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Pedidos dos Funcionários</a></h1>
        </div>
    </header>

    <section class="orders-section container">
        <h2>Pedidos Recentes</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="order-summary">
                    <h3>Pedido #<?php echo $row['id']; ?></h3>
                    <p><strong>Nome do Cliente:</strong> <?php echo $row['nome_cliente']; ?></p>
                    <p><strong>Data e Hora:</strong> <?php echo $row['data_hora']; ?></p>
                    <button class="details-btn" onclick="toggleDetails('details-<?php echo $row['id']; ?>')">Ver Detalhes</button>
                    <div id="details-<?php echo $row['id']; ?>" class="order-details">
                        <?php
                        $pedido_id = $row['id'];
                        $sql_detalhes = "SELECT * FROM pedidos WHERE id = '$pedido_id'";
                        $result_detalhes = $conn->query($sql_detalhes);
                        while ($detalhe = $result_detalhes->fetch_assoc()): ?>
                            <p><strong>Produto:</strong> <?php echo $detalhe['nome']; ?></p>
                            <p><strong>Categoria:</strong> <?php echo $detalhe['categoria']; ?></p>
                            <p><strong>Descrição:</strong> <?php echo $detalhe['descricao']; ?></p>
                            <p><strong>Preço:</strong> R$ <?php echo number_format($detalhe['preco'], 2, ',', '.'); ?></p>
                            <p><strong>Meio de Pagamento:</strong> <?php echo $detalhe['pagamento']; ?></p>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum pedido encontrado.</p>
        <?php endif; ?>
    </section>

    <script>
        function toggleDetails(id) {
            var details = document.getElementById(id);
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
