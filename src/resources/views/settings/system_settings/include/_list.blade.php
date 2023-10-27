<div class="table-responsive table-has-actions table-has-filter ">
    <div id="" class="form-inline no-footer">
        <div class="dt-buttons btn-group flex-wrap float-end">
            <a href="{{ route('settings.system_settings.create') }}" class="btn btn-success">
                <span class="mdi mdi-plus"></span>
                {{ trans('packages/core::common.create') }}
            </a>
        </div>
    </div>
    <table class="table table-striped table-secondary table-hover vertical-middle bg-white mt-3" role="grid" aria-describedby="">
        <thead>
            <tr role="row">
                <th class="text-start no-column-visibility sorting_disabled user-checkbox" rowspan="1"
                    colspan="1" aria-label="Check box">
                    <label class="user-checkbox-label">
                        <input class="table-check-all" data-set=".dataTable .checkboxes" name="" type="checkbox">
                    </label>
                </th>
                <th title="{{ trans('packages/core::settings.system_settings.key') }}" class="text-start sorting_desc" tabindex="0"
                    rowspan="1" colspan="1" aria-label="">{{ trans('packages/core::settings.system_settings.key') }}
                </th>
                <th title="{{ trans('packages/core::settings.system_settings.value') }}" class="text-start sorting_desc" tabindex="0"
                    rowspan="1" colspan="1" aria-label="">{{ trans('packages/core::settings.system_settings.value') }}
                </th>
                <th width="12%" title="{{ trans('packages/core::user.created_at') }}" class="text-start" tabindex="0"
                    aria-controls="" rowspan="1" colspan="1"
                    aria-label="">{{ trans('packages/core::user.created_at') }}
                </th>
                <th title="Operations" class="text-start sorting_disabled user-checkbox" rowspan="1"
                    colspan="1" aria-label="Operations">{{ trans('packages/core::user.operations') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($systemSettings as $key => $item)
                <tr role="row" class="{{ $key % 2 ? 'odd' : 'even'}}">
                    <td class="text-start no-column-visibility dtr-control pt-3">
                        <div class="text-start">
                            <div class="checkbox checkbox-primary table-checkbox">
                                <label class="user-checkbox-label">
                                    <input class="checkboxes" name="id[]" type="checkbox"
                                        value="{{ $item->id }}">
                                </label>
                            </div>
                        </div>
                    </td>
                    <td class="text-start pt-3">{{ $item->key }}</td>
                    <td class="text-start pt-3">
                        <textarea class="form-control editable" data-url="{{ route('settings.system_settings.editable', $item->id) }}"
                                  name="value" rows="{{ isJSON($item->value) ? 5 : 1 }}" label="{{ trans('packages/core::settings.system_settings.value') }}" data-id="{{ $item->id }}"
                                  validate="true" validate-pattern="required">{!! isJSON($item->value) ? renderJsonAsHtml($item->value) : $item->value  !!}</textarea>
                        <div id="error_value-{{ $item->id }}" ></div>
                    </td>
                    <td class="text-center column-key-3 pt-3">{{ $item->created_at }}</td>
                    <td class="text-center">
                        @if(empty($item->deletable))
                            <button class="btn btn-sm bg-danger btn-delete" title="Delete" role="button" data-url="{{ route('settings.system_settings.destroy', $item->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px" viewBox="2 2 20 20"><title>delete</title>
                                    <path
                                        d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                                </svg>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
