<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->post('/feed/add', function (Request $request, Response $response) {

    $this->logger->info("tweet-away '/feed/add' route");

    $data = $request->getParsedBody();
    $ip = $_SERVER['REMOTE_ADDR'];
    $name = filter_var($data['username'], FILTER_SANITIZE_STRING);
    $message = filter_var($data['message'], FILTER_SANITIZE_STRING);

    try {
        $conn = $this->db;
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    $sql = "INSERT INTO feed_chardur.Users (name) VALUES (?)";
    $insertName = $conn->prepare($sql);
    $insertName->execute([$name]);

    $idQuery = $conn->prepare("SELECT LAST_INSERT_ID()");
    $idQuery->execute();
    $id = $idQuery->fetchColumn();

    $sql = "insert into feed_chardur.Messages (message, userID, time) values (?,?,current_timestamp())";
    $insertMsg = $conn->prepare($sql);
    $insertMsg->execute([$message, $id]);

    $MsgidQuery = $conn->prepare("SELECT LAST_INSERT_ID()");
    $MsgidQuery->execute();
    $Msgid = $MsgidQuery->fetchColumn();

    $timeQuery = $conn->prepare("SELECT time from feed_chardur.Messages where messageId = $Msgid");
    $timeQuery->execute();
    $time = $timeQuery->fetchColumn();

    $sql = "insert into feed_chardur.Ips (ip, userID) values (?,?)";
    $insertMsg = $conn->prepare($sql);
    $insertMsg->execute([$ip, $id]);

    $newFeed = [];
    $newFeed['name'] = $name;
    $newFeed['time'] = $time;
    $newFeed['message'] = $message;

    echo json_encode($newFeed);

    return $response;

});

$app->get('/feed', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/feed' route");
    // Render index view

    try {
        $conn = $this->db;
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    $queryFeed = $conn->prepare(" select name, time, message from Users inner join Messages on Users.userID = Messages.userID order by time desc ");
    $queryFeed->execute();
    $args['feed'] = $queryFeed->fetchAll();
    echo json_encode($args['feed']);
    return $response;
});

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("tweet-away '/' route");
    // Render index view

    return $this->renderer->render($response, 'index.phtml', ['args'=>$args]);
});
