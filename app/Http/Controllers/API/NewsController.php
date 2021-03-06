<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function onePost($id){
        $post = News::findOrFail($id);
        return new NewsResource($post);
    }

    public function index(){
        return NewsResource::collection(News::orderBy('created_at' , 'desc')->paginate(6));
    }

    public function create(Request $request)
    {
       $news =  request()->validate([
            'title' => 'required',
            'info' => 'required'
        ]);

       if(News::create($news)){
           return "NEWS POST CREATED!";
       }else{
           return "Unable to Create News Post!";
       }
    }

    public function update(Request $request)
    {
       $news =  request()->validate([
            'id' => 'required',
            'title' => 'required',
            'info' => 'required'
        ]);

       $post = News::findOrFail($request->input('id'));
       if($post->update($news)){
           return "NEWS POST UPDATED!";
       }else{
           return "Unable to Update News Post!";
       }

    }

    public function destroy($id){
        News::findOrFail($id)->delete();
    }
}
