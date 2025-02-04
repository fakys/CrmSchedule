<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $full_name
 * @property string $name
 * @property string $description
 */
class Subject extends Model{

    protected $table = 'subjects';

    protected $fillable = [
        'name',
        'full_name',
        'description',
    ];
}
