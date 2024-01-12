<?php

class Produto {
    public $nome;
    public $preco;
    public $quantidade;

    public function __construct($nome = '', $preco = 0, $quantidade = 0) {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    public function setProduto($data) {
        if (isset($data['nome']) && isset($data['preco']) && isset($data['quantidade'])) {
            $this->nome = $data['nome'];
            $this->preco = $data['preco'];
            $this->quantidade = $data['quantidade'];
    
            // Salva o produto no arquivo produtos.txt
            $this->salvarProduto();
    
            echo "Produto cadastrado com sucesso!\n";
        } else {
            echo "Erro: Informações incompletas para cadastrar o produto.\n";
        }
    }

    public function getProduto() {
        if ($this->nome) {
            return "Produto: {$this->nome}, Preço: {$this->preco}, Quantidade: {$this->quantidade}";
        } else {
            return ;
        }
    }

    public static function listarProdutos() {
    $produtos = [];
    $nomeArquivo = "produtos.txt";

    // Verifica se o arquivo existe antes de tentar lê-lo
    if (file_exists($nomeArquivo)) {
        $linhas = file($nomeArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($linhas as $linha) {
            $dados = explode(",", $linha);

            // Verifica se existem dados suficientes na linha antes de tentar acessar índices específicos
            if (count($dados) >= 3) {
                $produtos[] = new self($dados[0], $dados[1], $dados[2]);
            }
        }
    }

    return $produtos;
}
private function salvarProduto() {
    // Verifica se todas as informações do produto estão presentes antes de salvar
    if ($this->nome && $this->preco !== null && $this->quantidade !== null) {
        $linha = "{$this->nome},{$this->preco},{$this->quantidade}\n";
        file_put_contents("produtos.txt", $linha, FILE_APPEND);
    }
}
    public function getQuantidade() {
        return $this->quantidade;
    }
}
