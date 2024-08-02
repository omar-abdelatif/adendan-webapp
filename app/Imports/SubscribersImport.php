<?php

namespace App\Imports;

use App\Models\Subscribers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class SubscribersImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $birthdate = null;
            if ($row['birthdate'] instanceof \PhpOffice\PhpSpreadsheet\Shared\Date) {
                $birthdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthdate'])->format('Y-m-d');
            } elseif (is_numeric($row['birthdate'])) {
                $birthdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthdate'])->format('Y-m-d');
            } else {
                $birthdate = date('Y-m-d', strtotime($row['birthdate']));
            }
            Subscribers::create([
                'member_id'                 => $row['member_id'],
                'name'                      => $row['name'],
                'nickname'                  => $row['nickname'],
                'ssn'                       => $row['ssn'],
                'address'                   => $row['address'],
                'educational_qualification' => $row['educational_qualification'],
                'qualification_date'        => $row['qualification_date'],
                'job'                       => $row['job'],
                'job_destination'           => $row['job_destination'],
                'job_tel'                   => $row['job_tel'],
                'job_address'               => $row['job_address'],
                'home_tel'                  => $row['home_tel'],
                'martial_status'            => $row['martial_status'],
                'birthdate'                 => $birthdate,
                'mobile_no'                 => $row['mobile_no'],
                'membership_type'           => $row['membership_type'],
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
