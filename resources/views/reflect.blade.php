@extends('layouts.dlayout')

@section('content')
    
    @php
    
    $tunni_summa = 0;
    
    @endphp
    
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->name }}, This is the looking back page.
                    @if ($is_admin)
                        For CSV-friendly page: <a target="_self" href="{{ action('HomeController@reflect', ['csv' => 1]) }}"> here</a>.
                    @endif
                </div>
                <div class="panel-body">
                
                @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                
                
                    <div class="row">
                      {{ Form::open(['method' => 'GET']) }}
                        <div class="col-sm-4"><h3>Ajaperiood</h3>
                            {{ Form::date('dtf', $date_later_than, ['class' => 'reflect-date']) }} -
                            {{ Form::date('dtt', $date_less_than, ['class' => 'reflect-date']) }}
                        </div>
                        <div class="col-sm-4">
                        </div>
                            
                        <div class="col-sm-4"><h3></h3>
                            @if ($is_admin)
                                <select class="reflect-date" name="uid" id="uid">
                                    @if (empty($get_user_id))
                                        <option value="">-kasutaja-</option>
                                    @else
                                        <option value="">-näita kõiki-</option>
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
                                    <option value="">-projekt-</option>
                                @else
                                    <option value="">-näita kõiki-</option>
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
                            {{ Form::submit('Kuva vastavaid') }}
                        </div>
                            
                      {{ Form::close() }}</td>
                        
                        @if ($add_new_habit == true)
                            </br></br>
<!-- Add new habitlog! -->
<button type="button" class="form-add-dotilog btn btn-custom btn-success" data-toggle="modal" data-target="#field-add-log-{{ $get_user_id }}">
<i class="fa fa-btn fa-edit"></i>Lisa LOGI</button>

<!-- Modal -->
<div id="field-add-log-{{ $get_user_id }}" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h3>Logikande käsitsi lisamine:</h3>
      </div>
        
      <div class="modal-body">
        {{-- @var $field from HomeController --}}
        {!! Form::model($newLog, ['method' => 'POST', 'route' => ['logs.store', $get_user_id]]) !!}
        {!! Form::hidden('uid', $get_user_id) !!}
        {!! Form::hidden('dtf', $date_later_than) !!}
        {!! Form::hidden('dtt', $date_less_than) !!}

            <div class="form-group" style="width: 100%;">
                {!! Form::label('uhid', 'Projekt') !!}
{{-- @foreach ( $user->getLinkedUserFields as $a)           --}}
                <select class="reflect-date" name="uhid" id="uhid">
                    @foreach ($unique_habits as $k => $u)
                        <option
                            name="key::{{$k}}"
                            value="{{ $u->id }}"
                            >{{ $u->getHabit->name }}
                        </option>
                    @endforeach
                </select>
{{-- @endforeach --}}
            </div>

            <div class="form-group" style="width: 50%; float: left;">
              {!! Form::label('date_log', 'Alustamise kuupäev') !!}
              {!! Form::date('date_log', $date_later_than, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group" style="width: 50%; float: left;">
              {!! Form::label('time_log', 'Alustamise kellaaeg') !!}
              {!! Form::time('time_log', '08:00:00', ['class' => 'form-control']) !!}
            </div>
                                                                  
            <div class="form-group" style="width: 50%; float: left;">
            <!--
              {!! Form::label('date_log2', 'Lõpetamise kuupäev') !!}
              {!! Form::date('date_log2', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
              -->
            </div>
            <div class="form-group" style="width: 50%; float: left;">
              {!! Form::label('time_log', 'Lõpetamise kellaaeg') !!}
              {!! Form::time('time_log2', \Carbon\Carbon::now()->toTimeString(), ['class' => 'form-control']) !!}
            </div>
      </div>
            
      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Lisa!</button>
        {!! Form::close() !!}
      </div>
    </div>
</div> 
                    @endif
                    </div>
                
                    <div class="row">
                        <div class="col-sm-4"><h3>Aeg</h3></div>
                        <div class="col-sm-4"><h3>Projekt</h3></div>
                        <div class="col-sm-4"><h3>Väärtus</h3>
                            @if ($is_mode)
                                <span style="float: right; cursor: pointer;" onClick="jQuery('.form-edit-dotilo0g').toggle()">☇-Muuda</span>
                                @if ($is_admin)
                                    <span style="float: right; cursor: pointer;" onClick="jQuery('.form-ip-dotilog').toggle()">☇-IP'd</span>
                                @endif
                            @endif
                        </div>
                    </div>
                  
                    {{-- @foreach ($dotiLogs as $kei => $dls) --}}
                    @foreach ($dotiLogs as $kei => $dlog)
                        {{-- @foreach ($dls as $dlog) --}}
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
                                    @if(isset($dlog->comment))
                                        #{{ $dlog->comment }}
                                    @endif
                                  </span>
                                </div>
                                <div class="col-sm-4">
                                @php
                                    $tunni_summa += $dlog->value_decimal;
                                @endphp
                                    <div style="display: inline-block;" class="decimal-fields">{{ $dlog->value_decimal }} </div><sup style="display: inline-block;"> {{ $dlog->getFieldHabit->unit_name }}</sup>
                                    @if ($is_mode)
                                        @if ($is_admin)
                                        {{ Form::open(['method' => 'PATCH', 'route' => ['remlog', $dlog->id], 'class' => 'form-remove-dotilog', 'style' => 'float: right;']) }}
                                            {{ Form::hidden('dlid', $dlog->id) }}
                                            {{ Form::hidden('uid', $get_user_id) }}
                                            {{ Form::hidden('hid', $get_hid) }}
                                            {{ Form::hidden('dtf', $date_later_than) }}
                                            {{ Form::hidden('dtt', $date_less_than) }}
                                            {{ Form::submit('Kustuta', ['class' => 'btn btn-custom btn-danger']) }}
                                        {{ Form::close() }}
                                        @endif

<!-- Trigger the modal with a button -->
                                        <button type="button" title="{{ $dlog->id }}" class="form-edit-dotilo0g btn btn-custom btn-success" data-toggle="modal" data-target="#field-edit-log-{{ $dlog->id }}">
                                        <i class="fa fa-btn fa-edit"></i>Muuda</button>
                                        
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
                                                        
                                                        @if ($add_new_habit == true)
                                                            <div id="habits-block" style="display: inline-block;width:100%; padding-right: 20px;">    
                                                                <select class="reflect-date" name="uhid" id="uhid">
                                                                    @foreach ($unique_habits as $k => $u)
                                                                        <option
                                                                            name="key::{{$k}}"
                                                                            value="{{ $u->id }}"
                                                                                @if ($dlog->fieldhabit_id == $u->id)
                                                                                    selected
                                                                                @endif
                                                                            >{{ $u->getHabit->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif
                        
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
                                                          {!! Form::number('value_decimal', '', ['class' => 'form-control', 'step' => 'any']) !!}
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
                            {{-- @endforeach --}}
                        @endforeach 

                    <br />
                    
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <strong style="display: inline-block;">SUMMA: </strong> 
                            <div style="display: inline-block;" class="1deecimal-suwrclasm"> {{ $tunni_summa }}
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
