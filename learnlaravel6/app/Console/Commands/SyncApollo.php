<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class SyncApollo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apollo:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = config('apollo.server') . '/configs/' . implode('/', array_values(config('apollo.query')));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->doSync();
    }

    protected function doSync()
    {
        $client = new Client(['timeout' => 2.00]);
        try {
            Log::debug(' url:'.json_encode($this->url));
            $response = $client->request('GET', $this->url);
            $body = json_decode($response->getBody()->getContents(), true);
            Log::debug(' body:'.json_encode($body));
            $cfg = Arr::get($body, 'configurations', []);
            if (!$cfg) {
                return true;
            }
            $cfg = array_map(function ($value) {
                if ($row = json_decode($value, true)) {
                    return $row;
                }
                return $value;
            }, $cfg);

            Log::debug(' cfg:'.json_encode($cfg));

            $items = [];
            foreach ($cfg as $key => $value) {
                data_set($items, $key, $value);
            }
            Log::debug(' items:'.json_encode($items));

            $this->updateEnv($items);
           /* foreach ($items as $k => $item) {
                $this->line('Saving [' . $k . ']');
                $this->save($k, $item);
            }*/

        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }


    }

    public function updateEnv($data){
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';
        $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));
        Log::debug(__METHOD__.' begin envPath:'.$envPath.' contentArray:'.json_encode($contentArray->toArray()));
        $contentArray->transform(function ($item) use ($data){
            foreach ($data as $key => $value){
                if(str_contains($item, $key)){
                    return $key . '=' . $value;
                }
            }
            return $item;
        });
        $content = implode($contentArray->toArray(), "\n");
        Log::debug(__METHOD__.' after envPath:'.$envPath.' contentArray:'.json_encode($contentArray));
        \File::put($envPath, $content);
        return true;

    }


    protected function save($fileName, $item)
    {
        /*if (config('apollo.sync.redis', false)) {
            cache()->tags('apollo')->forever($fileName, $item);
            $this->line('Saving To Redis ' . $fileName);
        }*/

        if (config('apollo.sync.file', false)) {
            $this->line('Saving To File ' . $fileName);
            $fileName = 'apollo/' . $fileName . '.php';
            ksort($item);
            $content = implode("\r\n", [
                "<?php",
                "return",
                var_export($item, true) . ';'
            ]);
            Storage::disk('config')->put($fileName, $content);
        }

        $this->line('==================');

    }
}
