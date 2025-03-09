<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $name
 * @property $description
 * @property $created_at
 * @property $updated_at
 */
class FormatLesson extends Model {
    protected $table = 'format_lessons';
}
