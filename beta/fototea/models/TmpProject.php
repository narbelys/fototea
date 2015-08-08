<?php

namespace Fototea\Models;

use \ORM;

class TmpProject {

    private static $table = 'tmp_project';

    public static function getTmpProjectByTmpId($tmpId){
        $tmpProject = ORM::for_table(self::$table)
                            ->where('pro_tmp_id', $tmpId)
                            ->where_null('user_id')
                            ->find_one();

        return $tmpProject;
    }

    public static function assignTmpProjectToUser($tmpProjectId, $userId){
        $pdo = ORM::get_db();
        $raw_query = "UPDATE ".self::$table." SET user_id = :uid WHERE pro_id = :tpid AND user_id IS NULL";
        $raw_parameters = array('uid' => $userId, 'tpid' => $tmpProjectId);
        $statement = $pdo->prepare($raw_query);
        $statement->execute($raw_parameters);

        return ;
    }

    public static function getTable() {
        return self::$table;
    }
}