<?php
session_start();
include('conexao.php');

// Verifica se os dados foram enviados via POST
if (isset($_POST['email'], $_POST['senha'])) {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validação básica dos dados
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.');window.location.href='../tela1/login.html';</script>";
        exit;
    }

    // Prepara a consulta para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o usuário foi encontrado
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senhaHash);
        $stmt->fetch();

        // Verifica se a senha está correta usando password_verify
        if (password_verify($senha, $senhaHash)) {
            // Autenticação bem sucedida: inicia sessão e armazena id do usuário
            $_SESSION['usuario_id'] = $id;
            echo "<script>alert('Login realizado com sucesso!');window.location.href='../tela1/index.html';</script>";
            exit;
        } else {
            echo "<script>alert('Senha incorreta.');window.location.href='../tela1/login.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('E-mail não encontrado.');window.location.href='../tela1/login.html';</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Por favor, preencha todos os campos.');window.location.href='../tela1/login.html';</script>";
    exit;
}
?>

