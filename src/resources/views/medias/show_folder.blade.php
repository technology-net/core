@if(!empty($id))
    <div class="col-1 p-0 pt-1 grid-view">
        <div class="folder-item">
            <button class="folder-container-back change-folder" data-folder="{{ $parent }}">
                <div class="folder-icon">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </div>
                <div class="folder-name folder-name-grid">...</div>
            </button>
        </div>
    </div>
@endif
@if(!$media->count())
    <div class="no-items text-black">
        <i class="fas fa-cloud-upload-alt"></i>
        <p>Drop files and folders here</p>
    </div>
@else
    @foreach($media as $item)
        <div class="col-1 p-0 pt-1 grid-view">
            <div class="folder-item" title="{{ $item->name }}">
                <button class="folder-container folder-container-{{$item->id}}"
                    data-is_directory="{{ $item->is_directory }}" data-id="{{ $item->id }}"
                    data-mime_type="{{ $item->mime_type }}" data-media="{{ @json_encode($item->getAttributes()) }}">
                    <i class="far fa-check-circle icon-check"></i>
                    <div class="folder-icon">
                        @if($item->is_directory)
                            <i class="fas fa-folder folder-icon-color"></i>
                        @else
                            <img src="{{ $item->image_thumbnail }}" alt="{{ $item->name }}">
                        @endif
                    </div>
                    <div class="folder-content">
                        <div class="folder-name folder-name-grid text-ellipsis">{{ $item->name }}</div>
                        <div class="more-info-folder d-none">
                            <div class="folder-size">{{ $item->size_format }}</div>
                            <div class="folder-created-at float-right">{{ $item->created_at }}</div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    @endforeach
@endif
