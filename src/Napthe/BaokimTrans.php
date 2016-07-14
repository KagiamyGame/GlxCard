<?php

namespace napthe;

use napthe\napthe;

class BaokimSCard {
	private $userbk;
	private $passbk;
	private $bk;
	private $seri;
	private $pin;
	private $mang;
	private $api_username;
	private $api_password;
	private $transaction_id;
	private $secure_code;
	private $amount;
	private $result;
	
	public function BaokimTrans(String $userbk, String $passbk, String $api_username, String $api_password, String $secure_code, String $merchant_id){
	
$userbk = 'CORE_API_HTTP_USR';
$passbk = 'CORE_API_HTTP_PWD';

$bk = 'https://www.baokim.vn/the-cao/restFul/send';
$seri = isset($_POST['txtseri']) ? $_POST['txtseri'] : '';
$pin = isset($_POST['txtpin']) ? $_POST['txtpin'] : '';
//Loai the cao (VINA, MOBI, VIETEL, VTC, GATE)
$mang = isset($_POST['chonmang']) ? $_POST['chonmang'] : '';


if($mang=='MOBI'){
	$ten = "Mobifone";
}
else if($mang=='VIETEL'){
	$ten = "Viettel";
}
else if($mang=='GATE'){
	$ten = "Gate";
}
else if($mang=='VTC'){
	$ten = "VTC";
}
else $ten ="Vinaphone";

$arrayPost = array(
		'merchant_id'=>$merchant_id,
		'api_username'=>$api_username,
		'api_password'=>$api_password,
		'transaction_id'=>$transaction_id,
		'secure_cods'=>$secure_code,
		'card_id'=>$mang,
		'pin_field'=>$pin,
		'seri_field'=>$seri,
		'algo_mode'=>'hmac'
);

ksort($arrayPost);

$data_sign = hash_hmac('SHA1',implode('',$arrayPost));

$arrayPost['data_sign'] = $data_sign;

$curl = curl_init($bk);

curl_setopt_array($curl, array(
		CURLOPT_POST=>true,
		CURLOPT_HEADER=>false,
		CURLINFO_HEADER_OUT=>true,
		CURLOPT_TIMEOUT=>30,
		CURLOPT_RETURNTRANSFER=>true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
		CURLOPT_USERPWD=>CORE_API_HTTP_USR.':'.CORE_API_HTTP_PWD,
		CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
));

$data = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

$result = json_decode($data,true);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$time = time();
//$time = time();
if($status==200){
	$amount = $result['amount'];
	switch($amount) {
		case 20000: $xu= 20000; break;
		case 50000: $xu= 50000; break;
		case 100000: $xu = 100000; break;
		case 200000: $xu = 200000; break;
		case 300000: $xu = 300000; break;
		case 500000: $xu = 500000; break;
		case 1000000: $xu = 1000000; break;
	}
	//$dbhost="localhost";
	//$dbuser ="xemtruoc_ngaydep";
	//$dbpass = "BL&v7Wd#hj07";
	//$dbname = "xemtruoc_tuonglai";
	//$db = mysql_connect($dbhost,$dbuser,$dbpass) or die("cant connect db");
	//mysql_select_db($dbname,$db) or die("cant select db");


	//mysql_query("UPDATE hqhpt_users SET tien = tien + $xu WHERE username  ='$user';");

	// Xu ly thong tin tai day
	$file = "carddung.log";
	$fh = fopen($file,'a') or die("cant open file");
	fwrite($fh,"Tai khoan: ".$user.", Loai the: ".$ten.", Menh gia: ".$amount.", Thoi gian: ".$time);
	fwrite($fh,"\r\n");
	fclose($fh);
	$sender->$sendMessage("Bạn đã thanh toán thành công thẻ '.$ten.' mệnh giá '.$amount.' ");

}
else{
	echo 'Status Code:' . $status . '<hr >';
	$error = $result['errorMessage'];
	echo $error;
	$file = "cardsai.log";
	$fh = fopen($file,'a') or die("cant open file");
	fwrite($fh,"Tai khoan: ".$user.", Ma the: ".$pin.", Seri: ".$seri.", Noi dung loi: ".$error.", Thoi gian: ".$time);
	fwrite($fh,"\r\n");
	fclose($fh);
	$sender->$sendMessage("Thong tin the cao khong hop le!");

}

}
}
