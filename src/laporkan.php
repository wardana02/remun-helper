<?php
ini_set('max_execution_time', '0'); // for infinite time of execution

use Gitlab\Client;
use Gitlab\ResultPager;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/functions.php");


$config = require_once(__DIR__ . '/config.php');

$token = $config['gitlab']['token'];
$projects = $config['projects'];
$id_pegawai = $config['id_pegawai'];
$result_dir = $config['result_dir'];
$_SESSION['author'] = $config['gitlab']['author'];

if (isset($_GET['date'])) {
    $oldDate = $_GET['date'];
} else {
    $oldDate = date("Y-m-d");
}

$date_bln = explode('-', $oldDate)[1];
$date_thn = (explode('-', $oldDate)[0]);

require_once(__DIR__ . "/todo.php");
foreach ($todo_list as $todo) {
    //echo $todo['id']."-".$date_thn."-".$date_bln."-6066";
    laporLogbook($todo['id'], $date_thn, $date_bln, 6066);
}

require_once(__DIR__ . "/issues.php");
foreach ($todo_list as $todo) {
    //echo $todo['id']."-".$date_thn."-".$date_bln."-6066";
    laporLogbook($todo['id'], $date_thn, $date_bln, 6066);
}


echo json_encode("DONE " . $oldDate);

