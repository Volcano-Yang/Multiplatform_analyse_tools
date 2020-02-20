# data_analyze-_tool

这是我利用空余时间开发的一个新媒体多平台文章数据统计工具，旨在解决现在公司在多个新媒体平台都有撒网，日常整理分析文章数据繁琐低效的问题。我通过node的chrome puppeteer库模拟浏览器操作，跳转到对各平台已经发布文章的url，对页面数据进行DOM定位抓取。然后再将抓取到的数据进行整理，与之前的数据进行对比分析，通过layui前端框架+php+echarts快速搭建网站进行展示。

## Todos:
- [ ] 进一步优化抓取准确率,对读取失败的文章设置是否再次抓取
- [ ] 直接设置账号主页即可抓取账号的全部文章数据，避免每次都要录入新文章url的麻烦
- [ ] 将展示网站改成vue+koa，模块化，前后端分离

## 使用到的技术

- 前端：layui框架

- 后端：php

- 爬虫部分：node的puppeteer

## 文件目录

- front_end---前端文件

  -untils---爬虫封装函数接口

  -assets---一些自己写的操作数据库的工具

- back_end---后端文件

  -asset/php 存放主要的前端模块

## 入口文件

index.html 是前端入口文件

app.js 是后端爬虫启动文件


## 数据库

数据库导出文件为：cloudcase_pe.sql

### 数据库表说明

- user——用户管理

- article_detail——抓取文章需要用到的url、发布时间、发布平台。

- article_data——每日抓取的单个文章的数据和初步分析

- platfrom_data——平台每日的汇总数据




