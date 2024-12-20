<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    public $table = 'groups_users';
    protected $fillable = [
        'user_group_id',
        'users_id',
    ];
}
