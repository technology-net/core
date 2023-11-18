<div class="content-header">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                @if(route('dashboard.index') !== url()->full())
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fa fa-home"></i>
                        {{ trans('packages/core::common.dashboard') }}
                    </a>
                @else
                    <i class="fa fa-home"></i>
                    {{ trans('packages/core::common.dashboard') }}
                @endif
            </li>
            @if(!empty($breadcrumbs))
                @foreach($breadcrumbs as $key => $breadcrumb)
                    @if(!$loop->last)
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] ?? redirect()->getUrlGenerator()->previous() }}">
                                {{$breadcrumb['label']}}
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item active">{{$breadcrumb['label']}}</li>
                    @endif
                @endforeach
            @endif
        </ol>
    </div><!-- /.container-fluid -->
</div>
