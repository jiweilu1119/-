<?php
header("Content-type: text/html; charset=utf-8");

function curl($img) {

$ch = curl_init();
$url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic'; //百度ocr api
$header = array(
'apikey:kwwAtEFLl60viIlvR7zBkyi0',
);

$data_temp = file_get_contents($img);
$data_temp = urlencode(base64_encode($data_temp));
//封装必要参数
$data = "fromdevice=pc&clientip=127.0.0.1&detecttype=LocateRecognize&languagetype=JAP&imagetype=1&image=".$data_temp;
curl_setopt($ch, CURLOPT_HTTPHEADER , $header); // 添加apikey到header
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 添加参数
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch , CURLOPT_URL , $url); // 执行HTTP请求
$res = curl_exec($ch);
if ($res === FALSE) {
echo "cURL Error: " . curl_error($ch);
}
curl_close($ch);
$temp_var = json_decode($res,true);
return $temp_var;

}

$wordArr = curl('images/sk2.png');
if($wordArr['errNum'] == 0) {
var_dump($wordArr);
} else {
echo "识别出错:".$wordArr["errMsg"];
}