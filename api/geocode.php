<?php
// هذا هو الكود الكامل للخدمة الوسيطة
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // السماح لأي موقع باستدعاء هذه الخدمة
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// استقبال العنوان من الطلب
$address = $_REQUEST['address'] ?? '';

if (empty($address)) {
    http_response_code(400);
    echo json_encode(['error' => 'Address parameter is missing.']);
    exit;
}

// هذا الكود هو نفسه الذي كان يتصل بـ Nominatim
// لكنه الآن يعمل من سيرفر نظيف
$url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&addressdetails=1&accept-language=ar&limit=1";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    // يجب وضع User-Agent حقيقي لتجنب الحظر
    CURLOPT_USERAGENT => 'MyGeocodeProxy/1.0 (please contact me if any issue)',
    CURLOPT_TIMEOUT => 20
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL Error: ' . $error]);
    exit;
}

// إرجاع الرد المستلم من Nominatim كما هو
echo $response;
?>