<?php
class me_bll {

    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = me_dao::getInstance();
        $this->db = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getData_bll($arrArgument) {
        return $this->dao->getData_dao($this->db, $arrArgument);
    }


}
