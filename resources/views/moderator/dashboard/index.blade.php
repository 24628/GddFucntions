@extends('layouts.master')

@section('css')


@endsection


@section('jumbotron')

@endsection


@section('sidebar')
    @if(auth()->check())
        @include('layouts.partials.sidebarProfile')
    @endif
@endsection


@section('content')
    <div style="background-color: white">
    <h1>Moderator</h1>
    <form method="POST" action="{{route('moderator.store.cvs_to_json')}}" id="form_cvs_to_json" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="file" id="cvs_to_json">
        <input type="hidden" name="cvs_to_json_text" id="cvs_to_json_text">
        <input type="hidden" name="file_name" id="file_name">
        <button type="button" onclick="parse()">Submit</button>
    </form>

    @include('moderator.dashboard.partials.linkToFunctions')

    <hr>
    all personases
    <a href="{{route('moderator.persona.create')}}">create persona</a>
    <br>

    <div style="overflow: hidden">
    @include('moderator.dashboard.partials.story')
    </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="{{asset('js/papaparse.min.js')}}"></script>
    <script>

        var data;

        function parse() {
            var file = document.getElementById('cvs_to_json').files[0];
            if(String(file.name.split('.').pop()) !== 'csv'){
                alert('This is not an csv file please check the extension of the file');
                return;
            }
            Papa.parse(file, {
                header: true,
                dynamicTyping: true,
                complete: function(results) {
                    data = results.data;
                    $("#file_name").val(file.name);
                    $("#cvs_to_json_text").val(JSON.stringify(data));
                    document.getElementById("form_cvs_to_json").submit();
                }
            });
        }
    </script>
@endsection