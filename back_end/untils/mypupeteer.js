const puppeteer = require('puppeteer');
const mysql = require('mysql');
const {
    setting
} = require('../config.js');

exports.get_sf_article_data = async function () {

    console.log("——————————开始抓取sf文章数据——————————");
    console.log("——————————开始抓取sf文章数据——————————");
    console.log("——————————开始抓取sf文章数据——————————");

    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let url_sentime = [];
    let articles_data = [];
    //需要修改平台名字
    const platform = "sf";

    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    //查询和轮寻
    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
                url_sentime[i] = result[i].sendtime;
            }
            console.log(url_array);

        }

    });

    const browser = await puppeteer.launch({
        headless: false
    });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1633,
        height: 754,
        deviceScaleFactor: 1,
    });


    for (i = 0; i < url_array.length; i++) {

        console.log("—————————开始抓取文章运营数据—————————");

        let id;
        const url = url_array[i];
        const send_time = url_sentime[i];
        const get_time = new Date();

        await page.goto(url);

        //每个网站不同的部分
        await page.waitFor('#articleTitle > a');
        await page.waitFor('body > div.wrap > div.container.mt15 > div > div.col-xs-12.col-md-9.main > div.post-topheader.custom-cloudbase.pt0 > div > div > div > div > div > div.content__tech.hidden-xs > span'); //


        const title = await page.$eval('#articleTitle > a', ele => ele.innerText);
        let read_count = await page.$eval(' body > div.wrap > div.container.mt15 > div > div.col-xs-12.col-md-9.main > div.post-topheader.custom-cloudbase.pt0 > div > div > div > div > div > div.content__tech.hidden-xs > span', ele => ele.innerText);
       
        let regexp = /(\d+(\.\d+)?)/g;
        let result = read_count.match(regexp);
        read_count = result[0];
        if (String(read_count).indexOf('.') != -1)
            read_count *= 1000;


        let like_count;
        let comments_count;

        try {
            like_count = await page.$eval('#mainLikeNum', ele => ele.innerText);
            if (like_count == null)
                like_count = 0;

        } catch (e) {
            like_count = 0;
        }

        try {
            comments_count = await page.$eval('#goToReplyArea > div.mb10.clearfix > strong', ele => ele.innerText); //badge
            if (comments_count == null)
                comments_count = 0;
            else if (comments_count == '评论')
                comments_count = 0;
            else {
                var result2 = comments_count.match(regexp);
                comments_count = result2[0];
            }
        } catch (e) {
            comments_count = 0;
        }

        console.log("文章", i + 1);
        console.log(title);
        console.log(url);
        console.log(get_time);
        console.log(send_time);
        console.log(read_count);
        console.log(like_count);
        console.log(comments_count);

        const article_data = [id, platform, title, send_time, get_time, url, read_count, like_count, comments_count];

        // console.log(article_data);
        articles_data.push(article_data);
    }

    await browser.close();

    console.log("爬取成功！！");
    // console.log(articles_data);


    console.log("开始插入");
    var insert_sql = "INSERT INTO article_data(`id`,`platform`,`title`,`sendtime`,`gettime`,`url`,`read`,`like`,`comment`) VALUES ?";

    connection.query(insert_sql, [articles_data], (err, results, fields) => {
        if (err) {
            return console.error(err.message);
        }
        console.log('插入articles_data成功');
    });

    connection.end;

    console.log("结束插入");
}

