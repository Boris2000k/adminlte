<?php

return[
    'data' => [
        'orders'              => [
            "label"               => "Import Orders",
            "permission_required" => "import-orders",
            "files"               => [
                "ds_sheet" => [
                    "label"   => "DS Sheet",
                    "headers_to_db" => [
                        'Order Date'       => 'order_date',
                        'Channel'          => 'channel',
                        'SKU'              => 'sku',
                        'Item Description' => 'item_description',
                        'Origin'           => 'origin',
                        'SO'              => 'so_num',
                        'Total Price'      => 'total_price',
                        'Cost'             => 'cost',
                        'Shipping Cost'    => 'shipping_cost',
                        'Profit'           => 'profit'
                    ],
                ],
        
            ],
        ],
        
            'refunds' => [
            "label"             => "Import Refunds",
            "permission_required" => "import-refunds",
            "files"             => [
                "ds_sheet" => [
                    "label"     => "DS Sheet",
                    "headers_to_db" => [
                        'Order#'            => 'order_num',
                        'Reason'            => 'reason',
                        'Status'            => 'status',
                    ],
                ],
            ],
        
        ],

        // 'gifts' => [
        //     "label"             => "Import Gifts",
        //     "permission_required" => "import-gifts",
        //     "files"             => [
        //         "ds_sheet" => [
        //             "label"     => "DS Sheet",
        //             "headers_to_db" => [
        //                 'Product name'            => 'product_name',
        //                 'Message'            => 'message',
        //                 'Delivery Address'            => 'delivery',
        //             ],
        //         ],
        //     ],
        
        // ],
        
    ],
    ];

?>