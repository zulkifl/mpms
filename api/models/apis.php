<?php

namespace api\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class apis {

    public static function apigetlist() {
        return[
            1 => ['name' => 'Echo', 'function' => 'echo', 'method' => 'GET',
                'description' => 'Check availabliity of server',
                'parameters' => [],
                'replay' => []
            ],
            5 => ['name' => 'Get Categories', 'function' => 'getcategories', 'method' => 'GET',
                'description' => 'Gives the list of all categories',
                'parameters' => [['token', 'M']],
                'replay' => ['']
            ],
            7 => ['name' => 'Get States', 'function' => 'getstates', 'method' => 'GET',
                'description' => 'Gives the list of all states',
                'parameters' => [['token', 'M']],
                'replay' => ['']
            ],
            8 => ['name' => 'Get Cities', 'function' => 'getcities', 'method' => 'GET',
                'description' => 'Gives the list of mentioned cities',
                'parameters' => [['token', 'M']],
                'replay' => ['']
            ],
            11 => ['name' => 'Search Service Providers', 'function' => 'getserviceproviders', 'method' => 'GET',
                'description' => 'Gives the list of service providers on the basis of search criteria',
                'parameters' => [['token', 'M'], ['categoryId', 'O'], ['cityId', 'O'] ,['offset', 'O']],
                'replay' => ['']
            ],
            12 => ['name' => 'Get Service Provider Detail', 'function' => 'getserviceproviderdetail', 'method' => 'GET',
                'description' => 'Gives the detail about the specified service provider',
                'parameters' => [['token', 'M'], ['providerId', 'M']],
                'replay' => ['']
            ],
        ];
    }

    public static function apipostlist() {
        return[
        ];
    }

}
