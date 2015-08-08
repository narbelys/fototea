<?php

namespace unit_tests\Util;
use Fototea\Models\AdjudicationManager;
use Fototea\Models\User;
use Fototea\Util\DateHelper;

class AdjudicationManagerTest extends \PHPUnit_Framework_TestCase
{
    //
    public function testAdjudicateProject() {

        $projectId = 32;
        $offerId = 5;

        //Proyect owner = 1
        //Winner = 2
        $this->assertTrue(AdjudicationManager::adjudicateProject($projectId,$offerId));
    }
}