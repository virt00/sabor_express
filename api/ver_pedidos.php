<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Busca os pedidos no banco de dados
$sql = "SELECT pedidos.id_pedidos, info_usuario.nome, pedidos.ingredientes_ped, pedidos.end_pedido, pedidos.valor_ped, pedidos.metodo_pag, pedidos.status_pedido
        FROM pedidos
        JOIN info_usuario ON pedidos.cliente_id = info_usuario.id_usuario";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pedidos - SaborExpress</title>
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
        .order-section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            text-align: left;
        }
        .order-section h2 {
            text-align: center;
            margin-bottom: 20px;
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
            <h1><a href="home_administracao.php">Administração SaborExpress</a></h1>
        </div>
    </header>
    <main class="container">
        <section class="order-section">
            <h2>Pedidos</h2>
            <?php
            if ($result && $result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID do Pedido</th>
                            <th>Nome do Cliente</th>
                            <th>Ingredientes</th>
                            <th>Endereço</th>
                            <th>Valor</th>
                            <th>Método de Pagamento</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>";
                while($row = $result->fetch_assoc()) {
                    $ingredientes = json_decode($row["ingredientes_ped"], true);
                    $ingredientes_formatados = "";
                    foreach ($ingredientes as $ingrediente) {
                        $ingredientes_formatados .= $ingrediente["nome"] . " (" . $ingrediente["quantidade"] . "x), ";
                    }
                    $ingredientes_formatados = rtrim($ingredientes_formatados, ", ");
                    
                    echo "<tr>
                            <td>" . $row["id_pedidos"] . "</td>
                            <td>" . $row["nome"] . "</td>
                            <td>" . $ingredientes_formatados . "</td>
                            <td>" . $row["end_pedido"] . "</td>
                            <td>R$ " . number_format($row["valor_ped"], 2, ',', '.') . "</td>
                            <td>" . $row["metodo_pag"] . "</td>
                            <td>" . $row["status_pedido"] . "</td>
                            <td>
                                <form method='post' action='atualizar_status.php'>
                                    <input type='hidden' name='id_pedido' value='" . $row["id_pedidos"] . "'>
                                    <select name='status_pedido'>
                                        <option value='Em Produção'>Em Produção</option>
                                        <option value='Em Rota de Entrega'>Em Rota de Entrega</option>
                                    </select>
                                    <button type='submit'>Atualizar</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "Nenhum pedido encontrado.";
            }
            $conn->close();
            ?>
        </section>
    </main>
    <footer>
        <p>© 2024 SaborExpress. Todos os direitos reservados.</p>
    </footer>
</body>
</html>