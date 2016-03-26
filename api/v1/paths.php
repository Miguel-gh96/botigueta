<?php

/*
 * Name Project
 */
define('PROJECT', '/api/v1/');

/*
 * $path
 */
$path = $_SERVER['DOCUMENT_ROOT'] . PROJECT;

/*
 * SITE_ROOT
 */
define('SITE_ROOT', $path);

/*
 * SITE_PATH
 */
define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . PROJECT);

/*
 * LIBS
 */
define('LIBS', SITE_ROOT . 'libs/');


//model
define('MODEL_PATH', SITE_ROOT . 'model/');


//modules
define('MODULES_PATH', SITE_ROOT . 'modules/');

//utils
define('UTILS', SITE_ROOT . 'utils/');


//category
define('MODEL_CATEGORY', SITE_ROOT . 'modules/category/model/model/');

//product
define('MODEL_PRODUCT', SITE_ROOT . 'modules/product/model/model/');

//me
define('MODEL_ME', SITE_ROOT . 'modules/me/model/model/');

//amigables
define('URL_AMIGABLES', TRUE);

//Production
define('PRODUCTION', true);
