<div class="card">
    <div class="card-header">
        <a href="{{ route('settings.users.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>
            {{ trans('packages/core::common.create') }}
        </a>
        <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="">
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
                        <input class="input-check-all" name="" type="checkbox">
                    </label>
                </th>
                <th>{{ trans('packages/core::user.username') }}</th>
                <th>{{ trans('packages/core::common.email') }}</th>
                <th width="10%" class="text-left">{{ trans('packages/core::common.status') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $item)
            <tr>
                <td class="text-center">
                    <label class="user-checkbox-label">
                        <input class="checkboxes" name="id[]" type="checkbox" value="{{ $item->id }}">
                    </label>
                </td>
                <td>
                    <a href="{{ route('settings.users.edit', ['user' => $item->id]) }}">{{ $item->username }}</a>
                </td>
                <td>{{ $item->email }}</td>
                <td>
                    <span class="btn-sm {{ $item->status == \IBoot\Core\App\Models\User::STATUS_ACTIVATED ? 'bg-success' : 'bg-danger' }}">{{ $item->status }}</span>
                </td>
                <td class="text-center">{{ $item->created_at }}</td>
                <td class="text-center">
                    <a class="btn btn-sm bg-info" href="{{ route('settings.users.edit', ['user' => $item->id]) }}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <button type="button" class="btn btn-sm bg-danger btn-delete-user" data-url="{{ route('settings.users.destroy', ['user' => $item->id]) }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
