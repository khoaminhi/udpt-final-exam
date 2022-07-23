<?php
function generateMaDK(){
    $characters = '0123456789ABCDXYZ';
        $charactersLength = strlen($characters);
        $maDangKy = '';
        for ($i = 0; $i < 10; $i++) {
            $maDangKy .= $characters[rand(0, $charactersLength - 1)];
        }
}

function rand_str($length=10, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $result = '';
    $count = strlen($charset);
    for ($i = 0; $i < $length; $i++) {
        $result .= $charset[mt_rand(0, $count - 1)];
    }
    return $result;
}
?>