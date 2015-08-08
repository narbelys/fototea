<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/25/14
 * Time: 9:27 PM
 *
 * Used library: https://github.com/there4/php-analytics-event
 */

namespace Fototea\Util;

use Fototea\Config\FConfig;
use Fototea\Util\A;

final class FAnalytics {
    /**
     * Call this method to get singleton
     *
     * @return FAnalytics
     */
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Analytics(FConfig::getValue('trackingID'), FConfig::getValue('analytics_site_url'));
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {

    }
}