<div class="table-responsive table-has-actions table-has-filter ">
    <div id="" class="form-inline no-footer">
        <div class="dt-buttons btn-group flex-wrap float-end">
            <a href="#" class="btn btn-success">
                <span class="mdi mdi-plus"></span>
                {{ trans('packages/core::common.create') }}
            </a>
        </div>
    </div>
    <table class="table table-striped table-secondary table-hover vertical-middle bg-white bg-gradient-primary mt-3"
           id="" role="grid" aria-describedby="">
        <thead>
        <tr role="row">
            <th class="text-start no-column-visibility sorting_disabled user-checkbox" rowspan="1"
                colspan="1" aria-label="">
                <label class="user-checkbox-label">
                    <input class="table-check-all" data-set=".dataTable .checkboxes" name="" type="checkbox">
                </label>
            </th>
            <th title="Name" class="text-start sorting_desc" tabindex="0"
                rowspan="1" colspan="1" aria-label="">Name
            </th>
            <th title="Created At" class="text-start" tabindex="0"
                aria-controls="" rowspan="1" colspan="1"
                aria-label="">{{ trans('packages/core::user.created_at') }}
            </th>
            <th title="Operations" class="text-end sorting_disabled user-checkbox" rowspan="1"
                colspan="1" aria-label="Operations">{{ trans('packages/core::user.operations') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($menus as $key => $menu)
            <tr role="row" class="{{ $key % 2 === 0 ? 'odd' : 'even'}}">
                <td class="text-start no-column-visibility dtr-control pt-3">
                    <div class="text-start">
                        <div class="checkbox checkbox-primary table-checkbox">
                            <label class="user-checkbox-label">
                                <input class="checkboxes" name="id[]" type="checkbox"
                                    value="{{ $menu->id }}">
                            </label>
                        </div>
                    </div>
                </td>
                <td class="text-start pt-3">
                    <a href="#">{{ $menu->menu_type }}</a>
                </td>
                <td class="column-key-3 pt-3">{{ $menu->created_at }}</td>
                <td class="text-end">
                    <a class="btn btn-sm bg-info btn-view-user" title="View user's profile"
                       href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px" viewBox="2 2 20 20"><title>pencil-outline</title>
                            <path
                                d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"/>
                        </svg>
                    </a>
                    <a class="btn btn-sm bg-danger btn-delete-user" title="Delete a user"
                       data-bs-original-title="Delete" data-url="#"
                       role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px" viewBox="2 2 20 20"><title>delete</title>
                            <path
                                d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex float-right mt-2">
{{--        {!! $users->links() !!}--}}
    </div>
</div>
