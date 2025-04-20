<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExcel implements FromArray, WithHeadings
{
    protected $data;

    const XLSX = 'xlsx';

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    public function headings(): array
    {
        return $this->data[0];
    }

    // Метод для данных
    public function array(): array
    {
        return array_slice($this->data, 1);
    }
}
