<?php

//index.php

//FSkript 1.0.0

//Including the function and classes.

require_once 'includes/functions.php';
autoload_classes();

//Including the function and classes.

//Session setting and start of the session.

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
session_start ();

//Session setting and start of the session.

//Script data.

define('name', 'FSkript');
define('version', '1.0.0');
define('author', 'pathologicalplay');

//Script data.

//Router.

$router = new Router();
$router->route();

//Router.

?>

