<?php
class product_model {

    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = product_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getData($arrArgument) {

        return $this->bll->getData_bll($arrArgument);
    }

    public function getListByCategory($arrArgument) {

        return $this->bll->getListByCategory_bll($arrArgument);
    }

    public function getListByQuery($arrArgument) {

        return $this->bll->getListByQuery_bll($arrArgument);
    }

    public function getAncestors($arrArgument) {
        return $this->bll->getAncestors_bll($arrArgument);
    }

}
