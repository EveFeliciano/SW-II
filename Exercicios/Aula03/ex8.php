<?php
function gerarNumerosAleatorios() {
    $numeros = [];
    for ($i = 0; $i < 10; $i++) {
        $numeros[] = rand(1, 100); // Número aleatório entre 1 e 100
    }
    return $numeros;
}
?>
