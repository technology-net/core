<div class="card">
    <div class="card-header">
        @can('create permissions')
            <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                {{ trans('packages/core::common.create') }}
            </a>
        @endcan
        @can('delete permissions')
            <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('permissions.deleteAll') }}">
                <i class="fas fa-trash"></i>
                {{ trans('packages/core::common.delete') }}
            </button>
        @endcan
    </div>

    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
        <thead>
            <tr>
                @can('delete permissions')
                    <th width="3%" class="text-center">
                        <label class="user-checkbox-label">
                            <input class="input-check-all" type="checkbox">
                        </label>
                    </th>
                @endcan
                <th width="15%">{{ trans('packages/core::common.name') }}</th>
                <th width="15%">{{ trans('packages/core::common.role_permission.group_name') }}</th>
                <th width="35%">{{ trans('packages/core::common.role_permission.roles.title') }}</th>
                <th width="10%">{{ trans('packages/core::common.role_permission.guard_name') }}</th>
                <th width="12%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($permissions as $item)
            <tr>
                @can('delete permissions')
                    <td class="text-center">
                        <label class="user-checkbox-label">
                            <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                        </label>
                    </td>
                @endcan
                <td>
                    @can('edit permissions')
                        <a href="{{ route('permissions.edit', $item->id) }}">{{ $item->name }}</a>
                    @else
                        {{ $item->name }}
                    @endcan
                </td>
                <td>{{ $item->group_name }}</td>
                <td>
                    @if($item->roles->isNotEmpty())
                        @foreach($item->roles as $role)
                            <span class="btn-sm btn-info d-inline-block mb-1">{{ $role->name }}</span>
                        @endforeach
                    @endif
                </td>
                <td>{{ $item->group_name }}</td>
                <td class="text-center">{{ $item->created_at }}</td>
                <td class="text-center">
                    @can('edit permissions')
                        <a class="btn btn-sm bg-info" href="{{ route('permissions.edit', $item->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    @endcan
                    @can('delete permissions')
                        <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('permissions.destroy', $item->id) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
