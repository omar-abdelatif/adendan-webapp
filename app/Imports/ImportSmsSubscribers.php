<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\SMSSubscribers;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class importSmsSubscribers implements ToCollection, WithHeadingRow, WithBatchInserts {
    public function collection(Collection $collection) {
        foreach ($collection as $row) {
            SMSSubscribers::create([
                'member_id' => is_numeric(trim((string) ($row['member_id'] ?? ''))) ? (int) trim($row['member_id']) : null,
                'mobile_no' => $row['mobile_no'],
                'amount' => $row['amount'],
                'subscription_start_date' => $this->parseExcelDate($row['subscription_start_date']),
                'subscription_expiry_date' => $this->parseExcelDate($row['subscription_expiry_date']),
                'active_sms' => $row['active_sms'],
            ]);
        }
    }
        function headingRow(): int {
        return 1;
    }
    function batchSize(): int {
        return 100;
    }
    private function parseExcelDate($value) {
        if ($value === null || $value === '') {
            return null;
        }
        try {
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
            }
            if ($value instanceof \DateTime) {
                return Carbon::instance($value)->format('Y-m-d');
            }
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            logger()->error('Date Parse Error', [
                'value' => $value,
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
