<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 10:09
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------
namespace TextToSQL\Write;

use TextToSQL\Write;

class SQL extends Write
{
    /**
     * 生成sql插入语句
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array  $data
     * @param string $eol
     *
     * @return string
     */
    public function generate($data = [], $eol = PHP_EOL)
    {
        $field_str = '';
        $data_str = '';
        $table_name = $this->getConfig('TableName');
        foreach ($data as $key => $value) {
            $field_str .= '`'. addslashes($key). '`,';
            $data_str .= '\''. addslashes($value). '\',';
        }
        $field_str = trim($field_str, ',');
        $data_str = trim($data_str, ',');
        $sql = "insert into {$table_name} ( {$field_str} ) values ( {$data_str} );" . $eol;
        return $this->characet($sql);
    }

    /**
     * 将传入的数组生成SQL并写入文件.
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array $data
     *
     * @return int|null
     * @throws \Exception
     */
    public function write($data = [])
    {
        if(empty($data))
            return null;

        $content = '';
        if(is_array($data[0])) {
            foreach ($data as $value) {
                if(empty($value))
                    continue;
                $content .= $this->generate($value);
            }
        } else {
            $content = $this->generate($data);
        }

        $ret = fwrite($this->handle, $content);
        if($ret === false) {
            throw new \Exception("file fwrite error!", 4006);
        }
        $this->checkFileSize();
        return $ret;
    }

}