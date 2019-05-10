<?php
/**
 * Created by 指尖.
 * User: yuexiage
 * Date: 2019/5/9
 * Time: 18:20
 */
include_once 'curlRequest.php';
class wxgetcontact{

    //获取uuid
    public static function getUuid(){
        #$url        = 'https://wx2.qq.com/jslogin?redirect_uri=https%3A%2F%2Fwx.qq.com%2Fcgi-bin%2Fmmwebwx-bin%2Fwebwxnewloginpage&appid=wx782c26e4c19acffb&lang=zh_CN&_=1485065568&fun=new';
        $url        = 'https://login.wx.qq.com/jslogin?appid=wx782c26e4c19acffb&redirect_uri=https%3A%2F%2Fwx.qq.com%2Fcgi-bin%2Fmmwebwx-bin%2Fwebwxnewloginpage&fun=new&lang=zh_CN&_=1557463463798';
        $uuid       = curlRequest($url);
        $pattern    = '#"(.*?)"#i';
        preg_match_all($pattern, $uuid, $matches);
        return $matches[1][0];
    }

    //生成二维码
    public static function getQr($uuid){
        echo  "<center><img src='https://wx.qq.com/qrcode/".$uuid."' width='200px'></center>";
        echo  "<center><a href='?cls=get_redirect_uri'>确认扫描后点击此处</a></center>";
    }

    //获取登录跳转连接
    public static function get_redirect_uri($uuid){
        $url        = "https://login.wx.qq.com/cgi-bin/mmwebwx-bin/login?loginicon=true&uuid={$uuid}&tip=0&r=-974452&_=1485065779";
        $out        = curlRequest($url);
        $pattern    = '#"(.*?)"#i';
        preg_match_all($pattern, $out, $matches);
        return $matches[1][0].'&fun=new&version=v2&lang=zh_CN';
    }

    //初始化页面和获取登陆信息
    public static function get_webwxnewloginpage($redirect_uri){
        $xml = "<xml>".curlRequest($redirect_uri)."</xml>";
        $xml = json_decode(json_encode(simplexml_load_string($xml)),TRUE);
        return $xml['error'];
    }

    //初始化
    public static function webwxinit($xmlArr){
        $url = "https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxinit?r=".time()."&lang=zh_CN&pass_ticket={$xmlArr['pass_ticket']}";
        $parme = '{"BaseRequest":{"Uin":"'.$xmlArr['wxuin'].'","Sid":"'.$xmlArr['wxsid'].'","Skey":"'.$xmlArr['skey'].'","DeviceID":"e811483204526976"}}';
        $header = ['Content-Type:application/json;charset=UTF-8','Accept:application/json','Cookie: pgv_pvi=2902457344; pgv_si=s2221383680; MM_WX_NOTIFY_STATE=1; MM_WX_SOUND_STATE=1; wxuin='.$xmlArr['wxuin'].'; webwxuvid=44f4ecb42886102ae726a1d8480f7c3c3ed339780030b89391334bb757c386f6618d7cd6c8b2c744b9a0c3c7150e6769; last_wxuin='.$xmlArr['wxuin'].'; mm_lang=zh_CN; wxpluginkey=1557445519; wxsid='.$xmlArr['wxsid'].'; wxloadtime=1557454005; webwx_data_ticket=gScanclArA5+8ja+AE572Nw5; webwx_auth_ticket=CIsBEPbXmKcEGoAByjgTUPxCZxGb8o5/jx2rstBNsLpjWM8dXUeECKpRIF1NRE8NPn9Ya/nuMaakOQ9MvrxmTuDD5fPbVGiFKhP1ekCDl0FDXtlvkVVRS7Kr63WcZiGRep2PZseDESCkfVJ0TrYf+STpOH529TdMcA47vu1DfCIXFPMtaHuXsaDbA1M=; login_frequency=2'];
        return curlRequest($url,'post',$header,$parme);
    }
    //获取好友列表
    public static function get_webwxgetcontact($xmlArr){
        $url = "https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxgetcontact?lang=zh_CN&pass_ticket={$xmlArr['pass_ticket']}&r=1557455531571&seq=0&skey={$xmlArr['skey']}";
        $parme = '{}';
        $parme = '{"BaseRequest":{"Uin":"'.$xmlArr['wxuin'].'","Sid":"'.$xmlArr['wxsid'].'","Skey":"'.$xmlArr['skey'].'","DeviceID":"e811483204526976"}}';
        $header = ['Content-Type:application/json;charset=UTF-8','Accept:application/json','Cookie: pgv_pvi=2902457344; pgv_si=s2221383680; MM_WX_NOTIFY_STATE=1; MM_WX_SOUND_STATE=1; wxuin='.$xmlArr['wxuin'].'; webwxuvid=44f4ecb42886102ae726a1d8480f7c3c3ed339780030b89391334bb757c386f6618d7cd6c8b2c744b9a0c3c7150e6769; last_wxuin='.$xmlArr['wxuin'].'; mm_lang=zh_CN; wxpluginkey=1557445519; wxsid='.$xmlArr['wxsid'].'; wxloadtime=1557454005; SyncKey=gScanclArA5+8ja+AE572Nw5; webwx_auth_ticket=CIsBEPbXmKcEGoAByjgTUPxCZxGb8o5/jx2rstBNsLpjWM8dXUeECKpRIF1NRE8NPn9Ya/nuMaakOQ9MvrxmTuDD5fPbVGiFKhP1ekCDl0FDXtlvkVVRS7Kr63WcZiGRep2PZseDESCkfVJ0TrYf+STpOH529TdMcA47vu1DfCIXFPMtaHuXsaDbA1M=; login_frequency=2'];
        $out = curlRequest($url,'post',$header,$parme);
        return $out;
    }
}