<?php
$jsonProdutos = file_get_contents("produtos.json");

$produtos = json_decode($jsonProdutos, true);

$novoProduto = ["nome" => "Leite", "preco" => 6.00, "quantidade" => 2];

$produtos[] = $novoProduto;

$jsonAtualizado = json_encode($produtos, JSON_PRETTY_PRINT);

file_put_contents("produtos.json", $jsonAtualizado);

echo "Novo produto adicionado com sucesso!";
?>

