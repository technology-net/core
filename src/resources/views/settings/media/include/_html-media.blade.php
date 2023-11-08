@section('media-css')
    <link href="{{ mix('core/css/media.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
@endsection

<div class="clearfix"></div>
<div class="media-wrapper">
    <div class="media-header">
        <div class="media-top-header">
            <div class="media-actions d-flex">
                <div class='file file--upload mr-2'>
                    <label for='input-file' class="btn btn-success m-0">
                        <i class="mdi mdi-cloud-upload-outline"></i> Upload
                    </label>
                    <input id='input-file' type='file' name="files[]" multiple class="d-none"/>
                </div>
                <button class="btn btn-success js-download-action mr-2" type="button">
                    <i class="mdi mdi-cloud-download-outline"></i>
                    Download
                </button>
                <button class="btn btn-success js-create-folder-action mr-2" type="button" data-toggle="modal"
                        data-target="#makeFolder">
                    <i class="mdi mdi-folder-outline"></i> {{ trans('packages/core::common.f_folder', ['field' => trans('packages/core::common.create')]) }}
                </button>
                <button class="btn btn-success js-change-action" data-type="refresh">
                    <i class="mdi mdi-sync"></i> Refresh
                </button>
            </div>
        </div>
    </div>
    <div class="card card-folders mt-2">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col mr-auto">
                    <ol class="folder-breadcrumb breadcrumb mt-1">
                        <i class="mdi mdi-folder mdi-18px"></i>
                        <li class="breadcrumb-item mt-1 mx-1">
                            <a href="#" data-folder="" class="change-folder">
                                All media
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col col-auto pr-2">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-secondary" id="btn-list">
                            <i class="mdi mdi-view-list mdi-18px"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary outline-none active d-flex" id="btn-grid">
                            <i class="mdi mdi-grid-large mdi-18px"></i>
                        </button>
                    </div>
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
                                {{--appen js--}}
                            </div>
                        </div>
                    </div>
                    <div class="media-details col-2 p-0 text-black">
                        <div
                            class="media-thumbnail d-flex justify-content-center align-items-center item-border-bottom">
                            <i class="mdi mdi-image"></i>
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
@include('packages/core::settings.media.include._modal-make-folder')
@section('media-js')
    <script>
        let ROUTE_SHOW = "{!! route('settings.media.show', ['media' => '__folderId']) !!}";
        let ROUTE_IDX = "{!! route('settings.media.index') !!}";
        let UPLOAD_FILE_URL = "{!! route('settings.media.upload-files') !!}";
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script type="text/javascript" src="{{ mix('core/js/media.js') }}" defer></script>
@endsection
