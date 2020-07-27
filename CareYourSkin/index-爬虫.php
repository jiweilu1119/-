<?php 
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


<!DOCTYPE html>
<body background="images\background.png"
style=" background-repeat:no-repeat ;
background-size:100% 100%;
background-attachment: fixed;"
>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?php echo "护肤"; ?></title>
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
      </section>


<div class="container " style="width: 100%">
    <div class="row clearfix">
    <p><label for="inputEmail3" class="col-sm-8 control-label"><?php echo "<br>填写产品中文名，获取产品网络评价"; ?></label></p>
    </div>
  <div class="row clearfix">
  
  
  <form class="form-horizontal" role="form" action="index.php" method="POST">
    <div class="col-md-10 column">
      
        <div class="form-group" >
        
           
          <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="kw" value="<?php echo $kw ?>"/>
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
            <?php } else { ?>
                <h2> <?php echo $productName ?> </h2>
                <br>

                <?php foreach($comments as $comment) { ?>
                    <!-- comment item start -->
                    <div>
                        <?php echo $comment['content'] ?>
                    </div>
                    <!-- comment item end -->
                    <br><br>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>

</div>
<!-- container end -->


    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>      

  </body>
</html>
