<?php

namespace App\Imports;

use App\Models\Fpregisteredemp;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesFPImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Fpregisteredemp([
            'name' => $row[0],
            'acc_no' => $row[1],
        ]);
    }
}
