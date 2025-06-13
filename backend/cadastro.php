<?php
include('conexao.php');

if (isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.');window.location.href='../tela1/cadastro.html';</script>";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, insira um e-mail válido.');window.location.href='../tela1/cadastro.html';</script>";
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    if (!$stmt_check) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('Este e-mail já está cadastrado!');window.location.href='../tela1/cadastro.html';</script>";
        $stmt_check->close();
        $conn->close();
        exit;
    }
    $stmt_check->close();

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }
    $stmt->bind_param("sss", $nome, $email, $senhaHash);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!');window.location.href='../tela1/login.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . htmlspecialchars($stmt->error) . "');window.location.href='../tela1/cadastro.html';</script>";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "<script>alert('Por favor, preencha todos os campos.');window.location.href='../tela1/cadastro.html';</script>";
}
?>
