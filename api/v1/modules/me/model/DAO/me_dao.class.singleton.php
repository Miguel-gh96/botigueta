<?php

class me_dao
{
    public static $_instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getData_dao($db, $arrArgument) {

        $sql = "SELECT * FROM users WHERE _id = '56e71da7eb9fc6d6bb00ad7f'";
        /*$stmt = $db->ejecutar($sql);*/
        /*$sql = "SELECT *
                FROM categories as c
                INNER JOIN products as p
                ON p.category_id = c._id
                where id_ = '2'";*/

        $stmt = $db->ejecutar($sql);

        return $db->listar($stmt);

        //return $db->listar($stmt);
    }


}
