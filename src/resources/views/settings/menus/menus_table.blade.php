<div class="card">
    <div class="card-header">
        @can('create menus')
            <a href="{{ route('settings.menus.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                {{ trans('packages/core::common.create') }}
            </a>
        @endcan
        @can('delete menus')
            <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('settings.menus.deleteAll') }}">
                <i class="fas fa-trash"></i>
                {{ trans('packages/core::common.delete') }}
            </button>
        @endcan
    </div>

    <div class="card-body">
        <table class="mt-3 table table-bordered table-hover table-striped" id="dataTable">
            <thead>
                <tr>
                    @can('delete menus')
                        <th width="3%" class="text-center">
                            <label class="user-checkbox-label">
                                <input class="input-check-all" name="" type="checkbox">
                            </label>
                        </th>
                    @endcan
                    <th>{{ trans('packages/core::settings.menus.menu_type') }}</th>
                    <th width="12%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                    <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $item)
                    <tr>
                        @can('delete menus')
                            <td class="text-center">
                                <label class="user-checkbox-label">
                                    <input class="checkboxes" name="id[]" type="checkbox" value="{{ $item->id }}">
                                </label>
                            </td>
                        @endcan
                        <td>
                            @can('edit menus')
                                <a href="{{ route('settings.menus.edit', $item->id) }}">{{ $item->menu_type }}</a>
                            @else
                                {{ $item->menu_type }}
                            @endcan
                        </td>
                        <td class="text-center">{{ $item->created_at }}</td>
                        <td class="text-center">
                            @can('edit menus')
                                <a class="btn btn-sm bg-info" href="{{ route('settings.menus.edit', $item->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endcan
                            @can('delete menus')
                                <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('settings.menus.destroy', $item->id) }}">
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
