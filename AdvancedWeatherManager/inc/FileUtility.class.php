<?php
// FileUtility.class.php


class FileUtility {
    // public static function read(string $filename): string {
    //     return file_exists($filename) ? file_get_contents($filename) : '';
    // }
    //     $content = FileUtility::read('data/myfile.txt');
    // echo nl2br($content);

    public static function read(string $filename): string {
        $contents = '';
        try {
            if (!file_exists($filename)) {
                throw new Exception("Файл '$filename' не существует.");
            }

            $fh = fopen($filename, 'r');
            if (!$fh) {
                throw new Exception("Не удалось открыть файл '$filename' для чтения.");
            }

            $filesize = filesize($filename);
            if ($filesize === false || $filesize === 0) {
                // Не критично, но можно логгировать
                $contents = '';
            } else {
                $contents = fread($fh, $filesize);
                if ($contents === false) {
                    throw new Exception("Ошибка чтения файла '$filename'.");
                }
            }

            fclose($fh);

        } catch (Exception $e) {
            // Здесь можно логгировать, кидать дальше или просто сохранять
            // например:
            error_log($e->getMessage());
            // или если у тебя есть массив для уведомлений:
            // self::$notifications[] = $e->getMessage();
        }

        return $contents;
    }


    // public static function write(string $filename, $data): bool {
    //     $dir = dirname($filename);
    //     if (!file_exists($dir)) {
    //         mkdir($dir, 0755, true);
    //     }
    //     return file_put_contents($filename, is_array($data) ? implode(",", $data) : $data) !== false;
    // }

    //     // Перезаписать файл
    // FileUtility::write('data/file.txt', "Привет, мир!");

    // // Добавить в конец
    // FileUtility::write('logs/log.txt', ['ERROR', 'Неверный формат'], true);

    public static function write(string $filename, $data, bool $append = false): bool {
        $result = false;
        try {
            // Создаём директорию, если нужно
            $dir = dirname($filename);
            if (!file_exists($dir)) {
                if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                    throw new Exception("Не удалось создать директорию: $dir");
                }
            }

            // Поддержка массивов
            if (is_array($data)) {
                $data = implode(",", $data);
            }

            // Открытие файла
            $mode = $append ? 'a' : 'w'; // 'a' — добавить, 'w' — перезаписать
            $fh = fopen($filename, $mode);
            if (!$fh) {
                throw new Exception("Не удалось открыть файл: $filename");
            }

            // Блокировка
            if (!flock($fh, LOCK_EX)) {
                fclose($fh);
                throw new Exception("Не удалось получить блокировку файла: $filename");
            }

            // Запись
            $bytes = fwrite($fh, $data, strlen($data));
            flock($fh, LOCK_UN);
            fclose($fh);

            if ($bytes === false || $bytes < strlen($data)) {
                throw new Exception("Ошибка записи в файл: $filename");
            }

            $result = true;

        } catch (Exception $e) {
            // Можно сохранять уведомления в свойство класса, если нужно
            if (property_exists(__CLASS__, 'notifications')) {
                self::$notifications[] = $e->getMessage();
            }
            error_log($e->getMessage());
        }

        return $result;
    }



    public static function append(string $filename, array $row): bool {
        $dir = dirname($filename);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $handle = fopen($filename, 'a');
        if ($handle === false) return false;
        fputcsv($handle, $row);
        fclose($handle);
        return true;
    }
}