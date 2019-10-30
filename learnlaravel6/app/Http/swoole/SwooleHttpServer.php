<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/9/9
 * Time: 18:18
 */

namespace App\Http\swoole;


use Illuminate\Support\Facades\Log;
use swoole_http_server;
use swoole_process;

class SwooleHttpServer
{
    protected $httpServer;
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
        $this->httpServer = new swoole_http_server("0.0.0.0", $this->port);
        $this->httpServer->set([
            'worker_num' =>3, //工作进程数
            'daemonize' => false, //是否后台运行
        ]);

        $this->httpServer->on("start", function ($server) {
            Log::debug(__METHOD__."Swoole http server is started at http://127.0.0.1:".$this->port."\n"
                . ' cur pid:'.getmypid()) ;
        });
        $this->httpServer->on("request", function ($request, $response) {
            Log::debug(__METHOD__."Swoole http server request data.".json_encode($request->get).
            ' cur pid:'.getmypid()) ;
            $response->header("Content-Type", "text/plain");
            $response->end("Hello World\n".json_encode(['hello'=>'nihao'.time()]));
         // $this->Run($request,$response);
        });

        $this->initProcess();
        //$this->Run(null,null);
        $this->p(['name' => 'a']);

        Log::debug(__METHOD__."Swoole http server start begin..". ' cur pid:'.getmypid()) ;
        $this->httpServer->start();
        Log::debug(__METHOD__."Swoole http server start ok..") ;
        return true;
    }

    public function initProcess()
    {
        if(!$this->bInitProcess)
        {
            $customMsgKey = 101;
            $mod = 2 /*| swoole_process::IPC_NOWAIT*/;//这里设置消息队列为非阻塞模式

            $curCtx = $this;
            for($i=0;$i<$this->worker_num; $i++) {
                $process=new swoole_process(
                    function (swoole_process $worker) use($curCtx,$i) {
                        // 子进程创建后需要执行的函数
                        swoole_set_process_name(__CLASS__. ": worker $i");
                        $curCtx->sub_process($worker);
                    }
                );
                //$process->callback = 'sub_process';
                $bQueueRet = $process->useQueue($customMsgKey, $mod);
                Log::debug(__METHOD__.' $bQueueRet:'.$bQueueRet);
                $process->start();
                Log::debug(__METHOD__.' start sub process 2');
                $pid = $process->pid;
                $this->process_pool[$pid] = $process;
            }
            Log::debug(__METHOD__.' process_pool:'.json_encode($this->process_pool));
            $this->bInitProcess = true;
        }
    }

     public function Run($request, $response)
    {
        //$m = [1,2,3,4,5,6,7,8,9];
       // $this->p($m);

       $url=$request->server['request_uri'];
        Log::debug(__METHOD__.' url:'.$url);
        $response->header("Content-Type", "text/html; charset=utf-8");
        if($url!='/favicon.ico'){
           // $m = [1,2,3,4,5,6,7,8,9];
            Log::debug(__METHOD__.' url 22:'.$url);
            $this->p($request->get);
            $response->end('ok');
        }
        else
        {
            $response->end('首页');
        }

    }

    public function p($messages)
    {
        $process= null;
        //sleep(1);
        //由于所有进程是共享使用一个消息队列，所以只需向一个子进程发送消息即可
        $process = reset($this->process_pool);
        Log::debug(__METHOD__.' push 33 msg:'.json_encode($messages). ' cur pid:'.getmypid().
        ' process:'.json_encode($process));
        $process->push(json_encode($messages));
        //Log::debug(__METHOD__.' push 11 msg:'.json_encode($process).' process_pool:'.json_encode($this->process_pool));
      /*  foreach ($messages as $msg) {
            Log::debug(__METHOD__.' push 33 msg:'.json_encode($msg). ' cur pid:'.getmypid());
            $process->push($msg);
        }*/

    }


    public function sub_process(swoole_process $worker)
    {
       //sleep(1); //防止父进程还未往消息队列中加入内容直接退出
        Log::debug(__METHOD__."worker ".$worker->pid." started");
        while(true)
        {
            $msg = $worker->pop();
            if ($msg)
            {
                Log::debug(__METHOD__.' pop msg:'.$msg. ' cur pid:'.getmypid());
                if ($msg === false) {
                    break;
                }
                $sub_pid = $worker->pid;
                // echo "[$sub_pid] msg : $msg".PHP_EOL;
                file_put_contents(__DIR__.'/a.txt',"[$sub_pid] msg : $msg".PHP_EOL,FILE_APPEND);
                sleep(1);//这里的sleep模拟任务耗时，否则可能1个worker就把所有信息全接受了
            }
            else
            {
                usleep(10);
            }
        }
        Log::debug(__METHOD__."worker ".$worker->pid." exit");
        $worker->exit(0);
    }




}