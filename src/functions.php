<?php


function writeCommitToArrayDirect(&$arrCommit, $id_pegawai, $repo, $project_name, $uraian)
{

    $flag = true;


    $flag = $flag && (false !== stripos($repo['author_name'], $_SESSION['author']));
    $flag = $flag && (false === stripos($repo['message'], 'merge'));

    if ($flag and ($uraian['use'] == 1)) {
        $uj = explode('-', $repo['message']);
        $jml = substr_count($repo['message'], " dan ");
        $jml += 1;

        if (($uj[0] <> $uraian['prefix_commit']) and ($uraian['prefix_commit'] == '*') and strlen($uj[0]) > 10) {
            $arrCommit[] = [
                $id_pegawai,
                getGitDate($repo['authored_date']),
                $uraian['id'],
                $uraian['prefix'] . $repo['message'],
                $jml,
                1,
                'Hasil Pekerjaan : ' . $uraian['hasil'],
                $uraian['bukti'],
                "Keterangan aplikasi : " . $project_name,
                $uraian['durasi']
            ];
        } elseif (($uj[0] == $uraian['prefix_commit']) and ($uraian['prefix_commit'] <> '*')) {
            $arrCommit[] = [
                $id_pegawai,
                getGitDate($repo['authored_date']),
                $uraian['id'],
                $uraian['prefix'] . $repo['message'],
                $jml,
                1,
                'Hasil Pekerjaan : ' . $uraian['hasil'],
                $uraian['bukti'],
                "Keterangan aplikasi : " . $project_name,
                $uraian['durasi']
            ];
        }

        //echo "asd";exit;



    }
}

function writeCommitToArrayDirectIssue(&$arrCommit, $id_pegawai, $repo, $project_name, $uraian)
{
    $flag = false;
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    } else {
        $date = date("Y-m-d");
    }
    if (strpos($repo['created_at'], $date) !== false) {
        $flag = true;
    }

    if ($flag and ($uraian['use'] == 1)) {

        $uj = explode('-', $repo['message']);
        $jml = substr_count($repo['message'], " dan ");
        $jml += 1;

        if (($uj[0] <> $uraian['prefix_commit']) and ($uraian['prefix_commit'] == '*') and strlen($uj[0]) > 10) {
            $arrCommit[] = [
                $id_pegawai,
                getGitDate($repo['created_at']),
                $uraian['id'],
                $uraian['prefix'] . $repo['title'],
                1,
                1,
                'Hasil Pekerjaan : ' . $uraian['hasil'],
                $uraian['bukti'],
                "Keterangan aplikasi : " . $project_name
            ];
        } elseif (($uj[0] == $uraian['prefix_commit']) and ($uraian['prefix_commit'] <> '*')) {
            $arrCommit[] = [
                $id_pegawai,
                getGitDate($repo['created_at']),
                $uraian['id'],
                $uraian['prefix'] . $repo['title'],
                1,
                1,
                'Hasil Pekerjaan : ' . $uraian['hasil'],
                $uraian['bukti'],
                "Keterangan aplikasi : " . $project_name
            ];
        }


    }
}

function writeCommitToArray(&$arrCommit, $id_pegawai, $repo, $project_name)
{
    $flag = true;

    $flag = $flag && (false !== stripos($repo['author_name'], $_SESSION['author']));
    $flag = $flag && (false === stripos($repo['message'], 'merge'));

    if ($flag) {

        extract(getIdUraianAndMessage($repo['message']));
        $arrCommit[$id_uraian][] = [
            '',
            $id_pegawai,
            getGitDate($repo['authored_date']),
            $id_uraian,
            $message,
            1,
            1,
            '',
            'git.uns.ac.id',
            $project_name
        ];
    }
}

function getIdUraianAndMessage($message)
{
    //JIKA INGIN URAIAN DIBAGI PER TANDA PADA COMMIT MESSAGE, MAKA DEFINISIKAN DISINI
    //JIKA TIDAK KOSONGKAN var $arr
    $arr = [
        //'fix bug' => '9371146',
    ];

    $messageParts = explode(":", $message);
    $prefix = trim($messageParts[0]);
    if (isset($messageParts[1])) {
        $message = trim($messageParts[1]);
    }

    if (isset($arr[$prefix])) {
        return [
            'id_uraian' => $arr[$prefix],
            'message' => trim(ucfirst($message)),
        ];
    }

    return [
        'id_uraian' => '',
        'message' => trim(ucfirst($message)),
    ];
}

function getGitDate($gitDateTime)
{
    $time = strtotime($gitDateTime);
    $date = date('Y-m-d', $time);
    //$dt = explode('-', $date);
    //$date = $dt[0] . '-' . '09' . '-'.$dt[2];
    //print_r($date);exit;
    return $date;
}

