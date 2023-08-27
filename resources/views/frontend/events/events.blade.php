
@extends('frontend.master')
@section('title','Voskill Events')
@section('content')
@section('front_eventsstyles')
    <style>
        /* .leaflet-layer {
            position: absolute;
            left: 0;
            top: 0;
            
        } */

        .event_card{
            margin: 10px;
            box-shadow: 0px 0px 7px 3px #d3b8b8;
            position:relative;
            transition: transform 1s;
        }

        .event_card img:hover {
            
            transform: scale(1.5);
            z-index:999;
        }

        .status_badge{
            position: absolute;
            top: 3px;
            left: 3px;
            width: 40%;
            font-size: 14px;
            margin: 2px;
        }

        .events_body
        {
           display: flex;
           height:150px;
        }
        .date{
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .eve_date:first-child{
            background-color: #e40f84;
        }
        .eve_date{
            padding: 20%;
            text-align: center;
            width: 60px;
            height:50px;
            font-size: 14px;
            color: white;
            background-color: #050405
        }
        .event_details{
            flex: 4;
        }

        .eve_dets ul{
            padding-left: 2px;
        }

        .eve_dets ul li{
            list-style-type: none;
        }
    </style>   
@stop

<!-- START SCHEDULE -->
<section id="schedule" class="section-padding" style="border: 2px solid black;">
    <div class="container">
        <div id="mapid" class="map map-home" style="width:100%; height:500px; margin-top: 50px z-index:-9.999;overflow: hidden;"></div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h3>Events Schedule</h3>
                    <span></span>
                    <p>This are all our upcoming Events and Tv shows</p>
                </div>
            </div>
            <!-- end col -->
            <div class="container">
                <div class="showallevents">
                    @include('frontend.events.eventsjson')
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!--- END ROW -->
    </div>
    <!--- END CONTAINER -->
</section>
<!-- END SCHEDULE -->

@endsection

@section('eventspagescripts')

<script type="text/javascript">

    var defaultLocation = [-1.286389,36.817223]
    var map = L.map('mapid')
    .setView(defaultLocation, 13);
            //.center(defaultLocation);

    //var layerGroup = L.layerGroup().addTo(map);
    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    }).addTo(map);

    var marker = new L.Marker([-1.2787474907651892,36.821225881576545]);
    marker.addTo(map);

    var firsteventsurl = '{{ route("events.get-first-events") }}'; 
    // layerGroup.clearLayers();
    $.ajax({
        url:firsteventsurl,
        type:"GET",
        dataType:"json",
        success:function(response){

            console.log(response);
            function onEachFeature(feature, layer) {
                // does this feature have a property named popupContent?
                if (feature.properties) {
                    layer.bindPopup(`
                    <div style="overflow-y:auto; max-height:500px; width:200px;">
                        <table class="table table-sm mt-2">
                            <tbody>
                                <tr><td>Location Id</td><td>${ feature.locationId }</td></tr>
                                <tr><td>Title</td><td>${ feature.properties.name }</td></tr>
                                <tr><td>Flyer</td><td><img src='event_images/medium/${ feature.properties.image }' class="img-fluid" style="width:100px; height:100px;"/></td></tr>
                                <tr><td>Venue</td><td>${ feature.properties.location }</td></tr>
                            </tbody>
                        </table>
                    </div>`
                    );
                }
            }

            var geolayer = L.geoJSON(response.geoJsondata, {
                onEachFeature: onEachFeature
            }).addTo(map);

            map.fitBounds(geolayer.getBounds())

        },
        error:function(response){
            console.log(response);
            if(error){
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
            }
        }
    });

    var removeMarkers = function() {
        map.eachLayer( function(layer) {

            map.removeLayer(layer)

        });
    }


    //mouse over to the marker on the map
    $(document).on('click','.mouseovertomarker',function()
    {
        var markerid=$(this).attr("marker-id");

        var url = '{{ route("admin.getcords") }}';  
        $.ajax({
            method:'get',
            url:url,
            dataType:'json',
            data:{
                marker_id:markerid,
            },
            success:function(data){
                console.log(data.location_latitude);
                map.flyTo([data.location_latitude,data.location_longitude],20)
            }
        })
    })

    $(document).ready(function(){

        // change pagination using ajax jquery
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            var page = $(this).attr('href').split('page=')[1];

            getMoreEvents(page)
        });
    });

    function getMoreEvents(page)
        {
            $.ajax({
                type:"GET",
                url:'{{ route("events.get-more-events") }}' + "?page=" + page,
                data:{
                    
                },
                success:function(data)
                {
                    removeMarkers();

                    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                        maxZoom: 20,
                        subdomains:['mt0','mt1','mt2','mt3']
                    }).addTo(map);

                    console.log(data);
                    $('.showallevents').html(data.view);

                    function onEachFeature(feature, layer) {
                    // does this feature have a property named popupContent?
                    if (feature.properties) {
                        layer.bindPopup(`
                        <div style="overflow-y:auto; max-height:500px; width:200px;">
                            <table class="table table-sm mt-2">
                                <tbody>
                                    <tr><td>Location Id</td><td>${ feature.locationId }</td></tr>
                                    <tr><td>Title</td><td>${ feature.properties.name }</td></tr>
                                    <tr><td>Flyer</td><td><img src='event_images/medium/${ feature.properties.image }' class="img-fluid" style="width:100px; height:100px;"/></td></tr>
                                    <tr><td>Venue</td><td>${ feature.properties.location }</td></tr>
                                </tbody>
                            </table>
                        </div>`
                        );
                    }
                }

                var geolayer = L.geoJSON(data.geoJsondata, {
                    onEachFeature: onEachFeature
                }).addTo(map);
                //var geolayer = L.geoJSON(geoJsondata).addTo(map);

                map.fitBounds(geolayer.getBounds())
                }
            })
        }
    
    
</script>
@stop