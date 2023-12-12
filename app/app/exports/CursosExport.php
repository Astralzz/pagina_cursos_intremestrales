<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CursosExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Encabezados de las columnas
        return array_keys($this->data[0]);
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo colana C / index 2
        $sheet->getColumnDimension('C')->setWidth(30);

    }
}
