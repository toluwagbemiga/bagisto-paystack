<?php

return [
    [
        'key'    => 'sales.payment_methods.paystack',
        'name'   => 'Paystack',
        'sort'   => 4,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'paystack::app.admin.system.title',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'description',
                'title'         => 'paystack::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' => false,
                'locale_based'  => true,
            ],[
                'name'          => 'image',
                'title'         => 'paystack::app.admin.system.image',
                'type'          => 'image',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name'          => 'active',
                'title'         => 'paystack::app.admin.system.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ] , [
                'name'          => 'sandbox',
                'title'         => 'paystack::app.admin.system.sandbox',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],[
                'name'          => 'profile_id',
                'title'         => 'paystack::app.admin.system.profile-id',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,true',
                'channel_based' => false,
                'locale_based'  => false,
            ], [
                'name'          => 'access_key',
                'title'         => 'paystack::app.admin.system.access-key',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,true',
                'channel_based' => false,
                'locale_based'  => false,
            ], [
                'name'          => 'secret_key',
                'title'         => 'paystack::app.admin.system.secret-key',
                'type'          => 'text',
                'depends'       => 'active:1',
                'validation'    => 'required_if:active,true',
                'channel_based' => false,
                'locale_based'  => false,
            ]
        ]
    ]
];
