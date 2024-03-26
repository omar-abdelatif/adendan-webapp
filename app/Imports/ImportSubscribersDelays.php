<?php

namespace App\Imports;

use App\Models\Olddelays;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;


class ImportSubscribersDelays implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Olddelays::create([
                'amount' => $row['amount'],
                'member_id' => $row['member_id'],
                'delay_period' => $row['delay_period'],
            ]);
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
