 <?php
 require_once('Produto.php');

 class Venda {
    public $produtoSelecionado;
    public $quantidadeVendida;
    public $desconto;

    public function setVenda($produtoSelecionado, $data) {
        if ($produtoSelecionado) {
            if (isset($data['quantidadeVendida']) && isset($data['desconto'])) {
                if ($produtoSelecionado->getQuantidade() >= $data['quantidadeVendida']) {
                    $produtoSelecionado->quantidade -= $data['quantidadeVendida'];

                    $this->produtoSelecionado = $produtoSelecionado;
                    $this->quantidadeVendida = $data['quantidadeVendida'];
                    $this->desconto = $data['desconto'];

                    // Adiciona as informações da venda ao arquivo "vendas.txt"
                    $this->salvarVenda();

                    echo "Venda registrada com sucesso!\n";
                } else {
                    echo "Erro: Estoque insuficiente para a venda.\n";
                }
            } else {
                echo "Erro: Informações incompletas para registrar a venda.\n";
            }
        } else {
            echo "Erro: Nenhum produto selecionado para realizar a venda.\n";
        }
    }

    private function salvarVenda() {
        $linha = "{$this->produtoSelecionado->getProduto()},{$this->quantidadeVendida},{$this->desconto}\n";
        file_put_contents("vendas.txt", $linha, FILE_APPEND);
    }
    public function getVenda() {
        if ($this->produtoSelecionado) {
            echo "Última Venda: " . $this->produtoSelecionado->getProduto() . ", Quantidade Vendida: {$this->quantidadeVendida}, Desconto: {$this->desconto}%\n";
            echo "Estoque Atual: {$this->produtoSelecionado->getQuantidade()}\n";
        } else {
            
        }
    
    }

}