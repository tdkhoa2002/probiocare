@extends('layouts.master')

@section('title')
Update Ads | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="p2p-create-ads py-4 py-md-5">
    <div class="container-custom">
        <div class="d-flex justify-content-between mb-3">
            <a class="backlink " href="{{route('fe.p2p.market.center')}}#postAds">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">Update Ads</div>
            </a>
        </div>
        <update-ads :ads-id="{{ $ads->id }}"></update-ads>
    </div>
</div>
@stop