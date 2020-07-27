<!DOCTYPE html>
<body background="images\background1.png"
style=" background-repeat:no-repeat ;
background-size:100% 100%;
background-attachment: fixed;"
>
<?php include("config.php");
require_once "baidu_transapi.php";
$path=$_COOKIE['mycookie'];

function fetch_comments($kw) {
    $url = "https://www.sephora.cn/search/?k=" . urlencode($kw);
    $html = file_get_contents($url);

    preg_match('/a target="_blank" href="[^"]*\/(\d+)\.html"[^>]*>([^<]*)/', $html, $matches);

    if (count($matches) < 2) {
        return [];
    } else {
        $productId = $matches[1];
        if(strlen($productId) <= 0) { return []; }
        $cms = [];
        $pageNo = 1;
        while(true) {
            $j = file_get_contents('https://api.sephora.cn/v1/product/comment/commentListForPC?productId=' .  $productId . '&pageNo=' . $pageNo .'&pageSize=3');
            $data = json_decode($j, true);
            foreach($data['results']['commentDtos'] as $comment) {
                array_push($cms, $comment);
                $GLOBALS['productName'] = $comment['productName'];
            }
            if($data['results']['hasNext']) {
                $pageNo++;
                continue;
            }
            break;
        }
        return $cms;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kw = $_POST['kw'];
    if(strlen($kw) > 0) {
        $GLOBALS['comments'] = fetch_comments($kw);
    } else {
        $GLOBALS['comments'] = [];
    }
}
?>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?php echo "CareYourSkin"; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500" rel="stylesheet" />
    <link href="css/website.css" rel="stylesheet" />
    <link href="css/image.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="navigation.css"> 
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style> 
#uploadfile{ font-size:12px; overflow:hidden; position:absolute} 
#exampleInputFile{ position:absolute; z-index:100; margin-left:-180px; font-size:60px;opacity:0;filter:alpha(opacity=0); margin-top:-5px;} 
</style> 
  </head>
  <body>

      <section class="Layout__Content">
        <h1 class="PageTitle"><?php echo "CareYourSkin"; ?></h1> 
        <p style="font-size:35px"><?php echo "开始你的护肤之旅吧"; ?></p>



 <form role="form" action="img.php" method="POST" enctype="multipart/form-data" style="width:20%;position:center;">
        <div class="form-group" style="align-content:center">
           <div id="uploadfile"> 
           <input type="file" id="exampleInputFile" name="file" id="file"/>
           <input class="btn btn-default" type="button" value=<?php echo "选择其他图片"; ?>> 
           </div> 
        </div>
        <br><br>
        <button type="submit" class="btn btn-default" name="submit">
        <em class="glyphicon glyphicon-align-right"></em>&nbsp;<?php echo "上传"; ?></button>

      </form>

        </section>

          </a>
      <?php
    //获取最新添加
     // $query ="SELECT * FROM `temp_img` order by id desc limit 0,1";
     // $idresult = mysqli_query($conn,$query);
     // while ($row = mysqli_fetch_array($idresult,MYSQLI_ASSOC)){
        ?>
        <section>

        <div style="width:100;position:center;"><img src="<?php echo $path ?>" height="500"/></div><br><br>
        
        </section>

        <?php 
        //图片上传本地地址
        //echo $row["path"];
      
      /**
* 发起http post请求(REST API), 并获取REST请求的结果
* @param string $url
* @param string $param
* @return - http response body if succeeds, else false.
*/

function request_post($url = '', $param = '')
{
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    // 初始化curl
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // post提交方式
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    // 运行curl
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
}

$token = '24.4e9bfac2c28e8b2d8e0c6b1843a60cbb.2592000.1593002697.282335-19063775';
$url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic?access_token=' . $token;
$img = file_get_contents($path);
$img = base64_encode($img);
$bodys = array(
    'image' => $img
);

$res = request_post($url, $bodys);
//var_dump($res);

//json数组转化为连贯文本
$message = '';
$key_message_1= '';
$key_message_2= '';
$x=0; 

$content = json_decode($res);

foreach ($content->words_result as $key) {
  //echo $key->words."&nbsp";
  $message=$message.$key->words." ";
  $x++;
  //获取第一个单词（可能为品牌名）
  if ($x<=1) {
    $key_message_1=$key_message_1.$key->words." ";
  }
  //获取前两个单词（可能为品牌名）
  if ($x<=2) {
    $key_message_2=$key_message_1.$key->words." ";
  }
  
}

$key_message_1=strtoupper($key_message_1);
$key_message_2=strtoupper($key_message_2);
//echo "<br>".$key_message_1."<br>";
//echo "<br>".$key_message_2."<br>";

?>

    <p><label for="inputEmail3" class="col-sm-8 control-label"><?php echo "该图片内的文字及翻译:<br>"; ?></label></p>
<?php

echo "<br>".$message."<br>";

/*
$search_sql ="SELECT * FROM `temp_text` WHERE `en_text` = '%$message%'";
$search_result = mysqli_query($conn,$search_sql);

if(row = mysqli_fetch_array($search_result,MYSQLI_ASSOC)){
  echo $row['zh_text'];
}
else{  }
*/
//获取翻译
$result = translate($message,"en","zh");
//var_dump($result) ;
$trans_res=$result["trans_result"][0]["dst"];
echo "<br>中文：".$trans_res."<br>";



$sql = "INSERT INTO `temp_text` (`zh_text`,`en_text`) VALUES ('$trans_res','$message')";
$insert = mysqli_query( $conn, $sql ); 
if(! $insert ){
  die("无法插入数据" . mysqli_error($conn));

}
?>


<p><label for="inputEmail3" class="col-sm-8 control-label"><?php echo "该产品可能是:<br>"; ?></label></p>


  
<?php


//匹配数据库，提供图片文字可能对应的产品名
$searchproduct_sql="SELECT COUNT(*) AS count_2 FROM `key_words` WHERE `en_name` LIKE '%$key_message_2%'"; 
$searchproduct_result = mysqli_query($conn,$searchproduct_sql);
if (!$searchproduct_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();
}


while ($row = mysqli_fetch_array($searchproduct_result,MYSQLI_ASSOC)){
  echo "<br>".@$row['product_name'];
  @$count_2=$row['count_2']; 
}

if ($count_2==0) {
  //echo "数据库内暂时无符合的数据";
$searchproduct_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$key_message_1%'"; 
$searchproduct_result = mysqli_query($conn,$searchproduct_sql);
if (!$searchproduct_result) {
  printf("Error: %s<br>", mysqli_error($conn));
  exit();}

while ($row = mysqli_fetch_array($searchproduct_result,MYSQLI_ASSOC)){
  echo "<br>".@$row['product_name'];
  @$count_1=count($result);
}
if (@$count_1==0) {
      echo "暂时无数据";
    }
    
}



//改查询前1个单词是否有对应的搜索结果
    





     
  

  




//获取丝芙兰网站产品评价

?>



<div class="container " style="width: 100%">
    <div class="row clearfix">
    <p><label for="inputEmail3" class="col-sm-8 control-label"><?php echo "<br>填写产品中文名，获取产品网络评价"; ?></label></p>
    </div>
  <div class="row clearfix">
  
  
  <form class="form-horizontal" role="form" action="pre.php" method="POST">
    <div class="col-md-10 column">
      
        <div class="form-group" >
        
           
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="kw" value="<?php echo @$kw ?>"/>
          </div></div></div>
          <div class="col-md-2 column" >
          <div class="col-sm-offset-2 col-sm-10" style="position:relative; left:-150px">

             <button type="submit" class="btn" name="searchbut"><?php echo "搜索"; ?></button>
          </div>
          </div>
    </form>
  </div>


<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
        <div>
            <?php if(count($comments) == 0) { ?>
                <div> 没有结果 </div>
            <?php } else { 
                ?>
      
                <div class="container-fluid">
    <div class="row-fluid">
        <div class="span6" style="width:60%;position:relative;float:left;">
            
                <div style="height:230px;overflow-y:auto;" id="tmtable">
                    <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style='width: 90%'>
                            <?php echo $productName ; ?>
                            </th>
                        </tr>
                    <tr>
                        
                        <th style="width:90%;">

                <?php foreach($comments as $comment) { ?>
                    <!-- comment item start -->
                    
                        <?php echo $comment['content']."<br><br>"?>
                    
                <?php } ?>
                </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- comment item end -->
                 </table></div>
        </div>   

            <?php } ?>
        </div>
    <?php } ?>

