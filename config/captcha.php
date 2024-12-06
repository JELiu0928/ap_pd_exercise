<?php

return [

    // 'characters' => '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ',
    'characters' => '0123456789',

    'default'   => [
        'length'    => 4,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'lines'     => false,
        'bgColor'   => '#FFFFFF',
        'fontColors'=> ['#009FCC'],
        'expire' => 18000,

    ],

    'flat'   => [
        'length'    => 4,
        'width'     => 70,
        'height'    => 30,
        'quality'   => 90,
        'lines'     => 0,
        'bgImage'   => false,
        'bgColor'   => '#FFF',
        'fontColors'=> ['#1447C7'],
        'contrast'  => -5,
        'expire' => 18000,
    ],

    'mini'   => [
        'length'    => 3,
        'width'     => 60,
        'height'    => 32,
        'expire' => 18000,
    ],

    'inverse'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'sensitive' => true,
        'angle'     => 12,
        'sharpen'   => 10,
        'blur'      => 2,
        'invert'    => true,
        'contrast'  => -5,
        'expire' => 18000,
    ]

];
