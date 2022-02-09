<?php
ini_set('max_execution_time', '0'); // for infinite time of execution

use Gitlab\Client;
use Gitlab\ResultPager;

error_reporting(0);
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/functions.php");
require_once(__DIR__ . "/todo_issue.php");

$config = require_once(__DIR__ . '/config.php');

$token = $config['gitlab']['token'];
$projects = $config['projects'];
$id_pegawai = $config['id_pegawai'];
$result_dir = $config['result_dir'];
$_SESSION['author'] = $config['gitlab']['author'];


$client = Client::create('https://git.uns.ac.id')
    ->authenticate($token);

foreach ($projects as $projectName => $project) {
    $pager = new ResultPager($client);

    $repositories = $pager->fetch($client->api('issues'), 'all', [
        'project_id' => $project['id'],
        'parameters' => [
            'scope' => 'assigned-to-me',
            'order_by' => 'created_at',
        ]
    ]);

    foreach ($repositories as $repo) {
        foreach ($todo_list as $todo) {
            writeCommitToArrayDirectIssue($arrCommit, $id_pegawai, $repo, $projectName, $todo);
        }

    }

    while ($pager->hasNext()) {
        $repositories = $pager->fetchNext();

        foreach ($repositories as $repo) {
            foreach ($todo_list as $todo) {
                writeCommitToArrayDirectIssue($arrCommit, $id_pegawai, $repo, $projectName, $todo);
            }

        }
    }

}

//injectLogbookKlb($arrCommit);

if (isset($_GET['preview'])) {
    writeXlsFile($arrCommit);
} else {
    injectLogbook($arrCommit);
}

if (isset($_GET['date'])) {
    $oldDate = $_GET['date'];
} else {
    $oldDate = date("Y-m-d");
}
echo json_encode("DONE " . $oldDate);
