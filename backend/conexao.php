<?php
// Dados da conexão com o banco
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "curriculo_perfeito";

// Criar conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

// Checar conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
