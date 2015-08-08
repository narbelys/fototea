<?php

namespace Fototea\Models;

use Fototea\Util\DateHelper;
use \ORM;

class Project {

    //projectos.pro_status
    const PROJECT_STATUS_ACTIVE                 = 'A';
    const PROJECT_STATUS_DRAFT                  = 'B';
    const PROJECT_STATUS_ADJUDICATED            = 'AD';
    const PROJECT_STATUS_CLOSED_PHOTOGRAPHER    = 'FF';
    const PROJECT_STATUS_CLOSED_CLIENT          = 'FC';
    const PROJECT_STATUS_CLOSED_FOTOTEA         = 'E';
    const PROJECT_STATUS_CANCELLED              = 'C';

    const PROJECT_ENVIRONMENT_INSIDE = 'interior';
    const PROJECT_ENVIRONMENT_OUTSIDE = 'exterior';
    const PROJECT_MOMENT_DAY = 'dia';
    const PROJECT_MOMENT_NIGHT = 'noche';

    private static $table = 'proyectos';

    public static function getStatusName($status){
        switch($status){
            case self::PROJECT_STATUS_ACTIVE:
                return 'Activo';
            case self::PROJECT_STATUS_DRAFT:
                return 'Borrador';
            case self::PROJECT_STATUS_ADJUDICATED:
                return 'Adjudicado';
            case self::PROJECT_STATUS_CLOSED_PHOTOGRAPHER:
                return 'Finalizado';
            case self::PROJECT_STATUS_CLOSED_CLIENT:
                return 'Finalizado';
            case self::PROJECT_STATUS_CLOSED_FOTOTEA:
                return 'Finalizado';
            case self::PROJECT_STATUS_CANCELLED:
                return 'Cancelado';
        }
    }

    public static function getMomentsName($moment){
        switch($moment){
            case self::PROJECT_MOMENT_DAY:
                return 'Día';
            case self::PROJECT_MOMENT_NIGHT:
                return 'Noche';
        }
    }

    public static function getEnvironmentsName($env){
        switch($env){
            case self::PROJECT_ENVIRONMENT_INSIDE:
                return 'Interiores';
            case self::PROJECT_ENVIRONMENT_OUTSIDE:
                return 'Exteriores';
        }
    }

    public static function canBeCancelled($project) {
        if (($project->pro_status == self::PROJECT_STATUS_ACTIVE) || ($project->pro_status == self::PROJECT_STATUS_DRAFT)){
            return true;
        }

        return false;
    }

    public static function canBeModified($project, $user) {
        if (($project->pro_status === self::PROJECT_STATUS_DRAFT) && ($project->user_id === $user->id) && ($user->user_type == User::USER_TYPE_CLIENT)){
            return true;
        }

        return false;
    }

    public static function canBeAdjudicated($project) {
        if ($project->pro_status === self::PROJECT_STATUS_ACTIVE) {
            return true;
        }
        return false;
    }

    /**
     * Check if project can be qualified by the user given
     *
     * @param $project
     * @param $user
     * @return bool
     */
    public static function canBeQualified($project, $user) {
        //TODO chequear owner aqui?? o en otro lado??

        //Checkdates
        if (!DateHelper::isPastDate($project->pro_date)) {
            return false;
        }

        //TODO las calificaciones no deberian depender del estatus, se esta complicando esto, revisar
        //Check status
        if ($user->user_type == User::USER_TYPE_CLIENT) {
            if (($project->pro_status == self::PROJECT_STATUS_ADJUDICATED || $project->pro_status == self::PROJECT_STATUS_CLOSED_PHOTOGRAPHER)){
                return true;
            }
        }

        if ($user->user_type == User::USER_TYPE_PHOTOGRAPHER) {
            if (($project->pro_status == self::PROJECT_STATUS_ADJUDICATED || $project->pro_status == self::PROJECT_STATUS_CLOSED_CLIENT)){
                return true;
            }
        }

        return false;
    }

    public static function createProjectFromTmp($tmpProject, $userId){
        $project = ORM::for_table(self::getTable())->create();

        $project->set('pro_cod', $tmpProject->pro_cod);
        $project->set('pro_tit', $tmpProject->pro_tit);
        $project->set('pro_descripcion', $tmpProject->pro_descripcion);
        //$project->set('pro_budget', $_POST['pro_budget']); deprecated
        $project->set('pro_date', $tmpProject->pro_date);
        $project->set('pro_date_end', $tmpProject->pro_date_end);
        $project->set('pro_cant', $tmpProject->pro_cant);
        $project->set('pro_length', $tmpProject->pro_length);
        $project->set('pro_country', $tmpProject->pro_country);
        $project->set('pro_state', $tmpProject->pro_state);
        $project->set('pro_city', $tmpProject->pro_city);
        $project->set('pro_address', $tmpProject->pro_address);
        $project->set('pro_cp', $tmpProject->pro_cp);
        $project->set('pro_type', $tmpProject->pro_type);
        $project->set('pro_category', $tmpProject->pro_category);
        $project->set('user_id', $userId);
        $project->set('pro_status', $tmpProject->pro_status);
        $project->set('pro_cdate', $tmpProject->pro_cdate);
        $project->set('pro_environment', $tmpProject->pro_environment);
        $project->set('pro_moment', $tmpProject->pro_moment);
        $project->set('pro_deadline', $tmpProject->pro_deadline);

        $project->save();

        return $project;
    }

