<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Event_cord;
use App\Models\Events_Model;
use Illuminate\Http\Request;
use App\Models\Event_category;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Events_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events()
    {
        $event_categories=Event_category::get();

        return view('backend.events.allevents',compact('event_categories'))->with(request()->input('page'));
    }

    // show all events in a datatable
    public function getallevents(Request $request)
    {
        $all_events=Events::with(['event_statuses']);

        if($request->ajax()){
            $all_events = DataTables::of ($all_events)

            ->addColumn ('eventcat_id',function(Events $event){
                return $event->eventcategory->eventcategory_title;
            })

            ->addColumn ('action',function($row){
                return 
                    '<button type="button" title="Mouse over to the marker on map" marker-id='.$row->id.' class="mousetomarker btn-sm btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                    //  <a href="downloaduserpayments/'.$row->id.'" id="Download Payment" title="Download All Payments Made by the Tenant" class="btn btn-danger"><i class="fa fa-download"></i></a>;
            })

            ->rawColumns(['eventcat_id','action'])
            ->make(true);

            return $all_events;
        }
    }

    public function getevents()
    {
        $getevents = Events::orderby('created_at','desc')->get();

        $customevents = [];
        foreach($getevents as $event)
        {
            $customevents[] =
            [
                'type' => 'Feature',
                    'properties' => 
                    [
                        'name' => $event->event_name,
                        'location' => $event->event_location,
                        'image'  => $event->event_flyer,
                    ],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $event->location_longitude, 
                            $event->location_latitude
                        ]
                    ],
                    'locationId' => $event->id
            ];
        }

        $geolocation = [
            'type' => 'FeatureCollection',
            'features' => $customevents
        ];

        $geoJsondata = collect($geolocation);

        return response()->json([
            'geoJsondata'=>$geoJsondata
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_event()
    {
        return view ('backend.events.addevent'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_event(Request $request)
    {
        $data=$request->all();
        
        $rules=[
            'event_name'=>'required',
            'event_date'=>'required',
            'event_location'=>'required',
            'event_time'=>'required',
            'event_type'=>'required',
            'event_venue'=>'required',
            'is_ticket'=>'required',
            'ticket_link' => 'required_if:is_ticket,==,yes',
            'event_flyer'=>'required|max:4000'
        ];

        $custommessages=[
            'event_name.required'=>'Write The Event Name',
            'event_date.required'=>'Select the Date for the Event',
            'event_time.required'=>'Select The Event the Event will Start',
            'event_venue.required'=>'Write The Name of the Venue where the event will Occur',
            'event_type.required'=>'Select the Type of the Event',
            'is_ticket.required'=>'Select whether the event has tickets to purchase',
            'ticket_link.required'=>'Enter the link to purchase tickets from',
            'event_location.required'=>'Write the Name of County The Event will Take Place',
            'event_flyer.required'=>'The Event Flyer is Blank',
            'event_flyer.max'=>'The Image Should not be Above 2mb'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>500,
                'message'=>$validator->errors()
            ]);

        } else {

            //check if the time booked is available
            $timeavailable=Events::where([
                'event_time'=>$data['event_time'],
                'location_longitude'=>$data['event_longitude'],
                'location_latitude'=>$data['event_latitude'],
                'event_date'=>$data['event_date'],
                'is_active'=>1])->count();

            if($timeavailable>0)
            {
                $message="The Time Belongs for another Event on that Date.Kindly check the time Again";
    
                return response()->json([
                    'status'=>450,
                    'message'=>$message
                ]);
            } else {
    
                if($data['event_id'])
                {
                    $event_details=Events::find($data['event_id']);
                    
                    if($request->hasFile('event_flyer')){
                        $imagetmp=$request->file('event_flyer');
                        if($imagetmp->isValid()){
                            $extension=$imagetmp->getClientOriginalExtension();
                            $image_name=$request->get('event_name').'-'.rand(111,9999).'.'.$extension;
        
                            $large_image_path='event_images/large/'.$image_name;
                            $medium_image_path='event_images/medium/'.$image_name;
                            $small_image_path='event_images/small/'.$image_name;
        
                            Image::make($imagetmp)->resize(1040,1200)->save($large_image_path);
                            Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                            Image::make($imagetmp)->resize(260,300)->save($small_image_path);
        
                        }
                    } else {
                        $image_name=$data['event_flyer'];

                    }

                    $event_details->update([
                        'event_name'=>$data['event_name'],
                        'event_date'=>$data['event_date'],
                        'event_time'=>$data['event_time'],
                        'event_venue'=>$data['event_venue'],
                        'eventcat_id'=>$data['event_type'],
                        'is_ticket'=>$data['is_ticket'],
                        'ticket_link'=>$data['ticket_link'],
                        'location_latitude'=>$data['event_latitude'],
                        'location_longitude'=>$data['event_longitude'],
                        'event_location'=>$data['event_location'],
                        'event_flyer'=>$image_name
                    ]);
        
                    $message="Event Details Have Been Updated Successfuly .";
                    return response()->json([
                        'status'=>200,
                        'message'=>$message
                    ]);
                } else {

                    if($request->hasFile('event_flyer')){
                        $imagetmp=$request->file('event_flyer');
                        if($imagetmp->isValid()){
                            $extension=$imagetmp->getClientOriginalExtension();
                            $image_name=$request->get('event_name').'-'.rand(111,9999).'.'.$extension;
        
                            $large_image_path='event_images/large/'.$image_name;
                            $medium_image_path='event_images/medium/'.$image_name;
                            $small_image_path='event_images/small/'.$image_name;
        
                            Image::make($imagetmp)->resize(1040,1200)->save($large_image_path);
                            Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                            Image::make($imagetmp)->resize(260,300)->save($small_image_path);
        
                        }
                    }

                    $event=new Events();
                    $event->event_name=$data['event_name'];
                    $event->event_date=$data['event_date'];
                    $event->event_time=$data['event_time'];
                    $event->event_venue=$data['event_venue'];
                    $event->eventcat_id=$data['event_type'];
                    $event->event_location=$data['event_location'];
                    $event->is_ticket=$data['is_ticket'];
                    $event->ticket_link=$data['ticket_link'];
                    $event->location_latitude=$data['event_latitude'];
                    $event->location_longitude=$data['event_longitude'];
                    $event->event_flyer=$image_name;
                    $event->save();
                    $event->event_statuses()->attach(1);

                    $event_location=new Event_cord();
                    $event_location->event_id=$event->id;
                    $event_location->location_latitude=$data['event_latitude'];
                    $event_location->location_longitude=$data['event_longitude'];
                    $event_location->save();

                    $event_location->eventcords()->attach($event->id);
        
                    $message="Event Has Been Saved In the DB Successfully.";
        
                    return response()->json([
                        'status'=>200,
                        'message'=>$message
                    ]);
                }
            }
            
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getevent(Request $request)
    {
        //get the events in that locationthat are active
        $activeeventsforthelocation=Events::where(['location_longitude'=>$request->longt,'location_latitude'=>$request->lat,'is_active'=>1])->get();

        $numberofevents=$activeeventsforthelocation->count();

        return response()->json([
            'eventscount'=>$numberofevents,
            'activeevents'=>$activeeventsforthelocation
        ]);
    }

    // show the event details when selected
    public function geteventdetails(Request $request)
    {
        $selectedeventdetails=Events::where(['id'=>$request->event_id])->first();

        return response()->json($selectedeventdetails);

    }

    //get cordinates for the id
    public function getcords_forid(Request $request)
    {
        $cordsforid=Events::select('location_latitude','location_longitude')->where(['id'=>$request->marker_id])->first();

        return response()->json($cordsforid);

    }


    //update event status 
    public function getevent_status($id)
    {
        $eventdata=Events::with('event_statuses')->select('id','event_name','event_date')->find($id);
        
        if($eventdata)
        {
            return response()->json([
                'status'=>200,
                'eventdata'=>$eventdata
            ]);
        }
    }

    //update event status 
    public function changeevent_status(Request $request)
    {
        $data=$request->all();
        $rules=[
            'eventstatus'=>'required'
        ];

        $custommessages=[
            'eventstatus.required'=>'Kindly Select The Event Status'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>500,
                'message'=>$validator->errors()
            ]);

        } else {

            $event_details=Events::find($data['event_status_id']);
            $event_details->event_statuses()->sync($data['eventstatus']);
        
            $message="Event Status Have Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
            
        } 
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData=Events::FindorFail($id);
        $deleteData->delete();
        return redirect()->route ('events.index')->with ('success','Event has Been Deleted Successfully');
    }
}