exports.get_juejin_article_data = async function () {

    console.log("——————————开始抓取掘金文章数据——————————");
    console.log("——————————开始抓取掘金文章数据——————————");
    console.log("——————————开始抓取掘金文章数据——————————");

    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let url_sentime = [];
    let articles_data = [];
    //需要修改平台名字
    const platform = "掘金";

    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    //查询和轮寻
    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
                url_sentime[i] = result[i].sendtime;
            }
            console.log(url_array);

        }

    });

    const browser = await puppeteer.launch({
        headless: false
    });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1633,
        height: 754,
        deviceScaleFactor: 1,
    });


    for (i = 0; i < url_array.length; i++) {

        console.log("—————————开始抓取文章运营数据—————————");

        let id;
        const url = url_array[i];
        const send_time = url_sentime[i];
        const get_time = new Date();

        await page.goto(url);

        //每个网站不同的部分
        await page.waitFor('#juejin > div.view-container > main > div > div.main-area.article-area.shadow > article > h1');
        await page.waitFor('#juejin > div.view-container > main > div > div.main-area.article-area.shadow > article > div.author-info-block > div > div > span');


        const title = await page.$eval('#juejin > div.view-container > main > div > div.main-area.article-area.shadow > article > h1', ele => ele.innerText);
        let read_count = await page.$eval('#juejin > div.view-container > main > div > div.main-area.article-area.shadow > article > div.author-info-block > div > div > span', ele => ele.innerText);

        let regexp = /(\d+(\.\d+)?)/g;
        let result = read_count.match(regexp);
        read_count = result[0];
        if (String(read_count).indexOf('.') != -1)
            read_count *= 1000;


        let like_count;
        let comments_count;


        try {
            like_count = await page.$eval('#juejin > div.view-container > main > div > div.article-suspended-panel.article-suspended-panel > div.like-btn.panel-btn.like-adjust.with-badge', ele => ele.badge);
            if (like_count == null)
                like_count = 0;
        } catch (e) {
            like_count = 0;
        }

        try {
            comments_count = await page.$eval('#juejin > div.view-container > main > div > div.article-suspended-panel.article-suspended-panel > div.comment-btn.panel-btn.comment-adjust.with-badge', ele => ele.badge);
            if (comments_count == null)
                comments_count = 0;
        } catch (e) {
            comments_count = 0;
        }


        console.log("文章", i + 1);
        console.log(title);
        console.log(url);
        console.log(get_time);
        console.log(send_time);
        console.log(read_count);
        console.log(like_count);
        console.log(comments_count);

        const article_data = [id, platform, title, send_time, get_time, url, read_count, like_count, comments_count];

        // console.log(article_data);
        articles_data.push(article_data);
    }

    await browser.close();

    console.log("爬取成功！！");
    // console.log(articles_data);


    console.log("开始插入");
    var insert_sql = "INSERT INTO article_data(`id`,`platform`,`title`,`sendtime`,`gettime`,`url`,`read`,`like`,`comment`) VALUES ?";

    connection.query(insert_sql, [articles_data], (err, results, fields) => {
        if (err) {
            return console.error(err.message);
        }
        console.log('插入articles_data成功');
    });

    connection.end;

    console.log("结束插入");
}

