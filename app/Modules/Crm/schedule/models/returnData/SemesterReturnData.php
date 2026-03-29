<?php
namespace App\Modules\Crm\schedule\models\returnData;

use App\Services\Forms\Domain\Services\FormReturnData\FromReturnDataInterface;
use App\Services\Forms\Infrastructure\Services\Attributes\FromReturnData\ReturnDataFieldAttribute;

class SemesterReturnData implements FromReturnDataInterface
{
    #[ReturnDataFieldAttribute('name')]
    private $name;

    #[ReturnDataFieldAttribute('date_start')]
    private $date_start;

    #[ReturnDataFieldAttribute('date_end')]
    private $date_end;

    #[ReturnDataFieldAttribute('year_start')]
    private $year_start;

    #[ReturnDataFieldAttribute('year_end')]
    private $year_end;

    public function getName()
    {
        return $this->name;
    }

    public function getDateStart()
    {
        return $this->date_start;
    }

    public function getDateEnd()
    {
        return $this->date_end;
    }

    public function getYearStart()
    {
        return $this->year_start;
    }

    public function getYearEnd()
    {
        return $this->year_end;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'date_start' => $this->getDateStart(),
            'date_end' => $this->getDateEnd(),
            'year_start' => $this->getYearStart(),
            'year_end' => $this->getYearEnd(),
        ];
    }
}
