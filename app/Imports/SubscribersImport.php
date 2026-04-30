<?php

namespace App\Imports;

use App\Models\Subscribers;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class SubscribersImport implements ToCollection, WithHeadingRow, WithBatchInserts {
    public function collection(Collection $collection) {
        foreach ($collection as $row) {
            $birthdate = null;
            if (!empty($row['birthdate'])) {
                if (is_numeric($row['birthdate'])) {
                    $birthdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthdate'])->format('Y-m-d');
                } else {
                    $birthdate = date('Y-m-d', strtotime($row['birthdate']));
                }
            }
            Subscribers::updateOrCreate(
                ['member_id' => $row['member_id']],
                [
                    'name' => $row['name'] ?? null,
                    'slug' => isset($row['name']) ? Str::slug(strtolower($row['name'])) : null,
                    'nickname' => $row['nickname'] ?? null,
                    'ssn' => $row['ssn'] ?? null,
                    'address' => $row['address'] ?? null,
                    'educational_qualification' => $row['educational_qualification'] ?? null,
                    'qualification_date' => $row['qualification_date'] ?? null,
                    'job' => $row['job'] ?? null,
                    'job_destination' => $row['job_destination'] ?? null,
                    'job_tel' => $row['job_tel'] ?? null,
                    'job_address' => $row['job_address'] ?? null,
                    'home_tel' => $row['home_tel'] ?? null,
                    'martial_status' => $row['martial_status'] ?? null,
                    'birthdate' => $birthdate ?? null,
                    'mobile_no' => $row['mobile_no'] ?? null,
                    'membership_type' => $row['membership_type'] ?? null,
                ]
            );
        }
    }
    function headingRow(): int {
        return 1;
    }
    function batchSize(): int {
        return 100;
    }
}
