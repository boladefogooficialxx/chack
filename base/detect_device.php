<?php

function detect_device($server = null) {

    if ($server === null) {
        $server = $_SERVER;
    }

    $ua = isset($server['HTTP_USER_AGENT']) ? trim($server['HTTP_USER_AGENT']) : '';
    $accept = isset($server['HTTP_ACCEPT']) ? strtolower($server['HTTP_ACCEPT']) : '';
    $x_wap_profile = isset($server['HTTP_X_WAP_PROFILE']) ? $server['HTTP_X_WAP_PROFILE'] : '';
    $profile = isset($server['HTTP_PROFILE']) ? $server['HTTP_PROFILE'] : '';

    // Normalize UA for matching
    $ua_lc = strtolower($ua);

    // 1) Detector de bots simples (crawler / spider)
    $bot_signatures = [
        'googlebot','bingbot','slurp','duckduckbot','baiduspider','yandex','sogou',
        'exabot','facebot','ia_archiver','mj12bot','healthbot','semrushbot','ahrefsbot',
        'twitterbot','applebot','petalbot','linkedinbot'
    ];
    
    foreach ($bot_signatures as $b) {
        if (strpos($ua_lc, $b) !== false) {
            return [
                'type' => 'bot',
                'is_mobile' => false,
                'is_tablet' => false,
                'is_desktop' => false,
                'is_bot' => true,
                'ua' => $ua,
            ];
        }
    }

    // 2) Heurísticas baseadas em headers de WAP / Mobile
    $is_mobile_header = false;
    if ($x_wap_profile || $profile) {
        $is_mobile_header = true;
    }
    if (strpos($accept, 'vnd.wap.wml') !== false || strpos($accept, 'wap') !== false) {
        $is_mobile_header = true;
    }

    // 3) Lista de tokens que indicam mobile / tablet
    $mobile_regex = '/\b(android|bb10|blackberry|iphone|ipod|iemobile|opera mini|opera mobi|windows phone|mobile|kindle|silk|bolt|fennec|maemo|symbian|palm|webos|up.browser|up.link|mmp|phone|nokia|samsung|htc|motorola|sony|zte|huawei|lg|xiaomi|mi |redmi|oneplus)\b/i';

    // Tablet tokens (mais específicos)
    $tablet_regex = '/\b(ipad|tablet|nexus 7|nexus 9|sm-t|tab|kindle fire|gt-p|xoom|sch-i800|playbook|silk|kfjwa|kftt|kfapwi|gt-p)\b/i';

    $is_tablet = false;
    $is_mobile = false;

    if (preg_match($tablet_regex, $ua)) {
        $is_tablet = true;
    }

    if (preg_match($mobile_regex, $ua) || $is_mobile_header) {
        $is_mobile = true;
    }

    // Alguns tablets (iPad, Android tablets) podem conter 'Android' mas não 'mobile' — reforçar lógica:
    // Se "android" aparece e "mobile" não, pode ser tablet (reinforce)
    if (stripos($ua, 'android') !== false && stripos($ua, 'mobile') === false) {
        // se já detectamos tablet via regex mantenha, senão marque como tablet
        $is_tablet = true;
        $is_mobile = false;
    }

    // iPad moderno e iPadOS pode reportar "Macintosh" + "Safari" — detectar por touch-capabilities no cliente via JS (use cookie fallback)
    // Aqui detectamos heurística: se UA contém "Macintosh" e há header "Sec-CH-UA-Platform" ou outros, não conseguimos 100% server-side.
    // Fallback: se cookie 'client_device_hint' estiver disponível, respeitamos
    if (isset($_COOKIE['client_device_hint'])) {
        // cookie esperado: 'mobile'|'tablet'|'desktop'
        $hint = $_COOKIE['client_device_hint'];
        if ($hint === 'mobile') {
            $is_mobile = true;
            $is_tablet = false;
        } elseif ($hint === 'tablet') {
            $is_tablet = true;
            $is_mobile = false;
        } elseif ($hint === 'desktop') {
            $is_tablet = false;
            $is_mobile = false;
        }
    }

    // Conclusão do tipo
    $is_bot = false; // já tratado acima, mas manter variável clara
    $type = 'unknown';

    if ($is_tablet) {
        $type = 'tablet';
    } elseif ($is_mobile) {
        $type = 'mobile';
    } else {
        // se nem mobile nem tablet, consideramos desktop
        $type = 'desktop';
    }

    return [
        'type' => $type,
        'is_mobile' => ($type === 'mobile'),
        'is_tablet' => ($type === 'tablet'),
        'is_desktop' => ($type === 'desktop'),
        'is_bot' => $is_bot,
        'ua' => $ua,
    ];
}

// helpers
function is_mobile($server = null) {
    $d = detect_device($server);
    return $d['is_mobile'];
}
function is_tablet($server = null) {
    $d = detect_device($server);
    return $d['is_tablet'];
}
function is_desktop($server = null) {
    $d = detect_device($server);
    return $d['is_desktop'];
}
function is_bot($server = null) {
    $d = detect_device($server);
    return $d['is_bot'];
}

?>
