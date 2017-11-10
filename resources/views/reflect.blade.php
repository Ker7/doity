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
                        <div class="col-sm-4"><h3>Time::Filter</h3>
                            {{ Form::date('dtf', $date_later_than, ['class' => 'reflect-date']) }} -
                            {{ Form::date('dtt', $date_less_than, ['class' => 'reflect-date']) }}
                        </div>
                        <div class="col-sm-4"><h3>Project::Filter</h3>
                            <select class="reflect-date" name="form_reflect_field" id="form-reflect-field">
                                @if (empty($get_field_id))
                                    <option value="">-field-</option>
                                @else
                                    <option value="">-show all-</option>
                                @endif
                                @foreach ($userFields as $k => $u)
                                    <option
                                        name="key::{{$k}}"
                                        value="{{ $u->id }}"
                                            @if ($get_field_id == $u->id)
                                                selected 
                                            @endif
                                        >{{ $u->getField->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="reflect-date" name="form_reflect_habits" id="form-reflect-habits">
                                @foreach ($unique_habits as $kk => $uu)
                                    @foreach ($uu as $k => $u)
                                        <option
                                            value="{{ $u->id }}"
                                                @if ($get_habit_id == $u->id)
                                                    selected 
                                                @endif
                                            >{{ $u->getHabit->name }} ({{ $u->get_logs_count }})
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="col-sm-4"><h3></h3>
                            {{ Form::submit() }}
                        </div>
                            
                      {{ Form::close() }}</td>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-4"><h3>When?</h3></div>
                        <div class="col-sm-4"><h3>What?</h3></div>
                        <div class="col-sm-4"><h3>Quantity?</h3></div>
                    </div>
                  
                    @foreach ($dotiLogs as $kei => $dls)
                        @foreach ($dls as $dlog)
                            <div class="row">
                                <div class="col-sm-4">
                                    {{ $dlog->created_at }}
                                </div>
                                <div class="col-sm-4">
                                    {{ $dlog->getFieldHabit->getHabit->name }}
                                </div>
                                <div class="col-sm-4">
                                    <div style="display: inline-block;" class="decimal-fields">{{ $dlog->value_decimal }} </div><sup style="display: inline-block;"> {{ $dlog->getFieldHabit->unit_name }}</sup>
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
