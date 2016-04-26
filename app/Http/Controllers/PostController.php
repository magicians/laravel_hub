<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Comment;
use App\Discussion;
use App\Favourite;
use App\Like;
use App\Markdown\Parser;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    protected $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
        $this->middleware('auth:web', ['except' => ['index', 'show', 'essential', 'tags']]);
    }

    /**
     * 首页视图
     *
     * @param User $users
     * @param Comment $comments
     * @param Discussion $discuz
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $users, Comment $comments, Discussion $discuz)
    {
        $discussions = Discussion::with('user', 'comments')->orderBy('top', 'desc')->orderBy('created_at', 'desc')->paginate(20);
        $newcomments = Comment::orderBy('created_at', 'desc')->take(5)->get();
        $hotPosts = DB::select('SELECT discussion_id,count(discussion_id) AS counts FROM comments GROUP BY discussion_id ORDER BY counts DESC LIMIT 5');
        if ($announcements = Announcement::where('show', '1')->get()->toArray()) {
            $announcement_index = array_rand($announcements);
            $announcement = $this->parser->makeHtml($announcements[$announcement_index]['announcement']);
        }
        foreach ($hotPosts as $hotPost) {
            $hot[] = [
                'hotPostId' => $hotPost->discussion_id,
                'hotPostTitle' => Discussion::findOrFail($hotPost->discussion_id)->title,
                'howHot' => $hotPost->counts * 12
            ];
        }
        $tag_groups = Tag::groupBy('tag_group')->lists('tag_group');
        foreach ($tag_groups as $tag_group) {
            $intag = Tag::where('tag_group', $tag_group)->get();
            $tags[$tag_group] = $intag;
        }
        return view('post.index', compact('discussions', 'newcomments', 'users', 'comments', 'discuz', 'hot', 'announcement', 'tags'));
    }

    /**
     * 精华帖子页面
     *
     * @param User $users
     * @param Comment $comments
     * @param Discussion $discuz
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function essential(User $users, Comment $comments, Discussion $discuz)
    {
        $discussions = Discussion::where('essential', '1')->latest()->paginate(30);
        $newcomments = Comment::orderBy('created_at', 'desc')->take(5)->get();
        $hotPosts = DB::select('SELECT discussion_id,count(discussion_id) AS counts FROM comments GROUP BY discussion_id ORDER BY counts DESC LIMIT 5');
        if ($announcements = Announcement::where('show', '1')->get()->toArray()) {
            $announcement_index = array_rand($announcements);
            $announcement = $this->parser->makeHtml($announcements[$announcement_index]['announcement']);
        }
        foreach ($hotPosts as $hotPost) {
            $hot[] = [
                'hotPostId' => $hotPost->discussion_id,
                'hotPostTitle' => Discussion::findOrFail($hotPost->discussion_id)->title,
                'howHot' => $hotPost->counts * 12
            ];
        }
        $tag_groups = Tag::groupBy('tag_group')->lists('tag_group');
        foreach ($tag_groups as $tag_group) {
            $intag = Tag::where('tag_group', $tag_group)->get();
            $tags[$tag_group] = $intag;
        }
        return view('post.essential', compact('discussions', 'newcomments', 'users', 'comments', 'discuz', 'hot', 'announcement', 'tags'));

    }

    public function tags(User $users, Comment $comments, Discussion $discuz, $name)
    {
        $discussions = Tag::where('tag_name', $name)->first()->discussions()->latest()->paginate(30);
        $newcomments = Comment::orderBy('created_at', 'desc')->take(5)->get();
        $hotPosts = DB::select('SELECT discussion_id,count(discussion_id) AS counts FROM comments GROUP BY discussion_id ORDER BY counts DESC LIMIT 5');
        if ($announcements = Announcement::where('show', '1')->get()->toArray()) {
            $announcement_index = array_rand($announcements);
            $announcement = $this->parser->makeHtml($announcements[$announcement_index]['announcement']);
        }
        foreach ($hotPosts as $hotPost) {
            $hot[] = [
                'hotPostId' => $hotPost->discussion_id,
                'hotPostTitle' => Discussion::findOrFail($hotPost->discussion_id)->title,
                'howHot' => $hotPost->counts * 12
            ];
        }
        $tag_groups = Tag::groupBy('tag_group')->lists('tag_group');
        foreach ($tag_groups as $tag_group) {
            $intag = Tag::where('tag_group', $tag_group)->get();
            $tags[$tag_group] = $intag;
        }
        return view('post.tags', compact('discussions', 'newcomments', 'users', 'comments', 'discuz', 'hot', 'announcement', 'tags', 'name'));
    }


    /**
     * 根据帖子ID显示单页帖子内容
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function show(Parser $makeHtml, $id)
    {
        $discussion = Discussion::with('comments', 'tags')->find($id);
        $discussion->like_count = count(Like::where('like_type', 'App\Discussion')->where('like_id', $id)->get());
        $comments = $discussion->comments()->latest()->get();
        $floor = count($comments);
        foreach ($comments as $comment) {
            $comment->floor = $floor;
            $floor--;
        }
        if (Auth::guard('web')->check()) {
            $isfavourite = Favourite::where('discussion_id', $discussion->id)->where('user_id', Auth::guard('web')->user()->id)->get();
        } else {
            $isfavourite = null;
        }

        $tags = $discussion->tags()->with('discussions')->take(10)->get(); //取得和这个帖子相关的tag
        $related_discussions = []; //最终取得帖子列表
        $already_have = [$discussion->id]; //排除列表
        foreach ($tags as $tag) { //开始循环每个tag下的帖子
            $related_collections = $tag->discussions;
            //开始检查是否有重复,以免不同tag下的相同帖子撞车
            foreach ($related_collections as $related_collection) {
                if (!in_array($related_collection->id, $already_have)) { //如果列表里没有这张帖子
                    $already_have[] = $related_collection->id; //把这个帖子的id加入排队列表
                    $related_discussions[] = $related_collection;
                }
            }
        }

        return view('post.show', compact('discussion', 'makeHtml', 'comments', 'isfavourite', 'related_discussions'));
    }


    /**
     * 显示发表帖子页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::lists('tag_name', 'id');
        return view('post.create', compact('tags'));
    }

    /**
     * 发表帖子,存入数据库
     *
     * @param Requests\StorePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Requests\StorePostRequest $request)
    {
        $postData = [
            'user_id' => Auth::Guard('web')->user()->id,
        ];
        $discussion = Discussion::create(array_merge($request->all(), $postData));
        $discussion->tags()->attach($request->tags);
        return redirect()->action('PostController@show', ['id' => $discussion->id]);
    }

    /**
     * 帖子编辑页面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        //前台管理员和帖子所有者可以进入编辑页面
        $postData = Discussion::findOrfail($id);
        $tags = Tag::lists('tag_name', 'id');
        if (Auth::Guard('web')->user()->admin == 1) {
            return view('post.edit', compact('postData', 'tags'));
        } elseif (Auth::Guard('web')->user()->id == $postData->user_id) {
            return view('post.edit', compact('postData', 'tags'));
        } else {
            return redirect(url('/'));
        }

    }

    /**
     * 帖子更新方法
     *
     * @param Requests\StorePostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Requests\StorePostRequest $request, $id)
    {
        //检查权限
        if (Auth::Guard('web')->user()->admin == 1 || Discussion::findOrfail($id)->user->id == Auth::Guard('web')->user()->id) {
            $updateData = [
                'title' => $request->title,
                'contents' => $request->contents,
                'update_info' => '本帖最后由 ' . Auth::Guard('web')->user()->name . '・于 ' . Carbon::now() . ' 更新.'
            ];
            $discussion = Discussion::findOrfail($id);
            $discussion->update($updateData);
            $discussion->tags()->sync($request->tags);
            return redirect(action('PostController@show', ['id' => $id]));
        } else {
            return redirect('/');
        }

    }

    /**
     * 删除帖子
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        if (Auth::Guard('web')->user()->admin == 1 || Auth::Guard('web')->user()->id == Discussion::findOrfail($id)->user->id) {
            Discussion::destroy($id);
            Session::flash('delete_success', '帖子删除成功!');
            return redirect(url('/'));
        } else {
            return redirect(url('/'));
        }
    }


    public function setEssential($id, $method)
    {
        if (Auth::Guard('web')->user()->admin == 1) {
            $setEssential = Discussion::findOrfail($id);
            if ($method == 'set') {
                $setEssential->essential = 1;
                if ($setEssential->save()) {
                    Session::flash('setEssential_success', '设置精华成功');
                    return redirect(action('PostController@show', ['id' => $id]));
                }
            } elseif ($method == 'drop') {
                $setEssential->essential = 0;
                if ($setEssential->save()) {
                    Session::flash('setEssential_success', '取消精华成功');
                    return redirect(action('PostController@show', ['id' => $id]));
                }
            }

        } else {
            return redirect('/');
        }
    }

    public function setTop($id, $method)
    {
        if (Auth::Guard('web')->user()->admin == 1) {
            $setTop = Discussion::findOrfail($id);
            if ($method == 'set') {
                $setTop->top = 1;
                if ($setTop->save()) {
                    Session::flash('setTop_success', '设置置顶成功');
                    return redirect(action('PostController@show', ['id' => $id]));
                }
            } elseif ($method == 'drop') {
                $setTop->top = 0;
                if ($setTop->save()) {
                    Session::flash('setTop_success', '取消置顶成功');
                    return redirect(action('PostController@show', ['id' => $id]));
                }
            }

        } else {
            return redirect('/');
        }
    }

    public function preview(Request $request, $type)
    {
        if ($type == 'createDiscussion') {
            $previewHtml = $this->parser->makeHtml($request->contents);
        }
        return $previewHtml;
    }

    public function like($id)
    {
        $user_id = Auth::Guard('web')->user()->id;
        if (count(Like::where('user_id', $user_id)->where('like_type', 'App\Discussion')->where('like_id', $id)->get())) {
            Session::flash('already_like_post', '你已经赞过这篇文章了');
            return Redirect::back();
        } else {
            Discussion::find($id)->likes()->create([
                'user_id' => $user_id
            ]);
            return Redirect::back();
        }
    }

    public function favourite($id)
    {
        $discussion = Discussion::find($id);
        $user_id = Auth::guard('web')->user()->id;
        if (count(Favourite::where('discussion_id', $id)->where('user_id', $user_id)->get())) {
            //已经收藏过的话就取消收藏
            $discussion->favourite()->detach($user_id);
            return redirect()->back();
        } else {
            //否则就加入收藏
            $discussion->favourite()->attach($user_id);
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        $this->validate($request,[
           'keywords' => 'required',
        ]);
        $keywords = $request->keywords;
        $discussions = Discussion::where('title', 'like', '%' . $request->keywords . '%')->latest()->paginate(20);
        return view('post.search', compact('discussions', 'keywords'));

    }

}
   
