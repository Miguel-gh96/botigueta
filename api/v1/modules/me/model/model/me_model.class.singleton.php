<?php
class me_model {

    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = me_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getData($arrArgument) {
        return $this->bll->getData_bll($arrArgument);
    }

}
