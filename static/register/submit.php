<?php
// Pfad zur CSV-Datei
$csvFile = '/var/private/isv/open25.csv';

// Überprüfung des Honeypot-Feldes
if (!empty($_POST['honeypot'])) {
    die('Bot-Verdacht: Die Anmeldung wurde nicht gespeichert.');
}

// Eingehende Daten validieren und bereinigen
$vorname = htmlspecialchars(trim($_POST['vorname'] ?? ''));
$nachname = htmlspecialchars(trim($_POST['nachname'] ?? ''));
$verein = htmlspecialchars(trim($_POST['verein'] ?? ''));
$geburtsdatum = htmlspecialchars(trim($_POST['geburtsdatum'] ?? ''));
$handy = htmlspecialchars(trim($_POST['handy'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$rabatt = htmlspecialchars(trim($_POST['rabatt'] ?? 'nein'));
$bestaetigung = isset($_POST['bestaetigung']) ? 'on' : 'off';
$blitz = isset($_POST['blitz']) ? 'on' : 'off';
$agb = isset($_POST['agb']) ? 'on' : 'off';

// Validierungslogik
$errors = [];
if (empty($vorname)) $errors[] = 'Vorname ist erforderlich.';
if (empty($nachname)) $errors[] = 'Nachname ist erforderlich.';
if (empty($geburtsdatum) || !preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $geburtsdatum)) {
    $errors[] = 'Geburtsdatum ist ungültig. Format: TT.MM.JJJJ.';
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'E-Mail-Adresse ist ungültig.';
}
if ($agb !== 'on') {
    $errors[] = 'Die Zustimmung zu den Teilnahmebedingungen ist erforderlich.';
}

// Bei Fehlern: Ausgabe und Abbruch
if (!empty($errors)) {
    echo '<h1>Fehler bei der Anmeldung</h1>';
    echo '<ul>';
    foreach ($errors as $error) {
        echo "<li>{$error}</li>";
    }
    echo '</ul>';
    echo '<a href="javascript:history.back()">Zurück zum Formular</a>';
    exit;
}

// Daten in die CSV-Datei schreiben
$newEntry = [
    $vorname,
    $nachname,
    $verein,
    $geburtsdatum,
    $handy,
    $email,
    $rabatt,
    $bestaetigung,
    $blitz,
    $agb,
];

// Sicherstellen, dass die CSV-Datei existiert und beschreibbar ist
if (!file_exists($csvFile)) {
    if (!touch($csvFile)) {
        die('Fehler: Die CSV-Datei konnte nicht erstellt werden.');
    }
}
if (!is_writable($csvFile)) {
    die('Fehler: Die CSV-Datei ist nicht beschreibbar.');
}

// Öffnen der CSV-Datei und Hinzufügen des neuen Eintrags
if (($handle = fopen($csvFile, 'a')) !== FALSE) {
    fputcsv($handle, $newEntry);
    fclose($handle);
    echo '<h1>Anmeldung erfolgreich</h1>';
    echo '<p>Vielen Dank für die Anmeldung!</p>';
    echo '<a href="/register">Zurück zum Formular</a>';
} else {
    die('Fehler: Die CSV-Datei konnte nicht geöffnet werden.');
}
?>
