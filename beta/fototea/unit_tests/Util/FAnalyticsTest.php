<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 6/6/14
 * Time: 4:14 PM
 */

namespace unit_tests\Util;

ob_start(); //buffer on

use Fototea\App\App;
use Fototea\Util\FAnalytics;

class FAnalyticsTest extends \PHPUnit_Framework_TestCase
{

    public function testInvitarAmigo() {
        $app = new App();

//        $fAnalytics = $app->getHelper('FAnalytics');
        /** @var $ga \Fototea\Util\Analytics; */
        $ga = FAnalytics::getInstance();

        $this->assertNotNull($ga);

//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por twitter', 99);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por facebook', 98);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por twitter', 97);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por facebook', 96);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por twitter', 99);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por twitter', 95);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por email', 94);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por email', 99);
//        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por googleplus', 93);

        $ga->trackEvent('Referidos - Invitar Amigos', 'Invitar por googleplus', 93);

//        $ga->trackEvent()

    }
}