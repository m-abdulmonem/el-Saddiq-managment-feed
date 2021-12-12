@include("site.layouts.header")

@if(request()->segment(1) !== "daily")
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $title ?? '' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {!! get_breadcrumb(1,2,$title ?? '') !!}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endif
<!-- Main content -->
<div class="content">
    <div class="container-fluid">



        @yield("content")

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@push("js")
    @if($errors ?? '')
        <script>
            @foreach($errors->all() as $error)
                toastr.options = {
                    "positionClass": "toast-top-left",
                };
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif
    @if(session()->has("error"))
        <script>
            swal("{{ session("error") }}",{
                icon: "error",
            })
        </script>
    @endif
    @if(session()->has("access_denied"))
        <script>
            swal("{{ session("access_denied") }}",{
                icon: "warning",
                timer: 3000
            })
        </script>
    @endif
    @if(session()->has("info"))
        <script>
            swal("{{ session("info") }}",{
                icon: "info",
                timer: 3000
            })
        </script>
    @endif
    @if(session()->has("success"))
        <script>
            swal("{{ session("success") }}",{
                icon: "success",
            })
        </script>
    @endif
@endpush
@include("site.layouts.footer")
