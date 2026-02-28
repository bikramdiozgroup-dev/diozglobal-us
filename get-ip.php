<?php
// get-ip.php - Simple version: Get IP + Basic geolocation
header('Content-Type: application/json');

function get_client_ip(): string {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    
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

// Initialize with IP only
$response = [
    'ip' => $ip,
    'country' => '',
    'country_name' => '',
    'city' => '',
];

// Try to get country/city from ipapi.co using curl (more reliable than file_get_contents)
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://ipapi.co/' . urlencode($ip) . '/json/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 3,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_USERAGENT => 'diozglobal-subscriber',
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($result && !$error) {
        $data = json_decode($result, true);
        if (is_array($data)) {
            $response['country'] = $data['country_code'] ?? '';
            $response['country_name'] = $data['country_name'] ?? '';
            $response['city'] = $data['city'] ?? '';
        }
    }
}

echo json_encode($response);
?>
