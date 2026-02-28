<?php
// get-ip.php - Gets user's IP and geolocation
// Using ipapi.co API as per their documentation
header('Content-Type: application/json');

function get_client_ip(): string {
    // Check for Cloudflare
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    
    // Check for other proxies
    foreach (['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'] as $k) {
        if (!empty($_SERVER[$k])) {
            $ip = $_SERVER[$k];
            if ($k === 'HTTP_X_FORWARDED_FOR') {
                $ip = explode(',', $ip)[0];
            }
            return trim($ip);
        }
    }
    
    return '0.0.0.0';
}

$ip = get_client_ip();

// Initialize response
$response = [
    'ip' => $ip,
    'country' => '',
    'country_name' => '',
    'city' => '',
    'latitude' => '',
    'longitude' => '',
];

// Fetch geolocation from ipapi.co
// Documentation: https://ipapi.co/api/#introduction
// Free tier: 30,000 requests/month (no auth needed)
try {
    $url = 'https://ipapi.co/' . urlencode($ip) . '/json/';
    
    // Create stream context with timeout
    $options = [
        'http' => [
            'timeout' => 5,
            'user_agent' => 'diozglobal-subscriber-form',
        ],
        'https' => [
            'timeout' => 5,
            'user_agent' => 'diozglobal-subscriber-form',
        ]
    ];
    
    $context = stream_context_create($options);
    $json = @file_get_contents($url, false, $context);
    
    if ($json !== false) {
        $data = json_decode($json, true);
        
        if (is_array($data)) {
            // ipapi.co returns these fields:
            // - country_code (e.g., "US")
            // - country_name (e.g., "United States")  
            // - city (e.g., "Mountain View")
            // - latitude & longitude
            
            $response['country'] = $data['country_code'] ?? '';
            $response['country_name'] = $data['country_name'] ?? '';
            $response['city'] = $data['city'] ?? '';
            $response['latitude'] = $data['latitude'] ?? '';
            $response['longitude'] = $data['longitude'] ?? '';
        }
    }
} catch (Exception $e) {
    error_log('ipapi.co error: ' . $e->getMessage());
    // Return partial data with IP at least
}

// Cache the response for 1 hour to avoid rate limiting
header('Cache-Control: public, max-age=3600');

echo json_encode($response);
?>
