<?php
namespace App\Controller\Admin;

use Core\View;
use Core\Router;
use App\Models\Post;
use App\Services\Auth;
use App\Services\Authorization;

class PostController
{
    public function index()
    {
        Authorization::verify('dashboard');
        return View::render(
            template:'admin/post/index',
            layout:'layouts/admin',
            data:['posts' => Post::all()]);
    }

    public function create()
    {
        Authorization::verify('create_post');
       
        return View::render(
            template:'admin/post/create',
            layout:'layouts/admin',
            );
    }
    public function store()
    {
        Authorization::verify('create_post');
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => Auth::user()->id,
        ];
        Post::create($data);
        Router::redirect('/admin/posts');
    }
    public function edit($id)
    {
        $post = Post::find($id);
        Authorization::verify('edit_post', $post);
        return View::render(
            template:'admin/post/edit',
            layout:'layouts/admin',
            data:['post' => $post]);
    }
    public function update($id)
    {
        $post = Post::find($id);
        Authorization::verify('edit_post', $post);
        $post->title = $_POST['title'];
        $post->content = $_POST['content'];
        $post->save();
        Router::redirect('/admin/posts');
    }
    public function destroy($id)
    {
        $post = Post::find($id);
        Authorization::verify('delete_post', $post);
        $post->delete();
        Router::redirect('/admin/posts');
    }
}