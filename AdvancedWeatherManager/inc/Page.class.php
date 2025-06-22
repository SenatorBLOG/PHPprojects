<?php
require_once __DIR__ . '/FileUtility.class.php';

class Page
{
    protected static string $title     = 'Weather Data Management System';
    protected static string $developer = 'Mikhail Senatorov';

    public static function header(string $pageTitle = ''): void
    {
        $fullTitle = $pageTitle !== '' ? $pageTitle : self::$title;
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?= htmlspecialchars($fullTitle) ?></title>
            <link rel="stylesheet" href="css/styles.css">
        </head>
        <body>
            <header>
                <h1><?= htmlspecialchars($fullTitle) ?></h1>
            </header>
            <main>
        <?php
    }

    public static function footer(): void
    {
        ?>
            </main>
            <footer>
                <p>
                    &copy; <?= date('Y') ?> <?= htmlspecialchars(self::$title) ?>
                    &mdash; Developed by <?= htmlspecialchars(self::$developer) ?>
                </p>
            </footer>
        </body>
        </html>
        <?php
    }

    public static function formAddEntry(array $errors = []): void
    {
        ?>
        <section id="add-entry">
            <h2>Add New Weather Entry</h2>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <label for="date">Date (YYYY-MM-DD):</label>
                <input type="text" id="date" name="date" placeholder="2025-06-22" required>

                <label for="temperature">Temperature (°C):</label>
                <input type="number" id="temperature" name="temperature" step="0.1" min="-50" max="50" required>

                <label for="humidity">Humidity (%):</label>
                <input type="number" id="humidity" name="humidity" step="0.1" min="0" max="100" required>

                <label for="condition">Condition:</label>
                <input type="text" id="condition" name="condition" placeholder="Sunny" required>

                <button type="submit" name="submit_entry">Add Entry</button>
                <button type="reset">Reset</button>
            </form>

            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <?php foreach ($errors as $err): ?>
                        <p><?= htmlspecialchars($err) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
    }

    public static function formUploadCsv(array $messages = []): void
    {
        ?>
        <section id="upload-csv">
            <h2>Upload Historical Data (CSV)</h2>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="csv_file" accept=".csv" required>
                <button type="submit" name="submit_csv">Upload CSV</button>
            </form>

            <?php foreach ($messages as $msg): ?>
                <div class="<?= str_contains($msg, 'Success') ? 'success' : 'errors' ?>">
                    <p><?= htmlspecialchars($msg) ?></p>
                </div>
            <?php endforeach; ?>
        </section>
        <?php
    }

    public static function formUploadTxt(array $messages = []): void
    {
        ?>
        <section id="upload-txt">
            <h2>Upload Current Forecast (TXT)</h2>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="txt_file" accept=".txt" required>
                <button type="submit" name="submit_txt">Upload TXT</button>
            </form>

            <?php foreach ($messages as $msg): ?>
                <div class="<?= str_contains($msg, 'Success') ? 'success' : 'errors' ?>">
                    <p><?= htmlspecialchars($msg) ?></p>
                </div>
            <?php endforeach; ?>
        </section>
        <?php
    }

    public static function listUploadedFiles(string $directory): void
    {
        $files = glob(rtrim($directory, '/') . '/*');
        if (empty($files)) {
            return;
        }
        ?>
        <section id="uploaded-files">
            <h2>Uploaded Files</h2>
            <?php foreach ($files as $file): ?>
                <?php $name = basename($file); ?>
                <div class="file-item">
                    <span><?= htmlspecialchars($name) ?> (<?= date('Y-m-d H:i', filemtime($file)) ?>)</span>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="delete_file" value="<?= htmlspecialchars($name) ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </section>
        <?php
    }

    /**
     * @param \App\Models\WeatherEntry[] $entries
     */
    public static function listWeatherEntries(array $entries = []): void
    {
        ?>
        <section id="weather-list">
            <h2>Weather Entries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Temp (°C)</th>
                        <th>Humidity (%)</th>
                        <th>Condition</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entries)): ?>
                        <tr><td colspan="4">No entries available.</td></tr>
                    <?php else: ?>
                        <?php foreach ($entries as $e): ?>
                        <tr>
                            <td><?= htmlspecialchars($e->date) ?></td>
                            <td><?= htmlspecialchars($e->temperature) ?></td>
                            <td><?= htmlspecialchars($e->humidity) ?></td>
                            <td><?= htmlspecialchars($e->condition) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <?php
    }

    public static function showForecast(string $forecast = ''): void
    {
        ?>
        <section id="forecast">
            <h2>Current Forecast</h2>
            <pre><?= htmlspecialchars($forecast !== '' ? $forecast : 'No forecast available.') ?></pre>
        </section>
        <?php
    }

    public static function showStatistics(array $stats = []): void
    {
        $total       = $stats['totalEntries']   ?? 0;
        $avgTemp     = $stats['averageTemp']    ?? null;
        $avgHumidity = $stats['averageHumidity']?? null;
        $commonCond  = $stats['commonCondition']?? 'N/A';
        ?>
        <section id="statistics">
            <h2>Statistics</h2>
            <p>Total Entries: <?= $total ?></p>
            <p>Average Temperature: <?= $avgTemp !== null ? number_format($avgTemp, 2) . '°C' : 'N/A' ?></p>
            <p>Average Humidity: <?= $avgHumidity !== null ? number_format($avgHumidity, 2) . '%' : 'N/A' ?></p>
            <p>Most Common Condition: <?= htmlspecialchars($commonCond) ?></p>
        </section>
        <?php
    }
}
