<?php
// backend/redefinir_senha.php
include('conexao.php');

if(isset($_POST['token'], $_POST['nova_senha'], $_POST['confirma_senha'])) {
    $token = $_POST['token'];
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if($nova_senha !== $confirma_senha) {
        echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT usuario_id, expiracao, usado FROM reset_senha_tokens WHERE token = ?");
    if(!$stmt) {
        die("Erro na preparação da consulta: ".$conn->error);
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 0) {
        echo "<script>alert('Token inválido!'); window.location.href='../tela1/login.html';</script>";
        exit;
    }

    $stmt->bind_result($usuario_id, $expiracao, $usado);
    $stmt->fetch();

    if($usado) {
        echo "<script>alert('Este link já foi utilizado.'); window.location.href='../tela1/login.html';</script>";
        exit;
    }

    $data_atual = date("Y-m-d H:i:s");
    if($data_atual > $expiracao) {
        echo "<script>alert('Este link expirou.'); window.location.href='../tela1/login.html';</script>";
        exit;
    }
    $stmt->close();

    $senhaHash = password_hash($nova_senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    if(!$stmt) {
        die("Erro na preparação da atualização: ".$conn->error);
    }
    $stmt->bind_param("si", $senhaHash, $usuario_id);

    if($stmt->execute()) {
        $stmt->close();

        $stmt = $conn->prepare("UPDATE reset_senha_tokens SET usado = 1 WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Senha redefinida com sucesso!'); window.location.href='../tela1/login.html';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar a senha. Tente novamente.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Dados inválidos.'); window.location.href='../tela1/login.html';</script>";
    exit;
}
?>
