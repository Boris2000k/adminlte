<?php

namespace App\Imports;

use App\orders;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Dotenv\Exception\ValidationException;


class Order implements ToModel,WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   
  
    public function model(array $row)
    {
        return new orders([
            "order_date" => $row['order_date'],
            "channel" => $row["channel"],
            "sku" => $row["sku"],
            "item_description" => $row["item_description"],
            "origin" => $row["origin"],
            "so_num" => $row["so_num"],
            "total_price" => $row["total_price"],
            "cost" => $row["cost"],
            "shipping_cost" => $row["shipping_cost"],
            "profit" => $row["profit"],
        ]);
    }

    
    public function rules():array
    {
        return [
            '*.order_date' => ['required'],
            '*.channel' => ['required'],
            '*.sku' => ['required','unique:orders,sku'],
            '*.item_description' => ['required'],
            '*.origin' => ['required'],
            '*.so_num' => ['required'],
            '*.total_price' => ['required'],
            '*.cost' => ['required'],
            '*.shipping_cost' => ['required'],
            '*.profit' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'order_date.required' => 'Header: order_date is required',
            'channel.required' => 'Header: channel is required',
            'sku.required' => 'Header: sku is required',
            'sku.unique' => 'Header: sku must be unique',
            'item_description.required' => 'Header: item_description is required',
            'origin.required' => 'Header: origin is required',
            'so_num.required' => 'Header: so_num is required',
            'total_price.required' => 'Header: total_price is required',
            'cost.required' => 'Header: cost is required',
            'shipping_cost.required' => 'Header: shipping_cost is required',
            'profit.required' => 'Header: profit is required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    $exception = ValidationException::withMessages(collect($failures)->map->toArray()->all());
    throw $exception;
    }
}
