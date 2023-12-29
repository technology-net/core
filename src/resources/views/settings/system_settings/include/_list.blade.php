<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($systemSettings as $group => $items)
                @php
                    $textId = strtolower(str_replace(' ', '', $group));
                @endphp
                <li class="nav-item">
                    <a class="nav-link{{ $loop->first ? ' active' : '' }} tab-name" data-group="{{ $group }}" id="tabs{{ $textId }}" data-toggle="pill" href="#{{ $textId }}" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">{{ $group }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            @foreach($systemSettings as $group => $items)
                @php
                    $textId = strtolower(str_replace(' ', '', $group));
                @endphp
                <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }} tab-config" id="{{ $textId }}" role="tabpanel" aria-labelledby="tabs{{ $textId }}">
                    @if($group === IBoot\Core\App\Models\SystemSetting::FILE_SYSTEM)
                        <select class="form-control select-config" style="width: 18%">
                            @foreach(fileSystemOptions() as $key => $option)
                                <option value="{{ $key }}" @if(!empty($filesystemDisk) && $filesystemDisk->value == $key) selected @endif>{{ $option }}</option>
                            @endforeach
                        </select>
                    @endif
                    @if($group === IBoot\Core\App\Models\SystemSetting::EMAIL_CONFIG)
                        <select class="form-control select-config" style="width: 18%">
                            @foreach(emailConfigOptions() as $key => $option)
                                <option value="{{ $key }}" @if(!empty($emailTransport) && $emailTransport->value == $key) selected @endif>{{ $option }}</option>
                            @endforeach
                        </select>
                    @endif
                    <table class="mt-3 table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th width="18%">{{ trans('packages/core::settings.system_settings.key') }}</th>
                            <th>{{ trans('packages/core::settings.system_settings.value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->key }}</td>
                                    <td>
                                        @if(isJSON($item->value))
                                            @foreach(json_decode($item->value, true) as $key => $value)
                                                <div class="form-group row">
                                                    <label for="{{ $key }}" class="col-sm-4 col-form-label">{{ $key }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="{{ $key }}" class="form-control input-update"
                                                            value="{{ $value }}" validate-pattern="required"
                                                            data-url="{{ route('settings.system_settings.update', $item->id) }}"
                                                            data-id="{{ $item->id }}" @cannot('edit system settings') readonly @endcannot
                                                            data-value="json" @if(in_array($key, ['driver', 'transport'])) readonly @endif
                                                        >
                                                        <div id="error_{{ $key }}-{{ $item->id }}" ></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" name="value" class="form-control input-update" value="{{ $item->value }}"
                                                value="{{ $item->value }}" validate-pattern="required"
                                                data-value="string" data-url="{{ route('settings.system_settings.update', $item->id) }}"
                                                data-id="{{ $item->id }}" @cannot('edit system settings') readonly @endcannot
                                            >
                                            <div id="error_value-{{ $item->id }}" ></div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</div>
