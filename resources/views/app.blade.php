<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yet Another Laravel-SPA-Admin</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <style>
            @-webkit-keyframes scale {
                0% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    opacity: 1; }

                45% {
                    -webkit-transform: scale(0.1);
                    transform: scale(0.1);
                    opacity: 0.7; }

                80% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    opacity: 1; } }
            @keyframes scale {
                0% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    opacity: 1; }

                45% {
                    -webkit-transform: scale(0.1);
                    transform: scale(0.1);
                    opacity: 0.7; }

                80% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    opacity: 1; } }

            .ball-pulse > div:nth-child(0) {
                -webkit-animation: scale 0.75s 0s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: scale 0.75s 0s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .ball-pulse > div:nth-child(1) {
                -webkit-animation: scale 0.75s 0.12s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: scale 0.75s 0.12s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .ball-pulse > div:nth-child(2) {
                -webkit-animation: scale 0.75s 0.24s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: scale 0.75s 0.24s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .ball-pulse > div:nth-child(3) {
                -webkit-animation: scale 0.75s 0.36s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: scale 0.75s 0.36s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .ball-pulse > div {
                background-color: #fff;
                width: 15px;
                height: 15px;
                border-radius: 100%;
                margin: 2px;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
                display: inline-block; }

            @-webkit-keyframes ball-spin-fade-loader {
                50% {
                    opacity: 0.3;
                    -webkit-transform: scale(0.4);
                    transform: scale(0.4); }

                100% {
                    opacity: 1;
                    -webkit-transform: scale(1);
                    transform: scale(1); } }

            @keyframes ball-spin-fade-loader {
                50% {
                    opacity: 0.3;
                    -webkit-transform: scale(0.4);
                    transform: scale(0.4); }

                100% {
                    opacity: 1;
                    -webkit-transform: scale(1);
                    transform: scale(1); } }

            .ball-spin-fade-loader {
                position: relative; }
            .ball-spin-fade-loader > div:nth-child(1) {
                top: 25px;
                left: 0;
                -webkit-animation: ball-spin-fade-loader 1s 0s infinite linear;
                animation: ball-spin-fade-loader 1s 0s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(2) {
                top: 17.04545px;
                left: 17.04545px;
                -webkit-animation: ball-spin-fade-loader 1s 0.12s infinite linear;
                animation: ball-spin-fade-loader 1s 0.12s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(3) {
                top: 0;
                left: 25px;
                -webkit-animation: ball-spin-fade-loader 1s 0.24s infinite linear;
                animation: ball-spin-fade-loader 1s 0.24s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(4) {
                top: -17.04545px;
                left: 17.04545px;
                -webkit-animation: ball-spin-fade-loader 1s 0.36s infinite linear;
                animation: ball-spin-fade-loader 1s 0.36s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(5) {
                top: -25px;
                left: 0;
                -webkit-animation: ball-spin-fade-loader 1s 0.48s infinite linear;
                animation: ball-spin-fade-loader 1s 0.48s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(6) {
                top: -17.04545px;
                left: -17.04545px;
                -webkit-animation: ball-spin-fade-loader 1s 0.6s infinite linear;
                animation: ball-spin-fade-loader 1s 0.6s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(7) {
                top: 0;
                left: -25px;
                -webkit-animation: ball-spin-fade-loader 1s 0.72s infinite linear;
                animation: ball-spin-fade-loader 1s 0.72s infinite linear; }
            .ball-spin-fade-loader > div:nth-child(8) {
                top: 17.04545px;
                left: -17.04545px;
                -webkit-animation: ball-spin-fade-loader 1s 0.84s infinite linear;
                animation: ball-spin-fade-loader 1s 0.84s infinite linear; }
            .ball-spin-fade-loader > div {
                background-color: #fff;
                width: 15px;
                height: 15px;
                border-radius: 100%;
                margin: 2px;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
                position: absolute; }

            /**
             * Lines
             */
            @-webkit-keyframes line-scale {
                0% {
                    -webkit-transform: scaley(1);
                    transform: scaley(1); }

                50% {
                    -webkit-transform: scaley(0.4);
                    transform: scaley(0.4); }

                100% {
                    -webkit-transform: scaley(1);
                    transform: scaley(1); } }
            @keyframes line-scale {
                0% {
                    -webkit-transform: scaley(1);
                    transform: scaley(1); }

                50% {
                    -webkit-transform: scaley(0.4);
                    transform: scaley(0.4); }

                100% {
                    -webkit-transform: scaley(1);
                    transform: scaley(1); } }

            .line-scale > div:nth-child(1) {
                -webkit-animation: line-scale 1s 0.1s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: line-scale 1s 0.1s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .line-scale > div:nth-child(2) {
                -webkit-animation: line-scale 1s 0.2s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: line-scale 1s 0.2s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .line-scale > div:nth-child(3) {
                -webkit-animation: line-scale 1s 0.3s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: line-scale 1s 0.3s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .line-scale > div:nth-child(4) {
                -webkit-animation: line-scale 1s 0.4s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: line-scale 1s 0.4s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .line-scale > div:nth-child(5) {
                -webkit-animation: line-scale 1s 0.5s infinite cubic-bezier(.2, .68, .18, 1.08);
                animation: line-scale 1s 0.5s infinite cubic-bezier(.2, .68, .18, 1.08); }
            .line-scale > div {
                background-color: #fff;
                width: 4px;
                height: 35px;
                border-radius: 2px;
                margin: 2px;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
                display: inline-block; }

            html, body {
                height: 100%;
            }
            #bootstrap-loader {
                background-color: #324057;
                width: 100%;
                height: 100%;
                text-align: center;
            }
            #bootstrap-loader .loader {
                margin: auto;
                padding-top: 300px;
            }
        </style>
    </head>
    <body>
    {{-- 初始页面加载动画 --}}
    <div id="bootstrap-loader">
        <div class="loader">
            <div class="line-scale">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let loader = document.getElementById('bootstrap-loader');
            loader.parentNode.removeChild(loader);
        });
    </script>
    <div id="app">

    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
