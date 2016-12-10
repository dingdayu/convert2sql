<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/11 01:39
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------


namespace TextToSQL;

class Write extends File
{
    /**
     * @var Config 配置类对象
     */
    private $config;

    private $file_name = 'export';
    private $exportPath = __DIR__ . "/../export/";

    public function __construct($file_name = 'export')
    {
        $file_path = $this->newFilePath($file_name);
        parent::__construct($file_path, 'a+');
        if(!is_writable($file_path)) {
            throw new \Exception('file not wirte!', 4004);
        }
        $this->config = new Config();
    }

    /**
     * 获取最好的操作名
     *
     * @author: dingdayu(614422099@qq.com)
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->path;
    }

    /**
     * 创建一个新的导出文件
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $name
     *
     * @return string
     */
    public function newFilePath($name = '')
    {
        $this->file_name = $name ?: $this->file_name;
        return $this->exportPath . $this->file_name . '_' . time() . '.sql';
    }


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
     * 字符串编码转换为UTF8.
     *
     * @author: dingdayu(614422099@qq.com)
     * @param $data
     *
     * @return mixed|string
     */
    public function characet($data){
        if( !empty($data) ){
            $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
            if( $fileType != 'UTF-8' || $fileType != 'UTF-8'){
                $data = mb_convert_encoding($data ,'utf-8' , $fileType);
                $data = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $data);
            }
        }
        return $data;
    }

    /**
     * 检查文件大小，并根据配置更新文件路径.
     *
     * @author: dingdayu(614422099@qq.com)
     */
    protected function checkFileSize()
    {
        $max_size = $this->getConfig('FileMaxSize');
        $max_size = $max_size - 4;

        if(file_exists($this->path)) {
            $file_size = filesize($this->path) / 1024;

            if($file_size > $max_size) {
                $file_path = $this->newFilePath();
                parent::__construct($file_path, 'a+');
            }
        }
    }

    /**
     * 将文件内容清空.
     *
     * @author: dingdayu(614422099@qq.com)
     * @return int
     */
    public function clear()
    {
        return file_put_contents($this->path, '');
    }

    /**
     * 删除文件.
     *
     * @author: dingdayu(614422099@qq.com)
     * @return bool
     */
    public function remove()
    {
        return $this->delTree($this->exportPath);
    }

    /**
     * 删除目录及文件
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $dir
     * @param bool   $removeSelf
     *
     * @return bool
     */
    public function delTree($dir = '', $removeSelf = false) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("{$dir}/{$file}")) ? $this->delTree("{$dir}/{$file}") : unlink("{$dir}/{$file}");
        }
        return $removeSelf ? rmdir($dir) : true;
    }
}