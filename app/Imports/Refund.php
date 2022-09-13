<?php

namespace App\Imports;

use App\refunds;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Dotenv\Exception\ValidationException;


class Refund implements ToModel,WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
  
    public function model(array $row)
    {
        return new refunds([
            "order_num" => $row['order_num'],
            "reason" => $row["reason"],
            "status" => $row["status"],

        ]);
    }

    
    public function rules():array
    {
        return [
            '*.order_num' => ['required','unique:refunds,order_num'],
            '*.reason' => ['required'],
            '*.status' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'order_num.required' => 'Header: order_num is required',
            'order_num.unique' => 'Header: order_num must be unique',
            'reason.required' => 'Header: reason is required',
            'status.required' => 'Header: status is required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    $exception = ValidationException::withMessages(collect($failures)->map->toArray()->all());
    throw $exception;
    }
}
