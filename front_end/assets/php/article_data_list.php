<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>单平台数据</title>
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
                <li class="layui-nav-item"><a href="../../components/add_article.html">URL管理</a></li>
                <li class="layui-nav-item"><a href="">文章多发</a></li>
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
                    <li class="layui-nav-item"><a href="./analyse_platform.php">总数据</a></li>
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;">分数据</a>
                        <dl class="layui-nav-child">
                            <?php
                            $page_banner = "<dd><a href='" . $_SERVER['PHP_SELF'] . "?platform=1" . "'>segmentfault</a></dd>";
                            $page_banner .= "<dd><a href='" . $_SERVER['PHP_SELF'] . "?platform=2" . "'>掘金</a></dd>";
                            $page_banner .= "<dd><a href='" . $_SERVER['PHP_SELF'] . "?platform=3" . "'>微信开放社区</a></dd>";
                            $page_banner .= "<dd><a href='" . $_SERVER['PHP_SELF'] . "?platform=4" . "'>云+社区</a></dd>";
                            $page_banner .= "<dd><a href='" . $_SERVER['PHP_SELF'] . "?platform=5" . "'>简书</a></dd>";
                            echo $page_banner;
                            ?>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>

        <span class="layui-body" style="background-color: #ffffff; padding: 20px; ">
            <!-- 内容主体区域 -->
            <?php

            $platform = 0;
            $platform = $_GET['platform'];


            if ($platform == 0)
                $sql = "SELECT * FROM article_data AS a WHERE NOT EXISTS ( SELECT 1 FROM article_data WHERE a.title = title AND a.`read` < `read` ) ORDER BY sendtime DESC;";
            else if ($platform == 1) {
                $sql = "SELECT * FROM article_data AS a WHERE platform = 'sf' AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;";
                $platform_name = 'sf';
            } else if ($platform == 2) {
                $sql = "SELECT * FROM article_data AS a WHERE platform = '掘金' AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;";
                $platform_name = '掘金';
            } else if ($platform == 3) {
                $sql = "SELECT * FROM article_data AS a WHERE platform = '微信开放社区' AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;";
                $platform_name = '微信开放社区';
            } else if ($platform == 4) {
                $sql = "SELECT * FROM article_data AS a WHERE platform = '云+社区' AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;";
                $platform_name = '云+社区';
            } else if ($platform == 5) {
                $sql = "SELECT * FROM article_data AS a WHERE platform = '简书' AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;";
                $platform_name = '简书';
            }
            // else if ($platform == 6) {
            //     $sql = "SELECT * FROM article_data AS a WHERE platform = 'CSDN' AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;";
            //     $platform_name = 'CSDN';
            // }

            echo '<span class="layui-body-header">';
            echo '<span style="border-left: 4px solid #00a4ff; padding-left: 6px;">' . $platform_name . '     /  文章最新数据 </span>';
            echo '</span>'
            ?>
            <table align="center" cellpadding="5" cellspacing="1" bgcolor="#add3ef" class="layui-table" lay-skin="line">

                <colgroup>
                    <col>
                    <col width="120">
                    <col width="50">
                    <col width="50">
                    <col width="50">
                    <col width="50">
                    <col width="50">
                    <col width="50">
                </colgroup>
                <thead>
                    <tr>
                        <th>title</th>
                        <th>platform</th>
                        <th>read</th>
                        <th>like</th>
                        <th>comment</th>
                        <th>addread</th>
                        <th>addlike</th>
                        <th>addcomment</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($conn, $sql);

                    // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    if ($query)
                        while ($row = mysqli_fetch_assoc($query)) {  ?>

                        <tr bgcolor="#eff3ff">
                            <td>
                                <a href="<?php echo $row['url']; ?>"> <?php echo $row['title']; ?> </a>
                            </td>
                            <td>
                                <?php echo $row['platform']; ?>
                            </td>
                            <td>
                                <?php echo $row['read']; ?>
                            </td>
                            <td>
                                <?php echo $row['like']; ?>
                            </td>
                            <td>
                                <?php echo $row['comment']; ?>
                            </td>
                            <td>
                                <?php echo $row['addread']; ?>
                            </td>
                            <td>
                                <?php echo $row['addlike']; ?>
                            </td>
                            <td>
                                <?php echo $row['addcomment']; ?>
                            </td>
                        </tr>

                        <tr bgColor="#ffffff">
                            <td colspan="6">
                                抓取时间:<?php echo $row['gettime']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                发送时间:<?php echo $row['sendtime']; ?>
                            </td>
                            <td colspan="2" align="right">
                                <a href="article_data_single.php?url=<?php echo $row['url']; ?>&platform=<?php echo $platform_name; ?>&title=<?php echo $row['title']; ?>&sendtime=<?php echo $row['sendtime']; ?>">单文章数据详情</a>
                            </td>
                        </tr>
                    <?php } else
                    echo "没有文章";

                ?>
                </tbody>
            </table>


    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © 腾讯云.云开发运营小组
    </div>



    <script src="../../layui/layui.js"></script>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>

    <script>
        //JavaScript代码区域
        layui.use('element', function() {
            var element = layui.element;

        });
    </script>


    </div>
</body>

</html>