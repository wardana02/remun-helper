<?php

if (isset($_GET['date'])) {
    $oldDate = $_GET['date'];
} else {
    $oldDate = date("Y-m-d");
}

if (isset($_GET['to'])) {
    $fomattedDate = $_GET['to'];
} else {
    $newDate = new DateTime($oldDate);
    $newDate->add(new DateInterval('P1D')); // P1D means a period of 1 day
    $fomattedDate = $newDate->format('Y-m-d');
}


return [
    'id_pegawai' => '6066',
    'gitlab' => [
        'author' => 'aaji',
        'token' => 'cd7zozdELdaVQo-4M2nW',
        'since' => new DateTime($oldDate),
        'until' => new DateTime($fomattedDate),
    ],
    'result_dir' => __DIR__ . "/../runtime/2019B",
    'projects' => [
        'siakad.uns.ac.id' => [
            'use' => 1,
            'id' => 202,
            'branch' => 'master',
        ],
        'spmb.uns.ac.id' => [
            'use' => 1,
            'id' => 205,
            'branch' => 'develop',
        ],
        'spmb.uns.ac.id ' => [
            'use' => 1,
            'id' => 205,
            'branch' => 'ppds-dev',
        ],
        'api-iris.uns.ac.id' => [
            'use' => 1,
            'id' => 463,
            'branch' => 'develop',
        ],
        'ocw.uns.ac.id' => [
            'use' => 1,
            'id' => 549,
            'branch' => 'master',
        ],
        'kkn.uns.ac.id' => [
            'use' => 1,
            'id' => 326,
            'branch' => 'develop',
        ],
        'siakad-old.uns.ac.id' => [
            'use' => 1,
            'id' => 105,
            'branch' => 'master',
        ],
        'app seleksi ' => [
            'use' => 1,
            'id' => 412,
            'branch' => 'develop',
        ],
        'Open Course Ware' => [
            'use' => 1,
            'id' => 549,
            'branch' => 'template-ocw',
        ],
    ],
];
