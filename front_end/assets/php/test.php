<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>多功能表格</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../../layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../../layui/css/theme1.css" media="all">
    <link rel="shortcut icon" href="../images/logo_favicon .ico" />
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
    <?php
    include("../../conn.php");
    $sql = "SELECT * FROM article_data AS a WHERE NOT EXISTS ( SELECT 1 FROM article_data WHERE a.title = title AND a.`read` < `read` ) ORDER BY sendtime DESC;";
    // echo $sql;
    $query = mysqli_query($conn, $sql);
    // echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    $platfrom_array = array();
    $title_array = array();
    $url_array = array();
    $gettime_array = array();
    $sendtime_array = array();
    $read_array = array();
    $like_array = array();
    $comment_array = array();
    $addread_array = array();
    $addlike_array = array();
    $addcomment_array = array();



    if ($query)
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($platfrom_array, $row['platform']);
            array_push($title_array, $row['title']);
            array_push($url_array, $row['url']);
            array_push($gettime_array, $row['gettime']);
            array_push($sendtime_array, $row['sendtime']);
            array_push($read_array, $row['read']);
            array_push($like_array, $row['like']);
            array_push($comment_array, $row['comment']);
            array_push($addread_array, $row['addread']);
            array_push($addlike_array, $row['addlike']);
            array_push($addcomment_array, $row['addcomment']);
        } else
        echo "没有文章";

    // print_r($comment_array);

    ?>
</head>

<body>

    <table class="layui-hide" id="demo"></table>

    <script src="../../layui/layui.js" charset="utf-8"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
    <script>
        var splatfrom = '<?php echo urlencode(json_encode($platfrom_array)); ?>';
        var platfrom = eval(decodeURIComponent(splatfrom));
        var stitle = '<?php echo urlencode(json_encode($title_array)); ?>';
        var title = eval(decodeURIComponent(stitle));
        var surl = '<?php echo urlencode(json_encode($url_array)); ?>';
        var url = eval(decodeURIComponent(surl));
        var ssendtime = '<?php echo urlencode(json_encode($sendtime_array)); ?>';
        var sendtime = eval(decodeURIComponent(ssendtime));
        var sgettime = '<?php echo urlencode(json_encode($gettime_array)); ?>';
        var gettime = eval(decodeURIComponent(sgettime));
        var sread = '<?php echo urlencode(json_encode($read_array)); ?>';
        var read = eval(decodeURIComponent(sread));
        var slike = '<?php echo urlencode(json_encode($like_array)); ?>';
        var like = eval(decodeURIComponent(slike));
        var scomment = '<?php echo urlencode(json_encode($comment_array)); ?>';
        var comment = eval(decodeURIComponent(scomment));
        var saddread = '<?php echo urlencode(json_encode($addread_array)); ?>';
        var addread = eval(decodeURIComponent(saddread));
        var saddlike = '<?php echo urlencode(json_encode($addlike_array)); ?>';
        var addlike = eval(decodeURIComponent(saddlike));
        var saddcomment = '<?php echo urlencode(json_encode($addcomment_array)); ?>';
        var addcomment = eval(decodeURIComponent(saddcomment));

        // console.log(title);
        // console.log(addread);
        // console.log(addlike);
        console.log(comment);



        var article_data = [];
        for (var i = 0; i < platfrom.length; i++) {
            var obj = {
                'platfrom': platfrom[i],
                'title': title[i],
                'url': url[i],
                'gettime': gettime[i],
                'sendtime': sendtime[i],
                'read': read[i],
                'like': like[i],
                'comment': comment[i],
                'addread': addread[i],
                'addlike': addlike[i],
                'addcomment': addcomment[i],
            };
            article_data.push(obj)
        }


        layui.use('table', function() {
            var table = layui.table;
            //展示已知数据
            table.render({
                elem: '#demo',
                toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
                    ,
                defaultToolbar: ['filter', 'exports', 'print', { //自定义头部工具栏右侧图标。如无需自定义，去除该参数即可
                    title: '提示',
                    layEvent: 'LAYTABLE_TIPS',
                    icon: 'layui-icon-tips'
                }],
                cols: [
                    [ //标题栏
                        {
                            field: 'platfrom',
                            title: 'platfrom',
                            width: 120,
                            sort: true
                        }, {
                            field: 'title',
                            title: 'title',
                            width: 260,
                            sort: true
                        },
                        {
                            field: 'gettime',
                            title: 'gettime',
                            width: 120,
                            sort: true
                        }, {
                            field: 'sendtime',
                            title: 'sendtime',
                            width: 120,
                            sort: true
                        }, {
                            field: 'read',
                            title: 'read',
                            Width: 100,
                            sort: true
                        }, {
                            field: 'like',
                            title: 'like',
                            Width: 100,
                            sort: true
                        }, {
                            field: 'comment',
                            title: 'comment',
                            width: 120,
                            sort: true
                        }, {
                            field: 'addread',
                            title: 'addread',
                            width: 120,
                            sort: true
                        }, {
                            field: 'addlike',
                            title: 'addlike',
                            width: 120,
                            sort: true
                        }, {
                            field: 'addcomment',
                            title: 'addcomment',
                            width: 120,
                            sort: true
                        }
                    ]
                ],
                data: article_data,
                skin: 'line' //表格风格
                    ,
                even: true,
                page: true //是否显示分页
                    ,
                limits: [20, 100, 2000],
                limit: 20 //每页默认显示的数量
            });
        });
    </script>

</body>

</html>