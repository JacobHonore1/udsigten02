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

$to = 'info@udsigten.dk, epl@seguro.dk, jh@zaxis.dk';
$subject = 'Ny tilmelding - Udsigten Haderslev';
$message = "Ny bolig-interesseret har skrevet sig op via hero-tilmeldingsfeltet paa hjemmesiden:\n\nE-mail: $email";
$headers = "From: noreply@zaxis.dk\r\n";
$headers .= "Reply-To: $email\r\n";

$sent = mail($to, $subject, $message, $headers);

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Mail could not be sent']);
}
