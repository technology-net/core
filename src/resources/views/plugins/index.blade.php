@extends('packages/core::layouts.admin')
@section('css')
    <link href="{{ mix('core/css/plugin.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        @foreach($sidebarItems as $sidebarItem)
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="app-item app-{{ $sidebarItem->name_package }}">
                <div class="card text-black">
                    <div class="card-body">
                        <div class="app-icon">
                            @if ($sidebarItem->image)
                                <img src="data:image/png;base64,{{ $sidebarItem->image }}" alt="{{ $sidebarItem->name_package }}">
                            @endif
                        </div>
                        <div class="app-details">
                            <h4 class="app-name">{{ $sidebarItem->name_package }}</h4>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            San Petronio Basilica
                        </a>
                    </div>
                    <div class="card-body">
                        <span class="card-link text-warning">Active</span>
                        <a href="#" class="card-link text-danger">Remove</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
