<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

require 'vendor/autoload.php';

//----instanciando objeto app para as rotas -----
$app =  new \Slim\App([
    'settings'=>['displayErrorDetails' => true]
    ]);

//configuração do banco de dados com slim-------
$container =  $app->getContainer();
$container['db'] = function()
{
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'slim',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',

    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

//utiizando o banco criando uma tabela
$app->get('/usuarios', function(Request $request, Response $response){

    $db = $this->get('db');
    //criando uma tabela
    /* $db->schema()->dropIfExists('usuarios');
    $db->schema()->create('usuarios', function($table)
    {
        $table->increments('id');
        $table->string('nome');
        $table->string('email');
        $table->timestamps();
    }); 

    //inserindo um registro
    $db->table('usuarios')->insert([
        'nome' => 'Francisco Braga',
        'email' => 'icoxicoo@gmail.com'
    ]);
    
    //update de um registro
    $db->table('usuarios')
            ->where('id', 1)
            ->update(['nome'=>'Francisco Oliveira Braga']);
        
    //Deletando registro
    $db->table('usuarios')
        ->where('id',1)
        ->delete()
    */
    //listando
    $usuarios =$db->table('usuarios')->get();
    foreach($usuarios as $usuario)
    {
        echo $usuario->nome.'</br>';
    }
});



//executa o get
$app->run();
   /*  $app->get('/header', function(Request $request, Response $response){

        //retornando texto 
       $response->write("Esse é um retorno header");
        //modificando cabeçalho 
       return $response->withHeader('allow', 'PUT')
                        ->withAddedHeader('Content-Length', 10);
    });

    $app->get('/json', function(Request $request, Response $response){

        //retornando json
       return $response->withJson
       ([
            'nome' => "Francisco",
            'Profissão ' => "Desenvolvedor Web"
       ]);

    });

    $app->get('/xml', function(Request $request, Response $response){

        //arquivo xml
        $xml =file_get_contents('arquivo');
        $response->write($xml);
        return $response->withHeader('Content-Type','application/xml');
      
    });

    //middleware
    $app->add(function( $request, $response, $next){

        //iniciando o middleware
        $response->write(' Inicio Camada +1 ');
        $response = $next($request, $response);
        $response->write(' Fim Camada + 1 ');
        return $response;



    });

    $app->add(function( $request, $response, $next){

        //iniciando o middleware
        $response->write(' Inicio Camada + 2 ');
        $response = $next($request, $response);
        $response->write(' Fim Camada + 2 ');
        return $response;

    });


    $app->get('/usuarios', function(Request $request, Response $response){

        $response->write('usuarios');

    });

    $app->get('/postagens', function(Request $request, Response $response){

   
        $response->write('postagens');
     
      
    }); */


/*--------Container Dependency  Injection------
class Servico{}

//----------------container pimple--------
$container  = $app->getContainer();
$container['servico'] = function()
{
    return new Servico;
};
//processando uma classe detro de uma rota
$app->get('/servico', function(Request $request, Response $response){

    $servico = $this->get('servico');
    var_dump($servico);
});

//-------controllers como serviço----------------
$container  = $app->getContainer();
$container['Home'] = function()
{
    return new MyApp\controllers\Home( new MyApp\View);
};
$app->get('/usuario', 'Home:index');
*/



/*
get-Recuperar recursos do servidor (select)
post- Criar dado no servidor (Insert)
put - Atualizar dados no servidor (Update)
delete - Deletar dados do servidro (Delete)
*/

/* 
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
