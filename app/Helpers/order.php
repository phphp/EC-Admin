<?php

/**
 * 订单相关的帮助函数
 */

/**
 * 生成订单号
 * 订单号 = 年月日（6位）+ 订单号（后6位，认为每天的订单数不会超过100万）
 * 年月日易读也易于分表
 */
if ( ! function_exists('generateOrderNumber') )
{
    function generateOrderNumber(int $orderId)
    {
        return date('ymd', time()) . sprintf("%06d", substr($orderId, -6));
    }
}

/**
 * 数字转字符
 * 过万显示 x万+
 * 过百显示 3100+
 * 过十显示 20+
 * 个位精确显示
 */
if ( ! function_exists('numToStr') )
{
    function numToStr($num)
    {
        if ($num >= 10000) {
            return substr($num, 0, -4) . '万+';
        } elseif ($num >= 100) {
            return substr_replace($num, '00', -2, 2) . '+';
        } elseif ($num >= 10) {
            return substr_replace($num, '0', -1, 1) . '+';
        } else {
            return $num;
        }
    }
}