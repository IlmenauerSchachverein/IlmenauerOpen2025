<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldungen Open 2025</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .highlight {
            background-color: #ffcccc; /* Hellrot für Übereinstimmungen */
        }
    </style>
</head>
<body>
    <h1>Anmeldungen Open 2025</h1>

    <?php
    // Pfad zur CSV-Datei
    $csvFile = '/var/private/isv/open25.csv';

    if (!file_exists($csvFile)) {
        echo '<p style="color: red; text-align: center;">Fehler: Die CSV-Datei existiert nicht.</p>';
        exit;
    }

    // CSV-Datei öffnen
    $handle = fopen($csvFile, 'r');
    if (!$handle) {
        echo '<p style="color: red; text-align: center;">Fehler: Die CSV-Datei konnte nicht geöffnet werden.</p>';
        exit;
    }

    // Tabelle starten
    echo '<table>';
    echo '<tr><th>Vorname</th><th>Nachname</th><th>Verein</th><th>Geburtsdatum</th><th>Handynummer</th><th>E-Mail</th><th>Rabatt</th><th>Bestätigung</th><th>Blitzturnier</th><th>AGB Zustimmung</th></tr>';

    // Zeilen aus der CSV-Datei auslesen
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($data[0]) . '</td>'; // Vorname
        echo '<td>' . htmlspecialchars($data[1]) . '</td>'; // Nachname
        echo '<td>' . htmlspecialchars($data[2]) . '</td>'; // Verein
        echo '<td>' . htmlspecialchars($data[3]) . '</td>'; // Geburtsdatum
        echo '<td>' . htmlspecialchars($data[4]) . '</td>'; // Handynummer
        echo '<td>' . htmlspecialchars($data[5]) . '</td>'; // E-Mail
        echo '<td>' . htmlspecialchars($data[6]) . '</td>'; // Rabatt
        echo '<td>' . htmlspecialchars($data[7]) . '</td>'; // Bestätigung
        echo '<td>' . (isset($data[8]) && $data[8] === 'on' ? 'Ja' : 'Nein') . '</td>'; // Blitzturnier
        echo '<td>' . htmlspecialchars($data[9]) . '</td>'; // AGB Zustimmung
        echo '</tr>';
    }

    // Tabelle schließen
    echo '</table>';
    fclose($handle);
    ?>
</body>
</html>
