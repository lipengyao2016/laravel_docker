<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    protected $user;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::debug(__METHOD__.' begin user:'.json_encode($this->user));
        sleep(2);
        Log::debug(__METHOD__.' end user:'.json_encode($this->user));
        //throw new Exception('test send email not found 3333~!!');
    }

    /**
     * 任务失败的处理过程
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // 给用户发送任务失败的通知，等等……
        Log::debug(__METHOD__.'  exceptioned222!!!!'.$exception->getTrace());
    }
}
