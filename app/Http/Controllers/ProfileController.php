<?php

namespace App\Http\Controllers;

use App\Markdown\Parser;
use App\Message;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web', ['only' => ['showMessages', 'readMessage', 'sentMessage']]);
    }

    public function index($id)
    {
        $userInfo = User::with('discussions')->findOrfail($id);
        $discussions = $userInfo->discussions()->latest()->paginate(10);
        return view('profile.index', compact('userInfo', 'discussions'));
    }

    public function replies($id)
    {
        $userInfo = User::with('comments')->findOrfail($id);
        $replies = $userInfo->comments()->latest()->paginate(10);
        return view('profile.replies', compact('userInfo', 'replies'));
    }

    public function favourites($id)
    {
        $userInfo = User::with('comments')->findOrfail($id);
        $favourites = User::find($id)->favourite()->latest()->paginate(10);
        return view('profile.favourites',compact('userInfo','favourites'));
    }

    public function showMessages(User $user)
    {
        $userInfo = User::with('messages')->findOrfail(Auth::Guard('web')->user()->id);
        $messages = $userInfo->messages()->latest()->paginate(10);
        return view('profile.message', compact('userInfo', 'messages', 'user'));
    }

    public function readMessage(User $user, Parser $parser, $id)
    {
        $message = Message::findOrfail($id);
        //判断是否有权限查看这条信息
        if (Auth::Guard('web')->user()->id == $message->user_id) {
            $userInfo = User::findOrfail(Auth::Guard('web')->user()->id);
            $message->isread = true;
            $message->save();
            return view('profile.readmessage', compact('userInfo', 'message', 'user', 'parser'));
        } else {
            return redirect(url('/'));
        }

    }

    public function ReplyMessage(Requests\ReplyMessageRequest $request)
    {
        $data = [
            'from_user_id' => Auth::Guard('web')->user()->id,
        ];

        Message::create(array_merge($request->all(), $data));
        return redirect(action('ProfileController@readMessage', ['id' => $request->message_id]));
    }

    public function sentMessage(Requests\SentMessageRequest $request)
    {
        $user_id = User::where('name', $request->username)->get()->first();
        if (isset($user_id)) {
            $data = [
                'user_id' => $user_id->id,
                'from_user_id' => Auth::Guard('web')->user()->id,
            ];
            Message::create(array_merge($request->all(), $data));
            Session::flash('message_sent', '消息发送成功!');
            return redirect(action('ProfileController@showMessages'));
        } else {
            Session::flash('user_id_not_found', '没有找到该用户,请核对.');
            return redirect(action('ProfileController@showMessages').'#sentMessage')->withInput();
        }
    }

    public function deleteMessage($id)
    {
        //验证删除权限
        if (Message::findOrfail($id)->user_id == Auth::Guard('web')->user()->id) {
            Message::destroy($id);
            Session::flash('delete_success','删除消息成功!');
            return redirect(action('ProfileController@showMessages'));
        }else{
            return redirect(url('/'));
        }
    }

    public function showUpdateForm()
    {
        $id = Auth::guard('web')->user()->id;
        $userInfo = User::with('comments')->findOrfail($id);
        return view('profile.update',compact('userInfo'));
    }

    public function update(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $user = User::findOrfail($user_id);

        if($request->upassword == ''){
            $this->validate($request,[
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,'.$user_id ,
            ]);
            $user->update($request->all());
        }else{
            $this->validate($request,[
                'name' => 'required|min:3',
                'email' => 'required|email',
                'upassword' => 'required|min:10|unique:users,email,'.$user_id,
                'upassword_confirmation' => 'required',
            ],[
                'upassword.min' => '用户密码最少为:min个字符',
                'upassword.confirmed'=>'两次输入密码不一致',
                'upassword_confirmation.required' =>'请填写验证密码'
            ]);
            $data = [
              'password' => $request->upassword,
            ];
            $user->update(array_merge($request->all(), $data));
        }
        Session::flash('updateUser_success','更新用户资料成功');
        return redirect()->back();

    }
}
