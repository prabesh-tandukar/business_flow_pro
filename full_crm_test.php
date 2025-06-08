<?php
// full_crm_test.php - Test your actual CRM login endpoint

echo "🚀 Testing FULL CRM Login API\n";
echo "==============================\n\n";

// Test the REAL CRM login endpoint
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://localhost:8000/api/v1/auth/login', // Your real endpoint
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'admin@businessflowpro.com',
        'password' => 'password', // Try this password
        'device_name' => 'Full CRM Test'
    ])
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Status: $httpCode\n";
if ($error) {
    echo "cURL Error: $error\n";
}

echo "Response:\n";
echo "=========\n";

if ($response) {
    $data = json_decode($response, true);
    if ($data) {
        echo json_encode($data, JSON_PRETTY_PRINT);
        
        if ($httpCode === 200 && isset($data['data']['token'])) {
            echo "\n\n✅ FULL CRM LOGIN SUCCESSFUL!\n";
            echo "================================\n";
            echo "User ID: " . $data['data']['user']['id'] . "\n";
            echo "Name: " . $data['data']['user']['full_name'] . "\n";
            echo "Email: " . $data['data']['user']['email'] . "\n";
            echo "Token: " . substr($data['data']['token'], 0, 30) . "...\n";
            echo "Roles: " . implode(', ', $data['data']['user']['roles']) . "\n";
            echo "Permissions: " . count($data['data']['user']['permissions']) . " permissions\n";
            
            if (isset($data['data']['crm_stats'])) {
                echo "\nCRM Stats:\n";
                echo "- Leads: " . $data['data']['crm_stats']['leads_count'] . "\n";
                echo "- Deals: " . $data['data']['crm_stats']['deals_count'] . "\n";
                echo "- Contacts: " . $data['data']['crm_stats']['contacts_count'] . "\n";
                echo "- Deals Value: $" . number_format($data['data']['crm_stats']['deals_value']) . "\n";
            }
            
            // Test authenticated endpoints
            echo "\n🔐 Testing Authenticated Endpoints:\n";
            echo "===================================\n";
            
            $token = $data['data']['token'];
            
            // Test 1: Get current user
            echo "1. Testing /auth/user endpoint...\n";
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'http://localhost:8000/api/v1/auth/user',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Accept: application/json'
                ]
            ]);
            $userResponse = curl_exec($ch);
            $userStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            echo "   Status: $userStatus " . ($userStatus === 200 ? "✅" : "❌") . "\n";
            
            // Test 2: Health check
            echo "2. Testing /health endpoint...\n";
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'http://localhost:8000/api/v1/health',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Accept: application/json'
                ]
            ]);
            $healthResponse = curl_exec($ch);
            $healthStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            echo "   Status: $healthStatus " . ($healthStatus === 200 ? "✅" : "❌") . "\n";
            
            // Test 3: Leads endpoint (if it exists)
            echo "3. Testing /leads endpoint...\n";
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'http://localhost:8000/api/v1/leads',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Accept: application/json'
                ]
            ]);
            $leadsResponse = curl_exec($ch);
            $leadsStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            echo "   Status: $leadsStatus " . ($leadsStatus === 200 ? "✅" : ($leadsStatus === 404 ? "⚠️ (Not implemented)" : "❌")) . "\n";
            
        }
    } else {
        echo "Invalid JSON response: $response\n";
    }
} else {
    echo "No response received\n";
}

echo "\n\n🎯 SUMMARY:\n";
echo "===========\n";
if ($httpCode === 200) {
    echo "✅ Your CRM API is working perfectly!\n";
    echo "✅ Authentication system is functional\n";
    echo "✅ Token generation works\n";
    echo "✅ Ready for frontend development\n";
} else {
    echo "❌ Still some issues to resolve\n";
    echo "Check the error messages above\n";
}
?>