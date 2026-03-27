<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $accesses
 * @property $description
 */
class UserGroup extends Model
{
    public $table = 'user_groups';
    protected $fillable = [
        'name',
        'accesses',
        'description'
    ];

    public function getAccesses()
    {
        if($this->accesses){
            return json_decode($this->accesses, 1);
        }
        return [];
    }
}
