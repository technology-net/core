<div class="card">
        <div class="card-header">
            @can('create')
                <a href="{{ route('settings.users.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
                    {{ trans('packages/core::common.create') }}
                </a>
            @endcan
            @can('delete')
                <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('settings.users.deleteAll') }}">
                    <i class="fas fa-trash"></i>
                    {{ trans('packages/core::common.delete') }}
                </button>
            @endcan
        </div>

    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
        <thead>
            <tr>
                @can('delete')
                    <th width="3%" class="text-center">
                        <label class="user-checkbox-label">
                            <input class="input-check-all" name="" type="checkbox">
                        </label>
                    </th>
                @endcan
                <th width="10%">{{ trans('packages/core::user.username') }}</th>
                <th width="20%">{{ trans('packages/core::common.email') }}</th>
                <th width="35%">{{ trans('packages/core::common.role_permission.roles.title') }}</th>
                <th width="10%" class="text-left">{{ trans('packages/core::common.status') }}</th>
                <th width="12%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $item)
            <tr>
                @can('delete')
                    <td class="text-center">
                        <label class="user-checkbox-label">
                            <input class="checkboxes" name="id[]" type="checkbox" value="{{ $item->id }}" data-login-id="{{ Auth::id() }}" @if(Auth::id() == $item->id) disabled @endif>
                        </label>
                    </td>
                @endcan
                <td>
                    @can('edit')
                        <a href="{{ route('settings.users.edit', ['user' => $item->id]) }}">{{ $item->username }}</a>
                    @else
                        {{ $item->username }}
                    @endcan
                </td>
                <td>{{ $item->email }}</td>
                <td>
                    @if($item->roles->isNotEmpty())
                        @foreach($item->roles as $role)
                            <span class="btn-sm btn-info d-inline-block mb-1">{{ $role->name }}</span>
                        @endforeach
                    @endif
                </td>
                <td>
                    <span class="btn-sm {{ $item->status == \IBoot\Core\App\Models\User::STATUS_ACTIVATED ? 'bg-success' : 'bg-danger' }}">{{ $item->status }}</span>
                </td>
                <td class="text-center">{{ $item->created_at }}</td>
                <td class="text-center">
                    @can('edit')
                        <a class="btn btn-sm bg-info" href="{{ route('settings.users.edit', ['user' => $item->id]) }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    @endcan
                    @if(Auth::id() != $item->id)
                        @can('delete')
                            <button type="button" class="btn btn-sm bg-danger btn-delete-user" data-url="{{ route('settings.users.destroy', ['user' => $item->id]) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
