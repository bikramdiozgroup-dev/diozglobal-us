<?php
// get-ip.php - Gets user's IP and geolocation from server-side
header('Content-Type: application/json');

function get_client_ip(): string {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) return $_SERVER['HTTP_CF_CONNECTING_IP'];
    foreach (['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'] as $k) {
        if (!empty($_SERVER[$k])) {
            $ip = $_SERVER[$k];
            if ($k === 'HTTP_X_FORWARDED_FOR') $ip = explode(',', $ip)[0];
            return trim($ip);
        }
    }
    return '0.0.0.0';
}

$ip = get_client_ip();

// Try to get geolocation from IP using free APIs
$geolocation = [
    'ip' => $ip,
    'country' => '',
    'country_name' => '',
    'city' => '',
];

// Try ipapi.co API
try {
    $response = @file_get_contents('https://ipapi.co/' . $ip . '/json/');
    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data)) {
            $geolocation['country'] = $data['country_code'] ?? '';
            $geolocation['country_name'] = $data['country_name'] ?? '';
            $geolocation['city'] = $data['city'] ?? '';
        }
    }
} catch (Exception $e) {
    // Fallback to next method
}

echo json_encode($geolocation);
?>