exports.get_weixin_club_article_data = async function () {

    console.log("——————————开始抓取微信开放社区文章数据——————————");
    console.log("——————————开始抓取微信开放社区文章数据——————————");
    console.log("——————————开始抓取微信开放社区文章数据——————————");



    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let url_sentime = [];
    let articles_data = [];
    //需要修改平台名字
    const platform = "微信开放社区";

    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    //查询和轮寻
    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
                url_sentime[i] = result[i].sendtime;
            }
            console.log(url_array);

        }

    });

    const browser = await puppeteer.launch({
        headless: false
    });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1633,
        height: 754,
        deviceScaleFactor: 1,
    });


    for (i = 0; i < url_array.length; i++) {

        console.log("—————————开始抓取文章运营数据—————————");

        let id;
        const url = url_array[i];
        const send_time = url_sentime[i];
        const get_time = new Date();

        await page.goto(url);

        //每个网站不同的部分
        await page.waitFor('#articleApp > div.post_overview.markdown_detail_post_overview > div > h1 > span > span');
        await page.waitFor('#create_time');


        const title = await page.$eval('#articleApp > div.post_overview.markdown_detail_post_overview > div > h1 > span > span', ele => ele.innerText);
        let read_count = await page.$eval('#articleApp > div.post_overview.markdown_detail_post_overview > div > div > div:nth-child(5) > span:nth-child(1)', ele => ele.innerText);

        let regexp = /(\d+(\.\d+)?)/g;
        let result = read_count.match(regexp);
        read_count = result[0];
        if (String(read_count).indexOf('.') != -1)
            read_count *= 1000;


        let like_count;
        let comments_count;


        try {
            like_count = await page.$eval('#articleApp > div.behavior_container > div.behavior_item.behavior_favour > div', ele => ele.innerText);
            if (like_count == null)
                like_count = 0;
        } catch (e) {
            like_count = 0;
        }

        try {
            comments_count = await page.$eval('#articleApp > div.post_overview.markdown_detail_post_overview > div > div > div:nth-child(6) > span:nth-child(1)', ele => ele.innerText);
            if (comments_count == null)
                comments_count = 0;
        } catch (e) {
            comments_count = 0;
        }


        console.log("文章", i + 1);
        console.log(title);
        console.log(url);
        console.log(get_time);
        console.log(send_time);
        console.log(read_count);
        console.log(like_count);
        console.log(comments_count);

        const article_data = [id, platform, title, send_time, get_time, url, read_count, like_count, comments_count];

        // console.log(article_data);
        articles_data.push(article_data);
    }

    await browser.close();

    console.log("爬取成功！！");
    // console.log(articles_data);


    console.log("开始插入");
    var insert_sql = "INSERT INTO article_data(`id`,`platform`,`title`,`sendtime`,`gettime`,`url`,`read`,`like`,`comment`) VALUES ?";

    connection.query(insert_sql, [articles_data], (err, results, fields) => {
        if (err) {
            return console.error(err.message);
        }
        console.log('插入articles_data成功');
    });

    connection.end;

    console.log("结束插入");
}

exports.get_yun_club_article_data = async function () {

    console.log("——————————开始抓取云+社区文章数据——————————");
    console.log("——————————开始抓取云+社区文章数据——————————");
    console.log("——————————开始抓取云+社区文章数据——————————");

    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let url_sentime = [];
    let articles_data = [];
    //需要修改平台名字
    const platform = "云+社区";

    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    //查询和轮寻
    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
                url_sentime[i] = result[i].sendtime;
            }
            console.log(url_array);

        }

    });

    const browser = await puppeteer.launch({
        headless: false
    });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1633,
        height: 754,
        deviceScaleFactor: 1,
    });


    for (i = 0; i < url_array.length; i++) {

        console.log("—————————开始抓取文章运营数据—————————");

        let id;
        const url = url_array[i];
        const send_time = url_sentime[i];
        const get_time = new Date();

        await page.goto(url);

        //每个网站不同的部分
        await page.waitFor('#react-root > div:nth-child(1) > div.J-body.col-body.pg-article > h1');
        await page.waitFor('#react-root > div:nth-child(1) > div.J-body.col-body.pg-article > div.col-article-author > div.extra-part > div > span > span');


        const title = await page.$eval('#react-root > div:nth-child(1) > div.J-body.col-body.pg-article > h1', ele => ele.innerText);
        let read_count = await page.$eval('#react-root > div:nth-child(1) > div.J-body.col-body.pg-article > div.col-article-author > div.extra-part > div > span > span', ele => ele.innerText);

        let regexp = /(\d+(\.\d+)?)/g;
        let result = read_count.match(regexp);
        read_count = result[0];
        if (String(read_count).indexOf('.') != -1)
            read_count *= 1000;


        let like_count;
        let comments_count;

        try {
            like_count = await page.$eval('#react-root > div:nth-child(1) > div.J-body.col-body.pg-article > section.col-article > div.com-widget-operations > div.main-cnt > a > span', ele => ele.innerText);
            if (like_count == null)
                like_count = 0;

        } catch (e) {
            like_count = 0;
        }

        try {
            comments_count = await page.$eval('#react-root > div:nth-child(1) > div.J-body.col-body.pg-article > section.col-group.group-comments > div > header > div > span', ele => ele.innerText);
            if (comments_count == null)
                comments_count = 0;
            else if (comments_count == '评论')
                comments_count = 0;
            else {
                var result2 = comments_count.match(regexp);
                comments_count = result2[0];
            }
        } catch (e) {
            comments_count = 0;
        }

        console.log("文章", i + 1);
        console.log(title);
        console.log(url);
        console.log(get_time);
        console.log(send_time);
        console.log(read_count);
        console.log(like_count);
        console.log(comments_count);

        const article_data = [id, platform, title, send_time, get_time, url, read_count, like_count, comments_count];

        // console.log(article_data);
        articles_data.push(article_data);
    }

    await browser.close();

    console.log("爬取成功！！");
    // console.log(articles_data);


    console.log("开始插入");
    var insert_sql = "INSERT INTO article_data(`id`,`platform`,`title`,`sendtime`,`gettime`,`url`,`read`,`like`,`comment`) VALUES ?";

    connection.query(insert_sql, [articles_data], (err, results, fields) => {
        if (err) {
            return console.error(err.message);
        }
        console.log('插入articles_data成功');
    });

    connection.end;

    console.log("结束插入");
}

