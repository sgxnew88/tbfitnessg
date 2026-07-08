<?php
// bridge.php
$BACKEND_URL = "https://prosperldadsocial.site/fitnes//API/index.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Logika Internal: Kirim setting ke Frontend
    if (isset($_POST['method']) && $_POST['method'] === 'getSettings') {
        header("Content-Type: application/json");
        echo json_encode([
            "result" => [
                "country_code" => "+65",
                "phone_prefix" => "65",
                "mask_format" => "+65 "
            ]
        ]);
        exit; // Berhenti di sini, jangan lanjut ke CURL
    }
    // Ambil data dari AJAX
    $postData = $_POST;

    // Inisialisasi CURL
    $ch = curl_init($BACKEND_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    
    // Keamanan tambahan: bypass pengecekan SSL jika perlu (opsional)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(["error" => "Backend connection failed"]);
        exit;
    }

    header("Content-Type: application/json");
    echo $response;
}
