@extends("site.layouts.index")
@section("content")
    @push("css")
        {!! datatable_files("css") !!}
    @endpush
    <div class="row">
        <div class="col-12">

            <form action="{{ route("roles.update",$role->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans("home.save") }}</button>
                        <a class="btn btn-success" href="{{ url("roles/create") }}"><i class="fa fa-plus"></i> {{ trans("home.new") }}</a>
                        <div class="btn btn-danger btn-delete float-right"
                             data-url="{{ url("role/$role->id/delete") }}"
                             data-name="{{ $role->name }}" data-token="{{ csrf_token() }}"><i class="fa fa-trash"></i> {{ trans("home.delete") }}</div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name">{{ trans("categories.name") }}</label>
                            <input type="text" class="form-control" id="name" placeholder="{{ trans("categories.name") }}" name="name" value="{{ old("name") ? old("name") : $role->name }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name_ar">{{ trans("categories.name_ar") }}</label>
                            <input type="text" class="form-control" id="name_ar" placeholder="{{ trans("categories.name_ar") }}" name="name_ar" value="{{ old("name_ar") ? old("name_ar") : $role->name_ar  }}">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>



            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="{{ url("permissions/create") }}"><i class="fa fa-plus"></i> {{ trans("roles.new_permission") }}</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="ma-admin-datatable" class="table table-bordered table-striped">
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
                        @forelse($role->permissions as $permission)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <th>{{ $permission->name }}</th>
                                <th>{{ $permission->name_ar }}</th>
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
        {!! datatable_files() !!}
    @endpush
@endsection