exports.get_jianshu_article_data = async function () {

    console.log("——————————开始抓取简书文章数据——————————");
    console.log("——————————开始抓取简书文章数据——————————");
    console.log("——————————开始抓取简书文章数据——————————");


    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let url_sentime = [];
    let articles_data = [];
    //需要修改平台名字
    const platform = "简书";

    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    //查询和轮寻
    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
                url_sentime[i] = result[i].sendtime;
            }
            console.log(url_array);

        }

    });

    const browser = await puppeteer.launch({
        headless: false
    });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1633,
        height: 754,
        deviceScaleFactor: 1,
    });


    for (i = 0; i < url_array.length; i++) {

        console.log("—————————开始抓取文章运营数据—————————");

        let id;
        const url = url_array[i];
        const send_time = url_sentime[i];
        const get_time = new Date();

        await page.goto(url);

        //每个网站不同的部分
        await page.waitFor('#__next > div._21bLU4._3kbg6I > div > div > section:nth-child(1) > h1');
        await page.waitFor('#__next > div._21bLU4._3kbg6I > div > div > section:nth-child(1) > div.rEsl9f > div > span:nth-child(3)');


        const title = await page.$eval('#__next > div._21bLU4._3kbg6I > div > div > section:nth-child(1) > h1', ele => ele.innerText);
        let read_count = await page.$eval('#__next > div._21bLU4._3kbg6I > div > div > section:nth-child(1) > div.rEsl9f > div > span:nth-child(3)', ele => ele.innerText);

        let regexp = /(\d+(\.\d+)?)/g;
        let result = read_count.match(regexp);
        read_count = result[0];
        if (String(read_count).indexOf('.') != -1)
            read_count *= 1000;


        let like_count;
        let comments_count;


        try {
            like_count = await page.$eval('#__next > div._21bLU4._3kbg6I > div > div._gp-ck > section:nth-child(1) > div._1kCBjS > div:nth-child(1) > div:nth-child(1) > span', ele => ele.innerText);
            if (like_count == null)
                like_count = 0;
            else {
                let regexp = /(\d+(\.\d+)?)/g;
                let result = like_count.match(regexp);
                like_count = result[0];
            }
        } catch (e) {
            like_count = 0;
        }

        try {
            comments_count = await page.$eval('#note-page-comment > section > h3 > div._10KzV0 > span._2R7vBo', ele => ele.innerText);
            if (comments_count == null)
                comments_count = 0;
        } catch (e) {
            comments_count = 0;
        }


        console.log("文章", i + 1);
        console.log(title);
        console.log(url);
        console.log(get_time);
        console.log(send_time);
        console.log(read_count);
        console.log(like_count);
        console.log(comments_count);

        const article_data = [id, platform, title, send_time, get_time, url, read_count, like_count, comments_count];

        // console.log(article_data);
        articles_data.push(article_data);
    }

    await browser.close();

    console.log("爬取成功！！");
    // console.log(articles_data);


    console.log("开始插入");
    var insert_sql = "INSERT INTO article_data(`id`,`platform`,`title`,`sendtime`,`gettime`,`url`,`read`,`like`,`comment`) VALUES ?";

    connection.query(insert_sql, [articles_data], (err, results, fields) => {
        if (err) {
            return console.error(err.message);
        }
        console.log('插入articles_data成功');
    });

    connection.end;

    console.log("结束插入");
}

