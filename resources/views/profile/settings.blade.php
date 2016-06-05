@extends('layout.app')

@section('title', $meta['title'])
@section('description', $meta['description'])
@section('keywords',$meta['keywords'] )

@section('content')

@include('profile.sidebar')

    <div class="col-xs-12 col-sm-8 col-md-6 panel">
        @include('profile.menu')  
        <div class="row posting_block">
        
            <h4 class="size18 bold text-center">{{ trans('sovpal.'.Request::input('section')) }} :
            <div class="dropdown">
                <a class="blue_c dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="fa fa-question-circle"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="size10 blue_c text-center">
                        {{ trans('sovpal.profile.'.$data->type .'.'. Request::input('section').'.Help') }}
                    </li>
                </ul>
            </div>
            </h4>
            <br>
            @include('layout.forms._basic.default',['model' => 'user','method' => 'update','type'=>'','button'=>'SaveChanges','modal_data'=>null])

        </div>
        @include('profile.footer')
    </div>

<div class="hidden-sm hidden-xs col-md-2">
	@include('layout.blogs')
</div>

@endsection


