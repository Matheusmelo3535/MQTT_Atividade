<?php

require __DIR__ . '/vendor/autoload.php';

use Psr\Http\Message\MessageInterface as ResponsePsr;
use Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/', function(Request $request, Response $response, $args){
    $dados = file_get_contents('dadosMqtt.json');
    $response->getBody()->write($dados);
    
    return $response;
});

$app->post('/mqttData', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();
    writeOnJsonFile($parsedBody);
    return $response
        ->withStatus(201)
        ->withJson($parsedBody);
});

function writeOnJsonFile($message)
{
    $done = false;
    $old_content = file_get_contents('dadosMqtt.json');
    $jsoninfo = $old_content ? json_decode($old_content) : array();
    $jsoninfo[] = $message;
    $generated_json =  json_encode($jsoninfo);

    if (file_put_contents("dadosMqtt.json", $generated_json)) {
        $done = true;
        echo "Dados armazenados com êxito no arquivo JSON";
    } else {
        echo "Não foi possível armazenar os dados no arquivo JSON!";
    }
    return $done;
}


$app->run();
