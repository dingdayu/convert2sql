<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/8 22:26
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------

include_once 'autoload.php';

$start_memory = memory_get_usage();

$csv = new \TextToSQL\Read\CVS(__DIR__ . '/4.csv');
$sql = new \TextToSQL\Write\SQL();

// 清理导出文件夹(暂不可用，会将导出的文件直接删除，因为先创建的文件后删除的)
// 两种方案，一，导出时新建文件不放在构造方法里，二，将清理文件夹的方法独立出来
//$sql->remove();

$filed = $csv->printExportFiled();
$table = new \TextToSQL\Console\Table();
echo $table->getTable($filed);

if(strtolower(\TextToSQL\Console\IO::input('格式是否正确：（y是，其他否）')) != 'y') {
    exit();
}

echo "导出文件：" . PHP_EOL . $sql->getFilePath() . PHP_EOL;

while (!$csv->feof()) {
    // 获取一行数据
    $data = $csv->getExportArr();

    // 显示进度
    $i = $csv->getProgress();
    $memory = memory_get_usage() - $start_memory;
    printf("当前进度: [%-50s] %d%% 占用：%dM\r", str_repeat('#',$i/2), $i, $memory/1024);

    // 存入文件
    $sql->write($data);
}

echo PHP_EOL;
echo "Done.\n";


