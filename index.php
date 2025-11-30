<?php
session_start();
require 'conexao.php';

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pombalesa Games - Home</title>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/responsive.css">

    <style>
        body { background-color: #0d0d0d; color: #fff; }
        .game-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; padding: 20px; }
        .game-card { 
            background: #1a1a1a; border: 1px solid #333; width: 250px; border-radius: 10px; overflow: hidden; 
            transition: 0.3s; text-align: center; padding-bottom: 15px;
        }
        .game-card:hover { transform: translateY(-5px); border-color: #ff0055; box-shadow: 0 0 15px rgba(255,0,85,0.3); }
        .game-card img { width: 100%; height: 250px; object-fit: cover; }
        .game-title { color: #fff; font-size: 1.1rem; margin: 10px 0; font-weight: bold; }
        .game-price { color: #00ff88; font-size: 1.3rem; font-weight: bold; margin-bottom: 10px; }
        .btn-buy { 
            background: #ff0055; color: white; border: none; padding: 10px 20px; 
            width: 80%; border-radius: 5px; cursor: pointer; font-weight: bold; 
        }
        .btn-buy:hover { background: #d60046; }
        header { background: #000; padding: 15px; border-bottom: 2px solid #ff0055; display:flex; justify-content:space-between; align-items:center;}
        nav a { color: white; text-decoration: none; margin-left: 15px; font-weight: bold; }
    </style>
</head>
<body>

    <header>
        <h1 style="color:#ff0055; margin:0;">🦅 Pombalesa Games</h1>
        <nav>
            <a href="index.php">Loja</a>
            <a href="carrinho.php">Carrinho 🛒</a>
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="admin_produtos.php" style="color:#00ff88;">[Admin]</a>
                <a href="logout.php" style="color:red;">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="cadastro.php">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2 style="text-align:center; margin-top:30px; color:#ddd;">Catálogo de Jogos</h2>
        
        <div class="game-container">
            <?php foreach($produtos as $prod): ?>
                <div class="game-card">
                    <img src="<?= $prod['imagem'] ?>" alt="<?= $prod['nome'] ?>">
                    <div class="game-title"><?= $prod['nome'] ?></div>
                    <div style="font-size:0.8rem; color:#aaa;"><?= $prod['plataforma'] ?></div>
                    <div class="game-price">R$ <?= number_format($prod['preco'], 2, ',', '.') ?></div>
                    
                    <form action="carrinho.php" method="POST">
                        <input type="hidden" name="id_produto" value="<?= $prod['id'] ?>">
                        <button type="submit" name="add" class="btn-buy">COMPRAR</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>