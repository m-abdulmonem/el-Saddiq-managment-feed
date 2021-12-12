@extends("site.layouts.index")
@section("content")

    <div class="row">
        <div class="col-12">

            <form action="{{ route("permissions.update",$permission->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans("home.ٍ.Save") }}</button>
                        <a class="btn btn-success" href="{{ url("permissions/create") }}"><i class="fa fa-plus"></i> {{ trans("home.New") }}</a>
                        <div class="btn btn-danger btn-delete float-right"
                             data-url="{{ url("permission/$role->id/delete") }}"
                             data-name="{{ $role->name }}" data-token="{{ csrf_token() }}"><i class="fa fa-trash"></i> {{ trans("home.Delete") }}</div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name">{{ trans("categories.Name") }}</label>
                            <input type="text" class="form-control" id="name" placeholder="{{ trans("categories.Name") }}" name="name" value="{{ old("name") ? old("name") : $permission->name }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name_ar">{{ trans("categories.Name_Ar") }}</label>
                            <input type="text" class="form-control" id="name_ar" placeholder="{{ trans("categories.Name_Ar") }}" name="name_ar" value="{{ old("name_ar") ? old("name_ar") : $permission->name_ar  }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="select_role">{{ trans("roles.select_role") }}</label>
                            <select name="role_id" id="select_role" class="form-control">
                                <option value="{{ null }}">{{ trans("roles.select_role") }}</option>
                                    <option value="{{ $role->id }}" selected>{{ $role->name . "( " . $role->name_ar . " )" }}</option>
                                @if(old("role_id"))
                                    {{ $old_role = \Spatie\Permission\Models\Role::findById(old("role_id")) }}
                                    <option value="{{ old("role_id") }}" selected>{{ $old_role->name . "( " . $old_role->name_ar . " )" }}</option>
                                @endif
                                @forelse($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name . "( " . $role->name_ar . " )"  }}</option>
                                @empty
                                    <option value="">{{ trans("roles.Role_Empty") }}</option>
                                @endforelse
                            </select>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


@endsection
