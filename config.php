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
    'AddField' => ['appid' => 'gh_6ad2847b5c39'],
    'ExportField' => ['fake_id', 'nick_name', 'sex', 'headimgurl', 'country', 'province', 'city', 'language', 'subscribe_time'], // 导出字段

    'FieldAlias' => ['fake_id' => 'openid', 'nick_name' => 'nickname'], // 字段映射

    // 必须是新字段，如果映射过
    'FieldFunction' => ['subscribe_time' => 'strtotime', 'sex' => 'toSex'],

    'TableName' => '`tp_bjrcb_wechat_fans_list`',

    'FileMaxSize' => 102400
);
