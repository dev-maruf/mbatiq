@extends('layouts.app')

@section('content')
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Switch                                
                            </h2>                            
                        </div>
                        <div class="body">                                                        
                            <input type="hidden" id="main-status" name="status" value="0">
                            <button type="button" id="main-btn" class="btn btn-success waves-effect">
                                <i class="material-icons">power_settings_new</i>
                                <span id="main-label">Switch On</span>                            
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-{{$temp['color']}}" id="temp" role="progressbar" aria-valuenow="{{$temp['val']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$temp['val']}}%;">
                                    {{$temp['val']}}&deg;C
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $( document ).ready(function() {
        var state = {{Auth::user()->machine}};
        changeView(state);        
    });

    function changeView($state){
        if($state == 0){
            $("#main-btn").removeClass("btn-danger").addClass("btn-success");
            $("#main-label").text("Switch On");
            $("#main-status").attr('value', '1');
        }
        else if($state == 1){
            $("#main-btn").removeClass("btn-success").addClass("btn-danger");
            $("#main-label").text("Switch Off");
            $("#main-status").attr('value', '0');
        }
    }
    
    $("#main-btn").click(function(){
        // console.log($("#main-status").val());
        changeState($("#main-status").val());
    });
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function changeState($state){        
        $.ajax({
            type:'POST',
            url:'{{route('change.state')}}',
            data:{
                state: $state
            },
            success:function(data){                
                console.log(data);
                changeView(data);
            },
            error: function(err){
                console.log(err);
            }
        });
    }

    var initialTempColor = "{{$temp['color']}}";

    setInterval(function () {
        $.getJSON('{{route('temp')}}', function (data) {
            var temp = data.val;
            var color = data.color;
            $('#temp').css('width', temp+'%').attr('aria-valuenow', temp);
            $('#temp').html(temp+"&deg;C");
            if(initialTempColor != color){
                initialTempColor = color;
                $('#temp').removeClass();
                $('#temp').addClass("progress-bar progress-bar-"+color);
            }
        });         
    }, 1000);
</script>
@endsection