function writeXlsFile($data)
{
    require_once(__DIR__ . "/excel.php");
}

function injectLogbookKlb($logbook_data)
{
    $minutes_to_add = 5;
    $date = date("Y-m-d H:i:s");

    foreach ($logbook_data as $logbook) {
        $minutes_to_add = $minutes_to_add + 5;
        $time = new DateTime($date);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $stamp = $time->format('Y-m-d H:i:s');

        $curl = curl_init();
        //print_r($logbook);echo $stamp;exit;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://remunerasi.uns.ac.id/web/m/simpan_data/remunerasi_logbook_klb",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('i[id_pegawai]' => $logbook[0], 'i[tgl_input]' => $stamp, 'i[uraian_pekerjaan]' => $logbook[3], 'i[tanggal]' => $logbook[1], 'i[detail_aktivitas]' => $logbook[3], 'i[jumlah]' => '1', 'i[lokasi]' => '1', 'i[waktu_mengerjakan]' => $logbook[9], 'i[hasil_tindakan]' => $logbook[6], 'i[tempat_penyimpanan_bukti]' => $logbook[7], 'i[status]' => 'selesai', 'i[keterangan]' => $logbook[8]),
            CURLOPT_HTTPHEADER => array(
                "Cookie: PHPSESSID=koasmhuc4brsb1uu73d1sdk1d5; BNES_PHPSESSID=GPftn9RXAFFRZcBXfhQdKwBusR4YLx9PSRkk/4RvSjpE0jvZGciaeBke8/nJzCu1jeO8zXuWu+vCowYDe42OeU1unnk2Epi5Idcwn1bRARc="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;//exit;

    }

}

function injectLogbook($logbook_data)
{

    //url old
    //"https://remunerasi.uns.ac.id/application/component/logbook.2017/index.ctrl.php?t=cmVtdW5lcmFzaV9sb2dib29rX2hhcmlhbl91bnM=&w=YW5kIG5pcD0nMTk5NjAyMjMyMDE4MDgwMSc=&act=c"
    $minutes_to_add = 5;
    $date = date("Y-m-d H:i:s");

    foreach ($logbook_data as $logbook) {
        $date_bln = number_format(explode('-', $logbook[1])[1]);
        $minutes_to_add = $minutes_to_add + 5;
        $time = new DateTime($date);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $stamp = $time->format('Y-m-d H:i:s');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://remunerasi.uns.ac.id/application/component/logbook.2021/index.ctrl.php?t=cmVtdW5lcmFzaV9sb2dib29rX2hhcmlhbl91bnNfMjAyMg==&w=YW5kIG5pcD0nMTk5NjAyMjMyMDE4MDgwMSc=&act=c",
            //CURLOPT_URL => "https://remunerasi.uns.ac.id/application/component/logbook.2021/index.ctrl.php?t=cmVtdW5lcmFzaV9sb2dib29rX2hhcmlhbl91bnM=&w=YW5kIG5pcD0nMTk5NjAyMjMyMDE4MDgwMSc=&act=c",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('i[id_pegawai]' => $logbook[0], 'i[tgl_input]' => $stamp, 'tahun' => '2021', 'bln' => $date_bln, 'i[revisi_ke]' => '', 'i[id_uraian_pekerjaan]' => $logbook[2], 'i[tanggal]' => $logbook[1], 'i[detail_aktifitas]' => $logbook[3], 'i[jumlah]' => '1', 'i[lokasi]' => '1', 'i[hasil_tindakan]' => $logbook[6], 'i[tempat_penyimpanan_bukti]' => $logbook[7], 'i[keterangan]' => $logbook[8]),
            CURLOPT_HTTPHEADER => array(
                "Cookie: PHPSESSID=koasmhuc4brsb1uu73d1sdk1d5; BNES_PHPSESSID=GPftn9RXAFFRZcBXfhQdKwBusR4YLx9PSRkk/4RvSjpE0jvZGciaeBke8/nJzCu1jeO8zXuWu+vCowYDe42OeU1unnk2Epi5Idcwn1bRARc="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

    }


}

function laporLogbook($idU, $thn, $bln, $idP)
{


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://remunerasi.uns.ac.id/application/component/logbook.2021/page/laporkan.logbook.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('idU' => $idU, 'thn' => $thn, 'bln' => $bln, 'idP' => $idP),
        CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=l0lh7qb3ouqu6itavg1fv90fp2; BNES_PHPSESSID=OX+kYunot/aU8qXnZGP3UPT3bNRZP+3XFp3/gl/9/7nfjz4er0kgs4xPqHxGAKYeUAOYvtqvntNPuadJ/I6qNFjkwfkYBeqAwQ29BHHSg54='
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

}

?>
