<?php
$produtos = [
    ["nome" => "Arroz", "preco" => 10.50, "quantidade" => 5],
    ["nome" => "Feijão", "preco" => 8.00, "quantidade" => 3],
    ["nome" => "Macarrão", "preco" => 4.50, "quantidade" => 10]
];

$jsonProdutos = json_encode($produtos, JSON_PRETTY_PRINT);

file_put_contents("produtos.json", $jsonProdutos);

echo "Arquivo produtos.json criado com sucesso!";
?>