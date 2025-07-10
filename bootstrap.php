<?php

define('BASE_PATH', realpath(__DIR__));
define('HANDLERS_PATH', realpath(BASE_PATH . '/handlers'));
define('UTILS_PATH', realpath(BASE_PATH . '/utils'));
define('DUMMIES_PATH', realpath(BASE_PATH . '/staticDatas'));
define('COMPONENTS_PATH', realpath(BASE_PATH . '/components'));
define('LAYOUTS_PATH', realpath(BASE_PATH . '/layouts'));
define('PAGES_PATH', realpath(BASE_PATH . '/pages'));
define('C_ASSETS_PATH', realpath(COMPONENTS_PATH . '/assets'));
define('P_ASSETS_PATH', realpath(PAGES_PATH . '/assets'));

chdir(BASE_PATH);

session_start();