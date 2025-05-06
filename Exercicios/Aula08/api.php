<?php
header("Content-Type: application/json; charset=UTF-8");

$metodo = $_SERVER['REQUEST_METHOD'];
$arquivo = 'usuarios.json';

if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$usuarios = json_decode(file_get_contents($arquivo), true);

function salvarUsuarios($usuarios, $arquivo)
{
    file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function buscarUsuarioPorId($usuarios, $id)
{
    foreach ($usuarios as $usuario) {
        if ($usuario['id'] == $id) {
            return $usuario;
        }
    }
    return null;
}

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $usuario = buscarUsuarioPorId($usuarios, $id);
            if ($usuario) {
                echo json_encode($usuario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        if (!isset($dados["nome"]) || !isset($dados["email"])) {
            http_response_code(400);
            echo json_encode(["erro" => "Nome e email são obrigatórios."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $novo_id = !empty($usuarios) ? max(array_column($usuarios, 'id')) + 1 : 1;

        $novo_usuario = [
            "id" => $novo_id,
            "nome" => $dados["nome"],
            "email" => $dados["email"]
        ];

        $usuarios[] = $novo_usuario;
        salvarUsuarios($usuarios, $arquivo);

        echo json_encode([
            "mensagem" => "Usuário inserido com sucesso!",
            "usuario" => $novo_usuario
        ], JSON_UNESCAPED_UNICODE);
        break;

    case 'PUT':
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!isset($dados["id"]) || !isset($dados["nome"]) || !isset($dados["email"])) {
            http_response_code(400);
            echo json_encode(["erro" => "ID, nome e email são obrigatórios."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = $dados["id"];
        $usuario_encontrado = null;

        foreach ($usuarios as $index => $usuario) {
            if ($usuario['id'] == $id) {
                $usuarios[$index]['nome'] = $dados["nome"];
                $usuarios[$index]['email'] = $dados["email"];
                $usuario_encontrado = $usuarios[$index];
                break;
            }
        }

        if ($usuario_encontrado) {
            salvarUsuarios($usuarios, $arquivo);
            echo json_encode([
                "mensagem" => "Usuário atualizado com sucesso!",
                "usuario" => $usuario_encontrado
            ], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'DELETE':
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!isset($dados["id"])) {
            http_response_code(400);
            echo json_encode(["erro" => "ID é obrigatório para exclusão."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = intval($dados["id"]);
        $usuario_encontrado = false;

        foreach ($usuarios as $index => $usuario) {
            if ($usuario['id'] == $id) {
                array_splice($usuarios, $index, 1); // Remove o usuário
                $usuario_encontrado = true;
                break;
            }
        }

        if ($usuario_encontrado) {
            salvarUsuarios($usuarios, $arquivo);
            echo json_encode(["mensagem" => "Usuário excluído com sucesso."], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido!"], JSON_UNESCAPED_UNICODE);
        break;
}
?>
