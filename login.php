<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Dados incorretos!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Pombalesa</title>
    <style>
        body { background: #050505; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: #1a1a1a; padding: 40px; border-radius: 8px; border: 1px solid #333; text-align: center; }
        input { display: block; width: 100%; padding: 10px; margin: 10px 0; background: #333; border: 1px solid #555; color: white; }
        button { width: 100%; padding: 10px; background: #ff0055; border: none; color: white; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color:#ff0055">Login Pombalesa</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Seu Email" required>
            <input type="password" name="senha" placeholder="Sua Senha" required>
            <button type="submit">ENTRAR</button>
        </form>
        <br>
        <a href="cadastro.php" style="color:#aaa">Criar conta</a>
    </div>
</body>
</html>