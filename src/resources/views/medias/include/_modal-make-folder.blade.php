<!-- Modal -->
<div class="modal fade" id="makeFolder" tabindex="-1" role="dialog" aria-labelledby="makeFolderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makeFolderLabel">{{ trans('packages/core::common.f_folder', ['field' => trans('packages/core::common.create')]) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="create-folder-form" action="{{ route('media.create-folder') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="text" name="name" placeholder="{{ trans('packages/core::common.f_folder', ['field' => trans('packages/core::common.name')]) }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">{{ trans('packages/core::common.create') }}</button>
                        </div>
                    </div>
                    <div id="error_name" ></div>
                </form>
            </div>
        </div>
    </div>
</div>
