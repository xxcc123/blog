<?php

namespace App\Http\Controllers\Backend\User;

use App\Models\User\OauthClient;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;

class UserController extends Controller
{
    //
    public function user(){

        return view('index');
    }

    public function getApi(){

//        $crea= $this->credentials($request);
//        $https = OauthClient::where('user_id',$user['id'])
//            ->where('secret',$secret)->get()->toArray();

        $http= new Client();
//        foreach($https as $value){

            $response= $http->post('http://cheng.tofnews.com/oauth/token',[
                'form_params' => [
                   'grant_type' => 'password',
                   'client_id' => '2',
                   'client_secret' => 'EdUy0ISpTol2pGRhk82IF654s8esy4SmG38c8Q04',
                   'username' => 'cheng@erpboost.com',
                   'password' => '123123',
                   'scope' => '',
                ]
            ]);
            dump($response);
//        }

        return json_decode((string) $response->getBody(), true);

    }

    public function userApi(){

        $data=$this->getApi();

        if($data['access_token']==true){
            $user=User::all();dump($user);
        }else{
            echo '11';
        }

    }

    public function clientApi(){
        $guzzle=new Client();

//        $response=$guzzle->post('http://cheng.tofnews.com/oauth/token',[
//            'form_params' => [
//                'grant_type' => 'password',
//                'client_id' =>  '2',
//                'username'  =>  'cheng@erpboost.com',
//                'password'  =>  '123123',
//                'client_secret' => 'EdUy0ISpTol2pGRhk82IF654s8esy4SmG38c8Q04',
//                'scope'  => '*',
//            ]
//        ]);

        $query=http_build_query([
            'client_id' => '2',
            'redirect_url' => 'http://cheng.tofnews.com/callback',
            'response_type' => 'token',
            'scope' => '',
        ]);

        return redirect('http://cheng.tofnews.com/oauth/authorize?'.$query);
//        dump(json_decode((string) $response->getBody(),true));
//        return json_decode((string) $response->getBody(), true);
    }

    public function tokenApi(){

        $http=new Client();

        $response= $http->post('http://cheng.tofnews.com/oauth/token',[
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '2',
                'client_secret' => 'EdUy0ISpTol2pGRhk82IF654s8esy4SmG38c8Q04',
                'username' => 'cheng@erpboost.com',
                'password' => '123123',
                'scope' => '',
            ]
        ]);

//        $password=bcrypt('aaa123');dump($password);

        $access_token=json_decode($response->getBody(),true);
        if(!empty($access_token)){
            $user= \App\User::all();
            dump($user);
        }else{
            echo 11;
        }

//        return view('home');
    }

    public function login(){
        return view('login.login');
    }

    public function getloginapi(Request $request){
        $name=$request->input('name');
        $password=$request->input('password');

        $user=User::first();

        if($user['name']==$name && $user['password']==$password){

            $this->getApi();
            return redirect()->route("index");
        }
        echo 11;
    }

    /**
     * 用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(50);

        $data = [
            'users' => $users
        ];

        return view('backend.user',$data);
    }

    /**
     * 用户搜索
     * @param Request $request
     */
    public function search(Request $request)
    {
        $keyword = trim($request->get('table_search'));

        $users = User::where('name','like',$keyword)
            ->Orwhere('email','like',$keyword)
            ->paginate(50);

        $data = [
            'users' => $users
        ];

        return view('backend.user',$data);
    }

    /**
     * 用戶詳情
     * @param $id
     */
    public function show()
    {
        $user = User::findOrFail(user_id());

        return view('backend.user-show',['user' => $user]);
    }

    /**
     * 用户编辑页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'user' => $user
        ];

        return view('backend.user-detail',$data);
    }

    /**
     * 用户更新
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->input(['_token']));

        return redirect()->route('user');
    }

    /**
     * 刪除用戶
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user');
    }

    /**
     * 文件上传
     * @param Request $request
     */
    public function fileload(Request $request)
    {
         $request->file('file')->store('avatars');

         return redirect()->route('user');
    }
}
