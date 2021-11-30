<?php
namespace App\Exports;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
    public $user_id;
    public function __construct($user_id=null)
    {
        $this->user_id = $user_id;
    }

    public function view(): View
    {
        $task_user = (new TaskUser())->getTable();
        $project = (new Project())->getTable();
        $task = (new Task())->getTable();
        $select = [
            "{$project}.id",
            "{$project}.title",
            "{$project}.description",
            "{$project}.sorting_order",
            "{$project}.created_by",
            "{$project}.updated_by",
        ];
        return view('exports.users', [
            'projects' => TaskUser::select($select)
                ->join($task, "{$task}.id","=","{$task_user}.task_id")
                ->leftJoin($project, "{$project}.id", "=", "{$task}.project_id")
                ->where("{$task_user}.user_id", $this->user_id)
                ->groupBy("{$task}.project_id")
                ->with('tasks')
                ->get()
        ]);
    }
}
