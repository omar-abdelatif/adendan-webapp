<?php

namespace App\Imports;

use App\Models\Wedding;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class WeddingImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row){
            Wedding::create([
                'day' => $row['day'] ?? null,
                'date' => $row['date'] ?? null,
                'groom_name' => $row['groom_name'] ?? null,
                'pride_father_name' => $row['pride_father_name'] ?? null,
                'address' => $row['address'] ?? null,
                'from_time' => $this->parseExcelTime($row['from_time'] ?? null),
                'to_time' => $this->parseExcelTime($row['to_time'] ?? null),
            ]);
        }
    }

    private function parseExcelTime($value)
    {
        if (!$value) return null;

        // لو الوقت جاي كرقم (Excel time)
        if (is_numeric($value)) {
            $carbonTime = \Carbon\Carbon::instance(Date::excelToDateTimeObject($value));
            return $carbonTime->format('g:i A');
        }

        // لو string بصيغة وقت
        try {
            return \Carbon\Carbon::parse($value)->format('g:i A');
        } catch (\Exception $e) {
            return null; // فشل التحويل
        }
    }

    function headingRow(): int
    {
        return 1;
    }

    function batchSize(): int
    {
        return 100;
    }
}
