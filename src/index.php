<?php


require_once 'Produto.php';
require_once 'Venda.php';
// Verifica se há dados enviados pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtem dados do formulário e cadastra o produto
    $dadosProduto = [
        'nome' => isset($_POST['nome']) ? $_POST['nome'] : '',
        'preco' => isset($_POST['preco']) ? floatval($_POST['preco']) : 0,
        'quantidade' => isset($_POST['quantidade']) ? intval($_POST['quantidade']) : 0,
    ];
    $produto = new Produto();
    $produto->setProduto($dadosProduto);
    echo $produto->getProduto();

    $produtosCadastrados = Produto::listarProdutos();

    $venda = new Venda();

    // Obtem dados do formulário e registra a venda
    $produtoSelecionadoIndex = isset($_POST['produtoSelecionado']) ? $_POST['produtoSelecionado'] : null;
    $produtoSelecionado = isset($produtosCadastrados[$produtoSelecionadoIndex]) ? $produtosCadastrados[$produtoSelecionadoIndex] : null;

    $dadosVenda = [
        'quantidadeVendida' => isset($_POST['quantidadeVendida']) ? min(intval($_POST['quantidadeVendida']), $produtoSelecionado->getQuantidade()) : 0,
        'desconto' => isset($_POST['desconto']) ? floatval($_POST['desconto']) : 0,
    ];

    // Verifica se $produtoSelecionado não é nulo antes de chamar getProduto()
    if ($produtoSelecionado) {
        $venda->setVenda($produtoSelecionado, $dadosVenda);
        echo $venda->getVenda();
        echo $produtoSelecionado->getProduto();  // Exibe o estoque atualizado do produto após a venda
    } else {
        
    }
}
// Código em HTML para adionar interações com o usuário
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Mercadinho JWT</title>
</head>
<body>

<h1>PDV Mercadinho JWT</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h2>Cadastrar Produto</h2>
    <label for="nome">Nome do Produto:</label>
    <input type="text" name="nome" required><br>

    <label for="preco">Preço do Produto:</label>
    <input type="number" name="preco" step="0.01" required><br>

    <label for="quantidade">Quantidade do Produto:</label>
    <input type="number" name="quantidade" required><br>

    <button type="submit">Cadastrar Produto</button>
</form>

<hr>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h2>Registrar Venda</h2>

    <?php
    $produtosCadastrados = Produto::listarProdutos();
    if ($produtosCadastrados && is_array($produtosCadastrados) && count($produtosCadastrados) > 0) {
        echo '<label for="produtoSelecionado">Selecione o Produto:</label>';
        echo '<select name="produtoSelecionado">';
        
        foreach ($produtosCadastrados as $index => $produto) {
            echo "<option value=\"$index\">{$produto->getProduto()}</option>";
        }

        echo '</select><br>';
    } else {
        echo 'Erro: Nenhum produto cadastrado para realizar a venda.<br>';
    }
    ?>

    <label for="quantidadeVendida">Quantidade Vendida:</label>
    <input type="number" name="quantidadeVendida" required><br>

    <label for="desconto">Desconto (%):</label>
    <input type="number" name="desconto" step="0.01" required><br>

    <button type="submit">Registrar Venda</button>
</form>

</body>
</html>