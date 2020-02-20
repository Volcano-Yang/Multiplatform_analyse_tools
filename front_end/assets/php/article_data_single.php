<!DOCTYPE html>
<html lang="utf-8">

<head>
    <meta charset="utf-8">
    <title>单文章数据详情</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="../images/logo_favicon .ico" />
    <link rel="stylesheet" href="../../node_modules/layui-src/dist/css/layui.css" media="all">
    <link rel="stylesheet" href="../../layui/css/theme1.css">
    <link rel="stylesheet" href="../css/navagator.css">
    <script src="../../node_modules/echarts/dist/echarts-en.min.js"></script>
</head>

<body class="layui-layout-body">

    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="logo" style="color:rgb(222, 226, 230);font-size: 1.4em;">
                <img src="../images/tcb_black.icon.png" class="logo_image">
                运营后台
            </div>

            <!-- 头部区域（可配合layui已有的水平导航） -->
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="https://766f-volcano-f8423d-1256342025.tcb.qcloud.la/云开发小程序icon.png?sign=055d90c13779927b4f40e1c8d429f256&t=1566269300" class="layui-nav-img">
                        云开发小助手
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="layui-body" style="background-color: #ffffff; padding:20px; left:0px; margin-top:60px;">
        <!-- 内容主体区域 -->
        <?php
        include '../../conn.php';
        $url = $_GET['url'];
        $platform = $_GET['platform'];
        $title = $_GET['title'];
        $sendtime = $_GET['sendtime'];
        $sql = "select * from article_data where url='" . $url . "' ORDER BY `read` DESC";
        // echo $sql;
        $query = mysqli_query($conn, $sql);
        // echo "Error: " . $sql . "<br>" . mysqli_error($conn);

        $sql2 = "select * from article_data where url='" . $url . "' ORDER BY `read` ASC";
        // echo $sql;
        $query2 = mysqli_query($conn, $sql2);
        // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        ?>

        <br>

        <div align='center'>
            <font color="#2693f5">标题：</font>
            <a href="<?php echo $row['url']; ?>"> <?php echo $title; ?> </a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <font color="#2693f5">平台：</font>
            <?php echo $platform ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <font color="#2693f5">发送时间：</font>
            <?php echo $sendtime ?>
        </div>

        <br>

        <div style="width:70%;  margin: 0 auto;">
            <table class="layui-table" lay-skin="line">

                <colgroup>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <thead>
                    <tr>
                        <th style='background-color: #2f4056; color: #fff;'>gettime</th>
                        <th style='background-color: #2f4056; color: #fff;'>read</th>
                        <th style='background-color: #2f4056; color: #fff;'>like</th>
                        <th style='background-color: #2f4056; color: #fff;'>comment</th>
                        <th style='background-color: #2f4056; color: #fff;'>addread</th>
                        <th style='background-color: #2f4056; color: #fff;'>addlike</th>
                        <th style='background-color: #2f4056; color: #fff;'>addcomment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($query)
                        while ($row = mysqli_fetch_assoc($query)) {  ?>
                        <tr>
                            <td style="font-size:12px;">
                                <?php echo $row['gettime']; ?> &nbsp;&nbsp;
                            </td>
                            <td style="font-size:12px;">
                                <?php echo $row['read']; ?> &nbsp;&nbsp;
                            </td>
                            <td style="font-size:12px;" >
                                <?php echo $row['like']; ?> &nbsp;&nbsp;
                            </td>
                            <td style="font-size:12px;" align="center">
                                <?php echo $row['comment']; ?> &nbsp;&nbsp;
                            </td>
                            <td style="font-size:12px;" align="center">
                                <?php echo $row['addread']; ?> &nbsp;&nbsp;
                            </td>
                            <td style="font-size:12px;" align="center">
                                <?php echo $row['addlike']; ?> &nbsp;&nbsp;
                            </td>
                            <td style="font-size:12px;" align="center">
                                <?php echo $row['addcomment']; ?> &nbsp;&nbsp;
                            </td>
                        </tr>

                    <?php } else
                    echo "没有文章";
                ?>
                    <?php
                    $date_array = array();
                    $addread_array = array();
                    $addlike_array = array();
                    $addcomment_array = array();
                    if ($query2)
                        while ($row2 = mysqli_fetch_assoc($query2)) {  ?>

                        <?php
                            array_push($addread_array, $row2['addread']);
                            array_push($addlike_array, $row2['addlike']);
                            array_push($addcomment_array, $row2['addcomment']);
                            array_push($date_array, $row2['gettime']);
                            ?>

                    <?php } else
                    echo "没有文章";
                ?>


                </tbody>
            </table>
        </div>


        <br>


        <div id="main" style="width: 1000px; height:500px; margin:0 auto;"></div>
        <script type="text/javascript">
            var saddread = '<?php echo urlencode(json_encode($addread_array)); ?>';
            var addread = eval(decodeURIComponent(saddread));
            var saddlike = '<?php echo urlencode(json_encode($addlike_array)); ?>';
            var addlike = eval(decodeURIComponent(saddlike));
            var saddcomment = '<?php echo urlencode(json_encode($addcomment_array)); ?>';
            var addcomment = eval(decodeURIComponent(saddcomment));
            var sdate = '<?php echo urlencode(json_encode($date_array)); ?>';
            var adate = eval(decodeURIComponent(sdate));

            console.log(addread);
            console.log(addlike);
            console.log(addcomment);
            console.log(adate);



            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('main'));

            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: '单文章数据增长折线图'
                },
                tooltip: {},
                legend: {
                    data: ['增长访问量', '增长点赞量', '增长评论量']
                },
                xAxis: {
                    data: adate
                },
                yAxis: {
                    min: -5
                },
                series: [{
                    name: '增长访问量',
                    type: 'line',
                    minheight: 5,
                    data: addread
                }, {
                    name: '增长点赞量',
                    type: 'line',
                    minheight: 5,
                    data: addlike
                }, {
                    name: '增长评论量',
                    type: 'line',
                    minheight: 5,
                    data: addcomment
                }]

            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        </script>
    </div>

</body>

</html>