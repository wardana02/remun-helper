<?php
/**
 * Created by PhpStorm.
 * User: Aaji
 * Date: 05/11/2020
 * Time: 21:44
 */

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://remunerasi.uns.ac.id/web/m/simpan_data/remunerasi_logbook_klb",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('i[id_pegawai]' => '6066', 'i[tgl_input]' => date("Y-m-d H:i:s"), 'i[uraian_pekerjaan]' => 'Melakukan perubahan label keterangan diterima pada aplikasi SPMB mdul pantukhir', 'i[tanggal]' => '2020-06-02', 'i[detail_aktivitas]' => 'Melakukan perubahan label keterangan diterima pada aplikasi SPMB mdul pantukhir', 'i[jumlah]' => '1', 'i[lokasi]' => '1', 'i[waktu_mengerjakan]' => '30', 'i[hasil_tindakan]' => 'Telah diselesaikan', 'i[tempat_penyimpanan_bukti]' => 'git.uns.ac.id', 'i[status]' => 'selesai', 'i[keterangan]' => 'aplikasi : spmb.uns.ac.id'),
    CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=v3sfoiovdmkg0spk4ffi36gk60; BNES_PHPSESSID=STwyDVQkxYyM0KXtWHCk7++AYOFnRUpxA4v5tDQwgPP0ulNrs04sR69KMkCIC5qRP6KUHPQDyAWdzV32txhUDfBKgTfBaYJskL/vwdYtTcQ="
    ),
));

$response = curl_exec($curl);

curl_close($curl);
