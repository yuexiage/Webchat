<?php
/**
 * Created by 指尖.
 * User: yuexiage
 * Date: 2019/5/9
 * Time: 14:17
 */
session_start();
include_once 'lib/wxgetcontact.php';

if(empty($_GET['cls'])){
    //获取uuid
    $uuid = wxgetcontact::getUuid();
    $_SESSION['uuid'] = $uuid;
    #echo $_SESSION['uuid'].'<br>';
    //生成二维码
   wxgetcontact::getQr($uuid);
}
if(!empty($_GET['cls']) && $_GET['cls']=='get_redirect_uri'){
    #echo $_SESSION['uuid'].'<br>';
    $redirect_uri = wxgetcontact::get_redirect_uri($_SESSION['uuid']);
    $_SESSION['redirect_uri'] = $redirect_uri;
    #echo $redirect_uri.'<br>';
    $xmlArr = wxgetcontact::get_webwxnewloginpage($redirect_uri);
    #var_export($xmlArr);exit;
    #echo "<br>";
    $out = wxgetcontact::webwxinit($xmlArr);
    #var_export($out);exit;
    #echo "<br>";
    $list = wxgetcontact::get_webwxgetcontact($xmlArr);
    $memberlist = json_decode($list,true)['MemberList'];
    if(!empty($memberlist)){
        foreach (for_memberlist($memberlist,$xmlArr['skey']) as $val){
            echo $val;
        }
    }

}

function for_memberlist($memberlist,$skey){
    foreach($memberlist as $val){
        if(!empty($val['NickName']) && !empty($val['HeadImgUrl'])){
            yield  '<li><img src="https://wx.qq.com'.$val['HeadImgUrl'].$skey.'"> nickname:'.$val['NickName'].'</li>';
        }

    }
}