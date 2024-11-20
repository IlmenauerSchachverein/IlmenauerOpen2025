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
    $csvNames = [];

    // CSV-Daten auslesen
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            $headerSkipped = false;
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // Skip header if present
                if (!$headerSkipped) {
                    $headerSkipped = true;
                    continue;
                }
                $csvNames[] = trim($data[3]) . ', ' . trim($data[2]); // Nachname, Vorname
            }
            fclose($handle);
        }
    } else {
        echo '<p style="color: red; text-align: center;">Fehler: Die CSV-Datei existiert nicht.</p>';
    }

    // ChessResults-Daten abrufen
    $url = 'https://chess-results.com/tnr1056111.aspx?lan=0';
    $html = file_get_contents($url);
    $webNames = [];

    if ($html !== FALSE) {
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Tabelle parsen
        $rows = $xpath->query("//table[contains(@class, 'CRs')]//tr");
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Überspringe Header
            $cells = $row->getElementsByTagName('td');
            if ($cells->length >= 4) {
                $webNames[] = trim($cells->item(3)->nodeValue); // Name im Format "Nachname, Vorname"
            }
        }
    } else {
        echo '<p style="color: red; text-align: center;">Fehler: Die ChessResults-Tabelle konnte nicht geladen werden.</p>';
    }

    // Namen, die auf ChessResults gemeldet sind, aber nicht in der CSV stehen
    $notInCsv = array_diff($webNames, $csvNames);

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
        <th>ChessResults</th>
    </tr>';

    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            $headerSkipped = false;
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (!$headerSkipped) {
                    $headerSkipped = true;
                    continue;
                }

                // Vollständiger Name aus CSV für Vergleich
                $fullName = trim($data[3]) . ', ' . trim($data[2]);

                // Highlight und ChessResults-Abgleich
                $highlightClass = in_array($fullName, $webNames) ? 'highlight' : '';
                $chessResultsMatch = in_array($fullName, $webNames) ? 'X' : '';

                // Tabelle ausgeben
                echo "<tr class='{$highlightClass}'>";
                echo '<td>' . htmlspecialchars($data[0]) . '</td>'; // Datum
                echo '<td>' . htmlspecialchars($data[1]) . '</td>'; // Zeit
                echo '<td>' . htmlspecialchars($data[2]) . '</td>'; // Vorname
                echo '<td>' . htmlspecialchars($data[3]) . '</td>'; // Nachname
                echo '<td>' . htmlspecialchars($data[4]) . '</td>'; // Verein
                echo '<td>' . htmlspecialchars($data[5]) . '</td>'; // Geburtsdatum
                echo '<td>' . htmlspecialchars($data[6]) . '</td>'; // Handy
                echo '<td>' . htmlspecialchars($data[7]) . '</td>'; // Email
                echo '<td>' . htmlspecialchars($data[8]) . '</td>'; // Rabattberechtigung
                echo '<td>' . htmlspecialchars($data[9]) . '</td>'; // Bestätigung
                echo '<td>' . htmlspecialchars($data[10]) . '</td>'; // AGB
                echo '<td>' . htmlspecialchars($data[11]) . '</td>'; // Blitzturnier
                echo "<td>{$chessResultsMatch}</td>"; // ChessResults
                echo '</tr>';
            }
            fclose($handle);
        }
    }

    echo '</table>';

    // Liste der Namen, die nicht in der CSV sind
    echo '<h2>Auf ChessResults gemeldet, aber nicht in der CSV-Datei:</h2>';
    if (!empty($notInCsv)) {
        echo '<ul>';
        foreach ($notInCsv as $name) {
            echo "<li>{$name}</li>";
        }
        echo '</ul>';
    } else {
        echo '<p>Alle gemeldeten Spieler sind auch in der CSV-Datei vorhanden.</p>';
    }
    ?>
</body>
</html>
