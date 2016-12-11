<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/11 14:34
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------

namespace TextToSQL\Console;

class IO
{
    // 询问用户输入
    public static function input($msg = '')
    {
        if ($msg) {
            fwrite(STDOUT, $msg);
        }

        $value = trim(fgets(STDIN));

        return $value;
    }

    /**
     * 输出到控制台.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param string $msg
     * @param string $color
     */
    public static function output($msg = '', $color = '')
    {
        $Color = new Color();
        echo $Color->color($msg, $color);
    }
}
