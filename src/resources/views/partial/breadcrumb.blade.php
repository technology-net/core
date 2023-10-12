<ol class="breadcrumb" v-pre="">
    <i class="mdi mdi-home breadcrumb-icon"></i>
    <li class="breadcrumb-item mt-1">
        @if(route('dashboard.index') !== url()->full())
            <a href="{{ route('dashboard.index') }}">{{ trans('packages/core::common.dashboard') }}</a>
        @else
            <span class="text-black">{{ trans('packages/core::common.dashboard') }}</span>
        @endif
    </li>
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
