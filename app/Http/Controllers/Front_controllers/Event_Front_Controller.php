<?php

namespace App\Http\Controllers\Front_controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Event_Front_Controller extends Controller
{
    public function events (){
        
        // $events=Events::orderby('id','desc')->paginate(4);
        // return view('frontend.events.events',['events'=>$events]);

        $allevents=Events::with('event_statuses','eventcategory')->orderby('id','DESC')->paginate(6);
        
        return view('frontend.events.events',compact('allevents'));
    }

    public function get_first_events()
    {
        $allevents=Events::with('event_statuses','eventcategory')->orderby('id','DESC')->paginate(6);

        $customevents = [];
        foreach($allevents as $event)
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

    public function get_more_events (){
        
        $allevents=Events::with('event_statuses','eventcategory')->orderby('id','DESC')->paginate(6);

        $customevents = [];
        foreach($allevents as $event)
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

        $view = view('frontend.events.eventsjson',compact('allevents'))->render();
        return response()->json([
            'geoJsondata'=>$geoJsondata,
            'view'=>$view
        ]);
        
    }
}
