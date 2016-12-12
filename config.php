<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 10:20
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------

return array(
    // 添加到sql数组中的（表格中不存在的字段）
    'AddField' => ['appid' => 'gh_6ad2847b5c39'],
    // 导出的字段（表格中的名字）
    'ExportField' => ['fake_id', 'nick_name', 'sex', 'headimgurl', 'country', 'province', 'city', 'language', 'subscribe_time'],
    // 字段别名（需要更换字段名称时使用）
    'FieldAlias' => ['fake_id' => 'openid', 'nick_name' => 'nickname'],

    // 需要函数处理的字段（如果映射过字段，请使用新的字段作为键名）
    'FieldFunction' => ['subscribe_time' => 'strtotime', 'sex' => 'toSex'],

    // 导出的表格名称
    'TableName' => '`tp_bjrcb_wechat_fans_list`',

    // 需要文件分割时的大小，单位kb
    'FileMaxSize' => 102400
);
