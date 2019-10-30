<?php

namespace App\Console\Commands;

use App\Http\swoole\SwooleHttpServer;
use App\Http\swoole\SwooleTcpServer;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $swooleHttpServer;
    protected $swooleTcpServer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->swooleHttpServer = new SwooleHttpServer(9501);
        $this->swooleTcpServer = new SwooleTcpServer(9501);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Log::debug(__METHOD__.' sendEmail called!!!!');

        $this->line('sdf');

       // $this->swooleHttpServer->start();
        $this->swooleTcpServer->start();


    }


}
