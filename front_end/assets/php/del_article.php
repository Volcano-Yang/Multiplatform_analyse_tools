<?php
include '../../conn.php';
$url = $_GET['url'];
$sql = "DELETE FROM article_detail WHERE url='" . $url . "'";
// echo $sql;
if (mysqli_query($conn, $sql)) {
    //页面跳转，实现方式为javascript
    $url = "./article_list.php?platform=0";
    echo "<script>";
    echo  "alert('删除成功');";
    echo "window.location.href='$url';";
    echo "</script>";
} else {
    echo "<script>";
    echo  "alert('删除失败');";
    echo "</script>";
}
