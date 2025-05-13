<?php
// Função para consultar o CEP na API ViaCEP
function consultarCEP($cep) {
    $url = "https://viacep.com.br/ws/" . $cep . "/json/";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Verifica se o formulário foi enviado
$cep = '';
$cep_info = [];
if (isset($_POST['cep'])) {
    $cep = $_POST['cep'];
    // Verifica se o CEP tem 8 dígitos
    if (preg_match('/^\d{8}$/', $cep)) {
        $cep_info = consultarCEP($cep);
    } else {
        $cep_info['erro'] = "CEP inválido! O CEP deve conter 8 dígitos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CEP - ViaCEP</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color:rgb(245, 211, 246); /* Cor de fundo suave */
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-size: cover;
        background-position: center;
    }

    .container {
        width: 80%;
        max-width: 600px;
        background-color: rgba(255, 255, 255, 0.6); /* Fundo branco com transparência */
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(197, 0, 122, 0.42);
        text-align: center;
        backdrop-filter: blur(8px); /* Dá um efeito de desfoque no fundo */
    }

    h1 {
        font-size: 30px;
        color:rgb(248, 98, 168); /* Cor rosa Hello Kitty */
        margin-bottom: 20px;
        font-family: 'fantasy', sans-serif;
    }

    label {
        font-size: 18px;
        margin-bottom: 8px;
        color:rgb(250, 138, 194); /* Cor de texto suave */
        font-weight: bold;
        display: block;
        font-family: 'Comic Sans MS', sans-serif;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        margin-bottom: 20px;
        border: 2px solid #e9006b; /* Cor de borda rosa */
        border-radius: 10px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #ff1493; /* Cor de borda ao focar */
        box-shadow: 0 0 8px rgba(252, 42, 154, 0.82); /* Efeito de sombra no input */
    }

    button {
        width: 100%;
        padding: 14px;
        font-size: 18px;
        background-color: #ff69b4; /* Rosa fofo para o botão */
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-family: 'Comic Sans MS', sans-serif;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #ff1493; /* Cor mais forte ao passar o mouse */
    }

    .result {
        margin-top: 20px;
    }

    .result p {
        font-size: 16px;
        color: #555;
        margin: 8px 0;
        font-family: 'Comic Sans MS', sans-serif;
    }

    .result strong {
        color: #e9006b; /* Cor rosa nas labels */
    }

    .error {
        color: red;
        font-size: 16px;
        font-weight: bold;
    }

    footer {
        margin-top: 20px;
        font-size: 14px;
        color: #ff69b4;
    }

    footer a {
        color: #e9006b;
        text-decoration: none;
        font-weight: bold;
    }

    </style>
</head>
<body>
    <div class="container">
        <h1>CONSULTA DE CEP</h1>
        <form method="post">
            <label for="cep">Digite o CEP (apenas números):</label>
            <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($cep); ?>" required>
            <button type="submit">Consultar</button>
        </form>

        <?php if (!empty($cep_info)) : ?>
            <div class="result">
                <?php if (isset($cep_info['erro'])) : ?>
                    <p class="error"><?php echo $cep_info['erro']; ?></p>
                <?php else : ?>
                    <p><strong>Logradouro:</strong> <?php echo $cep_info['logradouro']; ?></p>
                    <p><strong>Bairro:</strong> <?php echo $cep_info['bairro']; ?></p>
                    <p><strong>Localidade:</strong> <?php echo $cep_info['localidade']; ?></p>
                    <p><strong>UF:</strong> <?php echo $cep_info['uf']; ?></p>
                    <p><strong>Estado:</strong> <?php echo $cep_info['uf']; ?></p>
                    <p><strong>Região:</strong> <?php echo isset($cep_info['regiao']) ? $cep_info['regiao'] : 'Não disponível'; ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
