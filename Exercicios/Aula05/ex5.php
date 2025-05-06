<?php

$produtos = json_decode(file_get_contents('produtos.json'), true);


$produto_remover = isset($_GET['nome']) ? $_GET['nome'] : 'Produto Exemplo';


$produtos_filtrados = array_filter($produtos, function ($produto) use ($produto_remover) {
    return $produto['nome'] !== $produto_remover;
});


file_put_contents('produtos.json', json_encode(array_values($produtos_filtrados), JSON_PRETTY_PRINT));

echo "Produto removido (se existia no JSON).";
?>
