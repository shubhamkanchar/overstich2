<?php
return [
    'test' =>[
        'pincode'=>'https://staging-express.delhivery.com/c/api/pin-codes/json/',
        'waybill' => 'https://staging-express.delhivery.com/waybill/api/bulk/json/?count=1',
        'warehouse-create' => 'https://staging-express.delhivery.com/api/backend/clientwarehouse/create/',
        'warehouse-edit' => 'https://staging-express.delhivery.com/api/backend/clientwarehouse/edit/',
        'shipment-create' => 'https://staging-express.delhivery.com/api/cmu/create.json',
        'slip' => 'https://staging-express.delhivery.com/api/p/packing_slip',
        'pickup'=>'https://staging-express.delhivery.com/fm/request/new/'
    ],
    'live' =>[
        'pincode'=>'https://track.delhivery.com/c/api/pin-codes/json/',
        'waybill' => 'https://track.delhivery.com/waybill/api/bulk/json/?count=1',
        'warehouse-create' => 'https://track.delhivery.com/api/backend/clientwarehouse/create/',
        'warehouse-edit' => 'https://track.delhivery.com/api/backend/clientwarehouse/edit/',
        'shipment-create' => 'https://track.delhivery.com/api/cmu/create.json',
        'slip' => 'https://track.delhivery.com/api/p/packing_slip',
        'pickup' => 'https://track.delhivery.com/fm/request/new/'
    ]
];
?>