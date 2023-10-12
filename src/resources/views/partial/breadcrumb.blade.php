<ol class="breadcrumb" v-pre="">
    <i class="mdi mdi-home breadcrumb-icon"></i>
    <li class="breadcrumb-item mt-1"><a href="#">{{ trans('packages/core::common.dashboard') }}</a></li>
    @if(!empty($breadcrumbs))
        @foreach($breadcrumbs as $key => $breadcrumb)
            @if(!$loop->last)
                <li class="breadcrumb-item mt-1">
                    <a href="{{ $breadcrumb['url'] ?? redirect()->getUrlGenerator()->previous() }}">
                        {{$breadcrumb['label']}}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item mt-1 active">{{$breadcrumb['label']}}</li>
            @endif
        @endforeach
    @endif
</ol>
