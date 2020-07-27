<!DOCTYPE html>
<body background="images\background1.png"
style=" background-repeat:no-repeat ;
background-size:100% 100%;
background-attachment: fixed;"
>
<?php include("config.php");

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
           <input class="btn btn-default" type="button" value=<?php echo "选择图片"; ?>> 
           </div> 
        </div>
        <br><br>
        <button type="submit" class="btn btn-default" name="submit">
        <em class="glyphicon glyphicon-align-right"></em>&nbsp;<?php echo "上传"; ?></button>

      </form>

        </section>

</a>

    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>      

  </body>
</html>