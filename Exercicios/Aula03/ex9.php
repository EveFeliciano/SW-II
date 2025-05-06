<?php
function fatorial($numero) {
    if ($numero < 0) {
        return "Número inválido";
    }
    $fatorial = 1;
    for ($i = 2; $i <= $numero; $i++) {
        $fatorial *= $i;
    }
    return $fatorial;
}
?>
