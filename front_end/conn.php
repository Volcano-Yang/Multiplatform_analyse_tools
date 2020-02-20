<?php
    // 生产环境
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";
    $port = 10164;


    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
