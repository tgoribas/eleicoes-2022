<?php
/**
 * Configuração do Projeo
 */
session_start();

/* Carrega as Variaveis de Ambiente */
loadENV(__DIR__ . '/..');
function loadENV($dir)
{
    // Verifica se o arquivo .env existe
    if (!file_exists($dir . '/.env')) {
        return false;
    }

    // Define as variaveis de ambiente
    $lines = file($dir . '/.env');
    foreach ($lines as $line) {
        putenv(trim($line));
    }
}

// Define as constantes Globais
define('URL', getenv('URL'));
define('FOLDER', getenv('FOLDER'));
define('TOKEN', getenv('TOKEN'));

/*Define as configurações do Banco de Dados*/
$dbConfig = array(
    'db_host' => getenv('DB_HOST'),
    'db_name' => getenv('DB_NAME'),
    'db_user' => getenv('DB_USER'),
    'db_pass' => getenv('DB_PASS'),
    'db_port' => getenv('DB_PORT'),
);

require FOLDER . "/app/database.php";

// Carrega as funções Globais
require FOLDER . "/function/functions.php";
require FOLDER . "/app/estadosBR.php";

$urlImage = 'https://resultados.tse.jus.br/oficial/ele2022/545/fotos/br/';
