<?php

require 'vendor/autoload.php';
//----instanciando objeto app para as rotas -----
$app =  new \Slim\App;
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
});
//executa o get
$app->run();
