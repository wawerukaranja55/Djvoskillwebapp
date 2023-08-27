// js back up codes
//store an event to the database
$("#addeventform").on("submit",function(e){
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
$("#editbutton").on('click',function()
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
$("#addeventbutton").on('click',function()
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

// geojson data
var geoJsondata = {
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {
                "name": "Example 1",
                "amenity": "Baseball Stadium",
                "image": "https://images.unsplash.com/photo-1688976694262-89230d6133ba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3fHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60",
                "popupContent": "This is where the Rockies play!"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    36.814756393432624, 
                    -1.282469592705857
                ]
            },
            "locationId": 1
        },
        {
            "type": "Feature",
            "properties": {
                "name": "Example 2",
                "amenity": "Baseball Stadium",
                "iconSize": [50, 50],
                "image": "https://images.unsplash.com/photo-1688728981543-df24d24d0116?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyNXx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
                "popupContent": "This is where the Rockies play!"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    36.816703677177436,
                    -1.2842580516508735
            ]
            },
            "locationId": 2
        },
        {
            "type": "Feature",
            "properties": {
                "name": "Example 3",
                "amenity": "Baseball Stadium",
                "iconSize": [50, 50],
                "image": "https://images.unsplash.com/photo-1688966838599-05e6cf6628cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwzMnx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
                "popupContent": "This is where the Rockies play!"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    36.81707382202149,
                    -1.2815256914612605
            ]
            },
            "locationId": 3
        },
        {
            "type": "Feature",
            "properties": {
                "name": "Example 4",
                "amenity": "Baseball Stadium",
                "iconSize": [50, 50],
                "image": "https://images.unsplash.com/photo-1688970462384-9bbafab3204d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1NXx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
                "popupContent": "This is where the Rockies play!"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    36.81891918182374,
                    -1.2806246944941864
                ]
            },
            "locationId": 4
        },
        {
            "type": "Feature",
            "properties": {
                "name": "Example 5",
                "amenity": "Baseball Stadium",
                "iconSize": [50, 50],
                "image": "https://images.unsplash.com/photo-1688890239634-86a95e80c3ed?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3OXx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
                "popupContent": "This is where the Rockies play!"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [36.81969165802003,-1.2926808656809894, ]
            },
            "locationId": 5
        }
    ]
}