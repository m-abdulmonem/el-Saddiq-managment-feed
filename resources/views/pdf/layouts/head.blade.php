<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@stack("title")</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_assets("all.min.css") }}">
    <!-- Ionicons -->
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
<!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_assets("adminlte.min.css") }}">

    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="{{ admin_assets("bootstrapRTL.min.css") }}">
    <link rel="stylesheet" href=" {{  admin_assets("rtl.css")  }} ">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .invoice{
            background: transparent;
        }
        .invoice-info,
        .list,
        .total{
            margin-top: 30px !important;
        }

        .title{
            margin-bottom: 50px;
        }

        .page-header{
            margin-bottom: 80px;
        }
        body:after{
            content: "";
            background: url("{{ admin_assets("logo.png") }}") center no-repeat;
            opacity: 0.09;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
        }
        .wrapper{
            font-size: 28px;
            font-weight: bold;
        }
        .row{
            margin: 0 !important;
        }
        .page-header{
            background: url("{{ admin_assets("logo.png") }}") no-repeat left top;
            background-size: contain;
            padding-bottom: 30px;
            margin-bottom: 30px;
            border-bottom: 1px solid #0000002e;
        }
        .page-break{
            page-break-before: always;
        }
        .footer {
            /*position: absolute;*/
            /*bottom: -10%;*/
            width: 100%;
            border-top: 1px solid #000;
        }
        @media print {

        }
    </style>
</head>
<body>