exports.get_csdn_article_data = async function () {

    console.log("——————————开始抓取CSDN文章数据——————————");
    console.log("——————————开始抓取CSDN文章数据——————————");
    console.log("——————————开始抓取CSDN文章数据——————————");


    const connection = mysql.createConnection(setting);

    connection.connect(
        console.log("连接成功")
    );

    let url_array = [];
    let url_sentime = [];
    let articles_data = [];
    //需要修改平台名字
    const platform = "CSDN";

    let sql1 = 'SELECT * FROM article_detail WHERE platform = "' + platform + '"';

    //查询和轮寻
    connection.query(sql1, function (err, result) {
        if (err) {
            console.log('[SELECT ERROR] - ', err.message);
            return;
        } else {
            console.log(sql1);

            for (var i in result) {
                url_array[i] = result[i].url;
                url_sentime[i] = result[i].sendtime;
            }
            console.log(url_array);

        }

    });

    const browser = await puppeteer.launch({
        headless: false,
        args: ['--start-maximized'],
    });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1366,
        height: 768,
        deviceScaleFactor: 1,
    });


    for (i = 0; i < url_array.length; i++) {

        console.log("—————————开始抓取文章运营数据—————————");

        let id;
        const url = url_array[i];
        const send_time = url_sentime[i];
        const get_time = new Date();

        await page.goto(url);

        //每个网站不同的部分

        await page.waitFor('#mainBox > main > div.blog-content-box > div > div > div.article-title-box > h1');
        console.log("1")

        await page.waitFor('#mainBox > main > div.blog-content-box > div > div > div.article-info-box > div.article-bar-top > span.read-count');
        console.log("1")

        const title = await page.$eval('#mainBox > main > div.blog-content-box > div > div > div.article-title-box > h1', ele => ele.innerText);
        console.log("1")
        let read_count = await page.$eval('#mainBox > main > div.blog-content-box > div > div > div.article-info-box > div.article-bar-top > span.read-count', ele => ele.innerText);
        console.log("1")

        let regexp = /(\d+(\.\d+)?)/g;
        let result = read_count.match(regexp);
        read_count = result[0];
        if (String(read_count).indexOf('.') != -1)
            read_count *= 1000;


        let like_count;
        let comments_count;


        try {
            like_count = await page.$eval('#supportCount', ele => ele.innerText);
            console.log("1")
            if (like_count == null)
                like_count = 0;
        } catch (e) {
            like_count = 0;
        }
        

        try {
            comments_count = await page.$eval('body > div.tool-box.vertical > ul > li:nth-child(3) > a > p');
            console.log("1")
            if (comments_count == null)
                comments_count = 0;
        } catch (e) {
            comments_count = 0;
        }


        console.log("文章", i + 1);
        console.log(title);
        console.log(url);
        console.log(get_time);
        console.log(send_time);
        console.log(read_count);
        console.log(like_count);
        console.log(comments_count);

        const article_data = [id, platform, title, send_time, get_time, url, read_count, like_count, comments_count];

        // console.log(article_data);
        articles_data.push(article_data);
    }

    await browser.close();

    console.log("爬取成功！！");
    // console.log(articles_data);


    console.log("开始插入");
    var insert_sql = "INSERT INTO article_data(`id`,`platform`,`title`,`sendtime`,`gettime`,`url`,`read`,`like`,`comment`) VALUES ?";

    connection.query(insert_sql, [articles_data], (err, results, fields) => {
        if (err) {
            return console.error(err.message);
        }
        console.log('插入articles_data成功');
    });

    connection.end;

    console.log("结束插入");
}
// csdn失败了


exports.get_csdn_article_data = async function () {
//    知乎因为他本身没有显示阅读量这种东西只能靠自己手写，只能得到点赞数和评论数，粉丝变化
}
