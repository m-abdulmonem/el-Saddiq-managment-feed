<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="login page for el-saddiq-managment">
    <title>MA Admin | {{ $title ?? '' }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ admin_assets("img/MAAdminLogo.png") }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_assets("css/all.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_assets("css/adminlte.min.css") }}">
    @stack("css")
    <link rel="stylesheet" href=" {{  admin_assets("/css/app.css")  }} ">

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="http://mabdulmonem-tech.com"><b>MA</b>Admin</a>
    </div>
    <!-- /.login-logo -->
    @yield("content")
</div>
<!-- /.login-box -->


@stack("js")

</body>
</html>

