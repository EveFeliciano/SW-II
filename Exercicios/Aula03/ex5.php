<?php
function somaArray($array) {
    $soma = 0;
    foreach ($array as $num) {
        $soma += $num;
    }
    return $soma;
}
?>
