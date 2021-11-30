<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';
    protected $hidden = ['password','remember_token'];
    protected $fillable = ['email', 'username', 'password', 'user_role', 'created_by'];

    public function task()
    {
        return $this->hasMany(TaskUser::class,'user_id');
    }

    public static function projects($id)
    {
        $task_user = (new TaskUser())->getTable();
        $project = (new Project())->getTable();
        $task = (new Task())->getTable();
        $select = [
            "{$project}.id"
        ];
        $project_ids = TaskUser::select($select)
            ->join($task, "{$task}.id","=","{$task_user}.task_id")
            ->leftJoin($project, "{$project}.id", "=", "{$task}.project_id")
            ->where("{$task_user}.user_id", $id)
            ->groupBy("{$project}.id")
            ->get();

        $projects = Project::whereIn('id', $project_ids)->with('tasks')->get();
        return $projects;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */

    public function getJWTCustomClaims()
    {
        return [];
    }
}
