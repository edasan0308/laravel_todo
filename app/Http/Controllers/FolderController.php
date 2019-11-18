<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
use App\Folder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request)
    {
        //フォルダのインスタンスを立てる
        $folder = new Folder();
        //リクエストのタイトル情報を取得
        $folder->title = $request->title;
        //インスタンス状態をDBに書き込む
        $folder->save();

        //フォルダ作成後はタスク一覧画面の新規フォルダの画面に遷移する
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
    
}