</div>

<p><label for="inputEmail3" class="col-sm-8 control-label"><?php echo "<br>功能相似的产品：<br>"; ?></label></p>

<?php
if(strpos($message,'wrinkles')|| strpos($message,'wrinkle')||strpos($message,'WRINKLE')!== false){ //文字识别出关键词
  //定义一个search key
  @$keymessage = 'wrinkle';
  echo '<br><br><br>功能同为淡化皱纹的产品有:<br>'; 
  $searchpro_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$keymessage%' OR `en_word` LIKE '%$keymessage%' ";
  $searchpro_result = mysqli_query($conn,$searchpro_sql);
  if (!$searchpro_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();}

  while ($row = mysqli_fetch_array($searchpro_result,MYSQLI_ASSOC)){
    echo $row['product_name'] ."<br>";
    echo  "<p style='color:#686966; font-size:13px;'>" .$row['product_des']." </p><br>";
    

}}


if(strpos($message,'hydration')|| strpos($message,'Hydration')||strpos($message,'HYDRATION')||strpos($message,'MOIST')||strpos($message,'Moist')!== false){ //文字识别出关键词
  //定义一个search key
  @$keymessage = 'hydration';
  echo '<br><br><br>功能同为保湿的产品有:<br>'; 
  $searchpro_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$keymessage%' OR `en_word` LIKE '%$keymessage%' ";
  $searchpro_result = mysqli_query($conn,$searchpro_sql);
  if (!$searchpro_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();}

  while ($row = mysqli_fetch_array($searchpro_result,MYSQLI_ASSOC)){
    echo $row['product_name']."<br>";
    echo  "<p style='color:#686966; font-size:13px;'>" .$row['product_des']." </p><br>";
  }


}
//}



