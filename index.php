<?php
define('BASE_PATH', __DIR__ . '/');

/**
* VERSÃO DE TESTE
* Permite a escolha automática do ambiente de desenvolvimento
* Sendo que em localhost, automaticamente será acessado no ambiente development
*/
if($_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
	define('PURE_ENV', 'development');
} else {
	define('PURE_ENV', 'production');
}
// DEBUG MODE
define('PURE_DEBUG', false);
require(BASE_PATH . 'app/configs/env/environment.php');
require(BASE_PATH . 'pure/kernel/autoloader.php');

use Pure\Kernel\Engine;
use App\Utils\Helpers;

if(!in_array(Helpers::get_client_ip(), ['127.0.0.1','143.54.196.69'])) {
	exit();
}
$app = Engine::get_instance();
$app->execute();