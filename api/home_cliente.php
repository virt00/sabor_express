<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}

$usuario_nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
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
            padding: 10px 0;
            text-align: center;
            position: relative;
        }
        header h1 {
            margin: 0;
        }
        nav {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #FFB444;
            box-shadow: 5px 4px 10px black;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }
        .profile-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
        .main-content {
            padding: 20px;
            text-align: center;
        }
        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
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
        }
        .button:hover {
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
        .modal-content form input[type="text"], .modal-content form input[type="email"] {
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
        <img src="profile-icon.png" alt="Profile Icon" class="profile-icon" onclick="openProfileModal()">
        <h1>Página Inicial</h1>
    </header>
    <nav>
        <a href="menu.php">Menu</a>
        <a href="status_pedido.php">Status dos Pedidos</a>
    </nav>
    <div class="main-content">
        <p>Bem-vindo, <?php echo htmlspecialchars($usuario_nome); ?>!</p>
        <button class="button" onclick="window.location.href='menu.php'">Fazer Pedido</button>
        <button class="button" onclick="window.location.href='status_pedido.php'">Ver Status dos Pedidos</button>
    </div>

    <div id="profileModal" class="modal">
        <div class="modal-content">
            <h2>Seu Perfil</h2>
            <form method="post" action="atualizar_perfil.php">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario_nome); ?>" readonly>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($_SESSION['cpf']); ?>" readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <button type="submit">Atualizar Perfil</button>
            </form>
        </div>
    </div>

    <script>
        function openProfileModal() {
            document.getElementById('profileModal').style.display = 'block';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('profileModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>