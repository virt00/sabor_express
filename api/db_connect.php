<?php
$servername = "localhost";
$username = "root";
$password = "vitor";
$dbname = "sabor_express";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>