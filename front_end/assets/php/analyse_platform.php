<!DOCTYPE html>
<html lang="utf-8">

<head>
    <meta charset="utf-8">
    <title>昨日总数据概览</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../../node_modules/layui-src/dist/css/layui.css" media="all">
    <link rel="stylesheet" href="../../layui/css/theme1.css">
    <link rel="stylesheet" type="text/css" href="../css/css.css">
    <link rel="shortcut icon" href="../images/logo_favicon .ico" />
    <script src="../../node_modules/echarts/dist/echarts-en.min.js"></script>
    <link rel="stylesheet" href="../css/navagator.css">
    <?php
    include("../../conn.php");
    ?>
    <style>
        .numberInfoSubTitle {
            color: rgba(0, 0, 0, .45);
            font-size: 14px;
            height: 22px;
            line-height: 22px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-break: break-all;
        }

        .numberInfoValue {
            color: rgba(0, 0, 0, .85);
            font-size: 24px;
            margin-top: 10px;
            height: 32px;
            line-height: 32px;
        }

        .numberInfoSuffix {
            color: rgba(0, 0, 0, .65);
            font-size: 16px;
            font-style: normal;
            margin-left: 4px;
            line-height: 32px;
        }
    </style>

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
                <li class="layui-nav-item"><a href='../../components/add_article.html'>URL管理</a></li>
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
                    <li class="layui-nav-item "><a href="javascript:;">总数据</a></li>
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

        <div class="layui-body" style="background-color: #ffffff; padding: 6px; " id="analyse_platform">
            <!-- 内容主体区域 -->

            <?php
            $sql = "SELECT * FROM platfrom_data AS a WHERE NOT EXISTS ( SELECT 1 FROM platfrom_data WHERE a.`platfrom` = `platfrom` AND a.`gettime` < `gettime` ) ORDER BY `platfrom` DESC;";
            // echo $sql;
            $query = mysqli_query($conn, $sql);
            // echo "Error: " . $sql . "<br>" . mysqli_error($conn);

            $sql2 = "SELECT * FROM platfrom_data AS a WHERE NOT EXISTS ( SELECT 1 FROM platfrom_data WHERE a.`platfrom` = `platfrom` AND a.`gettime` < `gettime` ) ORDER BY `read` DESC;";
            // echo $sql2;
            $query2 = mysqli_query($conn, $sql2);
            // echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);

            $sql3 = "SELECT * FROM platfrom_data AS a WHERE NOT EXISTS ( SELECT 1 FROM platfrom_data WHERE a.`platfrom` = `platfrom` AND a.`gettime` < `gettime` ) ORDER BY `addread` DESC;";
            // echo $sql2;
            $query3 = mysqli_query($conn, $sql3);
            // echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);

            ?>


            <div class="layui-fluid">
                <div class="layui-row layui-col-space15">

                    <div class="layui-col-xs12 layui-col-md10">
                        <div class="layui-card">
                            <div class="layui-card-header">各平台昨日数据</div>
                            <div class="layui-card-body">
                                <!-- 插入平台数据表格 -->

                                <table class="layui-table" lay-skin="line" width='100%'>

                                    <colgroup>
                                        <col >
                                        <col >
                                        <col >
                                        <col >
                                        <col >
                                        <col >
                                        <col >
                                        <col >
                                    </colgroup>
                                    
                                    <thead>
                                        <tr>
                                            <th style='background-color: #2f4056; color: #fff;'>platform</th>
                                            <th style='background-color: #2f4056; color: #fff;'>artinum</th>
                                            <th style='background-color: #2f4056; color: #fff;'>read</th>
                                            <th style='background-color: #2f4056; color: #fff;'>like</th>
                                            <th style='background-color: #2f4056; color: #fff;'>comment</th>
                                            <th style='background-color: #2f4056; color: #fff;'>addread</th>
                                            <th style='background-color: #2f4056; color: #fff;'>addlike</th>
                                            <th style='background-color: #2f4056; color: #fff;'>addcomment</th>
                                        </tr>
                                    </thead>


                                    <?php
                                    $platfrom_read = array();
                                    $platfrom_addread = array();
                                    $platfrom_addlike = array();
                                    $platfrom_addcomment = array();



                                    if ($query)
                                        while ($row = mysqli_fetch_assoc($query)) {  ?>

                                        <tr>
                                            <td style="font-size:12px;">
                                                <?php echo $row['platfrom']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['article_number']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['read']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['like']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['comment']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['addread']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['addlike']; ?>
                                            </td>
                                            <td style="font-size:12px;">
                                                <?php echo $row['addcomment']; ?>
                                            </td>
                                        </tr>

                                        <?php
                                            array_push($platfrom_read, $row['read']);
                                            array_push($platfrom_addread, $row['addread']);
                                            array_push($platfrom_addlike, $row['addlike']);
                                            array_push($platfrom_addcomment, $row['addcomment']);
                                            ?>

                                    <?php
                                    } else
                                    echo "没有文章";
                                ?>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="layui-col-xs12">
                        <div class="layui-card">
                            <div class="layui-card-body">
                                <div class="layui-tab layui-tab-brief" lay-filter="tabZZT">
                                    <ul class="layui-tab-title">
                                        <li>各平台阅读量对比</li>
                                        <li class="layui-this">各平台增量对比</li>
                                    </ul>
                                    <div class="layui-tab-content">
                                        <div class="layui-tab-item ">
                                            <div class="layui-row layui-col-space30">
                                                <div class="layui-col-xs12 layui-col-md8">
                                                    <div id="read_chart" style="height:330px; margin:0 auto;"></div>
                                                    <!-- 插入各平台阅读量对比 -->
                                                </div>
                                                <div class="layui-col-xs12 layui-col-md4">
                                                    <table class="layui-table" lay-skin="nob">
                                                        <colgroup>
                                                            <col width="50">
                                                            <col>
                                                            <col width="96">
                                                        </colgroup>
                                                        <thead>
                                                            <tr style="background: none;color: #333;">
                                                                <th colspan="3">总阅读访问量排名</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $i = 1;
                                                            if ($query2)
                                                                while ($row2 = mysqli_fetch_assoc($query2)) {  ?>
                                                                <tr>
                                                                    <td><span class="layui-badge layui-bg-cyan"><?php echo $i ?> </span></td>
                                                                    <td><?php echo $row2['platfrom'] ?></td>
                                                                    <td><?php echo $row2['read'] ?></td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            <?php
                                                            } else
                                                            echo "没有文章";
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="layui-tab-item layui-show">
                                            <div class="layui-row layui-col-space30">
                                                <div class="layui-col-xs12 layui-col-md8">
                                                    <div id="add_chart" style="height:330px; margin:0 auto;"></div>
                                                    <!-- 插入各平台阅读量对比 -->
                                                </div>
                                                <div class="layui-col-xs12 layui-col-md4">
                                                    <table class="layui-table" lay-skin="nob">
                                                        <colgroup>
                                                            <col width="50">
                                                            <col>
                                                            <col width="96">
                                                        </colgroup>
                                                        <thead>
                                                            <tr style="background: none;color: #333;">
                                                                <th colspan="3">昨日阅读访问量排名</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $i = 1;
                                                            if ($query3)
                                                                while ($row3 = mysqli_fetch_assoc($query3)) {  ?>
                                                                <tr>
                                                                    <td><span class="layui-badge layui-bg-cyan"><?php echo $i ?> </span></td>
                                                                    <td><?php echo $row3['platfrom'] ?></td>
                                                                    <td><?php echo $row3['addread'] ?></td>
                                                                </tr>
                                                                <?php $i++; ?>
                                                            <?php
                                                            } else
                                                            echo "没有文章";
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © 腾讯云.云开发运营小组
        </div>

        <script src="../../layui/layui.js"></script>
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript">
            layui.use(['layer', 'element'], function() {
                var $ = layui.jquery;
                var layer = layui.layer;
                var element = layui.element;

                var sread = '<?php echo urlencode(json_encode($platfrom_read)); ?>';
                var read = eval(decodeURIComponent(sread));
                var saddread = '<?php echo urlencode(json_encode($platfrom_addread)); ?>';
                var addread = eval(decodeURIComponent(saddread));
                var saddlike = '<?php echo urlencode(json_encode($platfrom_addlike)); ?>';
                var addlike = eval(decodeURIComponent(saddlike));
                var saddcomment = '<?php echo urlencode(json_encode($platfrom_addcomment)); ?>';
                var addcomment = eval(decodeURIComponent(saddcomment));


                // console.log(drawGpsMap(list));

                console.log(read);
                console.log(addread);
                console.log(addlike);
                console.log(addcomment);


                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('read_chart'));

                // 指定图表的配置项和数据
                var option = {
                    title: {
                        // text: '各平台阅读量对比'
                    },
                    tooltip: {},
                    legend: {
                        data: ['阅读量']
                    },
                    xAxis: {
                        data: ["简书", "掘金", "微信开放社区", "云+社区", "sf"]
                    },
                    yAxis: {},
                    series: [{
                        name: '阅读量',
                        type: 'bar',
                        barWidth: 20,
                        data: read
                    }]

                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);


                // 基于准备好的dom，初始化echarts实例
                var myChart2 = echarts.init(document.getElementById('add_chart'));

                // 指定图表的配置项和数据
                var option2 = {
                    title: {
                        // text: '各平台增量对比'
                    },
                    tooltip: {},
                    legend: {
                        data: ['阅读增量', '点赞增量', '评论增量']
                    },
                    xAxis: {
                        data: ["简书", "掘金", "微信开放社区", "云+社区", "sf"]
                    },
                    yAxis: {},
                    series: [{
                            name: '阅读增量',
                            type: 'bar',
                            barMinHeight: 5,
                            data: addread
                        },
                        {
                            name: '点赞增量',
                            type: 'bar',
                            barMinHeight: 5,
                            data: addlike
                        },
                        {
                            name: '评论增量',
                            type: 'bar',
                            barMinHeight: 5,
                            data: addcomment
                        }
                    ]

                };

                // 使用刚指定的配置项和数据显示图表。
                myChart2.setOption(option2);

                // 切换选项卡重新渲染
                element.on('tab(tabZZT)', function(data) {
                    if (data.index == 0) {
                        myChart.resize();
                    } else {
                        myChart2.resize();
                    }
                });

                // 窗口大小改变事件
                window.onresize = function() {
                    myChart2.resize();
                    myChart.resize();
                };

            });
        </script>
</body>

</html>