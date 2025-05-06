<?php
$jsonData = file_get_contents("usuarios.json");

$usuarios = json_decode($jsonData, true);

foreach ($usuarios as $usuario) {
    echo "Nome: " . $usuario['nome'] . " - Email: " . $usuario['email'] . "<br>";
}
?>
