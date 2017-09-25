@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        @if(!auth()->check() || is_null(auth()->user()->api_token))
            {{ Form::open(['method' => 'PATCH', 'route' => 'main.updateToken']) }}
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('text.api_token')
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('api_token', trans('text.api_token')) }}
                        {{ Form::text('api_token', old('api_token'), ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">
                        @lang('text.submit')
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        @endif

        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#add-new" aria-controls="add-new" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane panel active" id="add-new">
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('city', trans('text.city')) }}
                            {{ Form::text('city', '', ['class' => 'form-control', 'id' => 'city-input']) }}
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary">
                            @lang('text.submit')
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
