<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\map;

class AmbilController extends Controller
{
    //get data
    public function index() //deklarasi fungsi index (memanggil semua field di thingspeak)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.thingspeak.com/channels/1567602/feeds.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            return $response;
        }
    }

    public function suhu() //deklarasi function suhu (get suhu max, min, avg, grafik)
    {
        $currentDate = strval(gmdate("Y-m-d"));
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/feeds.json?key=AB2MDITZZC8AK4Z9&start=" . $currentDate . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+07:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                //set here your requesred headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $array_tanggal = array();
            $field1 = array();
            foreach ($response['feeds'] as $responses) {
                $originalDate = $responses['created_at']; //mengambil data tanggal dari creted_at
                $newDate = date("H:i", strtotime($originalDate) + 60 * 60 * 7); //mengubah tanggal
                array_push($array_tanggal, $newDate);

                $field1[] = $responses['field1'];
                $max = max($field1); //mencari value tertinggi
                $min = min($field1); //mencari value terendah
                $sum = array_sum($field1); //menjumlahkan value datanya
                $count = count($field1); //menjumlahkan datanya
                $avg = $sum / $count; //fungsi average(rata-rata)
            }
        }
        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Suhu"; //menampilkan pesan
        $data['data_tertinggi'] = $max;
        $data['data_terendah'] = $min;
        $data['data_rata'] = $avg;
        $data['x'] = $array_tanggal;
        $data['y'] = $field1;
        return $data;
    }

    public function saturasi() //deklarasi function suhu (get suhu max, min, avg, grafik)
    {
        $currentDate = strval(gmdate("Y-m-d"));
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/feeds.json?key=AB2MDITZZC8AK4Z9&start=" . $currentDate . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+00:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                //set here your requesred headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $array_tanggal = array();
            $field2 = array();
            foreach ($response['feeds'] as $responses) {
                $originalDate = $responses['created_at']; //mengambil data tanggal dari creted_at
                $newDate = date("H:i", strtotime($originalDate) + 60 * 60 * 7); //mengubah tanggal
                array_push($array_tanggal, $newDate);

                $field2[] = $responses['field2'];
                $max = max($field2); //mencari value tertinggi
                $min = min($field2); //mencari value terendah
                $sum = array_sum($field2); //menjumlahkan value datanya
                $count = count($field2); //menjumlahkan datanya
                $avg = $sum / $count; //fungsi average(rata-rata)
            }
        }
        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Suhu"; //menampilkan pesan
        $data['data_tertinggi'] = $max;
        $data['data_terendah'] = $min;
        $data['data_rata'] = $avg;
        $data['x'] = $array_tanggal;
        $data['y'] = $field2;
        return $data;
    }

    public function jmlhpengunjunghariini() //deklarasi function menghitung pengunjung hari ini
    {
        $curl = curl_init();
        $currentDate = strval(gmdate("Y-m-d"));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/fields/4.json?key=AB2MDITZZC8AK4Z9&start=" . $currentDate . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+00:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $field4 = array();
            foreach ($response['feeds'] as $responses) {
                $field4[] = $responses['field4'];
                $count = count($field4); //menghitung data
            }
        }

        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Jumlah Pengunjung Hari Ini"; //menampilkan pesan
        $data['data'] = $count; //ambil data terakhir di hari ini
        return $data;
    }

    public function jmlhpengunjungmingguini() //deklarasi function menghitung pengunjung minggu ini
    {
        $curl = curl_init();
        $currentDate = strval(gmdate("Y-m-d"));
        $sevendaysago = date('Y-m-d', strtotime('-7 days'));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/fields/4.json?key=AB2MDITZZC8AK4Z9&start=" . $sevendaysago . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+00:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $field4 = array();
            foreach ($response['feeds'] as $responses) {
                $field4[] = $responses['field4'];
                $count = count($field4); //menjumlahkan data
            }
        }

        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Jumlah Pengunjung Minggu Ini"; //menampilkan pesan
        $data['data'] = $count; //menampilkan jumlah data
        return $data;
    }

    public function jmlhpengunjungbulanini() //deklarasi function menghitung jumlah pengunjung bulan ini
    {
        $curl = curl_init();
        $currentDate = strval(gmdate("Y-m-d"));
        $thirtydaysago = date('Y-m-d', strtotime('-30 days'));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/fields/4.json?key=AB2MDITZZC8AK4Z9&start=" . $thirtydaysago . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+00:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $field4 = array();
            foreach ($response['feeds'] as $responses) {
                $field4[] = $responses['field4'];
                $count = count($field4); //menjumlahkan data
            }
        }

        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Jumlah Pengunjung Bulan Ini"; //menampilkan pesan
        $data['data'] = $count; //jumlah data perbulan
        return $data;
    }
    public function cairan() //deklasi function cairan
    {
        $curl = curl_init();
        $currentDate = strval(gmdate("Y-m-d"));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/feeds.json?key=AB2MDITZZC8AK4Z9&start=" . $currentDate . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+00:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $field3 = array();
            foreach ($response['feeds'] as $responses) {
                $field3[] = $responses['field3'];
                $last = last($field3); //ambil data terakhir
            }
        }

        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Cairan"; //menampilkan pesan
        $data['data'] = $last; //jumlah data perbulan
        return $data;
    }

    public function grafikpengunjung() //deklarasi index pengunjung(menampilkan seluruh data pengunjung)
    {

        $currentDate = strval(gmdate("Y-m-d"));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.thingspeak.com/channels/1567602/feeds.json?key=AB2MDITZZC8AK4Z9&start=" . $currentDate . "T00:00+02:00&end=" . $currentDate . "T23:59+02:00&timezone=GMT+00:00",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            $array_tanggal = array();
            $field4 = array();
            foreach ($response['feeds'] as $responses) {
                $originalDate = $responses['created_at'];
                $newDate = date("H:i", strtotime($originalDate) + 60 * 60 * 7); //mengubah tanggal
                //$array_waktu = DateTime::createFromFormat($responses['created_at']);
                array_push($array_tanggal, $newDate);
                $field4[] = $responses['field4'];
            }
        }

        $data['status'] = true; //menampilkan status
        $data['message'] = "Data Pengunjung"; //menampilkan pesan
        $data['x'] = $array_tanggal;
        $data['y'] = $field4;
        return $data;
    }
}
