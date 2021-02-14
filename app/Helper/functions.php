<?php

/**
 * JSON响应
 *
 * @param $message
 * @param $code
 * @param null $data
 */
function ee_json($message, $code, $data = null)
{
    $format = [
        'message' => $message,
        'code'    => $code,
        'data'    => $data
    ];
    return $format;
}

function  uuid()
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr ( $chars, 0, 8 ) . '-'
        . substr ( $chars, 8, 4 ) . '-'
        . substr ( $chars, 12, 4 ) . '-'
        . substr ( $chars, 16, 4 ) . '-'
        . substr ( $chars, 20, 12 );
    return $uuid ;
}