    /**
     * Load proyect by id and return it
     *
     * @param $id
     * @return bool|mixed
     */
    public static function loadById($id) {
        $project = ORM::for_table(self::$table)->where('pro_id', $id)->find_many();
        if (count($project) > 0) {
            return array_shift($project);
        }
        return false;
    }

    /**
     * Update proyect with give data (Except user_id and cdate)
     * A project cannot change its owner
     *
     * @param $id
     * @param array $data
     * @return bool
     */
    public static function updateProject($id, $data = array()) {

        if (count($data) == 0) {
            return false;
        }

        $project = ORM::for_table(self::$table)->where('pro_id', $id)->find_many();

        if (count($project) == 0) {
            return false;
        }

        $pdo = ORM::get_db();
        $raw_query = "UPDATE ".self::$table . " SET ";
        $raw_parameters = array();

        if (isset($data['pro_tit'])) {
            //$raw_query .= "pro_tit = :pro_tit";
            $raw_parameters['pro_tit'] = $data['pro_tit'];
        }


        if (isset($data['pro_descripcion'])) {
            //$raw_query .= "pro_descripcion = :pro_descripcion";
            $raw_parameters['pro_descripcion'] = $data['pro_descripcion'];
        }


        if (isset($data['pro_budget'])) {
            //$raw_query .= ", pro_budget = :pro_budget";
            $raw_parameters['pro_budget'] = $data['pro_budget'];

        }

        if (isset($data['pro_date'])) {
            //$raw_query .= ", pro_date = :pro_date";
            $raw_parameters['pro_date'] = $data['pro_date'];

        }

        if (isset($data['pro_date_end'])) {
           // $raw_query .= ", pro_date_end = :pro_date_end";
            $raw_parameters['pro_date_end'] = $data['pro_date_end'];

        }

        if (isset($data['pro_cant'])) {
            //$raw_query .= ", pro_cant = :pro_cant";
            $raw_parameters['pro_cant'] = $data['pro_cant'];
        }

        if (isset($data['pro_length'])) {
            //$raw_query .= ", pro_length = :pro_length";
            $raw_parameters['pro_length'] = $data['pro_length'];

        }

        if (isset($data['pro_country'])) {
            //$raw_query .= ", pro_country = :pro_country";
            $raw_parameters['pro_country'] = $data['pro_country'];
        }

        if (isset($data['pro_state'])) {
            //$raw_query .= ", pro_state = :pro_state";
            $raw_parameters['pro_state'] = $data['pro_state'];

        }

        if (isset($data['pro_city'])) {
            //$raw_query .= ", pro_city = :pro_city";
            $raw_parameters['pro_city'] = $data['pro_city'];
        }

        if (isset($data['pro_address'])) {
            //$raw_query .= ", pro_address = :pro_address";
            $raw_parameters['pro_address'] = $data['pro_address'];
        }

        if (isset($data['pro_cp'])) {
            //$raw_query .= ", pro_cp = :pro_cp";
            $raw_parameters['pro_cp'] = $data['pro_cp'];
        }

        if (isset($data['pro_type'])) {
            //$raw_query .= ", pro_type = :pro_type";
            $raw_parameters['pro_type'] = $data['pro_type'];
        }

        if (isset($data['pro_category'])) {
            //$raw_query .= ", pro_category = :pro_category";
            $raw_parameters['pro_category'] = $data['pro_category'];
        }

        if (isset($data['pro_status'])) {
            //$raw_query .= ", pro_status = :pro_status";
            $raw_parameters['pro_status'] = $data['pro_status'];
        }

        $raw_parameters['pro_environment'] = $data['pro_environment'];
        $raw_parameters['pro_moment'] = $data['pro_moment'];
        $raw_parameters['pro_deadline'] = $data['pro_deadline'];

        if (count($raw_parameters) == 0) {
            return false;
        }

        $ctl = 0;
        foreach ($raw_parameters as $key => $param) {
            if ($ctl == 0){
                $raw_query .= "$key = :$key";
                $ctl++;
            }
            $raw_query .= ", $key = :$key";
        }

        $raw_query .= ' WHERE pro_id = ' . intval($id);
        //echo $raw_query;

        $statement = $pdo->prepare($raw_query);
        return $statement->execute($raw_parameters);

    }

    public static function getTable() {
        return self::$table;
    }
}