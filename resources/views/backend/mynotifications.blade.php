@extends('backend.adminmaster')
@section('title','My Notifications')
@section('content')
    <div class="content-wrapper">
        my notifiations
        <div class="row">
            <div class="col-lg-12">
                <div class="box shadow-sm rounded bg-white mb-3">
                    <div class="box-title border-bottom p-3">
                        <h6 class="m-0">Recent Notifications</h6>
                    </div>
                    <div class="box-body p-0">
                        <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header shadow p-3 mb-5 bg-white rounded">
                            <div class="font-weight-bold mr-3 ">
                                <div class="text-truncate">DAILY RUNDOWN: WEDNESDAY</div>
                                <div class="small">Income tax sops on the cards, The bias in VC funding, and other top news for you</div>
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    </div>
                                </div>
                                <br />
                                <div class="text-right text-muted pt-1">3d</div>
                            </span>
                        </div>
                        <div class="p-3 d-flex align-items-center osahan-post-header">
                            <div class="font-weight-bold mr-3">
                                <div class="mb-2">We found a job at askbootstrap Ltd that you may be interested in Vivamus imperdiet venenatis est...</div>
                                <button type="button" class="btn btn-outline-success btn-sm">View Jobs</button>
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                    </div>
                                </div>
                                <br />
                                <div class="text-right text-muted pt-1">4d</div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <ul>
            @foreach ($notifications as $notification )
            <li>
                @if ($notification->type='App\Notifications\Newbookingreceived')

                A New Booking has been received
                <strong> {{ $notification->data['bookingstatus']['full_name']}}</strong>

                <a href="{{ route('requestdeposit',$notification->data['bookingstatus']['id']) }}"> View The Booking</a>
                    
                @endif
            </li> 
            @endforeach
        </ul> --}}
    </div>
@endsection