<?
error_reporting(E_ALL); 

header('Content-Type: text/html; charset=UTF-8');

define('DS', DIRECTORY_SEPARATOR);

$sitePath = dirname(__FILE__) . DS;
define ("SITE_PATH", $sitePath);

$siteURL = "http://" . $_SERVER["SERVER_NAME"] . ($_SERVER["SERVER_NAME"] == "localhost" ? "/BeeJee/" : "/");
define ("SITE_URL", $siteURL);

spl_autoload_register(function($class_name) {

    $dirs = array(
        "Core",
		"Models",
        "Controllers"
    );

    foreach ($dirs as $dir) {
        if (file_exists($dir . DS . $class_name . ".php")) {
            require_once($dir . DS . $class_name . ".php");
            return;
        }
    }
	
});

include "config.php";

$router = new Router();
$router->setPath(SITE_PATH . "Controllers");
$router->start();
?>