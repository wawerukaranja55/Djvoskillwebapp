@extends('backend.adminmaster')
@section('title','All Events')
@section('content')
@section('admin_eventsstyles')
    <style>
        .date-container {
            position: relative;
            float: left;
            .date-text {
            position: absolute;
            top: 6px;
            left: 12px;
            color: #aaa;
            }
            
            .date-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            /* pointer-events: none; */
            cursor: pointer;
            color: #aaa;
            }
        }
    </style>   
@stop

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="panel-heading mt-5 bg-dark p-2" style="text-align: center;">
                <p style="color: red; font_style:italicized;">To Add an Event Click its location on the map then proceed to add other details on the form</p>
                <h3 class="mb-2 panel-title" style="color: whitesmoke;">Events on The Map</h3> 
            </div>
            <div id="map" style="width: 100%; height: 500px; border:2px solid black;"></div>
        </div>
        <div class="col-lg-4">
            <div class="panel-heading mt-5 bg-dark p-2" style="text-align: center;"> 
                <h3 class="mb-2 panel-title" style="color: whitesmoke;">Event Form</h3> 
            </div>
            
            <div class="panel-body" style="height: 500px; border:2px solid green; overflow-y:scroll;">
                <div class="row p-2"  style="display:none;" id="editeventdetails">
                    <div class="col-md-6">
                        <div class="form-group" style="text-align: center">
                            {{-- <input type="button" name="editbuttonval" id="editbutton" class="btn text-light btn-success" placeholder="Edit Event/s"/> --}}
                            <button type="button" name="editbuttonval" id="editbutton" class="btn text-light btn-success">Edit Event/s</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="text-align: center">
                            <button type="button" id="addeventbutton" class="btn text-light btn-info">Add another Event for the Location</button>
                        </div>
                    </div>
                </div>
                <div class="row p-2 chooseevent" style="display:none;">
                    <div class="col-md-12">
                        <div class="form-group" >
                            <label>Events For that Location</label>
                            <br>
                            <select id="select_event" class="adminselect2 form-control text-white bg-dark" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                </div>
                <form id="addeventform" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="event_id" id="event_id">
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_longitude" class=" control-label">Event Longitude</label>
                                <input type="text" class="form-control text-white bg-dark" required name="event_longitude" id="event_longitude" readonly placeholder="Event Location Longitude">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_latitude" class=" control-label">Event Latitude</label>
                                <input type="text" class="form-control text-white bg-dark" required name="event_latitude" id="event_latitude" readonly placeholder="Event Location Latitude">
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_name" class=" control-label">Event Name</label>
                                <input type="text" class="form-control text-white bg-dark" name="event_name" id="event_name" placeholder="Event Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_location" class=" control-label">Event City/County</label>
                                <input type="text" class="form-control text-white bg-dark" name="event_location" id="event_location" placeholder="County/Town">
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_venue" class=" control-label">Event Venue</label>
                                <input type="text" class="form-control text-white bg-dark" name="event_venue" id="event_venue" placeholder="Event Venue">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_type" class=" control-label">Event Category</label>
                                <br>
                                <select id="event_type" name="event_type" class="adminselect2 form-control text-white bg-dark" style="width: 100%;">
                                    <option value=" " disabled selected>Select Event Category</option>
                                    @foreach($event_categories as $event_cat)
                                        <option value="{{ $event_cat->id }}">{{ $event_cat->eventcategory_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label class=" control-label">Event Has ticket?</label>
                                <div id="ticket_available">
                                    <label>
                                    <input type="radio" value="yes" name="is_ticket" class="is_ticket">
                                    Yes
                                    </label>
                                    <label>
                                    <input type="radio" value="no" name="is_ticket" class="is_ticket" checked>
                                    No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="purchasing_link">
                            <div class="form-group" style="text-align: center">
                                <label for="ticket_link" class=" control-label">Ticket Buying Link</label>
                                <input type="text" class="form-control text-white bg-dark" name="ticket_link" id="ticket_link" placeholder="Enter Ticket Buying Link">
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_date" class=" control-label">Event Date</label>
                                <div class="date_container">
                                    <input type="text" class="form-control text-white bg-dark" name="event_date" id='event_date_picker' readonly placeholder="Select Event Date Here">
                                    <span class="date-icon fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="text-align: center">
                                <label for="event_latitude" class=" control-label">Event Time</label>
                                <input type="text" class="form-control text-white bg-dark" required name="event_time" id="event_timepicker" readonly placeholder="Event Starting Time">
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-md-12">
                            <div class="form-group" style="text-align: center">
                                <label for="flyer" class=" control-label">Event Flyer</label>   
                            </div>
                            <div class="form-group" style="text-align: center">
                                <input onchange="loadFile(event)" id="event_flyer" type="file" name="event_flyer" accept="image/*" class="form-control text-white bg-dark">
                                <div id="eventimg">
                                    <input type="hidden" name="event_flyer" class="eventflyerimage"/>
                                    <img id="preview_event_flyer" style="height: 100px; width:100px;"/>
                                    {{-- <input type="hidden" name="event_flyer" class="eveimage"/> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="alert alert-warning d-none events_errorlist"></ul>
                    <div class="row p-2">
                        <div class="col-md-12">
                            <div class="form-group" style="text-align: center">
                                <button type="submit" class="btn btn-dark btn-block adminsubmitbtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <h3 class="mb-2 panel-title text-white" style="background:black; text-align:center; padding:10px;width:100%;">Upcoming Events</h3>
            <table id="eventstable" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Event Name</td>
                        <td>Event Category</td>
                        <td>Location</td>
                        <td>Date</td>
                        <td>Event Flyer</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection


@section('admineventsscript')
    
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('preview_event_flyer');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            }
        };

        //show all active events in a datatable
        var upcomingeventstable = $('#eventstable').DataTable({
            processing:true,
            serverside:true,
            responsive:true,

            ajax:"{{ route('admin.getallevents') }}",
            columns: [
                { data: 'id' },
                { data: 'event_name' },
                { data: 'eventcat_id', name:'eventcat_id.eventcategory.eventcategory_title', orderable:true,searchable:true},
                { data: 'event_venue' },
                { data: 'event_date' },
                { data: 'event_flyer',
                    render: function ( data, type, full, meta, row) {
                    return "<img src=\"/event_images/medium/" + data + "\" width=\"100\" height=\"200\"/>"
                    }
                }, 
                { data:
                    function (row) {
                    let eventstatus= [];
                    $(row.event_statuses).each(function (i, e) {
                        eventstatus.push(e.event_status_title);
                        });
                        return '<input readonly=" " class="eventstatus bg-dark text-white" style="width:100px;" value="' + eventstatus + '" data-id="' + row.id + '"><br><button type="button" value="' + row.id + '" style="width:100px;" class="btn-primary changeeventstatus">Change Status</button>';
                    }, name: 'event_statuses.event_status_title'
                },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],
        });

        // map scripts
        var defaultLocation = [-1.286389,36.817223]

        var map = L.map('map')
            .setView(defaultLocation, 13);
            //.center(defaultLocation);

            var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            }).addTo(map);    
        // var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 19,
        //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        // }).addTo(map);

        var marker = new L.Marker([-1.2787474907651892,36.821225881576545]);
        marker.addTo(map);

        L.Control.geocoder().addTo(map);

        var eventsurl = '{{ route("admin.getevents") }}';  
        $.ajax({
            url:eventsurl,
            type:"GET",
            dataType:"json",
            success:function(response){

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
                }).addTo(map).on('click', changeDeleteEventDetails);
                //var geolayer = L.geoJSON(geoJsondata).addTo(map);

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

        //mouse over to the marker on the map
        $(document).on('click','.mousetomarker',function()
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


        //get event id using its cordinates
        function changeDeleteEventDetails(e) {

            $('#event_longitude').val('');
            $('#event_latitude').val('');
            $('#event_id').val('');
            $('#event_name').val('');
            $('#event_location').val('');
            $('#event_date_picker').val('');
            $('#event_timepicker').val('');
            $('.eventflyerimage').val('');
            $( "#preview_event_flyer" ).attr('src',' ');
            $('input[name^="is_ticket"]').prop('checked', false);
            $('#event_venue').val('');
            $('#ticket_link').val('');
            $("#event_type").val('');
            $('.chooseevent').hide();

            
            var event_latitude=e.latlng.lat
            var event_longitude=e.latlng.lng
            $('#editeventdetails').show();
            $('#event_longitude').val(event_longitude);
            $('#event_latitude').val(event_latitude);

            var event_cordinates = [event_latitude,event_longitude];

            $('#editbutton').val(event_cordinates);

            //$('#addeventbutton').val(event_cordinates);
            
        }

        map.on('click',(e) =>{

            $('#editeventdetails').hide();

            var longitude = e.latlng.lng
            var latitude = e.latlng.lat
            
            $('#event_longitude').val('');
            $('#event_latitude').val('');
            $('#event_id').val('');
            $('#event_name').val('');
            $('#event_location').val('');
            $('#event_date_picker').val('');
            $('#event_timepicker').val('');
            $('.eventflyerimage').val('');
            $( "#preview_event_flyer" ).attr('src',' ');

            $('#event_longitude').val(longitude);
            $('#event_latitude').val(latitude);
        })

        var loadLocations = () =>
        {
            var eventsurl = '{{ route("admin.getevents") }}';  
            $.ajax({
                url:eventsurl,
                type:"GET",
                dataType:"json",
                success:function(response){

                    function onEachFeature(feature, layer) {
                        // does this feature have a property named popupContent?
                        if (feature.properties) {
                            layer.bindPopup(`
                            <div style="overflow-y:auto; max-height:500px; width:200px;">
                                <table class="table table-sm mt-2">
                                    <tbody>
                                        <tr><td>Location Id</td><td>${ feature.locationId }</td></tr>
                                        <tr><td>Title</td><td>${ feature.properties.name }</td></tr>
                                        <tr><td>Flyer</td><td><img src="${ feature.properties.image }" class="img-fluid" style="width:100px; height:100px;"/></td></tr>
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
                    //var geolayer = L.geoJSON(geoJsondata).addTo(map);

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
        }

        $(document).ready(function(){



            $('.chooseevent').hide();

            $('#purchasing_link').hide()

            $(function() {
                $('#event_date_picker').datepicker({
                    dateFormat: 'dd.mm.yy',
                    minDate: 0,
                    calendarWeeks: true,
                    autoclose: true,
                    todayHighlight: true,
                    rtl: true,
                    orientation: "auto",
                    changeMonth: true,
                    changeYear: true,
                });
                
                $('.date-icon').on('click', function() {
                    $('#event_date_picker').focus();
                })
            });

            $('#event_timepicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 60,
                startTime: '6:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });

            $("input[type='radio'][name='is_ticket']").change(function() {
                if ($(this).is(":checked")) {
                    var checkedval=($(this).val());

                    if (checkedval=="yes")
                    {
                        $('#purchasing_link').show();
                    } else {
                        $('#purchasing_link').hide();
                    }

                }
            });

            $('#select_event').change(function(){
                var selected_eventid=$(this).val();

                $.ajax({
                type:'GET',
                url:'{{ route('admin.geteventdetails') }}',
                data:{
                    'event_id':selected_eventid
                },
                success:function(res){ 
                    
                    $('#event_id').val('');
                    $('#event_name').val('');
                    $('#event_location').val('');
                    $('#event_date_picker').val('');
                    $('#event_timepicker').val('');
                    $('.eventflyerimage').val('');
                    $( "#preview_event_flyer" ).attr('src',' ');
                    $('input[name^="is_ticket"]').prop('checked', false);
                    $('#event_venue').val('');
                    $('#ticket_link').val('');
                    $("#event_type").val('');


                        console.log(res);
                        $('#event_id').val(res.id);
                        $('#event_name').val(res.event_name);
                        $('#event_location').val(res.event_location);
                        $('#event_date_picker').val(res.event_date);
                        $('#event_timepicker').val(res.event_time);
                        $("#event_type").val(res.eventcat_id).trigger('change');
                        $('input[name^="is_ticket"][value="' + res.is_ticket + '"]').prop('checked', true);
                        $('.eventflyerimage').val(res.event_flyer);
                        $('#event_venue').val(res.event_venue);
                        var showimage=$('#preview_event_flyer').attr('src', '/event_images/small/' + res.event_flyer);
                        $('#eventimg').append(showimage);
                        
                        if (res.is_ticket == "yes")
                        {
                            $('#purchasing_link').show();
                            $('#ticket_link').val(res.ticket_link);
                        }
                }
                });
            });
        });

        //store an event to the database
        $(document).on('submit','#addeventform',function(e){
            e.preventDefault();

            var url = '{{ route("admin.postevent") }}';
            var form = $('#addeventform')[0];
            var formdata=new FormData(form);

            // AJAX request 
            $.ajax({
                url:url,
                method:'POST',
                processData:false,
                contentType:false,
                data:formdata,
                success:function(response){
                    console.log(response);
                    $('.events_errorlist').html(" ");

                    if (response.status==200)
                    {
                        loadLocations();

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);

                        //empty the inputs
                        $('#event_longitude').val('');
                        $('#event_latitude').val('');
                        $('#event_id').val('');
                        $('#event_name').val('');
                        $('#event_type').val('');
                        $('#event_venue').val('');
                        $('.is_ticket').prop('checked', false);
                        $('#event_location').val('');
                        $('#event_date_picker').val('');
                        $('#event_timepicker').val('');
                        $('.eventflyerimage').val('');

                        $( "#preview_event_flyer" ).attr('src',' ');
                        $('.chooseevent').hide();

                        upcomingeventstable.ajax.reload( null, false );
                    } 
                    else if (response.status==500)
                    {
                        $('.events_errorlist').html(" ");
                        $('.events_errorlist').removeClass('d-none');
                        $.each(response.message,function(key,err_value)
                        {
                            $('.events_errorlist').append('<li>' + err_value + '</li>');
                        })
                    }
                    else if (response.status==450)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message); 
                    }

                }
            });
        });

        //on click of edit button get it details to edit
        $(document).on('click','#editbutton',function()
        {
            var eve_cordins=$(this).val();

            var cords_array = eve_cordins.split(",");

            var event_latitude = cords_array[0];
            var event_longitude = cords_array[1];

            var eventurl = '{{ route("admin.eventdetails") }}'; 
            
            $.ajax({
                url:eventurl,
                type:"GET",
                data:{
                    'lat':event_latitude,
                    'longt':event_longitude
                },
                dataType:"json",
                success:function(response){
                    console.log(response.activeevents[0]);
                    $('#event_longitude').val(event_longitude);
                    $('#event_latitude').val(event_latitude);

                    if (response.eventscount>1)
                    {
                        $('#event_longitude').val('');
                        $('#event_latitude').val('');
                        $('#event_id').val('');
                        $('#event_name').val('');
                        $('#event_location').val('');
                        $('#event_date_picker').val('');
                        $('#event_timepicker').val('');
                        $('.eventflyerimage').val('');
                        $( "#preview_event_flyer" ).attr('src',' ');
                        $('input[name^="is_ticket"]').prop('checked', false);
                        $('#event_venue').val('');
                        $('#ticket_link').val('');
                        $("#event_type").val('');

                        $('.chooseevent').show();

                        //append dropdown to select event for editing event details
                        $('#select_event').html('<option disabled selected value=" ">Select The Event to Edit</option>');
                        
                        console.log("the data is ",response.activeevents);
                        response.activeevents.forEach((event)=>{
                            $('#select_event').append('<option value="'+event.id+'">'+event.event_name+'</option>');
                        });
                        $('#event_longitude').val(event_longitude);
                        $('#event_latitude').val(event_latitude);
                        
                        //upon selecting auto fill it details in the form

                    } else {

                        $('#event_id').val('');
                        $('#event_name').val('');
                        $('#event_location').val('');
                        $('#event_date_picker').val('');
                        $('#event_timepicker').val('');
                        $('.eventflyerimage').val('');
                        $( "#preview_event_flyer" ).attr('src',' ');
                        $('input[name^="is_ticket"]').prop('checked', false);
                        $('#event_venue').val('');
                        $('#ticket_link').val('');
                        $("#event_type").val('');
                        $('.chooseevent').hide();

                        //autofillform with editing data
                        $('#event_id').val(response.activeevents[0].id);
                        $('#event_name').val(response.activeevents[0].event_name);
                        $('#event_location').val(response.activeevents[0].event_location);
                        $('#event_date_picker').val(response.activeevents[0].event_date);
                        $('#event_timepicker').val(response.activeevents[0].event_time);
                        $("#event_type").val(response.activeevents[0].eventcat_id).trigger('change');
                        $('input[name^="is_ticket"][value="' + response.activeevents[0].is_ticket + '"]').prop('checked', true);
                        $('.eventflyerimage').val(response.activeevents[0].event_flyer);
                        $('#event_venue').val(response.activeevents[0].event_venue);
                        var showimage=$('#preview_event_flyer').attr('src', '/event_images/small/' + response.activeevents[0].event_flyer);
                        $('#eventimg').append(showimage);

                        if (response.activeevents[0].is_ticket == "yes")
                        {
                            $('#purchasing_link').show();
                            $('#ticket_link').val(response.activeevents[0].ticket_link);
                        }
                    }
                }
            })
        });

        //on click of add button get it details to edit
        $(document).on('click','#addeventbutton',function()
        {
            $('.chooseevent').hide();

            $('#event_id').val('');
            $('#event_name').val('');
            $('#event_location').val('');
            $('#event_date_picker').val('');
            $('#event_timepicker').val('');
            $('.eventflyerimage').val('');
            $( "#preview_event_flyer" ).attr('src',' ');
            $('input[name^="is_ticket"]').prop('checked', false);
            $('#event_venue').val('');
            $('#ticket_link').val('');
            $("#event_type").val('');
        });

        //on click of the chnge status btn show modal for changing status
        $(document).on('click','.changeeventstatus',function(e){
            e.preventDefault();

            var event_id=$(this).val();

            $('#event_status_id').val(event_id);
            
            var url = '{{ route("admin.geteventstatus", ":id") }}';
                    url = url.replace(':id', event_id);
            $('#changeeventstatusmodal').modal('show');

            $.ajax({
                type:"GET",
                url:url,
                processData: false,
                contentType: false,
                success:function(response)
                {
                    console.log(response.eventdata.event_statuses[0].id);
                    if (response.status==200)
                    {
                        $('#event_status_name').val(response.eventdata.event_name);
                        $('#event_status_date').val(response.eventdata.event_date);
                        $('#eventstatus').append('<option value="' + response.eventdata.event_statuses[0].id + '">' + response.eventdata.event_statuses[0].event_status_title + '</option>').attr("selected", "selected","disabled");
                        $('#eventstatus').append('<option value="3">Postpone</option>');
                        $('#eventstatus').append('<option value="4">Cancel</option>');
                    }
                }
            })
        })

        //update event status from upcoming
        $(document).on('submit','#changeeventstatusform',function(e){
            e.preventDefault();

            var url = '{{ route("admin.changeeventstatus") }}';
            var form = $('#changeeventstatusform')[0];
            var formdata=new FormData(form);

            // AJAX request 
            $.ajax({
                url:url,
                method:'POST',
                processData:false,
                contentType:false,
                data:formdata,
                success:function(response){
                    console.log(response);
                    $('.events_errorlist').html(" ");

                    if (response.status==200)
                    {

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);

                        //empty the inputs
                        $('#event_status_id').val('');
                        $('#event_status_name').val('');
                        $('#event_status_date').val('');
                        $('#eventstatus').html('');

                        $('#changeeventstatusmodal').modal('hide');
                        upcomingeventstable.ajax.reload( null, false );
                    } 
                    else if (response.status==500)
                    {
                        $('.events_errorlist').html(" ");
                        $('.events_errorlist').removeClass('d-none');
                        $.each(response.message,function(key,err_value)
                        {
                            $('.events_errorlist').append('<li>' + err_value + '</li>');
                        })
                    }

                }
            });
        });
        
    </script>
@stop