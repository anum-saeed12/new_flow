<?php
namespace App\Exports;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
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
        return view('exports.users', [
            'projects' => User::projects($this->user_id),
            'user_id' => $this->user_id
        ]);
    }
}
