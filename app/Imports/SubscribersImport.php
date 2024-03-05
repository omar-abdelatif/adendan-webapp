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
            Subscribers::create([
                'ssn'                       => $row['ssn'],
                'job'                       => $row['job'],
                'name'                      => $row['name'],
                'job_tel'                   => $row['job_tel'],
                'address'                   => $row['address'],
                'nickname'                  => $row['nickname'],
                'home_tel'                  => $row['home_tel'],
                'member_id'                 => $row['member_id'],
                'birthdate'                 => $row['birthdate'],
                'mobile_no'                 => $row['mobile_no'],
                'job_address'               => $row['job_address'],
                'martial_status'            => $row['martial_status'],
                'membership_type'           => $row['membership_type'],
                'job_destination'           => $row['job_destination'],
                'qualification_date'        => $row['qualification_date'],
                'educational_qualification' => $row['educational_qualification'],
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
