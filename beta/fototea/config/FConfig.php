<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 3/26/14
 * Time: 10:48 PM
 */

namespace Fototea\Config;

class FConfig {

    /**
     * Main configuration
     */
    private static $config = array(

        // Base Urls
        'site_url' => 'http://dev.fototea.com/',
        'base_url' => 'http://dev.fototea.com/beta/fototea/',

        // Database
        'db_hostname' => 'localhost',
        'db_name' => 'fototea_fot',
        'db_user' => 'root',
        'db_password' => 'admin',
        'db_query_log' => true,

        // Profile's dimensions
        'profile_image_width' => 130,
        'profile_image_height' => 130,

        // Profile's cover
        'cover_image_width' => 1440,
        'cover_image_height' => 450,

        'maxUploadSize' => 15360,
        //'maxUploadSize' => 2360,

        // Album's constraints
        'maxFilesByAlbum' => 9,
        'defaultAlbumsByPhotographer' => 2,
        'creditsByAlbum' => 1,

        //Project constrains
        'maxDaysToAdjudicate' => 15,

        // Email configurations
        'email_smtp_user' => 'AKIAJ56NCUMHDTG7TM7Q',
        'email_smtp_pass' => 'AjdsphBsuAiSU4GexJc/4QM+ua7tg4c5Entm92yrPemT',
        'email_smtp_url' => 'email-smtp.us-west-2.amazonaws.com',
        'email_smtp_port' => '587',
        'email_sender_email' => 'no-reply@fototea.com',
        'email_sender_name' => 'Fototea',

        // Contacto
        'contacto_email' => 'paulo@fototea.com',
        'contacto_name' => 'Contacto Fototea',

        // Analytics
        'trackingID' => 'UA-51010735-1',
        'analytics_site_url' => 'dev.fototea.com',

        // Guest project - duration time
        'guest_project_duration' => 3600,

    );

    /**
     * Return the base path directory of the application.
     * @return string
     */
    public static function getBasePath($path = ''){
        return realpath(__DIR__. '/../') . $path;
    }

    /**
     * Return a particular url
     * @param $key = Key of the configuration value to be returned
     * @return false if don't exist, or the value when exist
     */
    public static function getUrl($path = null, $refreshCache = false) {
        if (!isset(self::$config['base_url'])) {
            return false;
        }

        $url =  ($path == null) ? (self::$config['base_url']) : (self::$config['base_url'] . $path);

        if ($refreshCache) {
            if (strpos($url, '?')) {
                $url .= '&';
            } else {
                $url .= '?';
            }
            $url .= time();
        }

        return $url;
    }

    public static function getThumbUrl($imagePath, $width, $height, $refreshThumb = false) {
        $url = 'thumb.php?w='.$width . '&h=' . $height . '&url=' . $imagePath;

        if ($refreshThumb) {
            $url .= '&refresh=true';
        }

        return self::getUrl($url, $refreshThumb);
    }

    /**
     * Return a particular configuration value based on a key
     * @param $key = Key of the configuration value to be returned
     * @return false if don't exist, or the value when exist
     */
    public static function getValue($key, $path = null) {
        if (!isset(self::$config[$key])) {
            return false;
        }

        return self::$config[$key];
    }
}