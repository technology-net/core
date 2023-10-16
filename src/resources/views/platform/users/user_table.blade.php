<div class="table-responsive table-has-actions table-has-filter ">
    <div id="" class="form-inline dt-bootstrap no-footer">
        <div class="dt-buttons btn-group flex-wrap float-end">
            <a href="{{ route('users.create') }}">
                <button class="btn btn-success bg-success action-item btn-primary rounded btn-create-user" tabindex="0"
                    aria-controls="botble-a-c-l-tables-user-table" type="button">
                    <span>
                        <span data-action="create" data-href="">
                            <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px"
                                viewBox="0 0 24 24"><title>account-plus-outline</title>
                                <path
                                    fill="#ffffff"
                                    d="M15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4M15,
                                    5.9C16.16,5.9 17.1,6.84 17.1,8C17.1,9.16 16.16,10.1 15,10.1A2.1,2.1 0 0,1 12.9,
                                    8A2.1,2.1 0 0,1 15,5.9M4,7V10H1V12H4V15H6V12H9V10H6V7H4M15,13C12.33,13 7,14.33 7,
                                    17V20H23V17C23,14.33 17.67,13 15,13M15,14.9C17.97,14.9 21.1,16.36 21.1,
                                    17V18.1H8.9V17C8.9,16.36 12,14.9 15,14.9Z"/>
                            </svg>
                            {{ trans('packages/core::common.create') }}
                        </span>
                    </span>
                </button>
            </a>
        </div>
    </div>
    <table class="table table-striped table-hover vertical-middle bg-white bg-gradient-primary mt-3"
        id="" role="grid" aria-describedby="">
        <thead>
        <tr role="row">
            <th class="text-start no-column-visibility sorting_disabled user-checkbox" rowspan="1"
                colspan="1" aria-label="">
                <label class="user-checkbox-label">
                    <input class="table-check-all" data-set=".dataTable .checkboxes" name="" type="checkbox">
                </label>
            </th>
            <th title="Username" class="text-start sorting_desc" tabindex="0"
                aria-controls="botble-a-c-l-tables-user-table" rowspan="1" colspan="1"
                aria-sort="descending" aria-label="">{{ trans('packages/core::user.username') }}
            </th>
            <th title="Email" class="text-start" tabindex="0"
                aria-controls="" rowspan="1" colspan="1" aria-label="">{{ trans('packages/core::user.email') }}
            </th>
            <th title="Created At" class="text-start" tabindex="0"
                aria-controls="" rowspan="1" colspan="1"
                aria-label="">{{ trans('packages/core::user.created_at') }}
            </th>
            <th title="Status" class="" rowspan="1"
                colspan="1" aria-label="Status">{{ trans('packages/core::user.status') }}
            </th>
            <th title="Operations" class="text-end sorting_disabled user-checkbox" rowspan="1"
                colspan="1" aria-label="Operations">{{ trans('packages/core::user.operations') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $user)
            <tr role="row" class="{{ $key % 2 === 0 ? 'odd' : 'even'}}">
                <td class="text-start no-column-visibility dtr-control pt-3">
                    <div class="text-start">
                        <div class="checkbox checkbox-primary table-checkbox">
                            <label class="user-checkbox-label">
                                <input class="checkboxes" name="id[]" type="checkbox"
                                    value="{{ $user->id }}">
                            </label>
                        </div>
                    </div>
                </td>
                <td class="text-start pt-3">
                    <a href="{{ route('users.edit', ['user' => $user->id]) }}">{{ $user->username }}</a>
                </td>
                <td class="text-start pt-3">{{ $user->email }}</td>
                <td class="column-key-3 pt-3">{{ $user->created_at }}</td>
                <td class="column-key-4 pt-3">
                    <span class="label-info status-label">{{ $user->status }}
                    </span>
                </td>
                <td class="text-end">
                    <a class="btn bg-info btn-view-user" title="View user's profile"
                       href="{{ route('users.edit', ['user' => $user->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px" viewBox="2 2 20 20"><title>pencil-outline</title>
                            <path
                                d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z"/>
                        </svg>
                    </a>
                    <a class="btn bg-danger btn-delete-user" title="Delete a user"
                       data-bs-original-title="Delete" data-url="{{ route('users.destroy', ['user' => $user->id]) }}"
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
        {!! $users->links() !!}
    </div>
</div>
