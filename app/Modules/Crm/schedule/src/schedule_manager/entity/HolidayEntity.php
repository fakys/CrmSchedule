<?php
namespace App\Modules\Crm\schedule\src\schedule_manager\entity;


class HolidayEntity
{
    private $holiday_name;
    private $holiday_date_start;
    private $holiday_date_end;
    private $holiday_description;
    private $holiday_format_type_id;
    private $holiday_use_weekday;

    public function getHolidayName()
    {
        return $this->holiday_name;
    }

    public function setHolidayName($holiday_name)
    {
        $this->holiday_name = $holiday_name;
    }

    public function getHolidayDateStart()
    {
        return $this->holiday_date_start;
    }

    public function setHolidayDateStart($holiday_date_start)
    {
        $this->holiday_date_start = $holiday_date_start;
    }

    public function getHolidayDateEnd()
    {
        $this->holiday_date_end = $this->holiday_date_start;
    }

    public function getHolidayDescription()
    {
        return $this->holiday_description;
    }

    public function setHolidayDescription($holiday_description)
    {
        $this->holiday_description = $holiday_description;
    }

    public function getHolidayFormatType()
    {
        return $this->holiday_format_type_id;
    }

    public function setHolidayFormatType($holiday_format_type_id)
    {
        $this->holiday_format_type_id = $holiday_format_type_id;
    }

    public function getHolidayUseWeekday()
    {
        return $this->holiday_use_weekday;
    }

    public function setHolidayUseWeekday($holiday_use_weekday)
    {
        $this->holiday_use_weekday = $holiday_use_weekday;
    }
    public function setHolidayDateEnd($holiday_date_end)
    {
        $this->holiday_date_end = $holiday_date_end;
    }
}
