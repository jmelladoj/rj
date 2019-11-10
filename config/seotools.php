<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Las mejores escort de Concepción - PlacerConce.cl", // set false to total remove
            'description'  => 'Las mejores escort, escorts, prostitutas, putas y damas de compañia de concepcion te esperan', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['escort', 'escorts', 'prostitutas' , 'damas de compañia', 'concepcion', 'escort concepcion', 'escorts en concepcion', 'postitutas en concepcion', 'damas de compañia en concepcion', 'conce'],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Las mejores escort de Concepción - PlacerConce.cl', // set false to total remove
            'description' => 'Las mejores escort, escorts, prostitutas, putas y damas de compañia de concepcion te esperan', // set false to total remove
            'url'         => 'https://www.placerconce.cl/', // Set null for using Url::current(), set false to total remove
            'type'        => false,
            'site_name'   => 'Placer Conce',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
