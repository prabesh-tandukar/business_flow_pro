<?php
// simple_auth_test.php - Test login without Spatie roles

echo "🚀 Testing Simple Login (No Roles)\n";
echo "==================================\n\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://localhost:8000/api/v1/auth/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'admin@businessflowpro.com',
        'password' => 'password',
        'device_name' => 'Simple Test'
    ])
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n";
echo "Response:\n";
echo "=========\n";
echo json_encode(json_decode($response), JSON_PRETTY_PRINT);
?>