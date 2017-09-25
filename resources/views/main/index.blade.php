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

        <div class="panel panel-default">
            <div class="panel-heading">Homepage</div>

            <div class="panel-body">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis hendrerit consectetur.
                Fusce mauris ante, sollicitudin at felis vel, maximus tempor nunc. Duis accumsan vulputate
                laoreet. Pellentesque aliquam, nisi lacinia finibus ornare, massa lorem ultrices diam, varius
                volutpat est turpis ac nunc. In quis nibh urna. Cras malesuada scelerisque pulvinar. Suspendisse
                nec nunc ut turpis ultricies consectetur. Cras commodo arcu eleifend, semper nisi a, faucibus
                dui. Nunc sit amet tincidunt enim. Nullam quis nulla pellentesque, auctor velit sed, malesuada
                diam. Nam ac tortor pulvinar, ornare ante sed, placerat dui. Etiam hendrerit, est id fermentum
                sagittis, mauris mauris vulputate lectus, vitae ultrices nisl orci dictum metus. Suspendisse
                tempus lorem et turpis pulvinar dictum. Fusce rhoncus congue semper. Maecenas posuere molestie
                sapien, sit amet finibus ante pretium ultricies.
            </div>
        </div>
    </div>

@endsection
