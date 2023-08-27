<div class="allevents">
    <!-- content left -->
    <div class="row" style="margin-top: 10px;">
        @if ($allevents->isEmpty())
            <div class="col-lg-6">
                No event Found At the Moment
            </div>
        @else 
    
            @foreach ($allevents as $eventdet)
            <div class="col-md-4 col-sm-6">
                <div class="card card-list event_card">
                    @foreach ($eventdet->event_statuses as $status )
                        @if ($status->event_status_title === "Upcoming")
                            <span class="badge badge-primary badge-sm status_badge">{{ $status->event_status_title }}</span> 
                        @elseif ($status->event_status_title === "Happening Now")
                            <span class="badge badge-success badge-sm status_badge">{{ $status->event_status_title }}</span>
                        @elseif ($status->event_status_title === "Past Event")
                            <span class="badge badge-warning badge-sm status_badge">{{ $status->event_status_title }}</span>
                        @endif
                        
                     @endforeach
                     
                    <img class="card-img-top" src="{{ asset ('event_images/medium/'.$eventdet->event_flyer) }}" alt="{{ $eventdet->event_name }}"
                        style="width:inherit; height: auto; box-shadow: 0px 0px 7px 3px #b1adad; object-fit:cover;transition: all .3s ease;">
                    <div class="card-body" style="padding: 0px;">
                        <section class="events_body">
                            <div class="date">
                                <span class="eve_date">{{  Carbon\Carbon::createFromFormat('d.m.Y', $eventdet->event_date)->day }}</span>
                                <span class="eve_date">{{ 
                                date('M',strtotime(Carbon\Carbon::createFromFormat('d.m.Y', $eventdet->event_date)->Format('M')))
                                }}</span>
                            </div>
                            <div class="event_details">
                                <div class="card-footer" style="padding: 0px;">
                                    <section style="display: flex; flex-direction:column;">
                                        <div class="eve_dets">
                                            <h5 class="card-title" style="height: 20px; text-align:start;padding:3px;">
                                                {{ $eventdet->eventcategory->eventcategory_title }}</h5>
                                        </div>
                                        <div class="eve_dets" style="height: 80px;">
                                            <ul>
                                                <li><b class=" fa fa-location-arrow"></b> {{ $eventdet->event_location }}</li>
                                                <li><b class=" fa fa-clock"></b> {{ $eventdet->event_time }}</li>
                                            </ul>
                                        </div>
                                        <div class="eve_dets" style="display: flex; flex-direction:row; justify-content:space-between;">
                                            @if ($eventdet->is_ticket == 'yes')
                                                @foreach ($eventdet->event_statuses as $status )
                                                    @if ($status->event_status_title === "Past Event")
                                                        <button class="btn btn-warning btn-sm" style="padding:7px; background-color:black; cursor: not-allowed;">
                                                            <a href="http://127.0.0.1:8000/" role="button" style="color:white;pointer-events: none;">
                                                            Buy Ticket
                                                        </a></button>
                                                    @else
                                                        <button class="btn btn-warning btn-sm" style="padding:7px; background-color:black;">
                                                            <a href="http://127.0.0.1:8000/" role="button" style="color:white;">
                                                            Buy Ticket
                                                        </a></button>
                                                    @endif
                                                @endforeach
                                                
                                            @endif

                                            <button class="mouseovertomarker btn btn-warning btn-sm" marker-id="{{ $eventdet->id }}">Show On Map</button>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="d-flex justify-content-center pagination" style="margin-top: 100px;">
        {{ $allevents->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>