if(strpos($message,'age')|| strpos($message,'AGE')||strpos($message,'Age')||strpos($message,'aging')!== false){ //文字识别出关键词
  //定义一个search key
  @$keymessage = 'age';
  echo '<br><br><br>功能同为抗老化的产品有:<br>'; 
  $searchpro_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$keymessage%' OR `en_word` LIKE '%$keymessage%' ";
  $searchpro_result = mysqli_query($conn,$searchpro_sql);
  if (!$searchpro_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();}

  while ($row = mysqli_fetch_array($searchpro_result,MYSQLI_ASSOC)){
    echo $row['product_name']."<br>";
    echo  "<p style='color:#686966; font-size:13px;'>" .$row['product_des']." </p><br>";

}}

if(strpos($message,'bright')|| strpos($message,'Bright')||strpos($message,'BRIGHT')||strpos($message,'Vitamin C')||strpos($message,'Vitamins C')||strpos($message,'White')!== false){ //文字识别出关键词
  //定义一个search key
  @$keymessage = 'bright';
  echo '<br><br><br>功能同为美白透亮的产品有:<br>'; 
  $searchpro_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$keymessage%' OR `en_word` LIKE '%$keymessage%' ";
  $searchpro_result = mysqli_query($conn,$searchpro_sql);
  if (!$searchpro_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();}

  while ($row = mysqli_fetch_array($searchpro_result,MYSQLI_ASSOC)){
    echo $row['product_name']."<br>";
    echo  "<p style='color:#686966; font-size:13px;'>" .$row['product_des']." </p><br>";
}}


if(strpos($message,'Acid')|| strpos($message,'acid')||strpos($message,'RECOVER')||strpos($message,'Recover')||strpos($message,'recover')!== false){ //文字识别出关键词
  //定义一个search key
  @$keymessage = 'recover';
  echo '<br><br><br>功能同为修复的产品有:<br>'; 
  $searchpro_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$keymessage%' OR `en_word` LIKE '%$keymessage%' ";
  $searchpro_result = mysqli_query($conn,$searchpro_sql);
  if (!$searchpro_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();}

  while ($row = mysqli_fetch_array($searchpro_result,MYSQLI_ASSOC)){
    echo $row['product_name']."<br>";
    echo  "<p style='color:#686966; font-size:13px;'>" .$row['product_des']." </p><br>";

}}

if(strpos($message,'SPOT')|| strpos($message,'spot')||strpos($message,'Spot')!== false){ //文字识别出关键词
  //定义一个search key
  @$keymessage = 'spot';
  echo '<br><br><br>功能同为淡斑的产品有:<br>'; 
  $searchpro_sql="SELECT * FROM `key_words` WHERE `en_name` LIKE '%$keymessage%' OR `en_word` LIKE '%$keymessage%' ";
  $searchpro_result = mysqli_query($conn,$searchpro_sql);
  if (!$searchpro_result) {
    printf("Error: %s<br>", mysqli_error($conn));
    exit();}

  while ($row = mysqli_fetch_array($searchpro_result,MYSQLI_ASSOC)){
    echo $row['product_name']."<br>";
    echo  "<p style='color:#686966; font-size:13px;'>" .$row['product_des']." </p><br>";

}}

      ?>






    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>      

  </body>
</html>