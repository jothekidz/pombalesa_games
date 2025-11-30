<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO clientes (nome, email, senha, cep, endereco) VALUES (?, ?, ?, ?, ?)";
    try {
        $pdo->prepare($sql)->execute([$_POST['nome'], $_POST['email'], $senha, $_POST['cep'], $_POST['end']]);
        echo "<script>alert('Conta criada!'); window.location='login.php';</script>";
    } catch(Exception $e) { echo "<script>alert('Email já existe!');</script>"; }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Pombalesa</title>
    <style>
        body { background: #050505; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: #1a1a1a; padding: 40px; border-radius: 8px; border: 1px solid #333; width: 300px; }
        input { width: 93%; padding: 10px; margin: 5px 0; background: #333; border: 1px solid #555; color: white; }
        button { width: 100%; padding: 10px; background: #00ff88; border: none; color: black; font-weight: bold; cursor: pointer; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color:#00ff88; text-align:center;">Nova Conta</h2>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome / Nick" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="text" id="cep" name="cep" placeholder="CEP" onblur="buscaCep()" required>
            <input type="text" id="end" name="end" placeholder="Endereço Automático">
            <button type="submit">CADASTRAR</button>
        </form>
        <p style="text-align:center"><a href="login.php" style="color:#aaa">Já tenho conta</a></p>
    </div>
    <script>
        function buscaCep() {
            var cep = document.getElementById('cep').value;
            if(cep.length == 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`).then(r=>r.json()).then(d=>{
                    if(!d.erro) document.getElementById('end').value = `${d.logradouro}, ${d.bairro}`;
                });
            }
        }
    </script>
</body>
</html>