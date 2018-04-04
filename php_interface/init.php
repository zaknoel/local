<?
include("sdvv/defines.php");
include("sdvv/events.php");
include("sdvv/functions.php");
spl_autoload_register(function ($class_name) {
    include_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/sdvv/classes/".$class_name.".php");
});
$detect = new Mobile_Detect;
define("IS_MOBILE", ($detect->isMobile())?(true):(false));
define("IS_TABLET", ($detect->isTablet())?(true):(false));
define("IS_TOUCHPAD", (IS_MOBILE || IS_TABLET)?(true):(false));
?>