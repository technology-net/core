<!-- Modal -->
<div class="modal fade" id="modalOpenMedia" tabindex="-1" role="dialog" aria-labelledby="modalOpenMediaLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="modalOpenMediaLabel">{{ trans('packages/core::settings.media.title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('packages/core::settings.media.include._html-media')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-insert" data-dismiss="modal">{{ trans('packages/core::common.insert') }}</button>
            </div>
        </div>
    </div>
</div>
