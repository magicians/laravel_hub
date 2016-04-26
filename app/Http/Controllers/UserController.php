<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * 显示注册表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('user.showRegisterForm');
    }

    /**
     * 经过UserRegisterRequest验证后写入数据库并重定向到首页
     *
     * @param Requests\UserRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function doRegister(Requests\UserRegisterRequest $request)
    {

        $data = [
          'avatar' => 'img/face.png',
        ];

        User::create(array_merge($request->all(),$data));

        $user_id = User::where('email', $request->email)->value('id');
        $welcome_message = Storage::get('welcomemessage.txt');
        Message::create([
            'message' => $welcome_message,
            'user_id' => $user_id,
            'from_user_id' => 1
        ]);

        return redirect(url('/'));
    }

    /**
     * 显示登录表单
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('user.showLoginForm');
    }


    /**
     * 验证用户登录
     * 名为web的Guard默认使用users表进行验证
     *
     * @param Requests\UserLoginRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auth(Requests\UserLoginRequest $request)
    {
        if (Auth::Guard('web')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            return redirect(url('/'));
        } else {
            $request->session()->flash('login_faild','邮箱或密码错误');
            return redirect(url('login'))->withInput();
        }
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        Auth::Guard('web')->logout();
        return redirect(url('/'));
    }
}
