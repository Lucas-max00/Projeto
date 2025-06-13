<?php
// backend/recuperar_senha.php
include('conexao.php');

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "<script>alert('E-mail não encontrado.'); window.location.href='../tela1/recuperar_senha.html';</script>";
        exit;
    }

    $stmt->bind_result($usuario_id);
    $stmt->fetch();
    $stmt->close();

    $token = bin2hex(random_bytes(16));
    $expiracao = date("Y-m-d H:i:s", strtotime('+1 hour'));
    $usado = 0;

    $stmt = $conn->prepare("INSERT INTO reset_senha_tokens (usuario_id, token, expiracao, usado) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro na preparação da inserção: " . $conn->error);
    }
    $stmt->bind_param("issi", $usuario_id, $token, $expiracao, $usado);
    if (!$stmt->execute()) {
        die("Erro ao inserir token: " . $stmt->error);
    }
    $stmt->close();

    $reset_link = "http://localhost/TCC-lucas/tela1/redefinir_senha.html?token=" . $token;

    echo "<script>alert('Link para redefinir senha gerado. Você será redirecionado.'); window.location.href='$reset_link';</script>";
    exit;
} else {
    echo "<script>alert('Por favor, informe o e-mail.'); window.location.href='../tela1/recuperar_senha.html';</script>";
    exit;
}
?>
<?php
// backend/recuperar_senha.php
include('conexao.php');

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "<script>alert('E-mail não encontrado.'); window.location.href='../tela1/recuperar_senha.html';</script>";
        exit;
    }

    $stmt->bind_result($usuario_id);
    $stmt->fetch();
    $stmt->close();

    $token = bin2hex(random_bytes(16));
    $expiracao = date("Y-m-d H:i:s", strtotime('+1 hour'));
    $usado = 0;

    $stmt = $conn->prepare("INSERT INTO reset_senha_tokens (usuario_id, token, expiracao, usado) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Erro na preparação da inserção: " . $conn->error);
    }
    $stmt->bind_param("issi", $usuario_id, $token, $expiracao, $usado);
    if (!$stmt->execute()) {
        die("Erro ao inserir token: " . $stmt->error);
    }
    $stmt->close();

    $reset_link = "http://localhost/TCC-lucas/tela1/redefinir_senha.html?token=" . $token;

    echo "<script>alert('Link para redefinir senha gerado. Você será redirecionado.'); window.location.href='$reset_link';</script>";
    exit;
} else {
    echo "<script>alert('Por favor, informe o e-mail.'); window.location.href='../tela1/recuperar_senha.html';</script>";
    exit;
}
?>
