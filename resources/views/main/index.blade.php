@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('text.api_id')
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ Form::label('api_id', trans('text.api_id')) }}
                    {{ Form::text('api_id', auth()->check()?auth()->user()->app_id:session()->get('app_id', ''), ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div>
            <ul class="nav nav-tabs" id="cities-list" role="tablist">
                <li role="presentation" class="active">
                    <a href="#add-new" aria-controls="add-new" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="cities-content">
                <div role="tabpanel" class="tab-pane panel active" id="add-new">
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('query', trans('text.query')) }}
                            {{ Form::text('query', '', ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary" id="add-city">
                            @lang('text.submit')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/html" id="content-template">
        <div role="tabpanel" class="tab-pane panel active" id="${cityName}">
            <div class="panel-body">
                <p class="text-center">
                    <img src="http://openweathermap.org/img/w/${weather_icon}.png" alt="${weather_main}">
                </p>
                <h4 class="text-center">${weather_main}</h4>
                <p class="text-muted text-center">${weather_description}</p>
                <div class="row">
                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt>Temperature:</dt>
                            <dd>${main_temperature} °C</dd>

                            <dt>Wind speed:</dt>
                            <dd>${wind_speed} m/s</dd>

                            <dt>Wind direction:</dt>
                            <dd>${wind_direction}</dd>
                        </dl>
                    </div>

                    <div class="col-md-6">
                        <dl class="dl-horizontal">
                            <dt>Sunrise:</dt>
                            <dd>${sys_sunrise}</dd>

                            <dt>Sunset:</dt>
                            <dd>${sys_sunset}/dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="text/html" id="tab-template">
        <li role="presentation" class="active">
            <a href="#${cityName}" aria-controls="${cityName}" role="tab" data-toggle="tab">
                ${cityName}
            </a>
        </li>
    </script>

@endsection

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            var initAppId = $('input#api_id').val();

            $('#add-city').on('click', function (e) {
                e.preventDefault();
                var appId = $('input#api_id').val();
                var query = $('input#query').val();

                $.ajax('/api/current', {
                    data: {
                        app_id: appId,
                        query: query
                    },
                    success: function (data) {
                        console.log(data);

                        console.log();

                        $('#cities-list .active').removeClass('active');
                        tabTemplate = $('#tab-template').html();
                        $('#cities-list').prepend($.tmpl(tabTemplate, {cityName: data.name}));

                        $('#cities-content .active').removeClass('active');
                        contentTemplate = $('#content-template').html();
                        $('#cities-content').prepend($.tmpl(contentTemplate, {
                            cityName: data.name,
                            weather_main: data.weather[0].main,
                            weather_icon: data.weather[0].icon,
                            weather_description: data.weather[0].description,
                            main_temperature: Math.round(data.main.temp),
                            wind_speed: Math.round(data.wind.speed),
                            wind_direction: getWindDirection(data.wind.deg),
                            sys_sunset: new Date(data.sys.sunset * 1000).toLocaleTimeString(),
                            sys_sunrise: new Date(data.sys.sunrise * 1000).toLocaleTimeString()
                        }));

                        $('input#query').val('');
                    },
                    error: function (response) {
                        var error = 'Unknow error';
                        if (typeof(response.responseJSON.error) != "undefined" && response.responseJSON.error !== null) {
                            error = response.responseJSON.error;
                        }

                        alert('Error: ' + error);
                    }
                });

                if (appId !== initAppId) {
                    saveAppId(appId);
                }
            });

            function getWindDirection(deg) {
                if (typeof(deg) === "undefined" || deg === null) {
                    return "N/A";
                }
                var directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW", "N"];
                var index = Math.round((deg % 360) / 22.5, 0) + 1;

                return directions[index];
            }

            function saveAppId(appId){
                $.ajax('/update-app-id', {
                    method: 'PATCH',
                    data: {
                        app_id: appId
                    }
                });
            }
        });
    </script>
@stop