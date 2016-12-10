<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/11 01:49
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------


namespace TextToSQL;


class Read extends File
{
    /**
     * @var array 字段分隔符,支持多个
     */
    protected $delimiter = [','];

    /**
     * @var array 导出的字段配置, 包含定位,别名
     */
    protected $export_field = [];

    /**
     * @var Config 配置类对象
     */
    private $config;

    public function __construct($file_path, $mode = 'r')
    {
        parent::__construct($file_path, $mode);
        $this->config = new Config();
        $this->export_field = $this->getExportField();
    }

    protected function getExportField(){}

    /**
     * 获取配置中的配置项.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param string $name
     *
     * @return string
     * @throws \Exception
     */
    protected function getConfig($name = '')
    {
        $value = $this->config->get($name);
        if (empty($value)) {
            throw new \Exception("config.php {$value} undefinition!", 4010);
        }
        return $value;
    }


    /**
     * 分割字符串为数组.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param string $str
     *
     * @return array|string
     */
    private function multiexplode($str = '')
    {
        if (!is_array($str)) {
            if (count($this->delimiter) > 1) {
                $str = str_replace($this->delimiter, $this->delimiter[0], $str);
            }
            $str = explode($this->delimiter[0], $str);
        }
        return $str;
    }

    /**
     * 导出前对字段进行回调处理
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param string $callback
     * @param string $str
     *
     * @return mixed
     * @throws \Exception
     */
    protected function exportCallable($callback = '', $str = '')
    {
        // 如果自定义类名
        if (is_array($callback)) {
            $callbackObj = new $callback[0]();
            if (method_exists($callbackObj, $callback[1])) {
                return call_user_func($callback, $str);
            } else {
                throw new \Exception("{$callback[0]}->{$callback[1]} not method! !", 4021);
            }
        } else {
            // 检查通用处理
            $exportHandle = new ExportHandle();
            if (method_exists($exportHandle, $callback)) {
                return call_user_func([$exportHandle, $callback], $str);
            }
            // 检查是否函数
            if (function_exists($callback)) {
                return call_user_func($callback, $str);
            }

            throw new \Exception("{$callback} not method!!", 4022);
        }

    }

    /**
     * 获取当前文件读取百分比.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return float
     */
    public function getProgress()
    {
        $size = filesize($this->path);
        $offset = $this->ftell();

        $x = $offset * 100 / $size;
        return ceil($x);
    }

    /**
     * 将内容转换为UTF8编码.
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @param string $data
     *
     * @return string
     */
    public function characet($data = ''){
        if( !empty($data) ){
            $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
            if( $fileType != 'UTF-8'){
                $data = mb_convert_encoding($data ,'utf-8' , $fileType);
            }
        }
        return $data;
    }
}