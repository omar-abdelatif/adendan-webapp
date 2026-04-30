<?php

namespace App\Imports;

use App\Models\Due;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSubscribersDues implements ToCollection, WithHeadingRow, WithBatchInserts, WithCalculatedFormulas {
    public function collection(Collection $collection) {
        foreach ($collection as $row) {
            Due::create([
                'member_id' => $row['member_id'],
                'item' => $row['item'],
                'total_amount' => $row['total_amount'],
                'amount_paid' => $row['amount_paid'],
                'amount_remaining' => $row['amount_remaining'],
                'transaction_type' => $row['transaction_type'],
            ]);
        }
    }
    function headingRow(): int {
        return 1;
    }

    function batchSize(): int {
        return 100;
    }
}
