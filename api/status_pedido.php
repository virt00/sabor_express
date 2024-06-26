<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter os pedidos do usuário logado
$sql = "SELECT * FROM pedidos WHERE cliente_id = '{$_SESSION['usuario_id']}' ORDER BY data_hora DESC";
$result = $conn->query($sql);

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status do Pedido</title>
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
        .status-section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            text-align: center;
        }
        .status-section h2 {
            margin-bottom: 20px;
        }
        .status-section p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .status-section .status {
            font-size: 24px;
            font-weight: bold;
            color: #FFB444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .order-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .order-actions button {
            background: #FFB444;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .order-actions button:hover {
            background: #77a3d6;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Status do Pedido</a></h1>
        </div>
    </header>

    <section class="status-section container">
        <h2>Seus Pedidos</h2>
        <?php if (count($pedidos) > 0): ?>
            <table>
                <tr>
                    <th>Número do Pedido</th>
                    <th>Nome do Cliente</th>
                    <th>Endereço</th>
                    <th>Valor Total</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['nome_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($pedido['end_pedido']); ?></td>
                        <td>R$ <?php echo number_format($pedido['valor_ped'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($pedido['status_pedido']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Nenhum pedido encontrado.</p>
        <?php endif; ?>
    </section>
</body>
</html>