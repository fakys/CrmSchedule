<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $description
 */
class Specialty extends Model{

    protected $table = 'specialties';

    protected $fillable = [
        'number',
        'name',
        'description',
    ];

    /**
     * @return StudentGroup[]
     */
    public function getGroups()
    {
        return StudentGroup::where(['specialty_id' => $this->id])->get();
    }
}
