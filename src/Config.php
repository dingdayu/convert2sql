<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 10:58
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------


namespace TextToSQL;


class Config
{
    private static $config = [];

    public function __construct()
    {
        if(empty(self::$config))
            self::$config = require(__DIR__ . '/../config.php');
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return self::$config;
    }

    public function get($name = '', $def = '')
    {
        return self::$config[$name] ?: $def;
    }

    public function set($name = '', $value = '')
    {
        self::$config[$name] = $value;
        return self::$config[$name];
    }
}