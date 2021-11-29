<?php
namespace App\Exports;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectExport implements FromView
{
    public function view(): View
    {
        return view('exports.projects', [
            'projects' => Project::with('tasks')->get()
        ]);
    }
}
