<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - SaborExpress</title>
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
        .register-section {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 5px 4px 10px black;
            border-radius: 5px;
            text-align: center;
        }
        .register-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .register-section input[type="text"], .register-section input[type="email"], .register-section input[type="password"], .register-section input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .register-section input[type="submit"] {
            background: #FFB444;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 5px 4px 10px black;
            transition: background-color 0.3s;
        }
        .register-section input[type="submit"]:hover {
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
    <script>
        function validarCPF(cpf) {
            return /^\d{11}$/.test(cpf);
        }

        function validarTelefone(telefone) {
            return /^\d{10,11}$/.test(telefone);
        }

        function validarFormulario() {
            const cpf = document.getElementById('cpf').value;
            const telefone = document.getElementById('telefone').value;

            if (!validarCPF(cpf)) {
                alert('CPF deve conter 11 dígitos numéricos.');
                return false;
            }

            if (!validarTelefone(telefone)) {
                alert('Telefone deve conter 10 ou 11 dígitos numéricos.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="#">Cadastro</a></h1>
        </div>
    </header>
    <main class="container">
        <section class="register-section">
            <h2>Cadastre-se</h2>
            <form action="register.php" method="post" onsubmit="return validarFormulario()">
                <input type="text" placeholder="Nome" name="nome" required>
                <input type="text" placeholder="CPF" id="cpf" name="cpf" required maxlength="11">
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Senha" name="senha" required>
                <input type="text" placeholder="Telefone" id="telefone" name="telefone" required>
                <input type="submit" name="submit" value="Cadastrar">
            </form>
        </section>
    </main>
    <footer>
        <p>© 2024 SaborExpress. Todos os direitos reservados.</p>
    </footer>
</body>
</html>