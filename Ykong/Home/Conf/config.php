<?php
return array(
	//'配置项'=>'配置值'

    //'配置项'=>'配置值'
    'DB_TYPE'=>'mysql',
    'DB_HOST'=>'127.0.0.1',
    'DB_NAME'=>'ykong',
    'DB_USER'=>'root',
    'DB_PWD'=>'root',
    'DB_PORT'=>3306,
    'URL_HTML_SUFFIX'       => '',
    'DB_PARAMS'=> array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),

    'MAIL_ADDRESS'=>'13006397107@163.com', // 邮箱地址
    'MAIL_SMTP'=>'smtp.163.com', // 邮箱SMTP服务器
    'MAIL_LOGINNAME'=>'13006397107@163.com', // 邮箱登录帐号
    'MAIL_PASSWORD'=>'chencong132327', // 邮箱密码

    'TMPL_PARSE_STRING' =>array(
        '__PUBLIC__'=>__ROOT__.'/Public',
        '__CSS__' => __ROOT__.'/Public/css',
        '__JS__' => __ROOT__.'/Public/js',
        '__JUI__'=>__ROOT__.'/Public/easyui'
    )
);

