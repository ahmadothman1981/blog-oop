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
        return View::render(
            template:'admin/posts/index',
            layout:'layouts/admin',
            data:['posts' => Post::all()]);
    }

    public function create()
    {
        return View::render(
            template:'admin/posts/create',
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
        return View::render(
            template:'admin/posts/edit',
            layout:'layouts/admin',
            data:['posts' => Post::find($id)]);
    }
    public function update($id)
    {
        $post = Post::find($id);
        Authorization::verify('edit_post', $post);
        $post = $_POST['title'];
        $post = $_POST['content'];
        $post->save();
        Router::redirect('/admin/posts');
    }
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        Router::redirect('/admin/posts');
    }
}