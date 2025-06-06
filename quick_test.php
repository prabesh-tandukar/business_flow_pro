<?php
// quick_test.php - Save this in your project root and run: php quick_test.php

echo "🚀 Testing CRM Login API\n";
echo "========================\n\n";

// Test login
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://localhost:8000/api/v1/auth/simple-login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'admin@businessflowpro.com',
        'password' => 'password',
        'device_name' => 'Test Script'
    ])
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n";
echo "Response:\n";
echo "=========\n";
echo json_encode(json_decode($response), JSON_PRETTY_PRINT);
echo "\n\n";

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['data']['token'])) {
        echo "✅ Login Successful!\n";
        echo "Token: " . substr($data['data']['token'], 0, 20) . "...\n";
        echo "User: " . $data['data']['user']['full_name'] . "\n";
        echo "Roles: " . implode(', ', $data['data']['user']['roles']) . "\n";
    }
} else {
    echo "❌ Login Failed\n";
}
?>