<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/9/9
 * Time: 18:18
 */

namespace App\Http\swoole;


use Illuminate\Support\Facades\Log;

use swoole_process;
use swoole_server;

class SwooleTcpServer
{
    protected $tcpServer;
    protected $port;

    protected $worker_num = 5;
    protected $process_pool = [];
    protected  $bInitProcess = false;

    /**
     * SwooleHttpServer constructor.
     * @param $port
     */
    public function __construct($port)
    {
        $this->port = $port;
    }

    public function start()
    {
        $this->tcpServer = new swoole_server("0.0.0.0", $this->port);
 /*       $this->tcpServer->set([
            'worker_num' =>5, //工作进程数
            'daemonize' => false, //是否后台运行
        ]);*/

        //监听连接进入事件
        $this->tcpServer->on('Connect', function ($serv, $fd) {
            Log::debug("Client: Connect.fd:" .$fd);
        });

         //监听数据接收事件
        $this->tcpServer->on('Receive', function ($serv, $fd, $from_id, $data) {
            Log::debug("recv: data.fd:" .$fd.' , data:'.$data);
            $serv->send($fd, "Server: ".$data);
        });

         //监听连接关闭事件
        $this->tcpServer->on('Close', function ($serv, $fd) {
            //echo "Client: Close.\n";
            Log::debug("Client: Close.fd:" .$fd);
        });

        Log::debug(__METHOD__."Swoole tcp server start begin..". ' cur pid:'.getmypid().
        ' port:'.$this->port) ;
        $this->tcpServer->start();
        Log::debug(__METHOD__."Swoole tcp server start ok..") ;
        return true;
    }





}