<?php

require 'vendor/autoload.php';
use Ratchet\Http\HttpServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {

    public function onOpen(ConnectionInterface $conn) {
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $dbConn = $this->connectDataBase();

        // FIND AND STORE SOCKET ID IN DB AGAINST USER
        if(str_contains($msg,"MYSERVEREMAIL")){

             $msg = str_replace("MYSERVEREMAIL=","",$msg);
             // STORE SOCKET ID AGAINST A USER
        }
        else{



        }


       echo $from->resourceId.' '.$msg;
    }

    public function onClose(ConnectionInterface $conn) {
        echo "closed connection! ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo $e->getMessage();
    }

    public function connectDataBase(){

        $servername = "localhost";
        $username = "root";
        $password = "Password@1";

        // Create connection
        $conn = new mysqli($servername, $username, $password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";

        return $conn;
    }
}


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();
