<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/7/6
 * Time: 17:33
 */
namespace App\Http\Controllers\Api;

use App\Events\OrderShipped;
use App\Http\facade\MyFooFacade;
use App\Jobs\ProcessOrder;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Laravel\Passport\Passport;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PassportController extends Controller
{

    public $successStatus = 200;

    private $http;
    public function __construct(Client $client)
    {
        $this->http = $client;
    }


    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        Log::debug("passportController->login email:".request('email').
            '  password:'.request('password'));

    /*   Teacher::create([
            'school_id'    => '10000',
            'teacher_name' => 'Kathy',
            'password'     => bcrypt('tt111')
        ]);
        Teacher::create([
            'school_id'    => '10001',
            'teacher_name' => 'Jack',
            'password'     => bcrypt('tt222')
        ]);*/

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            Log::debug(__METHOD__.' authUser:'.json_encode($user));
            $oldUser = User::where('email' ,request('email'))->first();

          /*  $jobRet = ProcessOrder::
            //dispatchNow($oldUser);
            dispatch($oldUser)
                ->delay(5)
            ->allOnConnection('redis')
                ->onQueue('processing');
            Log::debug(__METHOD__.' oldUser:'.json_encode($oldUser).' jobRet:'.json_encode($jobRet));*/


            //event(new OrderShipped($oldUser));
//            event(new OrderShipped($oldUser));

           // $success['token'] = $user->createToken('MyApp')->accessToken;
            //return response()->json(['success' => $success], $this->successStatus);
            //Log::debug(request('email'));
            //Log::debug(request('password'));
           // Log::debug(env('CLIENT_ID'));
            //Log::debug(env('CLIENT_SECRET'));

            Log::debug(env('APP_URL') . '/oauth/token');

            //Cache::store('redis')->put('userName',request('email'), 600);

            $tokenData =  [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('CLIENT_ID'),
                    'client_secret' => env('CLIENT_SECRET'),
                    'username' => request('email'),
                    'password' => request('password'),
                    'scope' => '',
                    'provider'=> 'users',
                ],
            ];

            Log::debug(__METHOD__.' tokenData:'.json_encode($tokenData));

            // 返回token
            try {
                $response = $this->http->post(env('APP_URL') . '/oauth/token',$tokenData);
                var_dump($response);
            } catch (\Exception $e){
                Log::debug($e);
                return response(['message' => '授权失败!'], 400);
            }

            return json_decode((string) $response->getBody(), true);

        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


    public function login2()
    {
        Log::debug("passportController->login2 email:".request('email').
            '  password:'.request('password'));

         $teacher = Teacher::where("school_id",request('school_id'));

        $userList = $this->http->get(env('APP_URL') . '/api/users');
        Log::debug(__METHOD__.' userList:'.json_encode($userList));

        //return $userList;

/*         $success['token'] = $teacher->createToken('teacher')->accessToken;

         return response()->json(['success' => $success], $this->successStatus);*/
           Log::debug(request('school_id'));
            Log::debug(request('password'));
            Log::debug(env('CLIENT_ID'));
            Log::debug(env('CLIENT_SECRET'));
           Log::debug(env('APP_URL') . '/oauth/token');
            // 返回token
            try {
                $response = $this->http->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('CLIENT_ID'),
                        'client_secret' => env('CLIENT_SECRET'),
                        'username' => request('school_id'),
                        'password' => request('password'),
                        'provider'=> 'teachers',
                        'scope' => '',
                    ],
                ]);
                var_dump($response);
            } catch (\Exception $e){
                Log::debug($e);
                return response(['message' => '授权失败!'], 400);
            }
            return json_decode((string) $response->getBody(), true);


    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
       $auth = app("auth");
       Log::debug(get_class($auth));

       $myfoo = app("myfoo");
        Log::debug(get_class($myfoo));
        $ret =  $myfoo->add(1,2);

        //$ret = MyFooFacade::add(1,2);

       // $ret = foo::add(3,4);
        Log::debug(__METHOD__.' ret:'.$ret);

        Log::debug(__METHOD__.' start!!!');
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->delete();
        }
        return response(['message' => '退出成功']);
    }



}
