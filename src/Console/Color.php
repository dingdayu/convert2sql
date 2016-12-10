<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://dingxiaoyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed dingdayu.
// +----------------------------------------------------------------------
// | Author: dingdayu 614422099@qq.com
// +----------------------------------------------------------------------
// | DATE: 2016/12/9 15:21
// +----------------------------------------------------------------------
// | Explain: 请在这里填写说明
// +----------------------------------------------------------------------

namespace TextToSQL\Console;

class Color
{
    private $themes = [
        'failure' => '31',
        'success' => '32',
        'warning' => '33',
        'note' => '34',
    ];

    private $styles = array(
        'none' => null,
        'bold' => '1',
        'dark' => '2',
        'italic' => '3',
        'underline' => '4',
        'blink' => '5',
        'reverse' => '7',
        'concealed' => '8',
        'default' => '39',
        'black' => '30',
        'red' => '31',
        'green' => '32',
        'yellow' => '33',
        'blue' => '34',
        'magenta' => '35',
        'cyan' => '36',
        'light_gray' => '37',
        'dark_gray' => '90',
        'light_red' => '91',
        'light_green' => '92',
        'light_yellow' => '93',
        'light_blue' => '94',
        'light_magenta' => '95',
        'light_cyan' => '96',
        'white' => '97',
        'bg_default' => '49',
        'bg_black' => '40',
        'bg_red' => '41',
        'bg_green' => '42',
        'bg_yellow' => '43',
        'bg_blue' => '44',
        'bg_magenta' => '45',
        'bg_cyan' => '46',
        'bg_light_gray' => '47',
        'bg_dark_gray' => '100',
        'bg_light_red' => '101',
        'bg_light_green' => '102',
        'bg_light_yellow' => '103',
        'bg_light_blue' => '104',
        'bg_light_magenta' => '105',
        'bg_light_cyan' => '106',
        'bg_white' => '107',
    );

    public static $SUCCESS = 'SUCCESS';
    public static $FAILURE = 'FAILURE';
    public static $WARNING = 'WARNING';
    public static $NOTE = 'NOTE';

    private $delimiter = [',', '|'];

    public function __construct()
    {
        $this->styles = array_merge($this->styles, $this->themes);
    }

    /**
     * 将语义化颜色转换成颜色代码
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $str
     *
     * @return int|mixed
     */
    public function convertColors($str = '')
    {
        if(is_array($str)) {
            $color_code_arr = [];
            foreach ($str as $value) {
                if(!empty($this->styles[$value])) {
                    $color_code_arr[] = $this->styles[$value];
                } elseif (is_int($value)) {
                    $color_code_arr[] = $value;
                }
            }

            return implode(';', $color_code_arr);
        }
        return in_array($str, $this->styles) ? $this->styles[$str] : 0;
    }

    /**
     * 分割字符串为数组.
     *
     * @author: dingdayu(614422099@qq.com)
     * @param string $color
     *
     * @return array|string
     */
    public function multiexplode($color = '')
    {
        if(!is_array($color)) {
            $ready = str_replace($this->delimiter, $this->delimiter[0], $color);
            $color = explode($this->delimiter[0], $ready);
        }
        return  $color;
    }

    /**
     * 检查当前环境十分支持颜色标准.
     *
     * @author: dingdayu(614422099@qq.com)
     * @return bool
     */
    public function checkColorSupport()
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return getenv('ANSICON') !== false || getenv('ConEmuANSI') === 'ON';
        }
        return function_exists('posix_isatty') && @posix_isatty(STDOUT);
    }

    public function getColors()
    {
        return array_keys($this->styles);
    }

    /**
     * @author: dingdayu(614422099@qq.com)
     * @param string $text
     * @param string $status
     * @param string $eol
     *
     * @return string
     */
    public function color($text = '', $status = 'NOTE', $eol = PHP_EOL)
    {
        if(!$this->checkColorSupport()) {
            return $text;
        }
        $color = $this->multiexplode($status);
        $code = $this->convertColors($color);
        return "\033[{$code}m" . $text . chr(27) . "[0m" . $eol;
    }
}