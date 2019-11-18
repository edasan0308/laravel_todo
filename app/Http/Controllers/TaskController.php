<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;

class TaskController extends Controller
{
    public function index(int $id)
    {
        //Folderモデルより全てのフォルダデータを取得
        $folders = Folder::all();

        //Folderモデルより$idに一致するフォルダデータを取得
        $current_folder = Folder::find($id);

        //Taskモデルより、folder_idとcurrent_folder->idで一致するものを取得
        //OLD::$tasks = Task::where('folder_id', $current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [ 
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        //idに該当するフォルダー情報を取得
        $current_folder = Folder::find($id);

        //Taskクラスのインスタンス生成
        $task = new Task();
        //Requestデータを変数に当てはめていく
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        //フォルダに対してタスクの保存
        //たしかFolder::findはDBでのリレーションを考慮してその周辺情報まで読み込んでくれる
        //つまり、current_folderのtaskとしてsaveすると読める
        $current_folder->tasks()->save($task);

        //リダイレクト処理、今回作成したタスクを扱うフォルダidのタスク一覧画面へ
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    public function showEditForm(int $id, int $task_id) 
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }
}
