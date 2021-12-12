@extends("site.layouts.index")
@section("content")

    <div class="row">
        <div class="col-12">

            <form action="{{ route("permissions.store") }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans("home.create") }}</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name">{{ trans("categories.name") }}</label>
                            <input type="text" class="form-control" id="name" placeholder="{{ trans("categories.name") }}" name="name" value="{{ old("name") }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name_ar">{{ trans("categories.name_ar") }}</label>
                            <input type="text" class="form-control" id="name_ar" placeholder="{{ trans("categories.name_ar") }}" name="name_ar" value="{{ old("name_ar") }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="select_role">{{ trans("roles.select_role") }}</label>
                            <select name="role_id" id="select_role" class="form-control">
                                <option value="{{ null }}">{{ trans("roles.select_role") }}</option>
                                @if(old("role_id"))
                                    {{ $old_role = \Spatie\Permission\Models\Role::findByName(old("role_id")) }}
                                    <option value="{{ old("role_id") }}" selected>{{ $old_role->name . "( " . $old_role->name_ar . " )" }}</option>
                                @endif
                                @forelse($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name . "( " . $role->name_ar . " )"  }}</option>
                                @empty
                                    <option value="">{{ trans("roles.role_empty") }}</option>
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
