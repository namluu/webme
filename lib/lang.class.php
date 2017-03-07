<?php
class Lang
{
    protected static $data;

    public static function load($code) {
        $langPath = ROOT.DS.'lang'.DS.strtolower($code).'.php';
        if (file_exists($langPath)) {
            self::$data = include ($langPath);
        } else {
            throw new Exception('Language file not found. '.$langPath);
        }
    }

    public static function get($key, $default = '') {
        return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default;
    }
}