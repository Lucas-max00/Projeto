<?php
session_start();
include('conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

// Proteção básica contra SQL Injection
$email = mysqli_real_escape_string($conn, $email);

$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['id'] = $user['id'];
    $_SESSION['nome'] = $user['nome'];
    header("Location: ../tela1/index.html");
    exit();
} else {
    echo "<script>alert('Email ou senha incorretos!');window.location.href='../tela1/login.html';</script>";
}

mysqli_close($conn);
?>
