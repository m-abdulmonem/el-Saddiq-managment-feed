@extends("site.layouts.index")
@section("content")
    @push("css")
        <!-- fullCalendar -->
        <link rel="stylesheet" href="{{ admin_assets("fullCalendar/fullcalendar/main.min.css", null, true) }}">
        <link rel="stylesheet" href="{{ admin_assets("fullCalendar/fullcalendar-daygrid/main.min.css", null,true) }}">
        <link rel="stylesheet" href="{{ admin_assets("fullCalendar/fullcalendar-timegrid/main.min.css", null,true) }}">
        <link rel="stylesheet" href="{{ admin_assets("fullCalendar/fullcalendar-bootstrap/main.min.css", null,true) }}">
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @push("js")
        <script src="{{ admin_assets("jquery-ui.min.js") }}"></script>
        <!-- fullCalendar 2.2.5 -->
        <script src="{{ admin_assets("moment/moment.min.js") }}"></script>
        <script src="{{ admin_assets("fullCalendar/fullcalendar/main.min.js",null, true) }}"></script>
        <script src="{{ admin_assets("fullCalendar/fullcalendar/locales/ar.js", null, true) }}"></script>
        <script src="{{ admin_assets("fullCalendar/fullcalendar-daygrid/main.min.js", null, true) }}"></script>
        <script src="{{ admin_assets("fullCalendar/fullcalendar-timegrid/main.min.js", null, true) }}"></script>
        <!-- Page specific script -->
        <script>
            $(function () {

                ajaxApi({
                    url: "{{ route("ajax.attendances.events") }}",
                    success: function (result) {
                        let events = [];

                        $.each(result[0], function (k,v) {
                            events.push(v)
                        });

                        new FullCalendar.Calendar(document.getElementById('calendar'), {
                            plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
                            defaultView:"dayGridMonth",
                            locale: 'ar',
                            header    : {
                                left  : 'prev,next, today',
                                center: 'title',
                                right : 'dayGridMonth,timeGridWeek,timeGridDay'
                            },

                            events    : events,
                            draggable: false,
                            editable  : false,
                        }).render();
                    }
                });

            })
        </script>
    @endpush
@endsection
