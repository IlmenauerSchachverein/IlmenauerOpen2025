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
    </style>
</head>
<body>
    <h1>Anmeldungen Open 2025</h1>

    <?php
    // Pfad zur CSV-Datei
    $csvFile = '/var/private/isv/open25.csv';

    // Überprüfen, ob die CSV-Datei existiert
    if (!file_exists($csvFile)) {
        echo '<p style="color: red; text-align: center;">Fehler: Die CSV-Datei existiert nicht.</p>';
        exit;
    }

    // Tabelle anzeigen
    echo '<table>';
    echo '<tr>
        <th>Datum</th>
        <th>Zeit</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Verein</th>
        <th>Geburtsdatum</th>
        <th>Handynummer</th>
        <th>E-Mail</th>
        <th>Rabattberechtigung</th>
        <th>Bestätigung</th>
        <th>AGB</th>
        <th>Blitzturnier</th>
    </tr>';

    // Datei öffnen und Zeilen auslesen
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $headerSkipped = false;
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Überprüfen, ob die Zeile genügend Spalten enthält
            if (count($data) < 12) {
                echo '<p style="color: red;">Fehler: Eine Zeile in der CSV-Datei hat nicht genügend Spalten.</p>';
                continue;
            }

            // Daten aus der CSV extrahieren
            $datum = htmlspecialchars($data[0]);
            $zeit = htmlspecialchars($data[1]);
            $vorname = htmlspecialchars($data[2]);
            $nachname = htmlspecialchars($data[3]);
            $verein = htmlspecialchars($data[4]);
            $geburtsdatum = htmlspecialchars($data[5]);
            $handynummer = htmlspecialchars($data[6]);
            $email = htmlspecialchars($data[7]);
            $rabatt = htmlspecialchars($data[8]);
            $bestaetigung = htmlspecialchars($data[9]);
            $agb = htmlspecialchars($data[10]);
            $blitzturnier = htmlspecialchars($data[11]);

            // Zeile in die Tabelle ausgeben
            echo "<tr>
                <td>{$datum}</td>
                <td>{$zeit}</td>
                <td>{$vorname}</td>
                <td>{$nachname}</td>
                <td>{$verein}</td>
                <td>{$geburtsdatum}</td>
                <td>{$handynummer}</td>
                <td>{$email}</td>
                <td>{$rabatt}</td>
                <td>{$bestaetigung}</td>
                <td>{$agb}</td>
                <td>{$blitzturnier}</td>
            </tr>";
        }
        fclose($handle);
    }

    echo '</table>';
    ?>
</body>
</html>
