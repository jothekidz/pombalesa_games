<?php
session_start();
require 'conexao.php';

if (isset($_POST['add'])) {
    $_SESSION['carrinho'][] = $_POST['id_produto'];
    header("Location: carrinho.php");
    exit;
}
if (isset($_GET['limpar'])) {
    unset($_SESSION['carrinho']);
    header("Location: carrinho.php");
    exit;
}

$itens = [];
$total = 0;
if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
    $ids = implode(',', $_SESSION['carrinho']);
    $stmt = $pdo->query("SELECT * FROM produtos WHERE id IN ($ids)");
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Carrinho - Pombalesa</title>
    <style>
        body { background: #0d0d0d; color: white; font-family: sans-serif; padding: 20px; }
        .box { max-width: 800px; margin: auto; background: #1a1a1a; padding: 20px; border-radius: 8px; border: 1px solid #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border-bottom: 1px solid #444; padding: 10px; text-align: left; }
        .total { text-align: right; font-size: 1.5rem; margin-top: 20px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer; border: none;}
        .btn-green { background: #00ff88; color: black; }
        .btn-red { background: #ff0055; color: white; }
    </style>
</head>
<body>
    <div class="box">
        <h1 style="color:#ff0055;">Seu Carrinho</h1>
        <table>
            <tr><th>Jogo</th><th>Plataforma</th><th>Preço</th></tr>
            <?php foreach($itens as $item): 
                $qtd = count(array_keys($_SESSION['carrinho'], $item['id']));
                $subtotal = $item['preco'] * $qtd;
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $item['nome'] ?> (x<?= $qtd ?>)</td>
                <td><?= $item['plataforma'] ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div style="background:#222; padding:15px; border-radius:5px;">
            <label>Calcular Frete (CEP):</label>
            <input type="text" id="cep" maxlength="8" placeholder="00000000" style="padding:5px;">
            <button onclick="calcFrete()" class="btn btn-red" style="padding:5px 10px;">OK</button>
            <p id="msgFrete" style="color:#aaa;"></p>
        </div>

        <div class="total">
            Total Produtos: R$ <span id="valTotal"><?= number_format($total, 2, '.', '') ?></span><br>
            <strong style="color:#00ff88;">Total Final: R$ <span id="final"><?= number_format($total, 2, ',', '.') ?></span></strong>
        </div>

        <br>
        <a href="index.php" class="btn" style="background:#333; color:white;">Continuar Comprando</a>
        <a href="?limpar=true" class="btn btn-red">Limpar</a>
        <button class="btn btn-green" onclick="alert('Compra realizada com sucesso!')">FINALIZAR PEDIDO</button>
    </div>

    <script>
        function calcFrete() {
            var cep = document.getElementById('cep').value;
            var totalProd = parseFloat(document.getElementById('valTotal').innerText);
            
            if(cep.length == 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(r => r.json())
                .then(d => {
                    if(!d.erro) {
                        let frete = 20.00;
                        document.getElementById('msgFrete').innerText = `Entrega para ${d.localidade}/${d.uf}: R$ 20,00`;
                        let final = totalProd + frete;
                        document.getElementById('final').innerText = final.toFixed(2).replace('.', ',');
                    } else { alert("CEP não encontrado"); }
                });
            } else { alert("Digite 8 números"); }
        }
    </script>
</body>
</html>