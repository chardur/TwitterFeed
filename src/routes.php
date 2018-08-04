<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/' route");
    // Render index view
    echo "testing routes";
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/test', function (Request $request, Response $response) {
    // Sample log message
    $this->logger->info("tweet-away '/test' route");
    // Render index view
    echo "testing";
    //return $this->renderer->render("testing");
});

