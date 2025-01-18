<?php
namespace App\Controller;

class PostController
{
    public function index()
    {
        return 'Post Index Page';
    }
    public function show($id)
    {
        return "Post with id: $id";
    }

}