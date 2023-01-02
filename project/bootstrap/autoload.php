<?php
session_start();


require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Asia/Tehran');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

errorHandle();
if (!getLanguage())
    setLanguage('fa');


$connection = connection(envv('DB_HOST'), envv('DB_USERNAME'), envv('DB_PASSWORD'), envv('DB_DATABASE'));


$base_url = baseUrl(httpCheck());
$adminPanelUrl = adminPanelUrl($base_url);
$current_url = $_GET['rt'] ?? '/';
$pages = seprator($current_url);

$route = route($pages[0], $pages[1] ?? '-', $adminPanelUrl);

view($route);





