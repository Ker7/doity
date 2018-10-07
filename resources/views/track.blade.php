@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->name }}, This is the tracking page.                    
                </div>
                    
                <div class="panel-body">
                
                    <div class="row">
                        <div class="col-sm-4"><h3>Did what?</h3></div>
                        <div class="col-sm-4"><h3>How much/long?</h3></div>
                        <div class="col-sm-4"><h3>When?</h3></div>
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
                        <div class="col-sm-4">
                            
                            <input type="number" name="habit-value" step="any" width=8 /> <span id="form-track-unit-name"></span>
                            
                        </div>
                        <div class="col-sm-4">
                        
                            {{ Form::date('date', \Carbon\Carbon::now()->timezone('Europe/Tallinn')) }}
                            {{ Form::time('time', $nowTime) }}
                        
                        </div>
                    </div>

                    <br />
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <h5>Tags ::</h5>
                            <span id="form-track-tags-selected"></span>
                            <span id="form-track-tags"></span>
                        </div>
                        <div class="col-sm-4">{{ Form::text('comment', null, ['placeholder' => 'comment'] ) }}</div>
                        <div class="col-sm-4">{{ Form::submit('TrackIT', ['class' => 'btn btn-sm btn-success']) }}</div>
                    </div> 
                    
                    {{ Form::close() }}

                    <div id="habits-block" style="display: inline-block;width:50%"></div>
                    
                </div>
                
                    <div id="ajax-box" style="display: inline-block;"></div>
                    <div id="ajax-box2" style="display: inline-block;"></div>
                
            </div>
                <pre></pre>
        </div>
    </div>
</div>
@endsection
