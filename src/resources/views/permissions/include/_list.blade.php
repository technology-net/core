<div class="card">
    <div class="card-header">
        <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>
            {{ trans('packages/core::common.create') }}
        </a>
        <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('permissions.deleteAll') }}">
            <i class="fas fa-trash"></i>
            {{ trans('packages/core::common.delete') }}
        </button>
    </div>

    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
        <thead>
            <tr>
                <th width="3%" class="text-center">
                    <label class="user-checkbox-label">
                        <input class="input-check-all" type="checkbox">
                    </label>
                </th>
                <th width="20%">{{ trans('packages/core::common.name') }}</th>
                <th width="47%">{{ trans('packages/core::common.role_permission.roles.title') }}</th>
                <th width="10%">{{ trans('packages/core::common.role_permission.guard_name') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($permissions as $item)
            <tr>
                <td class="text-center">
                    <label class="user-checkbox-label">
                        <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                    </label>
                </td>
                <td>
                    <a href="{{ route('permissions.edit', $item->id) }}">{{ $item->name }}</a>
                </td>
                <td>
                    @if($item->roles->isNotEmpty())
                        @foreach($item->roles as $role)
                            <span class="btn-sm btn-info">{{ $role->name }}</span>
                        @endforeach
                    @endif
                </td>
                <td>{{ $item->guard_name }}</td>
                <td class="text-center">{{ $item->created_at }}</td>
                <td class="text-center">
                    <a class="btn btn-sm bg-info" href="{{ route('permissions.edit', $item->id) }}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('permissions.destroy', $item->id) }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
