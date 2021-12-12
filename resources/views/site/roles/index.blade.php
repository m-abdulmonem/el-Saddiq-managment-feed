@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="{{ url("roles/create") }}"><i class="fa fa-plus"></i> {{ trans("home.new") }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="roles" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans("categories.name") }}</th>
                            <th>{{ trans("categories.name_ar") }}</th>
                            <th>{{ trans("home.actions") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <span class="d-none">{{ $i = 1 }}</span>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <th>{{ $role->name }}</th>
                                <th>{{ $role->name_ar }}</th>
                                <th>
                                    <a href="{{ url("roles/$role->id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-danger btn-delete"
                                       data-url="{{ url("role/$role->id/delete") }}"
                                       data-name="{{ $role->name }}" data-token="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                            @empty
                        @endforelse

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>{{ trans("categories.name") }}</th>
                            <th>{{ trans("categories.name_ar") }}</th>
                            <th>{{ trans("home.actions") }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="{{ url("permissions/create") }}"><i class="fa fa-plus"></i> {{ trans("roles.new_permission") }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="permissions" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans("categories.name") }}</th>
                            <th>{{ trans("categories.name_ar") }}</th>
                            <th>{{ trans("roles.title") }}</th>
                            <th>{{ trans("home.actions") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <span class="d-none">{{ $i = 1 }}</span>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <th>{{ $permission->name }}</th>
                                <th>{{ $permission->name_ar }}</th>
{{--                                @foreach($permission->roles as $role)--}}
{{--                                    <th>{{ $role->name }}( {{ $role->name_ar }} )</th>--}}
{{--                                @endforeach--}}
                                <th>{{ get_roles($permission->roles) }}</th>
                                <th>
                                    <a href="{{ url("permissions/$permission->id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-danger btn-delete"
                                       data-url="{{ url("permission/$permission->id/delete") }}"
                                       data-name="{{ $permission->name }}" data-token="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                        @empty
                        @endforelse

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>{{ trans("categories.name") }}</th>
                            <th>{{ trans("categories.name_ar") }}</th>
                            <th>{{ trans("roles.title") }}</th>
                            <th>{{ trans("home.actions") }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @push("js")
        {!! datatable_files("js",["permissions","roles"]) !!}
    @endpush
@endsection
