<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PaymentTransactions implements ToCollection, WithHeadingRow, WithBatchInserts, WithCalculatedFormulas {
    public function collection(Collection $collection) {
        foreach ($collection as $row) {
            $paymentDate = null;
            if (!empty($row['payment_date'])) {
                try {
                    if (is_numeric($row['payment_date'])) {
                        $paymentDate = Date::excelToDateTimeObject($row['payment_date'])->format('Y-m-d');
                    } else {
                        $timestamp = strtotime($row['payment_date']);
                        $paymentDate = $timestamp !== false ? date('Y-m-d', $timestamp) : null;
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
            paymentTransaction($row['member_id'], (int) $row['amount'] ?? 0, $paymentDate ?? null, trim($row['payment_method']), trim($row['payment_cat']), trim($row['transaction_type']), trim($row['transaction_cat']), trim($item), $row['inv_no']);
        }
    }
    function headingRow(): int {
        return 1;
    }
    function batchSize(): int {
        return 100;
    }
}
