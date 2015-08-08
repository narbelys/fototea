<?php

namespace unit_tests\Util;
use Fototea\Models\Project;
use Fototea\Models\User;
use Fototea\Util\DateHelper;

class ProjectModelTest extends \PHPUnit_Framework_TestCase
{
    //
    public function testProjectUpdateValidations() {
        $this->assertFalse(Project::updateProject(1));
        $this->assertFalse(Project::updateProject(1123123, array('a', 'b')));
        $this->assertFalse(Project::updateProject(1, array('a', 'b')));
    }

    public function testProjectUpdate() {
        $this->assertTrue(Project::updateProject(1, array('pro_descripcion' => 'nueva_desc')));
        $this->assertTrue(Project::updateProject(1, array('pro_tit' => 'nuevo titulo 2')));
        $this->assertTrue(Project::updateProject(1, array('pro_country' => 'MK')));
        $this->assertTrue(Project::updateProject(1, array('pro_country' => 'MK', 'pro_tit' => 'nuevo titulo 3')));
        $this->assertTrue(Project::updateProject(1, array('pro_date' => '2015-06-02 00:00:00', 'pro_date_end' => '2015-09-02 00:00:00')));
        $this->assertTrue(Project::updateProject(1, array('pro_cant' => '52', 'pro_cp' => '99999')));
        $this->assertTrue(Project::updateProject(1, array('pro_type' => '2', 'pro_category' => '2')));
        $this->assertTrue(Project::updateProject(1, array('pro_status' => 'E', 'pro_address' => 'mi casa', 'pro_state' => 'el estei', 'pro_city' => 'la citiman')));
        $this->assertTrue(Project::updateProject(1, array('user_id' => '5', 'pro_address' => 'mi casa', 'pro_state' => 'el estei', 'pro_city' => 'la citiman')));
    }

    public function testCanBeModified() {
        $project = new \stdClass;
        $user = new \stdClass;
        $user->id = 1;
        $user->user_type = User::USER_TYPE_CLIENT;

        $project->pro_status = Project::PROJECT_STATUS_DRAFT;
        $project->user_id =1;

        //$this->assertTrue($project);
        $this->assertTrue(Project::canBeModified($project, $user));

        $project->pro_status = Project::PROJECT_STATUS_ACTIVE;
        $this->assertFalse(Project::canBeModified($project, $user));

        $project->pro_status = Project::PROJECT_STATUS_ADJUDICATED;
        $this->assertFalse(Project::canBeModified($project, $user));

        $project->pro_status = Project::PROJECT_STATUS_CANCELLED;
        $this->assertFalse(Project::canBeModified($project, $user));

        $project->pro_status = Project::PROJECT_STATUS_CLOSED_CLIENT;
        $this->assertFalse(Project::canBeModified($project, $user));

        $project->pro_status = Project::PROJECT_STATUS_CLOSED_FOTOTEA;
        $this->assertFalse(Project::canBeModified($project, $user));

        $project->pro_status = Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER;
        $this->assertFalse(Project::canBeModified($project, $user));

        $project->user_id = 2;
        $this->assertFalse(Project::canBeModified($project, $user));

    }

}