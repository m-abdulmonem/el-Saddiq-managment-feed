</section>
<!-- /.content -->
<style>
    @media print {
        .footer {
            position: fixed;
            bottom: 0;
        }
    }
</style>
<!-- Main Footer -->
<div class="footer d-flex" style="font-size: 21px">
    <div class="col-6"><span>@lang("users/users.user") : </span> {{ auth()->user()->name() }}</div>
    <div class="col-6"><span>@lang("home.print_date") : </span> {{ now()->format("Y-m-d H:i:s") }}</div>
</div>
<!-- ./footer -->
<button type="button" class="btn btn-info no-print" onclick="window.print()"><i class="fa fa-print"></i> طباعة</button>
</div>
<!-- ./wrapper -->

<script type="text/javascript">
    window.onafterprint = function () {
        window.close()
    };
    @stack("js")
    window.addEventListener("load", window.print());
</script>
</body>
</html>

