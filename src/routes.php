<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/feed', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/' route");
    // Render index view

    echo "the feed route is working";

    $query = "Select * FROM feed_chardur.Users";

/*    $dbhandler = $this->db;
    $queryUsers = $dbhandler->prepare(" Select * FROM feed_chardur.Users ");

    try{
        $queryUsers->execute();
        $users = $queryUsers->fetchAll();

        print_r($users);
        return $users;

        // or you can send it to a template
        // $this->view->render($res, 'template.twig', $users);

    }catch(\PDOExeption $e)
    {
        // handle exception
    }*/

    $servername = "67.205.183.11";
    $username = "chardur";
    $password = "changeme";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=feed_chardur", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    $queryUsers = $conn->prepare(" Select * FROM feed_chardur.Users ");
    $queryUsers->execute();
    $users = $queryUsers->fetchAll();

    print_r($users);
    return $response;

});

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
