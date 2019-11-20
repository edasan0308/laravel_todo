<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(int $id)
    {
        //Folderモデルより全てのフォルダデータを取得
        $folders = Auth::user()->folders()->get();

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

    /**
     * GET /folders/{id}/tasks/{task_id}/edit
     */
    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        //$task_idに該当するタスク情報を取得する
        $task = Task::find($task_id);
    
        //requestに乗せられているフォームからのデータをモデル変数に割り当てて、DBに保存
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
    
        //リダイレクト処理、タスク一覧画面へ、その時の表示ページはタスクを登録したフォルダの状態
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
