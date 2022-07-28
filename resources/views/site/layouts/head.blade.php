<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="login page for el-saddiq-managment">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="medicines" content="{{ request()->segment(1) =="medicines" ? 1:0 }}">

    <title>{{ $title ?? '' ? $title ?? '' : "" }} - MA Admin</title>
    <link rel="icon" href="{{ admin_assets("/MAAdminLogo.png") }}" type="image/x-icon">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ admin_assets("/all.min.css") }}">
    <link rel="stylesheet" href="{{ admin_assets("/toastr.min.css") }}">
@stack("css")
<!-- Theme style -->
    <link rel="stylesheet" href=" {{  admin_assets("/adminlte.min.css")  }} ">
    <link rel="stylesheet" href=" {{  admin_assets("/component-custom-switch.css")  }} ">
    <link rel="stylesheet" href=" {{  admin_assets("/app.css")  }} ">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="{{ admin_assets("/bootstrapRTL.min.css") }}">
    <link rel="stylesheet" href=" {{  admin_assets("/rtl.css")  }} ">
    <!-- Google Font: Source Sans Pro -->
    {{--    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">--}}
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
