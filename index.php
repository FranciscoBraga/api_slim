<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

//----instanciando objeto app para as rotas -----
$app =  new \Slim\App;

/*
get-Recuperar recursos do servidor (select)
post- Criar dado no servidor (Insert)
put - Atualizar dados no servidor (Update)
delete - Deletar dados do servidro (Delete)
*/

 //atualizando dados que estão no servidor
 $app->delete('/usuarios/remove{id}',function(Request $request , Response $response){
    
    $id = $request->getAttribute('id');
 
    return $response->getBody()->write('Dados deletados: '.$id);
  });
//defindo paramentros request e response
$app->get('/postagens',function(Request $request , Response $response){
   //enviando uma resposta ao cliente conform pdaro PSR-7
   $response->getBody()->write("Listagem das postagens");
   return $response;
});
//enviando dados para o servidor
$app->post('/usuarios/adiciona',function(Request $request , Response $response){
   //recuperando o valor do post
   $post = $request->getParsedBody();
   $nome = $post['nome'];
   $email = $post['email'];

   return $response->getBody()->write($nome.'-'.$email);
 });
 //atualizando dados que estão no servidor
$app->put('/usuarios/atualiza',function(Request $request , Response $response){
    //atu
    $post = $request->getParsedBody();
    $id = $post['id'];
    $nome = $post['nome'];
    $email = $post['email'];
 
    return $response->getBody()->write('Dados Atualizados!');
  });
//executa o get
$app->run();

/* 

//-----definindo rotas para enviar dados para servidor---
$app->get('/postagens2',function(){
    echo "Listagem ";
});

//-------------passando uma id pela url-------------------
$app->get('/usuarios/{id}', function($request, $response){
    $id = $request->getAttribute('id');
    echo $id;
});
//----------definindo rotas com variváeis opcionais na url------------
$app->get('/postagens[/{ano}[/{mes}]]', function($request, $response){
    $ano = $request->getAttribute('ano');
    $mes = $request->getAttribute('mes');
    echo "Postagens: Ano:".$ano." Mês :".$mes; 
});
//---------------definindo rotas dinâmicas----------------
$app->get('/lista/{item:.*}', function($request, $response){
    $item = $request->getAttribute('item');
    var_dump(explode('/', $item));
});
//-------nomeando rotas----------------
$app->get('/blog/postagens/{id}', function($request, $response){
    echo "lista de postagens";
})->setName('blog');

$app->get('/meusite', function($request, $response){
    $retorno = $this->get('router')->pathfor("blog",['id'=>'5']);
    echo $retorno;
});
//------ agrupando rotas----
$app->group('/v1', function() use ($app){
    $app->get('/postagens',function(){
        echo "Listagem postagens ";
    });

    $app->get('/usuarios',function(){
        echo "Listagem usuarios ";
    });
}); */
