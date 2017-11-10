@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->name }}, This is the Timer-Tracking page
                </div>
                    
                <div class="panel-body">
                
                    <div class="row">
                        <div class="col-sm-4"><h3>Action</h3></div>
                        <div class="col-sm-4"><h3></h3></div>
                        <div class="col-sm-4"><h3></h3></div>
                    </div>
                
                    {{ Form::open() }}
                    <div class="row">
                        <div class="col-sm-4">
                        
                            <select name="form-track-fields" id="form-track-fields">
                                <option>*Choose field*</option>
                                @foreach ($userFields as $k => $u)
                                    <option value="{{ $u->id }}">{{ $u->getField->name }}</option>
                                @endforeach
                            </select>
                            <select name="form-track-habits" id="form-track-habits">
                            </select>
                                
                        </div>
                        <div class="col-sm-4">{{ Form::submit('Start Work', ['class' => 'btn btn-sm btn-success']) }}</div>
                        <div class="col-sm-4"></div>
                    </div>

                    <br />
                    
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                    </div> 
                    
                    {{ Form::close() }}
                    
                            
                        
                    <div id="habits-block" style="display: inline-block;width:100%">
                        Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. Tere 123, See on lause. 
                        
                        @foreach ($openLogs as $u)
                          @foreach ($u as $a)
                            <p> {{ $a->id }} </p>
                          @endforeach
                        @endforeach
                        
                    </div>
                    
                </div>
                
                    <div id="ajax-box" style="display: inline-block;"></div>
                    <div id="ajax-box2" style="display: inline-block;"></div>
                
            </div>
                <pre></pre>
        </div>
    </div>
</div>
@endsection
