<?php

class Page{

    static $title = "Weather Data Management System";
    static $developer = "Mikhail Senatorov";

    static function getHeader($title){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Weather Data Management System</title>
            <link rel="stylesheet" href="css/styles.css">
        </head>
        <body>
            <header>
                <h1><?php echo "$title" ?></h1>
            </header>
            <main>
        <?php
    }
    static function getForm($errors = []){
        ?>
        <section id="add-entry">
            <h2>Add New Weather Entry</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="date">Date (DD-MM-YYYY):</label>
                <input type="text" id="date" name="date" required><br>
                <label for="temperature">Temperature (°C):</label>
                <input type="number" id="temperature" name="temperature" step="0.1" required><br>
                <label for="humidity">Humidity (%):</label>
                <input type="number" id="humidity" name="humidity" min="0" max="100" step="0.1" required><br>
                <label for="condition">Condition:</label>
                <input type="text" id="condition" name="condition" required><br>
                
                <input type="hidden" name="fileName" value="<?php echo FileUtility::$currentFile; ?>">
                <input type="submit" name="submit_entry" value="Add Entry">
                <input type="reset" value="Reset">
            </form>
            <?php
            if (!empty($errors)) {
                echo '<div class="errors">';
                foreach ($errors as $error) {
                    echo '<p>' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';
            }
            ?>
        </section>
        <?php
    }
    static function uploadCsv($messages = []){
        ?>
        <section id="upload-csv">
            <h2>Upload Historical Data (CSV)</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
                <input type="submit" name="submit_csv" value="Upload CSV">
            </form>
            <?php
            foreach ($messages as $msg) {
                $class = str_starts_with($msg, 'Success') ? 'success' : 'errors';
                echo "<div class=\"$class\"><p>" . htmlspecialchars($msg) . "</p></div>";
            }
            ?>
        </section>
        <?php
    }

    static function uploadTxt($messages = []){
        ?>
        <section id="upload-txt">
            <h2>Upload Current Forecast (TXT)</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <input type="file" id="txt_file" name="txt_file" accept=".txt" required>
                <input type="submit" name="submit_txt" value="Upload TXT">
            </form>
            <?php
            foreach ($messages as $msg) {
                $class = str_starts_with($msg, 'Success') ? 'success' : 'errors';
                echo "<div class=\"$class\"><p>" . htmlspecialchars($msg) . "</p></div>";
            }
            ?>
        </section>
        <?php
    }
    static function listUploadedFiles($dir) {
        ?>
        <section class='uploaded-file'>
            <h2>Uploaded Files</h2>
            <?php
            $files = glob($dir . '/*');
            foreach ($files as $file) {
                $name = basename($file);
                $time = date("d-m-Y H:i", filemtime($file));
                echo "<span>$name ($time)</span>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='delete_file' value='$name'>
                        <button type='submit'>Delete</button>
                    </form>";
            }
            ?>
        </section>
        <?php
    }

    static function getWeatherList($weatherEntries){
        ?>
        <section id="weather-list">
            <h2>Weather Entries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Temperature (°C)</th>
                        <th>Humidity (%)</th>
                        <th>Condition</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($weatherEntries)) {
                        foreach ($weatherEntries as $entry) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($entry->date) . '</td>';
                            echo '<td>' . htmlspecialchars($entry->temperature) . '</td>';
                            echo '<td>' . htmlspecialchars($entry->humidity) . '</td>';
                            echo '<td>' . htmlspecialchars($entry->condition) . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <?php
    }
    static function getForecast(){
         ?>
         <section id="forecast">
             <h2>Current Forecast</h2>
             <pre><?php echo htmlspecialchars($forecast ?? 'No forecast available.'); ?></pre>
         </section>
         <?php
     }
    static function getStatistics(){
        ?>
         <section id="statistics">
             <h2>Statistics</h2>
             <p>Total Entries: <?php echo isset($totalEntries) ? $totalEntries : 0; ?></p>
             <p>Average Temperature: <?php echo isset($avgTemperature) ? number_format($avgTemperature, 2) . '°C' : 'N/A'; ?></p>
             <p>Average Humidity: <?php echo isset($avgHumidity) ? number_format($avgHumidity, 2) . '%' : 'N/A'; ?></p>
             <p>Most Common Condition: <?php echo isset($mostCommonCondition) ? htmlspecialchars($mostCommonCondition) : 'N/A'; ?></p>
         </section>
         <?php
    }
    static function getFooter($developer){
        ?>
                </main>
            <footer>
                <p>&copy; 2025 Weather Data Management System by <?php echo "$developer" ?> </p>
            </footer>
        </body>
        </html>
        <?php
    }
}