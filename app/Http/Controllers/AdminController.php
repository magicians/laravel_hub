<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Message;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    use ThrottlesLogins;

    public $username = 'name'; //ThrottleLogins的重定向以及getThrottleKey方法需要用到

    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['index', 'auth']]);
    }

    public function index()
    {
        return view('admin.index');
    }

    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    protected function getThrottleKey(Request $request)
    {
        return mb_strtolower('admin.' . $request->input($this->loginUsername())) . '|' . $request->ip();
    }

    public function auth(Request $request)
    {
        if ($throttle = $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request); //有过多失败次数将抛出错误
        } else {
            $this->validate($request, [
                'name' => 'required',
                'password' => 'required'
            ], [
                'name.required' => '请填写用户名',
                'password.required' => '请填写密码',
            ]);
            if (Auth::Guard('admin')->attempt(['name' => $request->name, 'password' => $request->password])) {
                return redirect(action('AdminController@home'));
            } else {
                $this->incrementLoginAttempts($request); //验证失败时失败次数+1
                Session::flash('login_error', '用户名或密码错误');
                return Redirect::back()->withInput();
            }
        }
    }

    public function home()
    {
        return view('admin.home');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->action('AdminController@index');
    }

    public function searchUser(Request $request)
    {
        if ($request->userid !== '') {
            $userInfo = User::where('id', $request->userid)->first();
            return view('admin.showEditUserForm', compact('userInfo'));
        } elseif ($request->username !== '') {
            $userInfo = User::where('name', $request->username)->first();
            return view('admin.showEditUserForm', compact('userInfo'));
        } elseif ($request->useremail !== '') {
            $userInfo = User::where('email', $request->useremail)->first();
            return view('admin.showEditUserForm', compact('userInfo'));
        } else {
            return redirect()->back();
        }

    }

    public function updateUser(Request $request)
    {
        $updateUser = User::find($request->id);
        if ($request->userpassword == '') {
            $updateUser->update($request->all());
        } else {
            $data = [
                'password' => $request->userpassword,
            ];
            $updateUser->update(array_merge($request->all(), $data));
        }
        return redirect()->action('AdminController@home');
    }

    public function messageManagement()
    {
        return view('admin.messageManagement');
    }

    public function doSendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);
        $user_id_list = User::lists('id')->all();
        foreach ($user_id_list as $user_id) {
            $data = [
                'message' => $request->message,
                'user_id' => $user_id,
                'from_user_id' => 1,
            ];
            Message::create($data);
        }
        Session::flash('sendMessage_success', '群发消息成功');
        return redirect()->back();
    }

    public function delAllMsg()
    {
        Message::truncate();
        Session::flash('delAllMsg_success', '删除所有消息成功');
        return redirect()->back();
    }

    public function delUnreadMsg()
    {
        Message::where('isread', 0)->delete();
        Session::flash('delUnreadMsg_success', '删除未读消息成功');
        return redirect()->back();
    }

    public function delReadMsg()
    {
        Message::where('isread', 1)->delete();
        Session::flash('delReadMsg_success', '删除已读消息成功');
        return redirect()->back();
    }

    public function delMonthMsg()
    {
        $monthMsgTimeStamp = Carbon::now()->timestamp - 30 * 24 * 60 * 60;
        $monthMsgDate = Carbon::createFromTimestamp($monthMsgTimeStamp);
        Message::where('created_at', '<', $monthMsgDate)->delete();
        Session::flash('delReadMsg_success', '删除一个月前的消息成功');
        return redirect()->back();
    }

    public function announce()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announce', compact('announcements'));
    }

    public function addAnnounce(Request $request)
    {
        $this->validate($request, [
            'announcement' => 'required',
            'show' => 'required',
        ], [
            'announcement.required' => '请填写公告内容',
            'show.required' => '请选择是否展示此公告',
        ]);
        $data = [
            'user_id' => Auth::guard('admin')->user()->id,
        ];
        Announcement::create(array_merge($request->all(), $data));
        Session::flash('addAnnounce_success', '发表公告成功');
        return redirect()->action('AdminController@announce');
    }

    public function editAnnounce($id)
    {
        $announce = Announcement::findOrfail($id);
        return view('admin.editAnnounceForm', compact('announce'));
    }

    public function updateAnnounce(Request $request, $id)
    {
        $this->validate($request, [
            'announcement' => 'required',
            'show' => 'required',
        ], [
            'announcement.required' => '公告内容不能为空',
        ]);
        $updateAnnounce = Announcement::findOrfail($id);
        $data = [
            'user_id' => Auth::guard('admin')->user()->id,
        ];
        $updateAnnounce->update(array_merge($request->all(), $data));
        Session::flash('updateAnnounce_success', '更新公告成功');
        return redirect()->action('AdminController@announce');
    }

    public function delAnnounce($id)
    {
        Announcement::destroy($id);
        Session::flash('delAnnounce_success', '删除公告成功');
        return redirect()->action('AdminController@announce');
    }

    public function tags()
    {
        $tags = Tag::orderBy('tag_group')->get();
        return view('admin.tags',compact('tags'));
    }

    public function addTag(Request $request)
    {
        $this->validate($request,[
            'tag_name' => 'required|unique:tags,tag_name',
            'tag_group' => 'required'
        ],[
            'tag_name.required' =>'请填写一个节点（标签）名',
            'tag_name.unique' =>'节点（标签）名已存在',
            'tag_group.required' =>'请填写一个节点（标签）分类名',
        ]);
        Tag::create($request->all());
        Session::flash('addTag_success','添加节点（标签）成功');
        return redirect()->action('AdminController@tags');
    }

    public function editTags($id)
    {
        $tag = Tag::findOrfail($id);
        return view('admin.editTags',compact('tag'));
    }

    public function updateTags(Request $request,$id)
    {
        $tag = Tag::findOrfail($id);
        $this->validate($request,[
           'tag_name' => 'required|unique:tags,tag_name,'.$id,
            'tag_group' => 'required'
        ],[
            'tag_name.required' =>'请填写一个节点（标签）名',
            'tag_name.unique' =>'节点（标签）名已存在',
            'tag_group.required' =>'请填写一个节点（标签）分类名',
        ]);
        $tag->update($request->all());
        Session::flash('updateTags_success','更新节点（标签）成功');
        return redirect()->action('AdminController@tags');
    }

    public function delTags($id)
    {
        Tag::destroy($id);
        Session::flash('delTags_success','删除节点（标签）成功');
        return redirect()->action('AdminController@tags');
    }
}
