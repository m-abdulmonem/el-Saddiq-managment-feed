
</section>
<!-- /.content -->
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

