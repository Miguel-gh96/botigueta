<?php
class category_model {

    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = category_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getData($arrArgument) {
        return $this->bll->getData_bll($arrArgument);
    }

    public function getCategories($arrArgument) {
        return $this->bll->getCategories_bll($arrArgument);
    }

    public function getAncestors($arrArgument) {
        return $this->bll->getAncestors_bll($arrArgument);
    }

}
