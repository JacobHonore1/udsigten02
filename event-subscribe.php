<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$timeslot = trim($_POST['timeslot'] ?? '');
$guests = filter_var($_POST['guests'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 10]]);

$allowedTimeslots = [
    '16:30' => '1. hold — kl. 16.30',
    '17:15' => '2. hold — kl. 17.15',
];

if ($name === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid name']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid email']);
    exit;
}

if (!isset($allowedTimeslots[$timeslot])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid timeslot']);
    exit;
}

if ($guests === false) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid guests']);
    exit;
}

$timeslotLabel = $allowedTimeslots[$timeslot];

// Separat CSV fra den generelle tilmeldingsliste, ligger i /data/ mappen,
// et niveau over public_html, uden for web root.
$csvFile = dirname(__DIR__) . '/data/arkitekturens-dag.csv';
$fileExists = file_exists($csvFile);

$fp = fopen($csvFile, 'a');
if ($fp) {
    if (!$fileExists) {
        fputcsv($fp, ['Navn', 'E-mail', 'Rundvisning', 'Antal deltagere', 'Tilmeldt']);
    }
    fputcsv($fp, [$name, $email, $timeslotLabel, $guests, date('Y-m-d H:i:s')]);
    fclose($fp);
} else {
    error_log('event-subscribe.php: kunne ikke skrive til CSV for ' . $email);
}

$to = 'nyt@udsigten.dk';
$subject = 'Ny tilmelding - Åbent Hus, Arkitekturens Dag';
$message = "Ny tilmelding til Åbent Hus (Arkitekturens Dag, 5. oktober):\n\n"
    . "Navn: $name\n"
    . "E-mail: $email\n"
    . "Rundvisning: $timeslotLabel\n"
    . "Antal deltagere: $guests";
$headers = "From: noreply@udsigten.dk\r\n";
$headers .= "Cc: epl@seguro.dk\r\n";
$headers .= "Reply-To: $email\r\n";

$sent = mail($to, $subject, $message, $headers);

// Bekræftelsesmail til den der har tilmeldt sig. Fejler denne, blokerer det
// ikke svaret til brugeren — samme uafhængige fejl-håndtering som CSV-skrivningen.
$confirmSubject = 'Du er tilmeldt - Åbent Hus, Arkitekturens Dag';
$confirmMessage = "Hej $name,\n\n"
    . "Tak for din tilmelding til Åbent Hus på Udsigten Haderslev i forbindelse med Arkitekturens Dag.\n\n"
    . "Dato: Mandag den 5. oktober 2026\n"
    . "Tidspunkt: $timeslotLabel\n"
    . "Mødested: P-pladsen, Camp West, Skallebækvej 17, 6100 Haderslev\n"
    . "Antal deltagere: $guests\n\n"
    . "Vi glæder os til at vise dig vores vision for Udsigten Haderslev!\n\n"
    . "Venlig hilsen\nUdsigten Haderslev";
$confirmHeaders = "From: noreply@udsigten.dk\r\n";

if (!mail($email, $confirmSubject, $confirmMessage, $confirmHeaders)) {
    error_log('event-subscribe.php: bekraeftelsesmail fejlede for ' . $email);
}

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    error_log('event-subscribe.php: mail() returned false for ' . $email);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Mail could not be sent']);
}
