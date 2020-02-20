
/*
* @author：Volcano-Yang 
* @document：后端爬虫的入口文件
*/

/*
 *mypupeteer是抓取各个网站数据的爬虫模块
 *simple_analyse是对爬取到的数据进行简单数据处理的模块（与昨天对比，得到各种增量）
 */

const get_article_data = require('./untils/mypupeteer')
const simple_anaylse = require('./untils/simple_anaylse')


/*
 * getinformation的作用：抓取各个网站数据
 * 每一个模块中抓取具体网站文章的函数命名规范：get_平台_article_data 
 * 注意最好先屏蔽简书，简书在整改，有些文章访问不了，会影响后面的抓取
 */

async function getinformation() {

    await get_article_data.get_sf_article_data();

    // await get_article_data.get_jianshu_article_data();

    await get_article_data.get_juejin_article_data();

    await get_article_data.get_weixin_club_article_data();

    await get_article_data.get_yun_club_article_data();

}


// var platform = ["sf", "简书", "掘金", "微信开放社区", "云+社区"];
var platform = ["sf", "掘金", "微信开放社区", "云+社区"];


/*
 * anaylse_article_addeverday的作用：得到每一篇文章今日与昨日相比的数据增量
 */
async function anaylse_article_addeverday() {

    for (var i = 0; i < platform.length; i++)

        await simple_anaylse.article_addeverday(platform[i]);

}


/*
 * anaylse_platform_addevery的作用：得到每一平台今日与昨日相比的数据增量
 */
async function anaylse_platform_addevery() {

    for (var i = 0; i < platform.length; i++)

        await simple_anaylse.platform_addevery(platform[i]);

}


async function main() {
    await  getinformation();
    await  anaylse_article_addeverday();
    await  anaylse_platform_addevery();

}

main();
