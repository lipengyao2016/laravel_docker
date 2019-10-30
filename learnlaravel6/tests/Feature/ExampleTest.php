<?php

namespace Tests\Feature;

use App\Common\UrlUtils;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
class ExampleTest extends TestCase
{
    //user token
   // public $accessToken  = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY1ZWQwODhmZTlmY2ZmMTAyNDY0MjRiNzcwN2Y1M2RiNTE1OTdjMTQ1OWE4ZTVlNzY1N2EwYzk3OTc0ZDdjN2I2OWM4ZGIwMGNlOTUwMjZmIn0.eyJhdWQiOiIyIiwianRpIjoiZjVlZDA4OGZlOWZjZmYxMDI0NjQyNGI3NzA3ZjUzZGI1MTU5N2MxNDU5YThlNWU3NjU3YTBjOTc5NzRkN2M3YjY5YzhkYjAwY2U5NTAyNmYiLCJpYXQiOjE1NjkyMjI0MjUsIm5iZiI6MTU2OTIyMjQyNSwiZXhwIjoxNTcwNTE4NDI1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.GCWbPiTr0JMxN0moukisd8L-UZfiHXbQEeFZLUou3Wv7JK-IzCaNL7-rsKn2MXP02keA96pKyniqWmgU3j7OnZiQXXqzepXxcaYIMpXxuyWZmJTECHo9wyjrC9lusF-vTIjXxBslevxSf1-XyySXpMC1Z_ezIpet0cZruyGGCyw1ht_Bve1WubRbu8gB3qAPaQ0y4k19gC1vSvqEekgUZAig-gWGhE8zsPHQ5INd4qA7nckB1EwXLhnTh-zKmYoJs5nzJV_ei3qGDNMxRqbyvjiBMctdLXXIb4NjrT2-VEGSkltKWysAQzMBmLH6aZuNl4853RSnNuG40zVW3Rol5WJytsIWprYEnKWeHUoPaCcnMXyA2ir_5JqoqR8gssVpX01KZtd7BDHsQYuJhViAWhCQoVvQhDOrkwnDR2PY1xSUjQfkod-wgjWiueTH_TEJAl-zorwO7q6ltjIgJeEb2-qJFMfHHOh0AH_-Dqckrp-ETh5M1C8lrRq1_1VoTJlmHUmsdKQb7rn2DS-jqfR4gK3rTjWDWNrvf_oAu86J9wPvrev4cc8IfDrbvlpLOnGMMmQ5BZAI2g0RelkxfgoPuXxgr6aChFQx2watKuIaSrOglPNNx3zaHiko8-EA-g6QdPmHZr-h7J0LJohAi2aDyDZSgU672I_MXNYpW4uS4bE';

    //teacher token
    public  $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI0NzFkM2I3MTQzY2VmYWFiYTM2ODI5MzAwZWI4M2M5MDk3NjEyZTMwYmYxYjQ5ZjhiZGZiM2UxZTNkY2U3NDU5M2EyOTJiZDUyNWJhYmEyIn0.eyJhdWQiOiIyIiwianRpIjoiMjQ3MWQzYjcxNDNjZWZhYWJhMzY4MjkzMDBlYjgzYzkwOTc2MTJlMzBiZjFiNDlmOGJkZmIzZTFlM2RjZTc0NTkzYTI5MmJkNTI1YmFiYTIiLCJpYXQiOjE1NjkyMjMyOTYsIm5iZiI6MTU2OTIyMzI5NiwiZXhwIjoxNTcwNTE5Mjk2LCJzdWIiOiIxMCIsInNjb3BlcyI6W119.MTcMh8tH9cAWW--yyFVBYDQ5j1GEODMA32RXK2cpMp8phbKiRRviPleTpJMFi1xVEOtxI4n1vx3MF7WJqXMVswmCNUzjSoYronJeCa3Csvo17itrwzhHjU2wN-yRRLHRoJOm2BPDeVFRIYUN0DzGKxUwqAFJJnNDyk8yV2TRyYhS5nKi0BsxnWUtn7DuZT4ei5W2pYVjfxdVi-Znh7BBUim16ipGQdmjWxzytJBEzuLz_6j8ixptkO3-uYFEUywV5hCaxVIa1GMVPJyEqbaUMpG3pcvnCqR3_qbuiGsv5yLMT_Py7OzpR7htFPh_4HJxDfPV_WPx2_y0V-zdZ1Hq-BpcaEEnmp22TQGOx9BNq_qHCtsiiZB9gH8fT7NAyJlvPPlWmuWGKmbAWjJUIjvnfr3DqkymDtggbOzw8z_vU0GW-J3Eybjznw5dhpd-IEtnzuk6K5cKGiROwtgh2CgqUjKk0N08ZWT4IyFBNjxI7kDdF1s_bjaFznidFE_baMjkTo7XVBn4_c-KaR1sl7fg-WaOCXlZqS3YmRxo_HlEFj6WpRw3b2Dyv9D9DpsMuAvVjlDMIOjMkMuSZ6FFxx6cMh_o8p2YSjx5u2ael1UMO8TkwrXJhK9XLjzGBhZTSJXFdxaaPOyDfH00G8xFSwz_QgdJ81aC0mxPzEW3jSbY4yE';
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLogin()
    {
        $loginData = [
            "email"=>"yao55@163.com",
            'password'=>"123456"];
        print_r(json_encode($loginData));
        $response = $this->post('http://www.myhosts.com/api/login',$loginData);
       // $response = $this->post('api/login',$loginData);
        //print_r($response);

        print_r(decodeUnicode($response->getContent()));

        //$response->assertStatus(200);
    }

    public function testLogin2()
    {
        $loginData = [
            "school_id"=>"10001",
            'password'=>"tt222"];

        $response = $this->post('http://www.myhosts.com/api/login2',$loginData);
        // $response = $this->post('api/login',$loginData);
        //print_r($response);
        print_r(decodeUnicode($response->getContent()));
        print_r($response->status());

        //$response->assertStatus(200);

    }

    public function testGetAdminUser()
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->accessToken,
        ];
        $response = $this->get('api/admin',$headers);
        print_r($response->getContent());
        $response->assertStatus(200);
    }

    public function testGetDetailsUser()
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->accessToken,
        ];

        $deviceqs = [
          //  'provider'=>'teachers'
        ];

        $response = $this->get(UrlUtils::combineURL('api/get-details',$deviceqs),$headers);
        print_r($response->getContent());
        print_r($response->status());
       // $response->assertStatus(200);
    }



    public function testGetPassportUserInfo()
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->accessToken,

        ];
        $response = $this->get('api/passportUserInfo',$headers);
        print_r($response->getContent());
        $response->assertStatus(200);
    }

    public function testLogout()
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$this->accessToken,

        ];
        $response = $this->post('api/logout',[],$headers);
        print_r($response->getContent());
        $response->assertStatus(200);
    }



}
