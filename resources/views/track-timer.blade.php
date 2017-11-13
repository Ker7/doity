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
                
                    {{-- Form::open() --}}
                    {!! Form::model($newLog, ['method' => 'PUT', 'route' => ['logs.start', '123']]) !!}
                    <div class="row">
                        <div class="col-sm-4">
                        
                            @php
                                //print_r($userFields);
                            @endphp
                            
                                @if (count($userFields) === 1)
                                  <select name="form-track-fields" id="form-track-fields">
                                    <option value="{{ $userFields[0]->id }}">{{ $userFields[0]->getField->name }}</option>
                                  </select>
                                  <select name="form-track-habits" id="form-track-habits">
                                  @foreach ($userFields[0]->getFieldActiveHabits as $ufhs)
                                      <option value="{{ $ufhs->id }}">{{ $ufhs->getHabit->name }}</option>
                                  @endforeach
                                  </select>
                                @else
                                  <select name="form-track-fields" id="form-track-fields">
                                    <option>*Choose*</option>
                                    @foreach ($userFields as $k => $u)
                                        <option value="{{ $u->id }}">{{ $u->getField->name }}</option>
                                    @endforeach
                                  </select>
                                  <select name="form-track-habits" id="form-track-habits">
                                  </select>
                                @endif
                                <input type="hidden" name="ip_address" value="@php
                                echo $_SERVER['REMOTE_ADDR']
                                @endphp" />
                                <input type="hidden" name="open_logs" value="@foreach($openLogs as $u)@foreach($u as $a){{ $a->id }},@endforeach @endforeach " />
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
                    
                    {{-- Form::close() --}}
                    {!! Form::close() !!}
                    
                            
                        @php
                            echo 'countOpenLogs: '.count($openLogs);
                        @endphp
                    <div id="habits-block" style="display: inline-block;width:100%" class="row">
                        
                        @foreach ($openLogs as $u)
                          @foreach ($u as $a)
                                
                           <div class="row">
                            <div class="col-sm-4">
                                <p>{{ $a->date_log }} - {{ $a->time_log }}</p>
                            </div>
                                
                            <div class="col-sm-4">
                                <h5>Activity: <strong>{{ $a->getFieldHabit->getHabit->name }}</strong></h5>
                            </div>
                            
                            <div class="col-sm-4">
                                {!! Form::model($a, ['method' => 'PATCH', 'route' => ['logs.finish', $a->id]]) !!}
                                <input type="hidden" name="ip_address" value="@php
                                    echo $_SERVER['REMOTE_ADDR']
                                @endphp" />
                                    <button class="btn btn-success" type="submit">Finish WORK</button>
                                {!! Form::close() !!}
                            </div>
                           </div>
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
