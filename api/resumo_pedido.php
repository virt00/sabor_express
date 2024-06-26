<?php
session_start();
$pedido = isset($_SESSION['pedido']) ? $_SESSION['pedido'] : [];

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter informações do usuário logado
$usuario_id = $_SESSION['usuario_id']; // Certifique-se de que o ID do usuário está armazenado na sessão
$sql = "SELECT nome FROM info_usuario WHERE id_usuario = '$usuario_id'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['end_pedido'])) {
    $nome_cliente = $usuario['nome'];
    $pedido_json = json_encode($pedido);
    $valor_ped = $_POST['valor_ped'];
    $metodo_pag = $_POST['metodo_pag'];
    $end_pedido = $_POST['end_pedido'];
    $status_pedido = "Pedido em Processo";

    $sql = "INSERT INTO pedidos (cliente_id, nome_cliente, ingredientes_ped, valor_ped, metodo_pag, end_pedido, status_pedido) VALUES ('$usuario_id', '$nome_cliente', '$pedido_json', '$valor_ped', '$metodo_pag', '$end_pedido', '$status_pedido')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: status_pedido.php");
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo do Pedido</title>
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
        .order-summary {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
        }
        .order-summary h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .order-item p {
            margin: 0;
        }
        .order-total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
        }
        .confirm-btn {
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
            text-align: center;
            margin-top: 20px;
        }
        .confirm-btn:hover {
            background: #77a3d6;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 5px 4px 10px black;
        }
        .modal-content h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .modal-content form {
            display: flex;
            flex-direction: column;
        }
        .modal-content form label {
            margin: 10px 0 5px;
        }
        .modal-content form input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .modal-content form button {
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
        }
        .modal-content form button:hover {
            background: #77a3d6;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Resumo do Pedido</a></h1>
        </div>
    </header>

    <section class="order-summary container">
        <h2>Resumo do Pedido</h2>
        <p>Nome do Cliente: <?php echo $usuario['nome']; ?></p>
        <div id="order-items">
            <?php foreach ($pedido as $item): ?>
                <div class="order-item">
                    <p><?php echo $item['nome']; ?> (<?php echo $item['quantidade']; ?>x) - R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="order-total">Total: R$ <?php echo number_format(array_reduce($pedido, function($carry, $item) {
            return $carry + ($item['preco'] * $item['quantidade']);
        }, 0), 2, ',', '.'); ?></p>
        <form id="confirmForm">
            <label for="metodo_pag">Método de Pagamento:</label>
            <select id="metodo_pag" name="metodo_pag" required>
                <option value="pix">Pix</option>
                <option value="cartao">Cartão</option>
                <option value="dinheiro">Dinheiro</option>
            </select>
            <input type="hidden" name="valor_ped" value="<?php echo array_reduce($pedido, function($carry, $item) { return $carry + ($item['preco'] * $item['quantidade']); }, 0); ?>">
            <button type="button" class="confirm-btn" onclick="showEnderecoModal()">Confirmar Pedido</button>
        </form>
    </section>

    <div id="enderecoModal" class="modal">
        <div class="modal-content">
            <h2>Informe seu Endereço</h2>
            <form id="enderecoForm" method="post" action="resumo_pedido.php">
                <label for="end_pedido">Endereço:</label>
                <input type="text" id="end_pedido" name="end_pedido" required>
                <input type="hidden" name="valor_ped" value="<?php echo array_reduce($pedido, function($carry, $item) { return $carry + ($item['preco'] * $item['quantidade']); }, 0); ?>">
                <input type="hidden" name="metodo_pag" id="hidden_metodo_pag">
                <button type="submit">Enviar Pedido</button>
            </form>
        </div>
    </div>

    <script>
        function showEnderecoModal() {
            document.getElementById('enderecoModal').style.display = 'block';
            document.getElementById('hidden_metodo_pag').value = document.getElementById('metodo_pag').value;
        }

        window.onclick = function(event) {
            var enderecoModal = document.getElementById('enderecoModal');
            if (event.target == enderecoModal) {
                enderecoModal.style.display = 'none';
            }
        }
    </script>
</body>
</html>