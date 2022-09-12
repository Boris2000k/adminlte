<?php

namespace App\Imports;

use App\orders;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Dotenv\Exception\ValidationException;
use Carbon\Carbon;




class OrdersImport implements ToModel,WithHeadingRow, WithValidation
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
            'order_date.required' => 'Header: Order Date is required',
            'channel.required' => 'Header: Channel is required',
            'sku.required' => 'Header: SKU is required',
            'sku.unique' => 'Header: SKU must be unique',
            'item_description.required' => 'Header: Item Description is required',
            'origin.required' => 'Header: Origin is required',
            'so_num.required' => 'Header: SO# is required',
            'total_price.required' => 'Header: Total Price is required',
            'cost.required' => 'Header: Cost is required',
            'shipping_cost.required' => 'Header: Shipping Cost is required',
            'profit.required' => 'Header: Profit is required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    $exception = ValidationException::withMessages(collect($failures)->map->toArray()->all());

    throw $exception;
    }

    
}
