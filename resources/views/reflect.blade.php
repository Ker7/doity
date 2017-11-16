@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->name }}, This is the looking back page.
                </div>
                <div class="panel-body">
                    <div class="row">
                      {{ Form::open(['method' => 'GET']) }}
                        <div class="col-sm-4"><h3>Time period</h3>
                            {{ Form::date('dtf', $date_later_than, ['class' => 'reflect-date']) }} -
                            {{ Form::date('dtt', $date_less_than, ['class' => 'reflect-date']) }}
                        </div>
                        <div class="col-sm-4">
                        </div>
                            
                        <div class="col-sm-4"><h3></h3>
                            @if ($is_admin)
                            <sup>If by person, the first submit person name</sup>
                                <select class="reflect-date" name="uid" id="uid">
                                    @if (empty($get_user_id))
                                        <option value="">-user-</option>
                                    @else
                                        <option value="">-show all-</option>
                                    @endif
                                    @foreach ($userSelect as $k => $u)
                                        <option
                                            name="key::{{$k}}"
                                            value="{{ $u->id }}"
                                                @if ($get_user_id == $u->id)
                                                    selected 
                                                @endif
                                            >{{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select class="reflect-date" name="hid" id="hid">
                                @if (empty($get_hid))
                                    <option value="">-habit-</option>
                                @else
                                    <option value="">-show all-</option>
                                @endif
                                @foreach ($all_habits as $kk => $u)
                                    <option
                                        value="{{ $u->id }}"
                                            @if ($get_hid == $u->id)
                                                selected
                                            @endif
                                        >{{ $u->name }}
                                    </option>
                                @endforeach
                                </select>
                            @endif
                            
                            {{ Form::submit() }}
                        </div>
                            
                      {{ Form::close() }}</td>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-4"><h3>When</h3></div>
                        <div class="col-sm-4"><h3>Activity</h3></div>
                        <div class="col-sm-4"><h3>Quantity</h3>
                            @if ($is_admin)
                                <span style="float: right; cursor: pointer;" onClick="jQuery('.form-edit-dotilog').toggle()">☇-Edit</span>
                                <span style="float: right; cursor: pointer;" onClick="jQuery('.form-ip-dotilog').toggle()">☇-Spy</span>
                            @endif
                        </div>
                    </div>
                  
                    @foreach ($dotiLogs as $kei => $dls)
                        @foreach ($dls as $dlog)
                            <div class="row">
                                <div class="col-sm-4">
                                    {{ $dlog->date_log }} {{ \Carbon\Carbon::parse($dlog->time_log)->format('H:i') }} - {{ \Carbon\Carbon::parse($dlog->time_log2)->format('H:i') }}@if ($is_admin)
                                    <div class="form-ip-dotilog">{{ $dlog->ip_address }} - {{ $dlog->ip_address2 }}</div>
                                         @endif
                                </div>
                                <div class="col-sm-4">
                                  <span
                                  @if ($dlog->is_counting == 1)
                                    style="background-color: lightblue;"
                                  @endif
                                  >
                                    @if ($is_admin)
                                        @if (empty($get_user_id))
                                            {{ $dlog->getFieldHabit->getUserField->getUser->name }}
                                        @endif
                                    @endif
                                    {{ $dlog->getFieldHabit->getHabit->name }}
                                  </span>
                                </div>
                                <div class="col-sm-4">
                                    <div style="display: inline-block;" class="decimal-fields">{{ $dlog->value_decimal }} </div><sup style="display: inline-block;"> {{ $dlog->getFieldHabit->unit_name }}</sup>
                                        @if ($is_admin)
                                            {{ Form::open(['class' => 'form-edit-dotilog', 'style' => 'display: none;']) }}
                                                {{-- Form::submit('[edit-'.$dlog->id.']', ['class' => 'btn btn-custom btn-success']) --}}
                                            {{ Form::close() }}

<!-- Trigger the modal with a button -->
                                            <button type="button" class="form-edit-dotilog btn btn-custom btn-success" data-toggle="modal" data-target="#field-edit-log-{{ $dlog->id }}">
                                            <i class="fa fa-btn fa-edit"></i>{{ $dlog->id }}</button>
                                            
                                            <!-- Modal -->
                                            <div id="field-edit-log-{{ $dlog->id }}" class="modal fade" role="dialog">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                            
                                                  <div class="modal-header">
                                                    <h3>Edit a log for:</h3>
                                                    <h5><strong>{{ $dlog->getFieldHabit->getUserField->getUser->name }}</strong> - {{ $dlog->getFieldHabit->getHabit->name }}({{ $dlog->id }})</h5>
                                                  </div>
                                                    
                                                  <div class="modal-body">
                                                    {{-- @var $field from HomeController --}}
                                                    {!! Form::model($dlog, ['method' => 'PATCH', 'route' => ['logs.update', $dlog->id]]) !!}
                                                    {!! Form::hidden('uid', $get_user_id) !!}
                                                    {!! Form::hidden('dtf', $date_later_than) !!}
                                                    {!! Form::hidden('dtt', $date_less_than) !!}

                                                    <div id="habits-block" style="display: inline-block;width:50%; float: left; padding-right: 20px;">                                                    
                                                        <div class="form-group">
                                                          {!! Form::label('date_log', 'Date') !!}
                                                          {!! Form::date('date_log', $dlog->date_log, ['class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="form-group">
                                                          {!! Form::label('time_log', 'Time') !!}
                                                          {!! Form::time('time_log', $dlog->time_log, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div id="habits-block" style="display: inline-block;width:50%">                                                    
                                                        <div class="form-group">
                                                          {!! Form::label('date_log2', 'Date2') !!}
                                                          {!! Form::date('date_log2', $dlog->date_log2, ['class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="form-group">
                                                          {!! Form::label('time_log', 'Time2') !!}
                                                          {!! Form::time('time_log2', $dlog->time_log2, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                      Value: <strong>{{ $dlog->value_decimal }} {{ $dlog->getFieldHabit->unit_name }}</strong><sup>NB! Correcting value here overwrites the time calculator!</sup><br> 
                                                      {!! Form::number('value_decimal', '', ['class' => 'form-control']) !!}
                                                      IP: {{ $dlog->ip_address }}
                                                    </div>
                                                    <div class="form-group" style="width: 100px;">
                                                      {!! Form::label('is_counting', 'Timer ON (0/1)') !!}
                                                      {!! Form::number('is_counting', $dlog->is_counting, ['class' => 'form-control']) !!}
                                                    </div>
                                                  </div>
                                                        
                                                  <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">Accept!</button>
                                                    {!! Form::close() !!}
                                                  </div>
                                                  
                                                </div>  
                                              </div>
                                            </div>

                                        @endif
                                </div>
                            </div>  
                        @endforeach
                    @endforeach 

                    <br />
                    
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <strong style="display: inline-block;">SUM:</strong>
                            <div style="display: inline-block;" class="decimal-sum">
                            </div>
                        </div>
                    </div> 
                        
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
