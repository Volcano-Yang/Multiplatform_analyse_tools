<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>文章URL查看</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="../images/logo_favicon .ico" />
    <link rel="stylesheet" href="../../node_modules/layui-src/dist/css/layui.css" media="all">
    <link rel="stylesheet" href="../../layui/css/theme1.css">
    <link rel="stylesheet" href="../css/navagator.css">
    <?php
    include("../../conn.php");
    ?>
</head>

<body class="layui-layout-body">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">

            <div class="logo" style="color:rgb(222, 226, 230);font-size: 1.4em;">
                <img src="../images/tcb_black.icon.png" class="logo_image">
                运营后台
            </div>

            <!-- 头部区域（可配合layui已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layui-this"><a href="../../components/add_article.html">URL管理</a></li>
                <li class="layui-nav-item"><a href="javascript:;">文章多发</a></li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="https://766f-volcano-f8423d-1256342025.tcb.qcloud.la/云开发小程序icon.png?sign=055d90c13779927b4f40e1c8d429f256&t=1566269300" class="layui-nav-img">
                        云开发小助手
                    </a>
                </li>
            </ul>
        </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item"><a href="./analyse_platfrom">总数据</a></li>
                    <li class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;">分数据</a>
                        <dl class="layui-nav-child">
                            <?php
                            $page_banner = "<dd><a href='./article_data_list.php?platform=1" . "'>segmentfault</a></dd>";
                            $page_banner .= "<dd><a href='./article_data_list.php?platform=2" . "'>掘金</a></dd>";
                            $page_banner .= "<dd><a href='./article_data_list.php?platform=3" . "'>微信开放社区</a></dd>";
                            $page_banner .= "<dd><a href='./article_data_list.php?platform=4" . "'>云+社区</a></dd>";
                            $page_banner .= "<dd><a href='./article_data_list.php?platform=5" . "'>简书</a></dd>";
                            // $page_banner .= "<dd><a href='./article_data_list.php?platform=6" . "'>CSDN</a></dd>";
                            echo $page_banner;
                            ?>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>

        <div class="layui-body" style="background-color: #ffffff; padding: 20px; ">
            <!-- 内容主体区域 -->

            <span class="layui-breadcrumb" lay-separator="|">
                <?php
                $page_banner = "<a href='" . $_SERVER['PHP_SELF'] . "?platform=0" . "'>全部  </a>";
                $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?platform=2" . "'>掘金  </a>";
                $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?platform=3" . "'>微信开放社区   </a>";
                $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?platform=4" . "'>云+社区   </a>";
                $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?platform=5" . "'>简书  </a>";
                $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?platform=6" . "'>CSDN  </a>";
                $page_banner .= "<a href='" . $_SERVER['PHP_SELF'] . "?platform=1" . "'>sf   </a>";
                echo $page_banner;
                ?>

                <a href="../../components/add_article.html">添加文章信息</a>
            </span>


            <table align="center" cellpadding="5" cellspacing="1" bgcolor="#add3ef" class="layui-table" lay-skin="line">

                <colgroup>
                    <col width="200">
                    <col width="200">
                    <col width="400">
                </colgroup>

                <?php
                $platform = 0;
                $platform = $_GET['platform'];


                if ($platform == 0)
                    $sql = "select * from article_detail order by sendtime desc";
                else if ($platform == 1)
                    $sql = "select * from article_detail where platform='sf' order by sendtime desc";
                else if ($platform == 2)
                    $sql = "select * from article_detail where platform='掘金' order by sendtime desc";
                else if ($platform == 3)
                    $sql = "select * from article_detail where platform='微信开放社区' order by sendtime desc";
                else if ($platform == 4)
                    $sql = "select * from article_detail where platform='云+社区' order by sendtime desc";
                else if ($platform == 5)
                    $sql = "select * from article_detail where platform='简书' order by sendtime desc";
                else if ($platform == 6)
                    $sql = "select * from article_detail where platform='CSDN' order by sendtime desc";


                $query = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($query)) {  ?>

                    <tr bgcolor="#f2f2f2">
                        <td style="font-size:0.9em">
                            <font color="#00a4ff">标题：</font><?php echo $row['title']; ?>
                        </td>
                        <td colspan="2" style="font-size:0.9em">
                            <font color="#00a4ff">平台：</font><?php echo $row['platform']; ?>
                        </td>

                    </tr>

                    <tr bgColor="#ffffff">
                        <td style="font-size:0.9em"><?php echo $row['url']; ?></td>
                        <td style="font-size:0.9em">
                            发送时间:<?php echo $row['sendtime']; ?>
                        </td>
                        <td style="font-size:0.9em">
                            <a href="./del_article.php?url=<?php echo $row['url']; ?>">删除</a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="border:none;"><span></span></td>

                    </tr>
                <?php } ?>

            </table>

        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © 腾讯云.云开发运营小组
        </div>
        </<a>


        <script src="../../layui/layui.js"></script>
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

        <script>
            //JavaScript代码区域
            layui.use('element', function() {
                var element = layui.element;

            });
        </script>
</body>

</html>