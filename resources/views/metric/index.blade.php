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

    @include('metric.partials.shareStory')


@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/103/three.js"></script>
    <script src="{{asset('js/TweenMax.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="{{asset('js/ToggleDisplay.js')}}"></script>
    <script src="{{asset('js/metric.js')}}"></script>
    <script src="{{asset('js/webvr.js')}}"></script>
    <script src="{{asset('js/orbitControl.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var booleanCentrum = false;
        var booleanZuid = false;
        var booleanWest = false;
        var booleanOost = false;
        var booleanNoord = false;
        var booleanNieuwWest = false;
        var booleanZuidOost = false;
        var booleanWestpoort = false;

        function start3DdataViz() {
            if(display3dData) {
                document.getElementById('data_viz_cubes_update').innerHTML = '';
                document.getElementById('data_viz_cubes_update').setAttribute("style", "height:500px");
                let a = window.getComputedStyle(document.getElementById("data_viz_cubes_update"), null);
                var canvasHeight = parseInt(a.getPropertyValue("height").substring(0, a.getPropertyValue("height").length - 2));
                var canvasWidth = parseInt(a.getPropertyValue("width").substring(0, a.getPropertyValue("width").length - 2));

                var scene = new THREE.Scene();
                var camera = new THREE.PerspectiveCamera(75, canvasWidth / canvasHeight, 0.1, 1000);
                var controls = new THREE.OrbitControls(camera);
                camera.position.z = 20;
                controls.update();

                $("#data_viz_cubes_update").hover(
                    function () {
                        noscroll()
                    }
                );

                var noscroll_var;

                function noscroll() {
                    if (noscroll_var) {
                        document.getElementsByTagName("html")[0].style.overflowY = "";
                        document.body.style.paddingRight = "0";
                        controls.enabled = false;
                        controls.enableZoom = false;
                        controls.enablePan = false;
                        controls.enableRotate = false;
                        noscroll_var = false
                    } else {
                        document.getElementsByTagName("html")[0].setAttribute('style', 'overflow-y: hidden !important');
                        document.body.style.paddingRight = "17px";
                        controls.enabled = true;
                        controls.enableZoom = true;
                        controls.enablePan = true;
                        controls.enableRotate = true;
                        noscroll_var = true
                    }
                }

                var renderer = new THREE.WebGLRenderer();
                renderer.setClearColor("#e3e0e5");
                renderer.setSize(canvasWidth, canvasHeight);
                var canvas = document.getElementById('data_viz_cubes_update');
                renderer.setSize($(canvas).width(), $(canvas).height());
                canvas.appendChild(renderer.domElement);

                var raycaster = new THREE.Raycaster();
                var mouse = new THREE.Vector2();

                var geometry = new THREE.BoxGeometry(1, 1, 1);
                var material = new THREE.MeshLambertMaterial({color: "red", transparent: true});

                for (let i = 0; i < 8; i++) {
                    let b = "";
                    0 === i ? b = "Centrum" : 1 === i ? b = "Zuid" : 2 === i ? b = "West" : 3 === i ? b = "Oost" : 4 === i ? b = "Noord" : 5 === i ? b = "NieuwWest" : 6 === i ? b = "ZuidOost" : 7 === i && (b = "Westpoort");
                    var mesh = new THREE.Mesh(geometry, material);
                    mesh.material.opacity = 1;
                    mesh.name = b;
                    mesh.position.x = (Math.random() - 0.5) * 20;
                    mesh.position.y = (Math.random() - 0.5) * 20;
                    mesh.position.z = (Math.random() - 0.5) * 20;
                    scene.add(mesh);
                }

                var light = new THREE.PointLight('white', 1, 1000);
                light.position.set(0, 0, 0);
                scene.add(light);

                var render = function () {
                    requestAnimationFrame(render);
                    controls.update();
                    renderer.render(scene, camera);
                };

                render();

                function onMouseMove(event) {
                    // event.preventDefault();

                    var rect = event.target.getBoundingClientRect();
                    mouse.x = ((event.clientX - rect.left) / canvasWidth) * 2 - 1;
                    mouse.y = -((event.clientY - rect.top) / canvasHeight) * 2 + 1;
                    raycaster.setFromCamera(mouse, camera);

                    var intersects = raycaster.intersectObjects(scene.children, true);
                    for (var i = 0; i < intersects.length; i++) {
                        booleanCentrum = false;
                        booleanZuid = false;
                        booleanWest = false;
                        booleanOost = false;
                        booleanNoord = false;
                        booleanNieuwWest = false;
                        booleanZuidOost = false;
                        booleanWestpoort = false;
                        switch(intersects[i].object.name){
                            case "Centrum":
                                booleanCentrum = true;
                                break;
                            case "Zuid":
                                booleanZuid = true;
                                break;
                            case "West":
                                booleanWest = true;
                                break;
                            case "Oost":
                                booleanOost = true;
                                break;
                            case "Noord":
                                booleanNoord = true;
                                break;
                            case "NieuwWest":
                                booleanNieuwWest = true;
                                break;
                            case "ZuidOost":
                                booleanZuidOost = true;
                                break;
                            case "Westpoort":
                                booleanWestpoort = true;
                                break;
                            default:
                                console.log('not on object');
                        }
                        updateCheckBoxesCheck();
                        this.tl = new TimelineMax();
                        this.tl.to(intersects[i].object.scale, 1, {x: 2, ease: Expo.easeOut});
                        this.tl.to(intersects[i].object.scale, .5, {x: 1, ease: Expo.easeOut});
                    }
                }
                window.addEventListener('click', onMouseMove);
            }
        }


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
                    method: 'POST', // Type of response and matches what we said in the route
                    url: '{{ route('ajax-metric-update') }}', // This is the url we gave in the route
                    data: {'data' :  JSON.stringify(allVals)}, // a JSON object to send back
                    success: function(response){ // What to do if we succeed
                        if(display3dData) {
                            addDataToTable(response)
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }

        function addDataToTable(response_data){
            console.log(response_data);
            if(booleanCentrum === true){document.getElementById('insert_text_city_name').innerHTML = 'Centrum'}
            else if(booleanZuid === true){document.getElementById('insert_text_city_name').innerHTML = 'Zuid'}
            else if(booleanWest === true){document.getElementById('insert_text_city_name').innerHTML = 'West'}
            else if(booleanOost === true){document.getElementById('insert_text_city_name').innerHTML = 'Oost'}
            else if(booleanNoord === true){document.getElementById('insert_text_city_name').innerHTML = 'Noord'}
            else if(booleanNieuwWest === true){document.getElementById('insert_text_city_name').innerHTML = 'Nieuw-West'}
            else if(booleanZuidOost === true){document.getElementById('insert_text_city_name').innerHTML = 'Zuid-Oost'}
            else if(booleanWestpoort === true){document.getElementById('insert_text_city_name').innerHTML = 'Westpoort'}
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
    </script>
    <script>
        var quill = new Quill('#editor-container', {
            modules: {
                toolbar: true
            },
            placeholder: 'Compose an epic...',
            theme: 'snow'
        });

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

        function submit_form() {
            let about = document.querySelector('input[name=about]');
            about.value = quill.root.innerHTML;
            $('input[name=story_add_body_to_story_hidden_json]').val(JSON.stringify(quill.getContents()));
            document.getElementById('form_make_story').submit();
        }
    </script>
    <script>
        var slider_age = document.getElementById("form_slider_story_age");
        var output_age = document.getElementById("output_form_slider_story_age");
        output_age.innerHTML = slider_age.value;

        slider_age.oninput = function() {
            output_age.innerHTML = this.value;
        };

        var slider_weight = document.getElementById("form_slider_story_weight");
        var output_weight = document.getElementById("output_form_slider_story_weight");
        output_weight.innerHTML = slider_weight.value;

        slider_weight.oninput = function() {
            output_weight.innerHTML = this.value;
        };

        var slider_height = document.getElementById("form_slider_story_height");
        var output_height  = document.getElementById("output_form_slider_story_height");
        output_height.innerHTML = slider_height.value;

        slider_height.oninput = function() {
            output_height.innerHTML = this.value;
        };
    </script>
@endsection