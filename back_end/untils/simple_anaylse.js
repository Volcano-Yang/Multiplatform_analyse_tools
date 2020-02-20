const puppeteer = require('puppeteer');
const mysql = require('mysql');
const {
    setting
} = require('../config.js');

exports.article_addeverday = async function (platform) {

    console.log("——————————开始分析", platform, "文章数据——————————");
    console.log("——————————开始分析", platform, "文章数据——————————");
    console.log("——————————开始分析", platform, "文章数据——————————");

    //这是一个写的很烂的代码，保护视力，千万别看
    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
            }
            // console.log(url_array);
        }

        // console.log(url_array.length);

        //放在这里强行同步

        for (var j = 0; j < url_array.length; j++) {

            let array = [];
            let sql2 = 'SELECT * FROM article_data WHERE platform = "' + platform + '" AND url = "' + url_array[j] + '" order by id desc';

            connection.query(sql2, function (err, result) {
                if (err) {
                    console.log('[SELECT ERROR] - ', err.message);
                    return;
                } else {
                    console.log(sql2);

                    for (var i in result) {
                        array[i] = {
                            "id": result[i].id,
                            "title": result[i].title,
                            "gettime": result[i].gettime,
                            "read": result[i].read,
                            "like": result[i].like,
                            "comment": result[i].comment,
                            "addread": result[i].addread,
                            "addlike": result[i].addlike,
                            "addcomment": result[i].addcomment
                        };
                    }

                    // console.log("处理前：");
                    // console.log(array);

                    //我又来强行同步了            
                    let k;
                    for (k = 0; k < array.length - 1; k++) {
                        array[k].addread = array[k].read - array[k + 1].read;
                        array[k].addlike = array[k].like - array[k + 1].like;
                        array[k].addcomment = array[k].comment - array[k + 1].comment;
                    }
                    array[k].addread = 0;
                    array[k].addlike = 0;
                    array[k].addcomment = 0;

                    // // console.log("处理后：");
                    // console.log(array);

                    for (k = 0; k < array.length; k++) {
                        console.log(array[k].id);
                        console.log(array[k].title);
                        console.log(array[k].addread);
                        console.log(array[k].addlike);
                        console.log(array[k].addcomment);
                        var sql3 = "UPDATE article_data SET addread=" + array[k].addread + " ,addlike=" + array[k].addlike + " ,addcomment=" + array[k].addcomment + " where id=" + array[k].id + ' and title="' + array[k].title + '"';
                        console.log(sql3);
                        connection.query(sql3);
                    }



                }
            });

        }

    });

    connection.end;
}



exports.platform_addevery = async function (platform) {

    console.log("——————————开始分析", platform, "平台数据——————————");
    console.log("——————————开始分析", platform, "平台数据——————————");
    console.log("——————————开始分析", platform, "平台数据——————————");
    //这是一个写的很烂的代码，保护视力，千万别看

    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    Date.prototype.Format = function (fmt) { // author: meizz
        var o = {
            "M+": this.getMonth() + 1, // 月份
            "d+": this.getDate(), // 日
            "h+": this.getHours(), // 小时
            "m+": this.getMinutes(), // 分
            "s+": this.getSeconds(), // 秒
            "q+": Math.floor((this.getMonth() + 3) / 3), // 季度
            "S": this.getMilliseconds() // 毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    let article_number = 0;
    let platform_read = 0;
    let platform_like = 0;
    let platform_comment = 0;
    let gettime = new Date().Format("yyyy-MM-dd");
    let platform_addread = 0;
    let platform_addlike = 0;
    let platform_addcomment = 0;
    let sql1 = 'SELECT * FROM article_data AS a WHERE platform = "' + platform + '" AND NOT EXISTS ( SELECT 1 FROM article_data WHERE a.url = url AND a.`read` < `read` ) ORDER BY sendtime DESC;';

    connection.query(sql1, function (err, result) {
        if (err) {
            console.log(sql1);
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                article_number++;
                platform_read += result[i].read;
                platform_like += result[i].like;
                platform_comment += result[i].comment;
                platform_addread += result[i].addread;
                platform_addlike += result[i].addlike;
                platform_addcomment += result[i].addcomment;
            }

            console.log("累加数据");
            console.log(platform);
            console.log(article_number);
            console.log(platform_read);
            console.log(platform_like);
            console.log(platform_comment);
            console.log(platform_addread);
            console.log(platform_addlike);
            console.log(platform_addcomment);
            console.log(gettime);

        }

        var sql3 = "INSERT IGNORE INTO platfrom_data(`platfrom`,`article_number`,`gettime`,`read`,`like`,`comment`,`addread`,`addlike`,`addcomment`) VALUES ('" + platform + "','" + article_number + "','" + gettime + "','" + platform_read + "','" + platform_like + "','" + platform_comment + "','" + platform_addread + "','" + platform_addlike + "','" + platform_addcomment + "')";
        console.log(sql3);
        connection.query(sql3);

    });

    connection.end;
}