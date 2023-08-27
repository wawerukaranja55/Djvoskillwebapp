
@extends('backend.adminmaster')
@section('title','Mpesa Payments')
@section('content')
<div class="row shadow mb-5 bg-black rounded">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <p id="registerurl" class="btn btn-success">Register Url</p>
            <p id="registeredurl"></p>
        </div>
        <div class="pull-right">
            <p id="generatetoken" class="btn btn-success">Generate Token</p>
            <p id="generatedtoken"></p>
        </div>
    </div>
</div>
@endsection

@section('mpesapaymentsscript')
    <script>
        $(document).on('click','#generatetoken',function(e){
            e.preventDefault();
            var url = '{{ route("get_AccessToken") }}';

            $.ajax({
                url:url,
                type:"GET",
                success:function(response){
                    var responseJSON = $.parseJSON(response)
                    $('#registeredurl').html(responseJSON.access_token);
                }
                ,error: function(error)
                {
                    console.error(error)
                }
            });
        })

        $(document).on('click','#registerurl',function(e){
            e.preventDefault();
            var url = '{{ route("register_URLs") }}';

            $.ajax({
                url:url,
                type:"post",
                success:function(response){
                    console.log(response);
                    //$('#registeredurl').html(responseJSON.access_token);
                }
                ,error: function(error)
                {
                    console.error(error)
                }
            });
        })
    </script>
@stop

