@section('media-css')
    <link href="{{ mix('core/css/media.mix.css') }}" rel="stylesheet"/>
@endsection

<div class="clearfix"></div>
<div class="media-wrapper">
    <div class="media-header">
        <div class="media-top-header">
            <div class="media-actions d-flex">
                <div class='file file--upload mr-2'>
                    <label for='input-file' class="btn btn-success btn-sm m-0 font-weight-normal">
                       <i class="fas fa-upload mr-1"></i> Upload
                    </label>
                    <input id='input-file' type='file' name="files[]" multiple class="d-none"/>
                </div>
                <button class="btn btn-success btn-sm js-create-folder-action mr-2" type="button" data-toggle="modal"
                        data-target="#makeFolder">
                    <i class="fas fa-folder-plus"></i> {{ trans('packages/core::common.f_folder', ['field' => trans('packages/core::common.create')]) }}
                </button>
                <button class="btn btn-success btn-sm js-refresh" data-type="refresh">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>
    </div>
    <div class="card card-folders mt-2">
        <div class="card-header py-1">
            <div class="d-flex align-items-center justify-content-between">
                <ol class="folder-breadcrumb p-2 m-0">
                    <li class="breadcrumb-item">
                        <a href="#" data-folder="" data-parent="" class="change-folder">
                             <i class="fas fa-folder"></i>
                            All media
                        </a>
                    </li>
                </ol>
                <div class="btn-group p-2">
                    <button class="btn btn-sm btn-outline-secondary" id="btn-list">
                        <i class="fas fa-list"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary outline-none active" id="btn-grid">
                        <i class="fas fa-th"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Folders Container -->
        <div class="card-body p-0" id="foldersGroup">
            <div id="main-folders" class="d-flex align-items-stretch flex-wrap">
                <div class="col-12 p-0 d-flex align-items-stretch flex-wrap">
                    <div id="scroll-folder" class="col-10 p-0 item-border-right">
                        <div class="container-fluid">
                            <div class="row p-2" id="fill-media" data-parent_id="">
                                {{--appen js-2--}}
                            </div>
                        </div>
                    </div>
                    <div class="media-details col-2 p-0 text-black">
                        <div class="media-thumbnail d-flex justify-content-center align-items-center item-border-bottom">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="media-description mx-2 mt-2">
                            <div class="media-name">
                                <span>Name: </span>
                                <p title=""></p>
                            </div>
                            <div class="media-size">
                                <span>Size: </span>
                                <p title=""></p>
                            </div>
                            <div class="media-full-url d-none">
                                <span>Full URL: </span>
                                <p title=""></p>
                            </div>
                            <div class="media-uploaded-at">
                                <span>Uploaded at: </span>
                                <p title=""></p>
                            </div>
                            <div class="media-modified-at">
                                <span>Modified at: </span>
                                <p title=""></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Folders Container -->
    </div>
</div>


<ul id="tooltip">
    <li class="copy-address">
        <i class="fas fa-link mr-2"></i>
        <span>@lang('packages/core::common.copy_link')</span>
    </li>
    <li class="download-file" data-url="{{ route('media.downloadFile') }}">
        <i class="fas fa-download mr-2"></i>
        <span>Download</span>
    </li>
    <li class="rename-file">
        <i class="fas fa-pencil-alt mr-2"></i>
        <span>@lang('packages/core::common.rename')</span>
    </li>
    <li class="delete-file" data-url="{{ route('media.deleteFiles') }}">
        <i class="fas fa-trash mr-2"></i>
        <span>@lang('packages/core::common.delete')</span>
    </li>
</ul>
@include('packages/core::medias.include._modal-make-folder')
@include('packages/core::medias.include._modal-rename')
@section('media-js')
    <script>
        let ROUTE_SHOW = "{!! route('media.show', ['media' => '__folderId']) !!}";
        let MEDIA_IDX = "{!! route('media.index') !!}";
        let UPLOAD_FILE_URL = "{!! route('media.upload-files') !!}";
        let MEDIA_URL = "{{ url('storage') }}";
        @if(config('filesystems.default') == \IBoot\Core\App\Models\SystemSetting::BUNNY_CDN)
            MEDIA_URL = "{{ config('core.media_url') }}";
        @endif
    </script>
    <script type="text/javascript" src="{{ mix('core/js/media.mix.js') }}" defer></script>
@endsection
