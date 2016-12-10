<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 18:14
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------


namespace TextToSQL\Console;


class Table
{

    private $lengthArray = [];

    /**
     * 通过数组获取对应的长度数组.
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array $filed
     *
     * @return array
     */
    public function getLengthArray($filed = [])
    {
        $this->lengthArray = [];
        foreach ($filed as $key => $value) {
            foreach ($value as $k => $v) {
                $this->lengthArray[$key][$k] = strlen($v);
            }
        }
        return $this->lengthArray;
    }

    /**
     * 用一维数组代表原二维数组中的最大长度
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array $filed
     *
     * @return array
     */
    public function getLengthArrayMaxArray($filed = [])
    {
        $arrLength = [];
        $lengthArray = $this->getLengthArray($filed);
        $keyArray = array_keys($filed[0]);

        foreach ($keyArray as $value) {
            $arrLength[$value] = $this->getMax(array_column($lengthArray, $value));
        }

        return $arrLength;
    }

    /**
     * 获取字符串的表格
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array $filed
     *
     * @return string
     */
    public function getTable($filed = [])
    {
        $return = '';
        $arrLength = $this->getLengthArrayMaxArray($filed);
        $rowLength = 0;

        foreach ($filed as $value) {
            $row = '|';
            foreach ($value as $k => $v) {
                $length = $this->getStringLength($v);
                $row .= ' ' . $v . str_repeat(' ', $arrLength[$k] - $length) . " | ";
            }
            $row = trim($row);
            $rowLength = $this->getStringLength($row);
            $return .= $row .PHP_EOL;
        }

        $head = str_repeat('-', $rowLength) . PHP_EOL;

        return $head . $return . $head;
    }

    /**
     * 获取一个数组中的最大值
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array $arr
     *
     * @return mixed
     */
    private function getMax($arr = [])
    {
        sort($arr);
        return end($arr);
    }

    /**
     * 获取一个数组中的最小值
     *
     * @author: dingdayu(614422099@qq.com)
     * @param array $arr
     *
     * @return mixed
     */
    private function getMin($arr = [])
    {
        sort($arr);
        return $arr[0];
    }

    /**
     * 兼容的获取一个字符串长度
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $str
     *
     * @return float|int
     */
    private function getStringLength($str = '')
    {
        return (strlen($str) + mb_strlen($str,'UTF8')) / 2;
    }
}