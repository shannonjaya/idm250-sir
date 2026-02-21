<?php

require_once __DIR__ . '/db-connect.php';
require_once __DIR__ . '/functions.php';
function api_request($url, $method, $data, $api_key) {
    $options = [
        'http' => [
            'method'  => $method,
            'header'  => "Content-Type: application/json\r\n" .
                         "x-api-key: " . $api_key . "\r\n",
            'content' => json_encode($data),
            'ignore_errors' => true
        ]
    ];

    $context  = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    $result   = json_decode($response, true);

    return $result;
}

// SEND MPL
function send_mpl($connection, $mpl_id) {
    global $env;

    $mpl = get_mpl_data($connection, $mpl_id);

    $url = "http://localhost:8888/idm250-sir/api/mpl.php"; // to be replaced with Team 4D endpoint
    $api_key = $env['X_API_KEY'];

    $header = $mpl[0];

    $data = [
        'reference_number' => $header['reference_number'],
        'trailer_number' => $header['trailer_number'],
        'expected_arrival' => $header['expected_arrival'],
        'items' => []
    ];

    foreach ($mpl as $item) {
        $data['items'][] = [
            'unit_id' => $item['unit_id'],
            'sku' => $item['sku'],
            'sku_details' => [
                'sku' => $item['sku'],
                'description' => $item['description'],
                'uom_primary' => $item['uom_primary'],
                'pieces' => $item['pieces'],
                'length_inches' => $item['length_inches'],
                'width_inches' => $item['width_inches'],
                'height_inches' => $item['height_inches'],
                'weight_lbs' => $item['weight_lbs']
            ]
        ];
    }

    return api_request($url, 'POST', $data, $api_key);
}

// SEND ORDER
