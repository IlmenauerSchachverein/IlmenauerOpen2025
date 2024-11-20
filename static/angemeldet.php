<?php

// Tabelle erstellen und Daten anzeigen
echo '<table>';
echo '<tr><th>Datum</th><th>Zeit</th><th>Vorname</th><th>Nachname</th><th>Verein</th><th>Geburtsdatum</th><th>Handynummer</th><th>Email</th><th>Rabattberechtigung</th><th>Bestätigung</th><th>AGB Zustimmung</th><th>Blitzturnier</th><th>ChessResults</th></tr>';

if (file_exists($csvFile)) {
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $fullName = trim($data[3]) . ', ' . trim($data[2]);
            $highlightClass = in_array($fullName, $webNames) ? 'highlight' : '';
            $chessResultsMatch = in_array($fullName, $webNames) ? 'X' : '';

            echo "<tr class='{$highlightClass}'>";
            echo '<td>' . htmlspecialchars($data[0]) . '</td>'; // Datum
            echo '<td>' . htmlspecialchars($data[1]) . '</td>'; // Zeit
            echo '<td>' . htmlspecialchars($data[2]) . '</td>'; // Vorname
            echo '<td>' . htmlspecialchars($data[3]) . '</td>'; // Nachname
            echo '<td>' . htmlspecialchars($data[4]) . '</td>'; // Verein
            echo '<td>' . htmlspecialchars($data[5]) . '</td>'; // Geburtsdatum
            echo '<td>' . htmlspecialchars($data[6]) . '</td>'; // Handynummer
            echo '<td>' . htmlspecialchars($data[7]) . '</td>'; // Email
            echo '<td>' . htmlspecialchars($data[8]) . '</td>'; // Rabattberechtigung
            echo '<td>' . htmlspecialchars($data[9]) . '</td>'; // Bestätigung
            echo '<td>' . htmlspecialchars($data[10]) . '</td>'; // AGB Zustimmung
            echo '<td>' . htmlspecialchars($data[11]) . '</td>'; // Blitzturnier
            echo "<td>{$chessResultsMatch}</td>";
            echo '</tr>';
        }
        fclose($handle);
    }
}
echo '</table>';

?>