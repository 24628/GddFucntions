@extends('layouts.master')

@section('css')

    <link href="{{ asset('css/metric.css') }}" rel="stylesheet">

@endsection

@section('jumbotron')
    <div class="jumbotron jumbotron-fluid box--shadow">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3">
                    <h1>GGD LOGO INSERT</h1>
                </div>
                <div class="col-12 col-md-7">
                    <div id="already-made-stories">
                        <h1 class="display-4">Stories</h1>
                        <p class="lead">Lorem Ipsum is just a sample
                            text from the printing and typesetting
                            industry. Lorem Ipsum has been the standard
                            sample text in this industry since the
                            16th century, when an unknown printer
                            took a brewing hook with letters and
                            mixed them up to make a font catalog.
                            It has not only survived five centuries
                            but has also, virtually unchanged, been
                            copied in electronic letter setting.
                            It became popular in the 60s with the
                            introduction of Letraset sheets with Lorem
                            Ipsum passages and more recently with
                            desktop publishing software such as
                            Aldus PageMaker containing versions of Lorem Ipsum.
                        </p>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="float-left">
                        <h1 onclick="toggleShareStory()">SHARE STORY</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('sidebar')

    <h1>Comparing metric</h1>

    <form id="metric_form">
    {{--@csrf--}}

    <!--main metric-->
    @include('metric.metric-selection-partials.main_metric')

    <!--comp metric-->
    @include('metric.metric-selection-partials.comparative_metric')

    <!--Age-->
    {{--@include('metric.metric-selection-partials.age')--}}

    <!--places-->
        {{--@include('metric.metric-selection-partials.view')--}}
    </form>


@endsection

@section('content')

    <div class="button_toggle">
        <div class="float-left"><button class="btn btn-success btn-sm button_toggle_dataviz" onclick="toggle_toMap()">Map</button></div>
        <div class="float-left"><button class="btn btn-success btn-sm button_toggle_dataviz" onclick="toggle_toDataviz()">Dataviz</button></div>
    </div>

    @include('metric.partials.map')

    @include('metric.partials.chart')

    @if(auth()->check())
    @include('metric.partials.shareStory')
    @elseif(!auth()->check())
    <p>You have to be logged in for this action</p>
    @endif

@endsection

@section('js')
    <script src="{{asset('js/ToggleDisplay.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#metric_form :input").change(function() {
            updateCheckBoxesCheck();
        });

        function updateCheckBoxesCheck() {

            $("#metric_form").data("changed",true);
            checkboxCheckChecked();
            function checkboxCheckChecked() {
                var allVals = [];
                $('#metric_form :checked').each(function() {
                    allVals.push($(this).val());
                });

                $.ajax({
                    method: 'POST',
                    url: '{{ route('ajax-metric-update') }}',
                    data: {'data' :  JSON.stringify(allVals)},
                    success: function(response){
                        console.log(response);
                        addDataToTable(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }

        function addDataToTable(response_data){
            console.log(response_data);
            forLoopDataInTable();
            function forLoopDataInTable() {
                var htmlPlace = document.getElementById('tbody_data_viz_show_data');
                htmlPlace.innerHTML = '';
                let b = 1;
                let sum;
                for(let i = 0; i < response_data.message.length; ++i) {
                    var tr = document.createElement('tr');
                    sum = i + b;
                    tr.innerHTML =
                        "<th scope=\"row\">" + sum + "<\/th>" +
                        "<td> " + response_data.message[i] + " <\/td>" +
                        "<td>" + Math.floor(Math.random() * 100) + "%<\/td>";

                    htmlPlace.appendChild(tr);
                }
            }
        }

        $(".checkbox-story-submit").change(function() {
            let storyMetricStore = [];
            $('#metric_form :checked').each(function() {
                storyMetricStore.push($(this).val());
            });
            let dataBaseReady = JSON.stringify(storyMetricStore);
            if(this.checked) {
                $('input[name=story_add_metric_to_story_hidden]').val(dataBaseReady);
            } else if(!this.checked){
                $('input[name=story_add_metric_to_story_hidden]').val('');
            }
        });

        var age;
        var height;
        var weight;

        var slider_age = document.getElementById("form_slider_story_age");
        var output_age = document.getElementById("output_form_slider_story_age");
        output_age.innerHTML = slider_age.value;

        slider_age.oninput = function() {
            output_age.innerHTML = this.value;
            age = this.value;
        };

        var slider_weight = document.getElementById("form_slider_story_weight");
        var output_weight = document.getElementById("output_form_slider_story_weight");
        output_weight.innerHTML = slider_weight.value;

        slider_weight.oninput = function() {
            output_weight.innerHTML = this.value;
            weight = this.value;
        };

        var slider_height = document.getElementById("form_slider_story_height");
        var output_height  = document.getElementById("output_form_slider_story_height");
        output_height.innerHTML = slider_height.value;

        slider_height.oninput = function() {
            output_height.innerHTML = this.value;
            height = this.value;
        };

        function submit_form() {
            document.getElementById('form_make_story').submit();
        }
    </script>
@endsection