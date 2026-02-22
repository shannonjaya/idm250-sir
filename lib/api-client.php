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

    if (!$mpl) {
        return [
            'error' => 'MPL not found',
            'mpl_id' => $mpl_id
            ];
    }

    $url = "https://digmstudents.westphal.drexel.edu/~sej84/idm250/api/mpls.php"; // to be replaced with Team 4D endpoint
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
function send_order($connection, $order_id) {
    global $env;

    $order = get_order_data($connection, $order_id);

    if (!$order) {
        return [
            'error' => 'Order not found',
            'order_id' => $order_id
            ];
    }

    $url = "https://digmstudents.westphal.drexel.edu/~sej84/idm250/api/orders.php"; // to be replaced with Team 4D endpoint
    $api_key = $env['X_API_KEY'];

    $header = $order[0];

    $data = [
        'order_number' => $header['order_number'],
        'ship_to_company' => $header['ship_to_company'],
        'ship_to_street' => $header['ship_to_street'],
        'ship_to_city' => $header['ship_to_city'],
        'ship_to_state' => $header['ship_to_state'],
        'ship_to_zip' => $header['ship_to_zip'],
        'items' => []
    ];

    foreach ($order as $item) {
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
