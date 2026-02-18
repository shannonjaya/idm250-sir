<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKU API Demo</title>
    <link rel="icon" href="../assets/logo-dark.svg" type="image/svg+xml">
</head>
<body>
    <h1>SKU API Demo</h1>

    <?php
        require_once './lib/db-connect.php';

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $api_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/sku.php?id=$id"; // call this api route
        $api_key = $env['X_API_KEY'];

        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "X-API-KEY: $api_key\r\n" . "Content-Type: application/json\r\n"
            ]
        ];
        $context = stream_context_create($options); // pases that api and structures it so it can be processed
        $response = file_get_contents($api_url, false, $context);//making the api call, calls it reponse because thats what it returns

        if ($response === false) {
            echo "<p>Error fetching sku.</p>";
        } else {
            $data = json_decode($response, true);
            if (isset($data['success']) && $data['success'] === true) { // first checking is it set, does this key exist, and then it checks if this is true
                $sku = $data['data']; // both teams calling it data

                if(empty($sku)) {
                    echo "<p>No sku found.</p>";
                } else {
                    echo "<ul>";
                    echo "<li>" . htmlspecialchars($sku['description']) . " (" . htmlspecialchars($sku['sku']) . ")</li>";
                    echo "</ul>";
                }
            } else {
                echo "<p>Error: " . htmlspecialchars($data['error'] ?? 'Unknown error') . "</p>";
            }
        }
    ?>
</body>
</html>

