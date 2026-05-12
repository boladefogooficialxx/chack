<?php

error_reporting(0);

function GetStr($str, $start, $end) {
    $a = explode($end, explode($start, $str)[1] )[0];
    return $a;
} 

function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

function Mobile(){

    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
        return true;
    }
    return false;
}

function Encrypt_Decrypt($action, $string){
    $output = false;
    $encrypt_method = "AES-256-CBC";

    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function MaskCpfCnpj($valor) {

    if(strlen($valor)>13){
        $formato = "##.###.###/####-##";
    }else{
        $formato = "###.###.###-##";
    }

    $retorno = '';
    $posicao_valor = 0;
    for($i = 0; $i<=strlen($formato)-1; $i++) {
        if($formato[$i] == '#') {
            if(isset($valor[$posicao_valor])) {
               $retorno .= $valor[$posicao_valor++];
            }
        } else {
            $retorno .= $formato[$i];
        }
    }
    return $retorno;
}

function Tela_search($e, $t){
    $d = false;
        for($i=0;$i<count($e);$i++){
            if($e[$i]['tela']==$t){ 
                $d = $e[$i];
            }
        }
    return $d;
}

function FilterBlock($ver){
    $ver = strtolower($ver);
    $palavra = '!(pau no cu|desgracado|otario|vai toma|seu cu|humano|você|http|avisando|bastardo|whatsapp|fudido|anúncio|telegram|vou|conversar|9532033471|991414959|<iframe|<span)!i';
    if (preg_match($palavra, $ver)) {
        return true;
    }
    return false;
}

  
function random_uagent() {
    
    $x = rand(1, 12);
  
    switch ($x) {
        case 1:
            return "Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; SCH-I535 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30";
            break;
        case 2:
            return "Mozilla/5.0 (Linux; Android 7.0; SM-G930V Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.125 Mobile Safari/537.36";
            break;
        case 3:
            return "Mozilla/5.0 (Linux; Android 7.0; SM-A310F Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.91 Mobile Safari/537.36 OPR/42.7.2246.114996";
            break;
        case 4:
            return "Opera/9.80 (Android 4.1.2; Linux; Opera Mobi/ADR-1305251841) Presto/2.11.355 Version/12.10";
            break;
        case 5:
            return "Mozilla/5.0 (Android 7.0; Mobile; rv:54.0) Gecko/54.0 Firefox/54.0";
            break;
        case 6:
            return "Mozilla/5.0 (Linux; Android 6.0.1; SM-G920V Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36";
            break;
        case 7:
            return "Mozilla/5.0 (Linux; Android 5.1.1; SM-N750K Build/LMY47X; ko-kr) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Puffin/6.0.8.15804AP";
            break;
        case 8:
            return "Mozilla/5.0 (Linux; Android 5.1.1; SM-N750K Build/LMY47X; ko-kr) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Puffin/6.0.8.15804AP";
            break;
        case 9:
            return "Mozilla/5.0 (Linux; Android 7.0; SAMSUNG SM-G955U Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/5.4 Chrome/51.0.2704.106 Mobile Safari/537.36";
            break;
        case 10:
            return "Mozilla/5.0 (Linux; Android 6.0; Lenovo K50a40 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.137 YaBrowser/17.4.1.352.00 Mobile Safari/537.36";
            break;
        case 11:
            return "Mozilla/5.0 (Linux; U; Android 7.0; en-us; MI 5 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.146 Mobile Safari/537.36 XiaoMi/MiuiBrowser/9.0.3";
            break;
        case 12:
            return "Mozilla/5.0 (Windows Phone 10.0; Android 6.0.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Mobile Safari/537.36 Edge/15.14977";
            break;
    }
}

function translate($q, $sl, $tl){
    $res= file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&ie=UTF-8&oe=UTF-8&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&sl=".$sl."&tl=".$tl."&hl=hl&q=".urlencode($q), $_SERVER['DOCUMENT_ROOT']."/transes.html");
    $res=json_decode($res);
    return $res[0][0][0];
}

function idiomaUsuario(){
    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    return $idioma; 
}

function DesformatPost($username){
    $username = str_replace('(*1)', '#', $username);
    $username = str_replace('(*2)', '&', $username);
    return str_replace('(*3)', '+', $username);
}


function Key_2captcha($Key_2captcha, $googlekey, $pageurl, $version, $re=false) {
    $v = 'v';

    if($re){
        $ch = curl_init("https://2captcha.com/in.php?key=$Key_2captcha&method=hcaptcha&sitekey=$googlekey&pageurl=$pageurl");
    }else{
        $ch = curl_init("https://2captcha.com/in.php?key=$Key_2captcha&method=userrecaptcha&googlekey=$googlekey&pageurl=$pageurl&version=$version");
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $res = curl_exec($ch);

    if (strpos($res, 'OK') !== false){

        $res2=false;
        $id = explode('|', $res)[1];

            for($i=0;$i<50;$i++){

                        if (strpos($res2, 'OK') !== false){
                            $r = explode('|', $res2)[1];
                            return $i.'|'.$r;
                             $i = 50;

                        }else{ 
                            $ch = curl_init("https://2captcha.com/res.php?key=$Key_2captcha&action=get&id=$id");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                            $res2 = curl_exec($ch);
                            $i++; 
                        }
              sleep(3);
            }

    }else{
        return $res;
    }

}

function FormatarAcentos($valor=''){

    $utf8_ansi2 = array(
     "À" => "\u00c0",
     "Á" => "\u00c1",
     "Â"=> "\u00c2",
     "Ã"=> "\u00c3",
     "Ä"=> "\u00c4",
     "Å"=> "\u00c5",
     "Æ"=> "\u00c6",
     "Ç"=> "\u00c7",
     "È"=> "\u00c8",
     "É"=> "\u00c9",
     "Ê"=> "\u00ca",
     "Ë"=> "\u00cb",
     "Ì"=> "\u00cc",
     "Í"=> "\u00cd",
     "Î"=> "\u00ce",
     "Ï"=> "\u00cf",
     "Ñ"=> "\u00d1",
     "Ò"=> "\u00d2",
     "Ó"=> "\u00d3",
     "Ô"=> "\u00d4",
     "Õ"=> "\u00d5",
     "Ö"=> "\u00d6",
     "Ø"=> "\u00d8",
     "Ù"=> "\u00d9",
     "Ú"=> "\u00da",
     "Û"=> "\u00db",
     "Ü"=> "\u00dc",
     "Ý"=> "\u00dd",
     "ß"=> "\u00df",
     "à"=> "\u00e0",
     "á"=> "\u00e1",
     "â"=> "\u00e2",
     "ã"=> "\u00e3",
     "ä"=> "\u00e4",
     "å"=> "\u00e5",
     "æ"=> "\u00e6",
     "ç"=> "\u00e7",
     "è"=> "\u00e8",
     "é"=> "\u00e9",
     "ê"=> "\u00ea",
     "ë"=> "\u00eb",
     "ì"=> "\u00ec",
     "í"=> "\u00ed",
     "î"=> "\u00ee",
     "ï"=> "\u00ef",
     "ð"=> "\u00f0",
     "ñ"=> "\u00f1",
     "ò"=> "\u00f2",
     "ó"=> "\u00f3",
     "ô"=> "\u00f4",
     "õ"=> "\u00f5",
     "ö"=> "\u00f6",
     "ø"=> "\u00f8" ,
     "ù"=> "\u00f9",
     "ú"=> "\u00fa",
     "û"=> "\u00fb",
     "ü"=> "\u00fc",
     "ý"=> "\u00fd",
     "ÿ"=> "\u00ff");

    return strtr($valor, $utf8_ansi2);
}


function Utf8_ansi($valor='') {

    $utf8_ansi2 = array(
    "\u00c0" =>"À",
    "\u00c1" =>"Á",
    "\u00c2" =>"Â",
    "\u00c3" =>"Ã",
    "\u00c4" =>"Ä",
    "\u00c5" =>"Å",
    "\u00c6" =>"Æ",
    "\u00c7" =>"Ç",
    "\u00c8" =>"È",
    "\u00c9" =>"É",
    "\u00ca" =>"Ê",
    "\u00cb" =>"Ë",
    "\u00cc" =>"Ì",
    "\u00cd" =>"Í",
    "\u00ce" =>"Î",
    "\u00cf" =>"Ï",
    "\u00d1" =>"Ñ",
    "\u00d2" =>"Ò",
    "\u00d3" =>"Ó",
    "\u00d4" =>"Ô",
    "\u00d5" =>"Õ",
    "\u00d6" =>"Ö",
    "\u00d8" =>"Ø",
    "\u00d9" =>"Ù",
    "\u00da" =>"Ú",
    "\u00db" =>"Û",
    "\u00dc" =>"Ü",
    "\u00dd" =>"Ý",
    "\u00df" =>"ß",
    "\u00e0" =>"à",
    "\u00e1" =>"á",
    "\u00e2" =>"â",
    "\u00e3" =>"ã",
    "\u00e4" =>"ä",
    "\u00e5" =>"å",
    "\u00e6" =>"æ",
    "\u00e7" =>"ç",
    "\u00e8" =>"è",
    "\u00e9" =>"é",
    "\u00ea" =>"ê",
    "\u00eb" =>"ë",
    "\u00ec" =>"ì",
    "\u00ed" =>"í",
    "\u00ee" =>"î",
    "\u00ef" =>"ï",
    "\u00f0" =>"ð",
    "\u00f1" =>"ñ",
    "\u00f2" =>"ò",
    "\u00f3" =>"ó",
    "\u00f4" =>"ô",
    "\u00f5" =>"õ",
    "\u00f6" =>"ö",
    "\u00f8" =>"ø",
    "\u00f9" =>"ù",
    "\u00fa" =>"ú",
    "\u00fb" =>"û",
    "\u00fc" =>"ü",
    "\u00fd" =>"ý",
    "\u00ff" =>"ÿ");

    return strtr($valor, $utf8_ansi2);
}

function RremoverAll($valor='',$e) {
    $utf8_ansi2 = array(
    "$e" =>""
    );
    return strtr($valor, $utf8_ansi2);
}

function token($tamanho=10, $id="", $up=false) {
    $characters = $id.'abcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    if($up === true) {
      return strtoupper($id.$randomString);
    } else {
      return $id.$randomString;
    }
  }

  
function RecaptchaVerif($token, $secret){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secret, 'response' => $token)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($ch);

}

