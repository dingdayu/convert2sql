<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/8 22:06
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------

namespace TextToSQL;

class File
{
    protected $handle;
    protected $path;

    public function __construct($file_path = '', $mode = 'r')
    {
        $this->handle = fopen($file_path, $mode);
        if (!file_exists($file_path)) {
            throw new \Exception('File not search!', 4001);
        }
        $this->path = $file_path;
    }

    /**
     * 获取指针位置.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return int
     */
    public function ftell()
    {
        return ftell($this->handle);
    }

    /**
     * 设置文件指针位置.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param int $offset
     *
     * @return int
     */
    public function fseek($offset = 0)
    {
        return fseek($this->handle, $offset);
    }

    /**
     * 将文件指针移到头部.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return bool
     */
    public function rewind()
    {
        return rewind($this->handle);
    }

    public function feof()
    {
        return feof($this->handle);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }
}
