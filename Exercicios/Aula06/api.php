<?php
    // CABEÇALHO
    header("Content-Type: application/json; charset=UTF-8");

    $metodo = $_SERVER['REQUEST_METHOD'];
    // echo "Método da requisição: " . $metodo;

    // Recupera o arquivo JSON na mesma pasta do projeto
    $arquivo = 'usuarios.json';

    // Verificação se existe ou não
    if (!file_exists($arquivo)) {
        file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // Lê o conteúdo do JSON
    $usuarios = json_decode(file_get_contents($arquivo), true);

    // CONTEÚDO
    // $usuarios = [
    //     ["id" => 1, "nome" => "Maria Souza", "email" => "maria@email.com"],
    //     ["id" => 2, "nome" => "João Silva", "email" => "joao@email.com"]
    // ];

    switch ($metodo) {
        case 'GET':
            // Retorna os usuários
            echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);            
            break;

        case 'POST':
            // Lê os dados enviados no corpo da requisição
            $dados = json_decode(file_get_contents('php://input'), true);

            // Verifica se os campos obrigatórios foram preenchidos
            if (!isset($dados["id"]) || !isset($dados["nome"]) || !isset($dados["email"])) {
                http_response_code(400);
                echo json_encode(["erro" => "Dados incompletos."], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Cria USUÁRIO
            $novo_usuario = [
                "id" => $dados["id"],
                "nome" => $dados["nome"],
                "email" => $dados["email"],
            ];

            // Cria ARRAY
            $usuarios[] = $novo_usuario;

            // Salva ARRAY em JSON
            file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Retorna mensagem de sucesso
            echo json_encode(["mensagem" => "Usuário inserido com sucesso!", "usuarios" => $usuarios], JSON_UNESCAPED_UNICODE);
            break;

            // Adiciona o novo USUÁRIO no ARRAY existente
            // array_push($usuarios, $novo_usuario);
            // echo json_encode('Usuário inserido com sucesso!', JSON_UNESCAPED_UNICODE);
            // print_r($usuarios);
            
        default:
            // Método não permitido
            http_response_code(405);
            echo json_encode(["erro" => "Método não permitido!"], JSON_UNESCAPED_UNICODE);
            break;
    }    
?>