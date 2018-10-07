@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->name }}, This is the CSV friendly page.
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
                            
                            {{-- Form::submit(['name' => 'filter']) --}}
                            {!! Form::submit( 'Filter', ['class' => 'btn btn-default', 'name' => 'submitbutton', 'value' => 'filter'])!!}
                            {!! Form::submit( 'CSV', ['class' => 'btn btn-default', 'name' => 'submitbutton', 'value' => 'getcsv']) !!}          
                        </div>
                            
                      {{ Form::close() }}</td>
                    </div>
                  <br />
                    <table>
                    <thead><tr>
<td>id</td><td>user</td><td>habit</td><td>date_log</td><td>time_log</td><td>date_log2</td><td>time_log2</td><td>value_decimal</td><td>ip_address</td><td>ip_address2</td><td>created_at</td><td>updated_at</td>
                    </tr></thead>
                        <tbody>
                        @foreach ($dotiLogs as $kei => $dlog)
                            <tr>
                                <td>{{ $dlog->id }}</td>
                                <td>{{ $dlog->getFieldHabit->getUserField->getUser->name }}</td>
                                <td>{{ $dlog->getFieldHabit->getHabit->name }}</td>
                                <td>{{ $dlog->date_log }}</td>
                                <td>{{ $dlog->time_log }}</td>
                                <td>{{ $dlog->date_log2 }}</td>
                                <td>{{ $dlog->time_log2 }}</td>
                                <td>{{ $dlog->value_decimal }}</td>
                                <td>{{ $dlog->ip_address }}</td>
                                <td>{{ $dlog->ip_address2 }}</td>
                                <td>{{ $dlog->created_at }}</td>
                                <td>{{ $dlog->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br />

                </div>
                    @if ($is_admin)
                        <form action="{{ action('HomeController@reflect', ['csv' => 1]) }}">
                            <input  style="float: right; margin: 30px;" type="submit" value="CSV" />
                        </form>
                    @endif
                    
                    <div id="ajax-box" style="display: inline-block;"></div>
                    <div id="ajax-box2" style="display: inline-block;"></div>
                
            </div>
                <pre></pre>
        </div>
    </div>
</div>
@endsection
