<?php

require_once "vendor/autoload.php";

use Workerman\Connection\TcpConnection;
use Workerman\Worker;


$worker = new Worker("websocket://0.0.0.0:2345");

$worker->count = 1;

// 建立連線時 callback function
// @see http://doc.workerman.net/worker/on-connect.html
$worker->onConnect = function($connection) {
    /** @var TcpConnection $connection */

    echo "已經有一人連線成功 用戶端IP位置: " . $connection->getRemoteIp() . "\n";
};


// 當 Client 傳送訊息到 Server 端時 callback function
// @see http://doc.workerman.net/worker/on-message.html
$worker->onMessage = function($connection ,$message) {
    /** @var TcpConnection $connection */
    $connection->send('you send : '.$message);
};

// 當 Client 連線時發生錯誤 callback function
// @see http://doc.workerman.net/worker/on-close.html
$worker->onError =  function($connection,$code,$message) {
    /** @var TcpConnection $connection */
};

// 當 Client 中斷連線時 callback function
$worker->onClose = function($connection) {
    /** @var TcpConnection $connection */

    echo "已經有一人中斷連線 用戶端IP位置: " . $connection->getRemoteIp() . "\n";
};

Worker::runAll();