function get_client_ip() {

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
      }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
      {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else{
        $ip_address = $_SERVER['REMOTE_ADDR'];
      }
      return $ip_address;
}

function isDrive($d) {

    $str = '|libertex|ztb|vindax|shakepay|gopax|plus500|paybis|youhodler|bitvavo|bitpanda|coinw|gmo|indodax|';
   
    if (strpos($str, "|$d|") !== false) {

        return true; // 'wallet'
    }

    return false;
}

function isBotDetected() {

    if ( preg_match('/abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|Zeus/i', $_SERVER['HTTP_USER_AGENT'])
    ) {
        return true; // 'Above given bots detected'
    }

    return false;
}

function isBotProvedorDetected($Provedor) {

    if (preg_match('/abacho|Google LLC|Zeus/i', $Provedor)) {
        return true; // 'Above given bots detected'
    }

    return false;
}

function DataDia(){
    date_default_timezone_set('America/Sao_Paulo'); 
    return date('Y-m-d')." ".date('H:i:s');
}

function IcoBan($name, $IcoData){
    
    $IcoData  = json_decode(file_get_contents($IcoData));

    for($i=0;$i<count($IcoData);$i++){
        if(strtoupper($IcoData[$i][0])==strtoupper($name)){
            $ico = $IcoData[$i][1];
        }
    }
    return $ico;
  }

?>