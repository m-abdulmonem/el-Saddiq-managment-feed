<html lang="ar">
    <head >
        <meta charset="utf-8">
        <title>فاتورة المورد</title>
    </head>
    {{ $data }}
    <body>
        <h1>فاتورة الموردين</h1>
    </body>
</html>

<script>

    window.onafterprint = function () {
        window.close()
    };

    this.print()
</script>
