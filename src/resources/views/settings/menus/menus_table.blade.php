<div class="card">
    <div class="card-header">
        <a href="#" class="btn btn-success btn-sm">
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
                    <th>{{ trans('packages/core::settings.menus.menu_type') }}</th>
                    <th width="10%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                    <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $item)
                    <tr>
                        <td class="text-center">
                            <label class="user-checkbox-label">
                                <input class="checkboxes" name="id[]" type="checkbox" value="{{ $item->id }}">
                            </label>
                        </td>
                        <td>
                            <a href="{{ route('settings.menus.edit', $item->id) }}">{{ $item->menu_type }}</a>
                        </td>
                        <td class="text-center">{{ $item->created_at }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm bg-info" href="{{ route('settings.menus.edit', $item->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button type="button" class="btn btn-sm bg-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
