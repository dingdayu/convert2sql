<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 10:33
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------


namespace TextToSQL;


class ExportHandle
{
    /**
     * 将时间转时间戳.
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $str
     *
     * @return false|int
     */
    public function strtotime($str = '')
    {
        date_default_timezone_set('Asia/Shanghai');
        return strtotime($str);
    }

    /**
     * 填充性别.
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $str
     *
     * @return int
     */
    public function toSex($str = '')
    {
        return $str ?: 0;
    }
}