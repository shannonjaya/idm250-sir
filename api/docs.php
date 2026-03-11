<?php
// Simple API documentation page for the project's API endpoints
// Place this file in the api/ folder so it can be opened in a browser.

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>API Documentation</title>
    <style>
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;max-width:900px;margin:32px auto;padding:0 16px;color:#111}
        pre{background:#f6f8fa;padding:12px;border-radius:6px;overflow:auto}
        h1,h2{margin-top:24px}
        table{border-collapse:collapse;width:100%}
        th,td{border:1px solid #ddd;padding:8px;text-align:left}
    </style>
</head>
<body>
    <h1>API Documentation</h1>
    <p>This page documents the available API endpoints under <strong>/api/v1/</strong>.</p>

    <h2>Authentication & Headers</h2>
    <ul>
        <li><strong>Content-Type:</strong> application/json</li>
        <li><strong>X-API-Key:</strong> Required — <code>sir-4d-api-2026</code> (checked by <code>check_api_key()</code>)</li>
        <li>CORS: <code>Access-Control-Allow-Origin: *</code> and POST/OPTIONS supported</li>
    </ul>

    <h2>/api/v1/mpls.php</h2>
    <p>Receives MPL notifications from the WMS. Only accepts <code>POST</code> requests. Expects JSON body.</p>

    <h3>Request</h3>
    <table>
        <tr><th>Method</th><td>POST</td></tr>
        <tr><th>Headers</th><td>Content-Type: application/json, X-API-Key</td></tr>
        <tr><th>Body (JSON)</th><td>
            <pre>{
  "action": "confirm",
  "reference_number": "123456"
}</pre>
        </td></tr>
    </table>

    <h3>Behavior</h3>
    <ul>
        <li>Validates API key via <code>check_api_key($env)</code>.</li>
        <li>Finds the MPL by <code>reference_number</code> using <code>get_mpl_by_reference()</code>.</li>
        <li>When <code>action</code> is <code>confirm</code> it sets the MPL status to <code>confirmed</code> and updates each unit's location to <code>warehouse</code>.</li>
    </ul>

    <h3>Responses</h3>
    <table>
        <tr><th>Code</th><th>Body</th></tr>
        <tr><td>200</td><td><pre>{
  "success": true,
  "action": "confirm",
  "reference_number": "123456",
  "units_updated": 10
}</pre></td></tr>
        <tr><td>400</td><td>Missing or invalid action / Missing reference number / Invalid action</td></tr>
        <tr><td>404</td><td>MPL not found</td></tr>
        <tr><td>405</td><td>Method Not Allowed (only POST allowed)</td></tr>
    </table>

    <h3>Example (curl)</h3>
    <pre>curl -X POST https://your-site.local/api/v1/mpls.php \
  -H "Content-Type: application/json" \
    -H "X-API-Key: sir-4d-api-2026" \
  -d '{"action":"confirm","reference_number":"123456"}'</pre>

        <h2>/api/v1/orders.php</h2>
        <p>Receives order notifications from the WMS. Only accepts <code>POST</code> requests. Expects JSON body.</p>

        <h3>Request</h3>
        <table>
                <tr><th>Method</th><td>POST</td></tr>
                <tr><th>Headers</th><td>Content-Type: application/json, X-API-Key</td></tr>
                <tr><th>Body (JSON)</th><td>
                        <pre>{
    "action": "ship",
    "order_number": "98765",
    "shipped_at": "2026-03-11T14:30:00Z"
}</pre>
                </td></tr>
        </table>

        <h3>Behavior</h3>
        <ul>
                <li>Validates API key via <code>check_api_key($env)</code>.</li>
                <li>Finds the order by <code>order_number</code> using <code>get_order_by_number()</code>.</li>
                <li>When <code>action</code> is <code>ship</code> it sets the order status to <code>confirmed</code>, records the <code>shipped_at</code> timestamp, and deletes the related inventory units via <code>delete_inventory_unit()</code>.</li>
        </ul>

        <h3>Responses</h3>
        <table>
                <tr><th>Code</th><th>Body</th></tr>
                <tr><td>200</td><td><pre>{
    "success": true,
    "action": "ship",
    "order_number": "98765",
    "shipped_at": "2026-03-11T14:30:00Z",
    "units_deleted": 5
}</pre></td></tr>
                <tr><td>400</td><td>Missing or invalid action / Missing order number / Missing shipped date</td></tr>
                <tr><td>404</td><td>Order not found</td></tr>
                <tr><td>405</td><td>Method Not Allowed (only POST allowed)</td></tr>
        </table>

        <h3>Example (curl)</h3>
        <pre>curl -X POST https://your-site.local/api/v1/orders.php \
    -H "Content-Type: application/json" \
    -H "X-API-Key: sir-4d-api-2026" \
    -d '{"action":"ship","order_number":"98765","shipped_at":"2026-03-11T14:30:00Z"}'</pre>

    <h2>Common helper functions</h2>
    <ul>
        <li><code>check_api_key($env)</code> — validates the incoming <code>X-API-Key</code>.</li>
        <li><code>get_mpl_by_reference($connection, $reference)</code> — fetches MPL by reference number.</li>
        <li><code>update_mpl_status($connection, $mpl_id, $status)</code> — updates status in DB.</li>
        <li><code>get_mpl_units($connection, $mpl_id)</code> — returns unit IDs for an MPL.</li>
        <li><code>update_inventory_location($connection, $location, $unit_id)</code> — moves inventory unit.</li>
    </ul>

    <h2>Notes</h2>
    <ul>
        <li>All endpoints return JSON and use HTTP status codes to indicate success or failure.</li>
        <li>Inspect the code in <strong>/lib/</strong> for DB and auth helpers referenced by the API.</li>
    </ul>

    <footer>
        <p>File generated: api/docs.php — edit this file to expand endpoint documentation.</p>
    </footer>
</body>
</html>
