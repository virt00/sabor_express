<?php
// Iniciar sessão
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', 'vitor', 'sabor_express');

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consultar produtos e organizar por categoria
$sql = "SELECT * FROM produto";
$result = $conn->query($sql);

// Organizar produtos por categoria
$categorias = [
    'paes' => [],
    'carnes' => [],
    'molhos' => [],
    'saladas' => [],
    'adicionais' => []
];

while ($row = $result->fetch_assoc()) {
    $categoria = strtolower($row['categoria']);
    if (array_key_exists($categoria, $categorias)) {
        $categorias[$categoria][] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido = json_decode($_POST['pedido'], true);
    $_SESSION['pedido'] = $pedido;

    header("Location: resumo_pedido.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
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
        .categories {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .categories button {
            background: #FFB444;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            margin: 0 10px;
            transition: background-color 0.3s;
        }
        .categories button:hover {
            background: #77a3d6;
        }
        .products-section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            display: none;
        }
        .products-section.active {
            display: block;
        }
        .products-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .product {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .product img {
            max-width: 150px;
            margin-right: 20px;
        }
        .product-info {
            flex: 1;
        }
        .product h3 {
            margin: 0;
        }
        .product p {
            margin: 5px 0;
        }
        .product .price {
            font-weight: bold;
            color: #FFB444;
        }
        .product form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .product form button {
            background: #FFB444;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .product form button:hover {
            background: #77a3d6;
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
        .order-item button {
            background: #FFB444;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .order-item button:hover {
            background: #77a3d6;
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
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Menu</a></h1>
        </div>
    </header>

    <div class="categories">
        <button onclick="showCategory('paes')">Pães</button>
        <button onclick="showCategory('carnes')">Carnes</button>
        <button onclick="showCategory('molhos')">Molhos</button>
        <button onclick="showCategory('saladas')">Saladas</button>
        <button onclick="showCategory('adicionais')">Adicionais</button>
    </div>

    <?php foreach ($categorias as $categoria => $produtos): ?>
        <section id="<?php echo $categoria; ?>" class="products-section">
            <h2><?php echo ucfirst($categoria); ?></h2>
            <?php foreach ($produtos as $produto): ?>
                <div class="product">
                    <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome_prod']; ?>">
                    <div class="product-info">
                        <h3><?php echo $produto['nome_prod']; ?></h3>
                        <p><?php echo $produto['descricao']; ?></p>
                        <p class="price">R$ <?php echo $produto['preco']; ?></p>
                        <form method="post" action="menu.php" onsubmit="addToOrder(event, '<?php echo $produto['nome_prod']; ?>', '<?php echo $produto['categoria']; ?>', <?php echo $produto['preco']; ?>)">
                            <button type="submit">Adicionar ao Pedido</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>

    <section id="order-summary" class="order-summary">
        <h2>Resumo do Pedido</h2>
        <div id="order-items"></div>
        <p class="order-total">Total: R$ <span id="order-total">0.00</span></p>
        <button class="confirm-btn" onclick="confirmOrder()">Confirmar Pedido</button>
    </section>

    <script>
        var order = [];
        var paoSelecionado = false;

        function showCategory(category) {
            var sections = document.querySelectorAll('.products-section');
            sections.forEach(function(section) {
                section.classList.remove('active');
            });
            document.getElementById(category).classList.add('active');
        }

        function addToOrder(event, nome, categoria, preco) {
            event.preventDefault();

            if (categoria === 'Pães' && paoSelecionado) {
                alert('Você só pode adicionar um tipo de pão.');
                return;
            }

            if (categoria === 'Pães') {
                paoSelecionado = true;
            }

            var itemExistente = order.find(item => item.nome === nome && categoria !== 'Pães');
            if (itemExistente) {
                itemExistente.quantidade += 1;
            } else {
                order.push({ nome: nome, categoria: categoria, preco: preco, quantidade: 1 });
            }

            updateOrderSummary();
        }

        function removeFromOrder(nome) {
            var itemIndex = order.findIndex(item => item.nome === nome);

            if (itemIndex !== -1) {
                var item = order[itemIndex];
                if (item.quantidade > 1) {
                    item.quantidade -= 1;
                } else {
                    if (item.categoria === 'Pães') {
                        paoSelecionado = false;
                    }
                    order.splice(itemIndex, 1);
                }
            }

            updateOrderSummary();
        }

        function updateOrderSummary() {
            var orderItemsDiv = document.getElementById('order-items');
            orderItemsDiv.innerHTML = '';
            var total = 0;

            order.forEach(function(item) {
                var itemTotal = item.preco * item.quantidade;
                total += itemTotal;

                var orderItemDiv = document.createElement('div');
                orderItemDiv.classList.add('order-item');

                var itemInfo = document.createElement('p');
                itemInfo.textContent = `${item.nome} (${item.quantidade}x) - R$ ${item.preco.toFixed(2)}`;
                orderItemDiv.appendChild(itemInfo);

                var removeBtn = document.createElement('button');
                removeBtn.textContent = 'Remover';
                removeBtn.onclick = function() { removeFromOrder(item.nome); };
                orderItemDiv.appendChild(removeBtn);

                orderItemsDiv.appendChild(orderItemDiv);
            });

            document.getElementById('order-total').textContent = total.toFixed(2);
        }

        function confirmOrder() {
            if (order.length === 0) {
                alert('Adicione itens ao seu pedido antes de confirmar.');
                return;
            }

            var pedido = JSON.stringify(order);
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'menu.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'pedido';
            input.value = pedido;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>