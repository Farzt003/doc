<?php
date_default_timezone_set('Asia/Jakarta');
/**
 * @Author: Eka Syahwan
 * @Date:   2017-09-09 07:04:25
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2018-01-08 03:32:29
 */
error_reporting(0);
ini_set('memory_limit', '-1');
mkdir('result-email');
mkdir('result-sampah');
 
$f = file_get_contents($argv[1]);
$f = explode("\r\n", $f);
$counts = count($f);
$f = array_unique($f);
 
$count      = count($f);
$yahoo      = 0;
$gmail      = 0;
$hotmail    = 0;
$aol        = 0;
$other      = 0;
$sampah     = 0;
$valid      = 0;
$hitung     = 0;
echo '
____ _ _    ___ ____ ____    ____ _  _ ____ _ _    
|___ | |     |  |___ |__/    |___ |\/| |__| | |     SPAMMER ID 2018
|    | |___  |  |___ |  \    |___ |  | |  | | |___  SHOR7CUT
 
';
foreach ($f as $key => $email) {
    $explode = explode("@", $email);
    if(! is_numeric($explode[0]) && filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/marketplace|marketplace.amazon|example|test|auto@|cdiscount.com/", $explode[0]) && !preg_match("/marketplace|marketplace.amazon|example|test|auto@|cdiscount.com|emaildomain/", $explode[1])){
       
        if(preg_match("/gmail/", $explode[1])){
            $x = fopen("result-email/email-gmail.txt", "a+");
            fwrite($x, $email."\r\n");
            fclose($x);
           
            $gmail++;
 
        }else if(preg_match("/yahoo|ymail|rocketmail/", $explode[1])){
            $x = fopen("result-email/email-yahoo.txt", "a+");
            fwrite($x, $email."\r\n");
            fclose($x);
 
            $yahoo++;
 
        }else if(preg_match("/hotmail|live|outlook|msn/", $explode[1])){
            $x = fopen("result-email/email-hotmail.txt", "a+");
            fwrite($x, $email."\r\n");
            fclose($x);
            $hotmail++;
        }else if(preg_match("/aol/", $explode[1])){
            $x = fopen("result-email/email-aol.txt", "a+");
            fwrite($x, $email."\r\n");
            fclose($x);
            $aol++;
        }else{
            $x = fopen("result-email/email-other.txt", "a+");
            fwrite($x, $email."\r\n");
            fclose($x);
            $other++;
        }
        $valid++;
    }else{
        $x = fopen("result-sampah/email-sampah.txt", "a+");
        fwrite($x, $email."\r\n");
        fclose($x);
        $sampah++;
    }
    echo "[Filter] Email ".number_format( $hitung , 0 , '' , ',' )." of ".number_format( $count , 0 , '' , ',' )." -[ ".round(($hitung+1)/$count * 100,2)."% ]-\r\n";
    $hitung++;
}
echo '
-------------------------------------------------
    REPORT EMAIL - Email Filter - Spammer ID
-------------------------------------------------
[+] Hotmail : '.number_format( $hotmail, 0 , '' , ',' ).' ('. (round(100-($valid-$hotmail)/$valid * 100,2)) .'%)
[+] Yahoo   : '.number_format( $yahoo, 0 , '' , ',' ).' ('. (round(100-($valid-$yahoo)/$valid * 100,2)) .'%)
[+] Aol     : '.number_format( $aol, 0 , '' , ',' ).' ('. (round(100-($valid-$aol)/$valid * 100,2)) .'%)
[+] Gmail   : '.number_format( $gmail, 0 , '' , ',' ).' ('. (round(100-($valid-$gmail)/$valid * 100,2)) .'%)
[+] Other   : '.number_format( $other, 0 , '' , ',' ).' ('. (round(100-($valid-$other)/$count * 100,2)) .'%)
-------------------------------------------------
[+] Jumlah Email Sama  : '.number_format( ($counts-$count) , 0 , '' , ',' ).' dari '.number_format( $counts, 0 , '' , ',' ).' Email
[+] Jumlah Email Unik  : '.number_format( $count , 0 , '' , ',' ).'
[+] Email  Bagus       : '.number_format( $valid , 0 , '' , ',' ).'
[+] Email  Sampah      : '.number_format( $sampah , 0 , '' , ',' ).'
[+] Reputasi Hasil     : '.(100-round(($valid-$gmail)/$count * 100,2)).'%
-------------------------------------------------
';
