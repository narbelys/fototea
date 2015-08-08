<?php

namespace Fototea\Models;

use \ORM;
use Fototea\Models\Project;
use Fototea\Util\DateHelper;

class Project_View {

    private static $table = 'proyectos_view';

    /**
     * @param $userId
     * @param $status
     * @param string $extraConditions
     * @return array|\IdiormResultSet
     */
    public static function loadUserProjects($userId, $status, $extraConditions = '') {

        $list = ORM::for_table(self::$table)->select('*');
        $list->where('user_id', $userId);

        if (is_array($status) && (count($status) > 0)){
            $list->where_in('pro_status', $status);
        }

        //Beware of sql inyection
        if (!empty($extraConditions)) {
            $list->where_raw($extraConditions);
        }

        return $list->find_many();
    }

    public static function loadTotalsByStatus($userId, $status = array()) {
        $list = ORM::for_table(self::$table)->select('pro_status')->select_expr('COUNT(*)', 'count');
        $list->where('user_id', $userId);

        if (is_array($status) && (count($status) > 0)){
            $list->where_in('pro_status', $status);
        }

        $list->group_by('pro_status');
        $list = $list->find_many();

        $results = array();
        foreach ($list as $item) {
            $results[$item->pro_status] = $item->count;
        }

        return $results;
    }

    /**
     * @param $id
     * @return object
     */
    public static function loadProjectById($id) {
        $project = ORM::for_table(self::$table)->select('*')->where('pro_id', $id)->find_one();
        $project->days_left = DateHelper::getHoursLeft($project->pro_date_end);
        return $project;
    }

    /**
     * @param $status
     * @param int $limit
     * @param string $orderBy
     * @param string $orderSort
     * @return array|\IdiormResultSet
     */
    public static function loadProjectsByStatus($status, $limit = 0, $orderBy = 'pro_date_end', $orderSort = 'desc') {
        $list = ORM::for_table(self::$table)->select('*');

        if (is_array($status) && (count($status) > 0)){
            $list->where_in('pro_status', $status);
        }

        if ($orderBy) {
            if ($orderSort == 'desc') {
                $list->order_by_desc($orderBy);
            } else {
                $list->order_by_asc($orderBy);
            }
        }

        if ($limit > 0){
            $list->limit($limit);
        }

        return $list->find_many();
    }

    /**
     * @param $userId
     * @return $projectsReceivable with info of the user who published the project.
     */
    public static function loadProjectsReceivableByUser($userId){
        $list = ORM::for_table(self::$table)->select('*')
            ->join('user', array('user_id', '=', 'user.id'))
            ->where_in('pro_status', array(Project::PROJECT_STATUS_ADJUDICATED, Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER, Project::PROJECT_STATUS_CLOSED_CLIENT))
            ->where('oferta_user_id', $userId)
            ->order_by_desc('pro_cdate');

        return $list->find_many();
    }

    public static function getTotalProjectReceivableByUser($userId){
        $projects = self::loadProjectsReceivableByUser($userId);

        $total = 0;

        foreach($projects as $project){
            $total += $project->oferta_bid;
        }

        return $total;
    }
}