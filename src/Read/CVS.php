<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 10:04
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------

namespace TextToSQL\Read;

use TextToSQL\Read;

class CVS extends Read
{
    /**
     * 1. 获取首行字段名称.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return array
     */
    private function getFirstRow()
    {
        $offset = $this->ftell();
        if ($offset !== 0) {
            //当指针不在开头时，转移到开头
            $this->rewind();
        }
        //读取首行
        $row = fgetcsv($this->handle);
        if ($offset !== 0) {
            //将指针移回
            $this->fseek($offset);
        }

        return $row;
    }

    /**
     * 2. 获取导出的字段数组 包含别名和定位.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return array
     */
    protected function getExportField()
    {
        if (!empty($this->export_field)) {
            return $this->export_field;
        }

        // 获取需要导出的字段配置和映射
        $exportField = $this->getConfig('ExportField');
        $fieldAlias = $this->getConfig('FieldAlias');

        $first = $this->getFirstRow();

        foreach ($first as $key => $value) {
            if (in_array($value, $exportField, true)) {
                $temp_pos = ['pos' => $key];
                $temp_pos['name'] = $value;
                $temp_pos['alias'] = (!empty($fieldAlias[$value])) ? $fieldAlias[$value] : $value;
                ksort($temp_pos);
                $this->export_field[] = $temp_pos;
            }
        }

        return $this->export_field;
    }

    /**
     * 获取打印到控制台的字段确认数组.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return array
     */
    public function printExportFiled()
    {
        $filed = $this->getExportField();
        $addField = $this->getConfig('AddField');
        $head_arr[] = ['name' => '字段名称', 'alias' => '字段别名', 'pos' => '字段位置'];
        ksort($head_arr);

        if (!empty($addField)) {
            foreach ($addField as $k => $v) {
                $add_arr = ['name' => $k, 'alias' => $v, 'pos' => '无'];
                ksort($add_arr);
                $head_arr[] = $add_arr;
            }
        }
        $filed = array_merge($head_arr, $filed);

        return $filed;
    }

    /**
     * 3. 根据一行内容，获取导出的数组.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param array $row
     *
     * @return array
     */
    protected function getFileRowToExportArr($row = [])
    {
        // 获取需要导出的字段定位和处理函数配置
        $fieldFunction = $this->getConfig('FieldFunction');
        $addField = $this->getConfig('AddField');

        if (empty($row)) {
            return [];
        }

        $arr = $addField ?: [];
        foreach ($this->export_field as $key => $value) {
            $temp_var = !empty($row[$value['pos']]) ? $row[$value['pos']] : '';
            // 处理字段函数
            $function = !empty($fieldFunction[$value['alias']])
                ?: !empty($fieldFunction[$value['name']]) ?: '';
            if (!empty($function)) {
                $function = $fieldFunction[$value['alias']];
                $temp_var = $this->exportCallable($function, $temp_var);
            }

            $arr = $arr + [$value['alias'] => $temp_var];
        }

        return $arr;
    }

    /**
     * 获取一行内容，并转出导出数组,自动下移文件游标.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return array|bool
     */
    private function getRowExportArr()
    {
        $content = fgetcsv($this->handle);
        if (empty($content)) {
            return [];
        }

        return $this->getFileRowToExportArr($content);
    }

    /**
     * 获取一定行数的导出数据.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param int $row    返回的行数,默认1行,-1则返回所有行
     * @param int $offset 开始的偏移量,默认-1不偏移,当为整数时偏移(暂不支持倒排)
     *
     * @return array
     */
    public function getExportArr($row = 1, $offset = -1)
    {
        $ret = [];

        if ($offset !== -1 && is_int($offset)) {
            $this->fseek($offset);
        }

        if ($row === -1) {
            while (!$this->feof()) {
                $ret[] = $this->getRowExportArr();
            }
        } else {
            for ($i = 1; $i <= $row; ++$i) {
                if (!$this->feof()) {
                    $ret[] = $this->getRowExportArr();
                }
            }
        }

        return $ret;
    }
}
