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
    function del_folder($folder)
    {
        if (is_dir($folder)) {
            if ($handle = opendir($folder)) { //開啟現在的資料夾
                while (false !== ($file = readdir($handle))) {
                    //避免搜尋到的資料夾名稱是false,像是0
                    if ($file != "." && $file != "..") {
                        //去除掉..跟.
                        unlink($folder . '/' . $file);
                    }
                }
                closedir($handle);
            }
            rmdir($folder);
        }
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