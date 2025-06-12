<?php
include('conexao.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Verifica se o email já está cadastrado usando prepared statement
$stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Email já cadastrado
    echo "<script>alert('Este e-mail já está cadastrado!');window.location.href='../tela1/cadastro.html';</script>";
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// Insere novo usuário com prepared statement
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha);

if ($stmt->execute()) {
    echo "<script>alert('Cadastro realizado com sucesso!');window.location.href='../tela1/login.html';</script>";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
