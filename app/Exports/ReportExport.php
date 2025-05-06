<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromArray, WithHeadings
{
    protected $rows;
    protected $columns;

    public function __construct(array $rows, array $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return array_map(fn($col) => $col['label'], $this->columns);
    }
}
