var mysql = require('mysql');
const {
    setting
} = require('../config.js');


//需要去利用在线工具转录，在复制,然后传入一个这样的数组
// var values = [
//     ["25", "CSDN", "云开发0基础训练营第二期热力来袭！", "https://blog.csdn.net/TCB_CloudBase/article/details/100893501", "文章", "2019-9-16"],
//     ["26", "CSDN", "云开发的数据库权限机制解读丨云开发101", "https://blog.csdn.net/TCB_CloudBase/article/details/100927651", "文章", "2019-9-18"],
//     ["27", "CSDN", "小程序·云开发的HTTP API调用丨实战", "https://blog.csdn.net/TCB_CloudBase/article/details/101031385", "文章", "2019-9-19"],
// ];

exports.insert_websites = function (values) {


    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("CONNECT SUCCESS")
    );

    var sql = "INSERT INTO article_detail(`id`,`platform`,`title`,`url`,`type`,`sendtime`) VALUES ?";

    connection.query(sql, [values], function (err) {
        if (err) {
            console.log('INSERT ERROR - ', err.message);
            return;
        }
        console.log("INSERT SUCCESS");
    });

    connection.end();

}