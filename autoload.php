<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: dingdayu dingxiaoyu@mocentre.com>
// +----------------------------------------------------------------------
// | DATE: 2016/7/18 10:34
// +----------------------------------------------------------------------

class Autoloader
{
    const NAMESPACE_PREFIX = 'TextToSQL\\';

    /**
     * 向PHP注册在自动载入函数.
     *
     * @author: dingdayu(614422099@qq.com)
     */
    public static function register()
    {
        spl_autoload_register([new self(), 'autoload']);
    }

    /**
     * 根据类名载入所在文件.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param $className
     */
    public static function autoload($className)
    {
        $namespacePrefixStrlen = strlen(self::NAMESPACE_PREFIX);
        if (strncmp(self::NAMESPACE_PREFIX, $className, $namespacePrefixStrlen) === 0) {
            $classNameArray = explode('\\', $className);
            unset($classNameArray[0]);
            $path = implode(DIRECTORY_SEPARATOR, $classNameArray);
            $filePath = __DIR__.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$path.'.php';
            if (file_exists($filePath)) {
                require_once $filePath;
            }
        }
    }
}

Autoloader::register();
