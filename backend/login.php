<?php
session_start();
include('conexao.php');

if (isset($_POST['email'], $_POST['senha'])) {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.');window.location.href='../tela1/login.html';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senhaHash);
        $stmt->fetch();

        if (password_verify($senha, $senhaHash)) {
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
<?php
session_start();
include('conexao.php');

if (isset($_POST['email'], $_POST['senha'])) {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.');window.location.href='../tela1/login.html';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $senhaHash);
        $stmt->fetch();

        if (password_verify($senha, $senhaHash)) {
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
