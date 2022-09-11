<?php

namespace App\Imports;

use App\orders;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new orders([
            "order_date" => $row["order_date"],
            "channel" => $row["channel"],
            "sku" => $row["sku"],
            "item_description" => $row["item_description"],
            "origin" => $row["origin"],
            "so" => $row["so"],
            "total_price" => $row["total_price"],
            "cost" => $row["cost"],
            "shipping_cost" => $row["shipping_cost"],
            "profit" => $row["profit"],
        ]);
    }
}
