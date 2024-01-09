<!-- Modal -->
<div class="modal fade" id="rename" tabindex="-1" role="dialog" aria-labelledby="rename-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rename-label">@lang('packages/core::common.rename')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rename-form" action="{{ route('media.renameFile') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="input-group">
                        <input class="form-control" type="text" name="name" placeholder="@lang('packages/core::common.name')">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">{{ trans('packages/core::common.confirm') }}</button>
                        </div>
                    </div>
                    <div id="error_name-mod"></div>
                </form>
            </div>
        </div>
    </div>
</div>
