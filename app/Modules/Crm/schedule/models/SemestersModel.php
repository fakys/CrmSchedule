<?php
namespace App\Modules\Crm\schedule\models;

use App\Src\BackendHelper;
use App\Src\modules\models\InterfaceModel;
use App\Src\modules\models\Model;
use Illuminate\Validation\ValidationException;


/**
 * @property $name
 * @property $year_start
 * @property $year_end
 * @property $date_start
 * @property $date_end
 */
class SemestersModel extends Model implements InterfaceModel
{
    public $id;
    public function fields(): array
    {
        return [
            'name',
            'date_start',
            'date_end',
            'year_start',
            'year_end',
        ];
    }

    //Сделать валидацию
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'date_start' => ['required', 'date', 'before:date_end'],
            'date_end' => ['required', 'date'],
            'year_start' => ['required', 'integer', 'min:2020', 'max:2050'],
            'year_end' => ['required', 'integer', 'min:2020', 'max:2050', 'gte:year_start'],
        ];
    }

    public function boolean(): array
    {
        return [
        ];
    }

    public function dateValidate()
    {
        $semesters = BackendHelper::getRepositories()->getAllSemesters();
        foreach ($semesters as $semester) {
            if (
                $this->id != $semester->id &&
                ((new \DateTime($this->date_start) >= new \DateTime($semester->date_start) && new \DateTime($this->date_end) >= new \DateTime($semester->date_end) && new \DateTime($this->date_start) <= new \DateTime($semester->date_end)) ||
                (new \DateTime($this->date_start) <= new \DateTime($semester->date_start) && new \DateTime($this->date_end) >= new \DateTime($semester->date_end)) ||
                (new \DateTime($this->date_start) <= new \DateTime($semester->date_start) && new \DateTime($this->date_end) <= new \DateTime($semester->date_end) && new \DateTime($this->date_end) >= new \DateTime($semester->date_start)))
            ) {
                throw ValidationException::withMessages([
                    'date_start' => ['Дата входит в другой семестр'],
                    'date_end' => ['Дата входит в другой семестр'],
                ]);
            } elseif (
                $this->year_start > (new \DateTime($this->date_start))->format('Y') ||
                $this->year_end < (new \DateTime($this->date_end))->format('Y')
            ) {
                throw ValidationException::withMessages([
                    'date_start' => ['Дата входит за учебный год'],
                    'date_end' => ['Дата входит за учебный год'],
                ]);
            }
        }
        return true;
    }

}
