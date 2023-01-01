<?php

if (!function_exists('convertToLocalTZ')) {
    function convertToLocalTZ(string $date, $format = 'Y-m-d H:i:s')
    {
        return \Illuminate\Support\Carbon::createFromFormat($format, $date, config('environment.local_timezone', 'UTC'));
    }
}

if (!function_exists('getLocalNow')) {
    function getLocalNow()
    {
        return \Illuminate\Support\Carbon::now(config('environment.local_timezone', 'UTC'));
    }
}

if (!function_exists('get_object_id')) {
    function get_object_id($class, $objectOrId)
    {
        $objectId = null;

        if (is_int($objectOrId)) {
            $objectId = $objectOrId;
        } elseif (is_object($objectOrId) && get_class($objectOrId) == $class) {
            $objectId = $objectOrId->id;
        }

//    if (!$objectId) throw new \InvalidArgumentException('Argument should be integer or '.$class.' object');

        return $objectId;
    }
}

// Read File From Sharepoint With Curl After ReadList

if (!function_exists('ReadOrDownloadFile')) {
    function ReadOrDownloadFile($file = '')
    {
        //$headers = [];
        //$pattern = "/(?:[^\/][\d\w\.]+)+(?<=(?:.jpg)|(?:.pdf)|(?:.gif)|(?:.jpeg))/";
        //$match = [];

        if ($file !== '') {
            $ch = curl_init();
            $fileName = basename($file);
            $file = curl_escape($ch, $file);
            $file = str_replace(['%2F', '%3A'], ['/', ':'], $file);

            set_time_limit(0);
            curl_setopt($ch, CURLOPT_URL, $file);
            curl_setopt($ch, CURLOPT_TIMEOUT, 75);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
            curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_REFERER, env('environment.app_url', ''));
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERPWD, env('environment.sp_username', '') . ':' . env('environment.sp_password', ''));

            $result = curl_exec($ch);
            curl_close($ch);

            $fp = fopen($fileName, 'w+');
            //file_put_contents(base_path('public/'). $match[0], $result);
            fwrite_stream($fp, $result);
            fclose($fp);

            return base_path('public/') . $fileName;
        }
    }
}


if (!function_exists('fwrite_stream')) {
    function fwrite_stream($fp, $string)
    {
        for ($written = 0; $written < strlen($string); $written += $fwrite) {
            $fwrite = fwrite($fp, substr($string, $written));
            if ($fwrite === false) {
                return $written;
            }
        }

        return $written;
    }
}


if (!function_exists('DBTenantTable')) {
    function DBTenantTable($table)
    {
        $connectionName = config('multitenancy.tenant_database_connection_name') ?? config('database.default');
        return \DB::connection($connectionName)->table($table);
    }
}
