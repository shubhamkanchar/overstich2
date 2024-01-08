<?php
return [
    'test' =>[
        'pincode'=>'https://staging-express.delhivery.com/c/api/pin-codes/json/',
        'waybill' => 'https://staging-express.delhivery.com/waybill/api/bulk/json/',
        'warehouse-create' => 'https://staging-express.delhivery.com/api/backend/clientwarehouse/create/'
    ],
    'live' =>[
        'pincode'=>'https://track.delhivery.com/c/api/pin-codes/json/',
        'waybill' => 'https://staging-express.delhivery.com/waybill/api/bulk/json/',
        'warehouse-create' => 'https://track.delhivery.com/api/backend/clientwarehouse/create/'
    ]
];
?>