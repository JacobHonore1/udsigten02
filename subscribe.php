<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid email']);
    exit;
}

// CSV filen ligger i /data/ mappen, én niveau over public_html, uden for web root.
$csvFile = dirname(__DIR__) . '/data/tilmeldinger.csv';
$fileExists = file_exists($csvFile);

$fp = fopen($csvFile, 'a');
if ($fp) {
    if (!$fileExists) {
        fputcsv($fp, ['E-mail', 'Tidspunkt']);
    }
    fputcsv($fp, [$email, date('Y-m-d H:i:s')]);
    fclose($fp);
} else {
    error_log('subscribe.php: kunne ikke skrive til CSV for ' . $email);
}

$to = 'info@udsigten.dk';
$subject = 'Ny tilmelding - Udsigten Haderslev';
$message = "Ny bolig-interesseret har skrevet sig op via hero-tilmeldingsfeltet paa hjemmesiden:\n\nE-mail: $email";
$headers = "From: noreply@udsigten.dk\r\n";
$headers .= "Reply-To: $email\r\n";

$sent = mail($to, $subject, $message, $headers);

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    error_log('subscribe.php: mail() returned false for ' . $email);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Mail could not be sent']);
}
