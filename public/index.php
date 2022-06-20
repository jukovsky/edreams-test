<?php

use App\Controllers\SearchController;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Psr7\Response;
use Slim\ResponseEmitter;

require_once __DIR__.'/../vendor/autoload.php';

$controller = new SearchController();
$responseEmitter = new ResponseEmitter();
$request = ServerRequestCreatorFactory::determineServerRequestCreator()->createServerRequestFromGlobals();
$response = new Response(StatusCodeInterface::STATUS_OK);
$response = $controller->searchAction($request, $response);
$responseEmitter->emit($response);