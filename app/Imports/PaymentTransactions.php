<?php

namespace App\Imports;

use App\Models\PaymentTransaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PaymentTransactions implements ToCollection, WithHeadingRow, WithBatchInserts, WithCalculatedFormulas {
    public function collection(Collection $collection) {
        foreach ($collection as $row) {
            $paymentDate = null;
            if (!empty($row['payment_date'])) {
                try {
                    if (is_numeric($row['payment_date'])) {
                        $paymentDate = Date::excelToDateTimeObject($row['payment_date'])->format('Y-m-d');
                    } else {
                        $paymentDate = date('Y-m-d', strtotime($row['payment_date']));
                    }
                } catch (\Exception $e) {
                    $paymentDate = null;
                }
            }
            $item = $row['item'];
            if (is_numeric($item)) {
                try {
                    $item = Date::excelToDateTimeObject($item)->format('Y-m-d');
                } catch (\Exception $e) {}
            }
            PaymentTransaction::create([
                'member_id' => $row['member_id'],
                'item' => $item,
                'amount' => $row['amount'] ?? 0,
                'inv_no' => $row['inv_no'],
                'payment_date' => $paymentDate ?? '-',
                'payment_method' => $row['payment_method'],
                'payment_cat' => $row['payment_cat'],
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
