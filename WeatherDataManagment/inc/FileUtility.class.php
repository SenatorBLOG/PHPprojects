<?php

class FileUtility{

    static $notifications = array();
    static $fileCounter = 0;
    static $currentFile = '';

    static function initialize ($fileName){
        self::$currentFile = $fileName;
    }

    static function open($mode){
        if(file_exists(self::$currentFile)){
            $fh = fopen(self::$currentFile, $mode);
            return $fh;
        }
        else {
            self::$notifications [] = "File does not exist";
            return false;
        }
    }

    static function close($fh){
        fclose($fh);
    }

    static function read(){
        $contents = '';

        try{
            if($fh = self::open('r')){
                $contents = fread($fh, filesize(self::$currentFile));
                self::close($fh);
            } else {
                throw new Exception("Cannnot read from the file " . self::$currentFile);
            }
        } catch (Exception $fe){
            self::$notifications [] = array($fe -> getMessage());
        }
        return $contents;
    }

    static function write($data){
        try{
            if($fh = self::open('a')){
                flock($fh,LOCK_EX);
                fwrite($fh, $data, strlen($data));
                flock($fh,LOCK_UN);
                self::close($fh);
            }
        } catch (Exception $fe){
            self::$notifications [] = array ($fe -> getMessage());
        }
    }
    static function upload($inputName, $allowedTypes = ['text/csv', 'text/plain']){
        $file = $_FILES[$inputName] ?? null;
        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            self::$notifications[] = "Error: No file selected for upload.";
            return '';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            self::$notifications[] = "Error: Upload failed with error code " . $file['error'];
            return '';
        }

        if (!in_array($file['type'], $allowedTypes)) {
            self::$notifications[] = "Error: Invalid file type.";
            return '';
        }

        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
        $targetPath = REPOSITORY . self::$fileCounter . '_' . $safeName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            self::$notifications[] = "Success: File uploaded successfully.";
            self::$fileCounter++;
            return $targetPath;
        } else {
            self::$notifications[] = "Error: Failed to move uploaded file.";
            return '';
        }
    }

}