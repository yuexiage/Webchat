<?php
/**
 * Created by 指尖.
 * User: yuexiage
 * Date: 2019/5/9
 * Time: 14:19
 */
function curlRequest($url,$method='',$header=[],$params=''){

    $curl = curl_init();											//初始化
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

    if($method !=''){
        $method = strtolower($method);
        switch($method) {
            case 'post':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params); 	//设置请求体，提交数据包
                break;
            case 'put':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params); 		//设置请求体，提交数据包
                break;
            case 'delete':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
    }
    //执行命令
    $output  = curl_exec($curl);
    #$request_header = curl_getinfo($curl);  						//打印请求的header信息
    #print_r($request_header);
    curl_close($curl);
    return $output;
}
