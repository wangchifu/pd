<?php

use Illuminate\Support\Facades\Log;

//顯示某目錄下的檔案
if (!function_exists('get_files')) {
    function get_files($folder)
    {
        if (!is_dir($folder)) {
            return false;
        }
           // 使用 scandir 取得目錄中的所有檔案和子目錄，過濾掉 '.' 和 '..'
        $files = array_diff(scandir($folder), array('.', '..'));

        // 初始化一個空陣列來保存文件
        $allFiles = [];

        // 遍歷每個檔案並確認它是文件而不是目錄
        foreach ($files as $file) {
            $filePath = $folder . DIRECTORY_SEPARATOR . $file;
            if (is_file($filePath)) {
                $allFiles[] = $file;  // 將文件名加入結果陣列
            }
        }

        return $allFiles; // 返回所有檔案的陣列
    }
}

//刪除某目錄所有檔案
if (!function_exists('del_folder')) {
    function del_folder($dir) {
        if (!is_dir($dir)) {
            echo "The provided path is not a directory!";
            return false;
        }
    
        // 打开目录句柄
        $items = scandir($dir);
        
        // 遍历目录中的所有项
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                // 跳过 . 和 ..
                continue;
            }
    
            $path = $dir . DIRECTORY_SEPARATOR . $item;
    
            // 如果是目录，递归删除子目录
            if (is_dir($path)) {
                del_folder($path);
            } else {
                // 如果是文件，删除文件
                unlink($path);
            }
        }
    
        // 删除当前目录
        rmdir($dir);
        return true;
    }
}

//自動判斷url是否有http，否則自動補齊
if (!function_exists('transfer_url_http')) {
    function transfer_url_http($url)
    {
        if (!($url)) {
            return null;
        } else {
            if (substr($url, 0, 8) == 'https://') {
                return $url;
            } elseif (substr($url, 0, 7) == 'http://') {
                return $url;
            } else {
                return 'http://' . $url;
            }
        }
    }
}


//轉為kb
if (!function_exists('filesizekb')) {
    function filesizekb($file)
    {
        return number_format(filesize($file) / pow(1024, 1), 2, '.', '');
    }
}

function filesizemb($file)
{    
    $sizeInBytes = filesize($file);
    $sizeInMB = $sizeInBytes / 1024 / 1024;

    return round($sizeInMB, 2) . ' MB';
}



function get_ip()
{
    $ipAddress = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // to get shared ISP IP address
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check for IPs passing through proxy servers
        // check if multiple IP addresses are set and take the first one
        $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipAddressList as $ip) {
            if (!empty($ip)) {
                // if you prefer, you can check for valid IP address here
                $ipAddress = $ip;
                break;
            }
        }
    } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED'];
    } else if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }
    return $ipAddress;
}

//回傳學校代碼，為國中小而設
if (!function_exists('get_schoool_code')) {
    function get_schoool_code($code)
    {
        //成功高中
        if($code =="074339" or $code =="074539") return "074339074539";
        //和美高中
        if($code =="074323" or $code =="074523") return "074323074523";
        //田中高中
        if($code =="074328" or $code =="074528") return "074328074528";
        //信義國中小
        if($code =="074541" or $code =="074774") return "074541074774";
        //鹿江國中小
        if($code =="074542" or $code =="074778") return "074542074778";
        //民權華德福國中小
        if($code =="074543" or $code =="074760") return "074543074760";
        //原斗國中小
        if($code =="074537" or $code =="074745") return "074537074745";

        return $code;
    }
}

function safeFileName(string $filename,$title)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    //$name = pathinfo($filename, PATHINFO_FILENAME);

    //拿掉全形空白
    $name = str_replace('　', '', $title);

    //拿掉半形空白
    $name = str_replace(' ', '', $name);

    //移除特殊符號    
    $name = preg_replace('/[\\\\\/\?\%\*\:\|\"\<\>\(\),。，．~]/u', '_', $name);
    

    // 回傳檔名
    return $ext ? ($name . '.' . $ext) : $name;
}