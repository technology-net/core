<div class="card">
    <div class="card-header">
        <a href="{{ route('settings.system_settings.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i>
            {{ trans('packages/core::common.create') }}
        </a>
        <button class="btn btn-sm bg-danger delete-all d-none ml-2" title="Delete" role="button" data-url="{{ route('settings.system_settings.deleteAll') }}">
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
                <th>{{ trans('packages/core::settings.system_settings.key') }}</th>
                <th>{{ trans('packages/core::settings.system_settings.value') }}</th>
                <th width="12%" class="text-center">{{ trans('packages/core::common.created_at') }}</th>
                <th width="10%" class="text-center">{{ trans('packages/core::common.operations') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($systemSettings as $item)
            <tr>
                <td class="text-center">
                    <label class="user-checkbox-label">
                        <input class="checkboxes" type="checkbox" value="{{ $item->id }}">
                    </label>
                </td>
                <td>{{ $item->key }}</td>
                <td>
                    <textarea class="form-control editable" data-url="{{ route('settings.system_settings.editable', $item->id) }}"
                              name="value" rows="{{ isJSON($item->value) ? 5 : 1 }}" data-id="{{ $item->id }}"
                              validate="true" validate-pattern="required">{!! isJSON($item->value) ? renderJsonAsHtml($item->value) : $item->value  !!}</textarea>
                    <div id="error_value-{{ $item->id }}" ></div>
                </td>
                <td class="text-center">{{ $item->created_at }}</td>
                <td class="text-center">
                    @if(empty($item->deletable))
                        <button type="button" class="btn btn-sm bg-danger btn-delete" data-url="{{ route('settings.system_settings.destroy', $item->id) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
