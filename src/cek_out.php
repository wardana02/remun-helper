<?php
/**
 * Created by PhpStorm.
 * User: Aaji
 * Date: 05/11/2020
 * Time: 22:54
 */

//LOGIN
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://remunerasi.uns.ac.id/web/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => array('a' => '1996022320180801', 'b' => 'NOLRUPIAH', 'sebagai' => '1', 'submit' => 'login'),
    CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=v3sfoiovdmkg0spk4ffi36gk60; BNES_PHPSESSID=STwyDVQkxYyM0KXtWHCk7++AYOFnRUpxA4v5tDQwgPP0ulNrs04sR69KMkCIC5qRP6KUHPQDyAWdzV32txhUDfBKgTfBaYJskL/vwdYtTcQ="
    ),
));

$response = curl_exec($curl);

curl_close($curl);


//SWITCH TO AJI

/*$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://remunerasi.uns.ac.id/simempat.35_do.pindah_01_6066.html",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => array('a' => '1','b' => '3','sebagai' => '1','submit' => 'login'),
    CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=v3sfoiovdmkg0spk4ffi36gk60; BNES_PHPSESSID=STwyDVQkxYyM0KXtWHCk7++AYOFnRUpxA4v5tDQwgPP0ulNrs04sR69KMkCIC5qRP6KUHPQDyAWdzV32txhUDfBKgTfBaYJskL/vwdYtTcQ="
    ),
));

$response = curl_exec($curl);

curl_close($curl);*/


//CEKOUT

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://remunerasi.uns.ac.id/web/m/cek_out",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=v3sfoiovdmkg0spk4ffi36gk60; BNES_PHPSESSID=STwyDVQkxYyM0KXtWHCk7++AYOFnRUpxA4v5tDQwgPP0ulNrs04sR69KMkCIC5qRP6KUHPQDyAWdzV32txhUDfBKgTfBaYJskL/vwdYtTcQ="
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo date("Y-m-d") . " - " . $response;
