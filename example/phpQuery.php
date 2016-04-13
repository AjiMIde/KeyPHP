<?php

/**
 * Copyright 2016-2020 Aji
 *
 * phpQuery is a server-side, chain able, CSS3 selector driven Document Object Model (DOM) API based on jQuery JavaScript Library.
 * Library is written in PHP5 and provides additional Command Line Interface (CLI).
 *
 * <<说明>>处理一个网页的时候，以前常使用正则，导致效率低、出错率高、难维护、可读性差等，phpQuery正是为了解决这个问题
 * phpQuery 是基于php5 的新增的 DOMDocument 来处理xml/html，运用xPath来处理.
 * 这个文件只是用来演示如何使用 phpQuery
 *
 * 项目地址：
 * [phpQuery](https://code.google.com/p/phpquery/)
 *
 * ## Get the list of specified type of files from document;
 *
 * ## Zip operation :
 * > * Create zip
 *
 * @email      Adele513900383@gmail.com
 *
 * Version     : 1.0
 * DateTime    : 2015-12-28
 * Modified    : 2016-04-13
 */

include '../Library/phpQuery/phpQuery-onefile.php';

/**
 * 初步认识
 */
function get() {
    phpQuery::newDocumentFile('http://www.baidu.com');
    $companies = pq('div');
    print_r($companies->html());
    foreach ($companies as $company) {
        echo pq($company)->find('a')->text() . "<br>";
    }
}

/**
 * phpQuery 提供多种方式创建 php 文档对象，如下：
 * ##可通过文件链接、http url、文本标志语言等；
 * ##也可以指定编码
 */
function newCreate() {
    phpQuery::newDocumentFile('http://www.baidu.com');

    $html = "<div></div>";
    $file = dirname(__FILE__) . '/xxx/xxx.html';
    $file = 'http://baidu.com';

    phpQuery::newDocument($html, $contentType = null);
    phpQuery::newDocumentFile($file, $contentType = null);
    phpQuery::newDocumentHTML($html, $charset = 'utf-8');
    phpQuery::newDocumentXHTML($html, $charset = 'utf-8');
    phpQuery::newDocumentXML($html, $charset = 'utf-8');
    phpQuery::newDocumentPHP($html, $contentType = null);
    phpQuery::newDocumentFileHTML($file, $charset = 'utf-8');
    phpQuery::newDocumentFileXHTML($file, $charset = 'utf-8');
    phpQuery::newDocumentFileXML($file, $charset = 'utf-8');
    phpQuery::newDocumentFilePHP($file, $contentType);
}

/**
 * phpQuery 提供的查询方法与jQuery基本一致
 * ## 支持#id,.className,element,*
 * ## 支持多查询，selector1,selector2
 * ## 支持选择符：空格,>,+,~
 * ## 支持属性[attr=**]
 * ## 支持更多
 */
function queryNode() {
    pq(".class ul > li[rel='foo']:first:has(a)");
}

/**
 * phpQuery 提供获取或修改对象的属性 attr，类 class，内容 html，文本 text，
 */
function changeAttrContent() {
    $obj = pq('div');

    $obj->attr('class');//get or set
    $obj->attr('checked', 'true');//set
    $obj->removeAttr('checked');//remove

    $obj->addClass('***');
    $obj->hasClass('***');
    $obj->removeClass('***');
    $obj->toggleClass('***');

    $obj->html();//get
    $obj->html('<div></div>');//set

    $obj->text();//get
    $obj->html('wtf');//set

    $obj->val();//get
    $obj->val('admin');//set
    $obj->val(true);//set

}

/**
 * 过滤器
 */
function filterNote() {
    $b = pq('div');
    $b->filter(':has(a)');
    $b->eq(1);
    $b->hasClass('.**');
    $b->is('**');
    $b->map('**');
    $b->not('**');
    $b->slice('**');
}

/**
 * 父、子代查询器
 */
function finding() {
    $b = pq('div');
    $b->add($b);
    $b->children('a');
    $b->contents();
    $b->next('a');
    $b->nextAll('');
    $b->parent('');
    $b->parents('');
    $b->prev('');
    $b->prevAll('');
    $b->siblings('');
}

/**
 * 合并、追加、插入、替换、删除
 */
function changingContent() {
    $b = pq('div');
    $b->append('<div></div>');
    $b->appendTo('<div></div>');
    $b->prepend('<div></div>');
    $b->prependTo('<div></div>');
    $b->after('<div></div>');
    $b->before('<div></div>');
    $b->insert('<div></div>');
    $b->insertBefore('<div></div>');
    $b->insertAfter('<div></div>');
    $b->wrap('<div></div>');
    $b->wrapAll('<div></div>');
    $b->wrapInner('<div></div>');
    $b->replaceAll('<div></div>');
    $b->replaceWith('<div></div>');
    $b->empty();
    $b->remove();
    $b->clone();
}

?>