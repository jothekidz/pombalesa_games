<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO produtos (nome, descricao, plataforma, preco, imagem) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['nome'], $_POST['desc'], $_POST['plat'], $_POST['preco'], $_POST['img']]);
    echo "<script>alert('Jogo cadastrado!'); window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pombalesa</title>
    <style>
        body { background: #111; color: white; font-family: sans-serif; display:flex; justify-content:center; align-items:center; height:100vh;}
        form { background: #222; padding: 40px; border-radius: 10px; border: 1px solid #ff0055; width: 300px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; background: #333; border:none; color:white; }
        button { width: 100%; padding: 10px; background: #ff0055; color: white; border: none; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <form method="POST">
        <h2 style="color:#ff0055; text-align:center;">Adicionar Jogo</h2>
        <input type="text" name="nome" placeholder="Nome do Jogo" required>
        <input type="text" name="desc" placeholder="Descrição curta">
        <select name="plat">
            <option value="PS5">PlayStation 5</option>
            <option value="Xbox">Xbox Series</option>
            <option value="PC">PC / Steam</option>
        </select>
        <input type="number" step="0.01" name="preco" placeholder="Preço (ex: 200.00)" required>
        <input type="text" name="img" placeholder="Link da Imagem (URL)" required>
        <button type="submit">Salvar</button>
        <br><br>
        <a href="index.php" style="color:#aaa; text-decoration:none; display:block; text-align:center;">Voltar</a>
    </form>
</body>
</html>