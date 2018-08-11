<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

/*$app->get('/feed', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/feed' route");
    // Render index view

    echo "the feed route is working";
    try {
        $conn = $this->db;
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

});*/

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/' route");
    // Render index view

    try {
        $conn = $this->db;
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    $queryFeed = $conn->prepare(" select name, time, message from Users inner join Messages on Users.userID = Messages.userID order by time desc ");
    $queryFeed->execute();
//    $feed = $queryFeed->fetchAll();
    $args['feed'] = $queryFeed->fetchAll();

    return $this->renderer->render($response, 'index.phtml', ['args'=>$args]);
});
