<?php

$usuarios = json_decode(file_get_contents('usuarios.json'), true);


$email_busca = isset($_GET['email']) ? $_GET['email'] : 'email@exemplo.com';


$usuario_encontrado = null;
foreach ($usuarios as $usuario) {
    if ($usuario['email'] === $email_busca) {
        $usuario_encontrado = $usuario;
        break;
    }
}


if ($usuario_encontrado) {
    echo "Usuário encontrado:<br>";
    echo "Nome: " . $usuario_encontrado['nome'] . "<br>";
    echo "Email: " . $usuario_encontrado['email'] . "<br>";
} else {
    echo "Usuário não encontrado.";
}
?>
