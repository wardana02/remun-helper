<?php
ini_set('max_execution_time', '0'); // for infinite time of execution

use Gitlab\Client;
use Gitlab\ResultPager;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/functions.php");
require_once(__DIR__ . "/todo.php");

$config = require_once(__DIR__ . '/config.php');

$token = $config['gitlab']['token'];
$projects = $config['projects'];
$id_pegawai = $config['id_pegawai'];
$result_dir = $config['result_dir'];
$_SESSION['author'] = $config['gitlab']['author'];


$client = Client::create('https://git.uns.ac.id')
    ->authenticate($token);


foreach ($projects as $projectName => $project) {
    if ($project['use'] == 1) {
        $pager = new ResultPager($client);

        $repositories = $pager->fetch($client->api('repositories'), 'commits', [
            'project_id' => $project['id'],
            'parameters' => [
                'since' => $config['gitlab']['since'],
                'until' => $config['gitlab']['until'],
                'ref_name' => $project['branch'],
            ],
        ]);


        //print_r($config);exit;
        foreach ($repositories as $repo) {
            foreach ($todo_list as $todo) {
                writeCommitToArrayDirect($arrCommit, $id_pegawai, $repo, $projectName, $todo);
            }

        }

        while ($pager->hasNext()) {
            $repositories = $pager->fetchNext();
            foreach ($repositories as $repo) {
                foreach ($todo_list as $todo) {
                    writeCommitToArrayDirect($arrCommit, $id_pegawai, $repo, $projectName, $todo);
                }
            }
        }
    }
}

//echo "<pre>";print_r($arrCommit);exit;


if (isset($_GET['preview'])) {
    writeXlsFile($arrCommit);
} else {
    injectLogbook($arrCommit);
}


//injectLogbookKlb($arrCommit);

if (isset($_GET['date'])) {
    $oldDate = $_GET['date'];
} else {
    $oldDate = date("Y-m-d");
}
echo json_encode("DONE " . $oldDate);

