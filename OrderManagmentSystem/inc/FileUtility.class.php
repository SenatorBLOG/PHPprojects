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
}