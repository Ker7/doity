@extends('layouts.dlayout')

@section('content')
    
    
@php
Carbon\Carbon::setLocale('et');
setlocale(LC_TIME, 'Estonian');
$dd= Carbon\Carbon::parse($date_later_than);
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
            {{ Form::open(['method' => 'GET' ]) }} 
                <div class="panel-body">
                
                @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                
                <!-- -->
                @if ($is_admin) 
                        <div class="col-sm-4"><h3></h3>
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
                                <input type="hidden" name="dtf" value="{{ $dd->format('Y-m-d') }}" />
                        {{ Form::submit('Filtreeri  ') }}
                        </div>
                 @endif
                <!-- -->
                
                <div class="month"> 
                  <ul>
                    <a target="_self" href="{{ action('HomeController@calendar', ['uid' => $get_user_id, 'dtf' => $dd->subMonth()->format('Y-m-d') ]) }}" ><li class="prev">&#10094;</li></a>
                    <a target="_self" href="{{ action('HomeController@calendar', ['uid' => $get_user_id, 'dtf' => $dd->addMonth(2)->format('Y-m-d') ]) }}" ><li class="next">&#10095;</li></a>
                    <li>
                      {{ $dd->subMonth()->formatLocalized('%B') }}<br>
                      <span style="font-size:18px">{{ $dd->format('Y') }}</span>
                    </li>
                  </ul>
            {{ Form::close() }}

                @if ($is_admin) 
                    <!-- Trigger the modal with a button -->
                    <br />
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#fieldAddBankDay"><i class="fa fa-btn fa-clone"></i> Lisa puhkuse/haiguse päev</button>
                    <!-- Modal -->
                    <div id="fieldAddBankDay" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                    
                          <div class="modal-header">
                            <h3>Puhkuse/haiguse päeva lisamine.</h3>
                          </div>
                            
                          <div class="modal-body">

            {{-- Form::model($bankDays, ["method" => "PATCH", "route" => ["bankdays.update", $ba->id]]) --}}
            
                            {!! Form::model(new App\BankDays, ['method' => 'POST', 'route' => ['bankdays.store']] ) !!}
                            <div class="form-group">
                                {!! Form::label('comment', 'Tööaja täpsustuse kirjeldus (Puhkus/Haigusleht/Pühad)') !!}
                                {!! Form::text('comment', 'Puhkus/Haigusleht', ['class' => 'form-control']) !!}
                                
                                {!! Form::hidden("uid", $get_user_id) !!}
                                {!! Form::hidden("dtf", $dd) !!}
             
<br /> 
                                {!! Form::label('value_decimal', 'Tundide arv päevas vajalikuks töötamiseks, nt. Puhkus/Haigus = 0, lühendatud tööpäev = 5') !!}
                                {!! Form::number('value_decimal', '0', ['class' => 'form-control', 'step' => 'any']) !!}             
             
                                {!! Form::label("bdatefrom", "Kuupäevast alates: ") !!}
                                {!! Form::date("bdatefrom", $date_later_than) !!}
                                
                                {!! Form::label("bdateto", "Kuupäevani kuni: ") !!}
                                {!! Form::date("bdateto", Carbon\Carbon::now() ) !!}
             
             
                            </div>
                                
                          </div>
                                
                          <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Add!</button>
                            {!! Form::close() !!}
                          </div>
                          
                        </div>  
                      </div>
                    </div>
                 @endif

                </div>
                    
<ul class="weekdays">
  <li>Esmaspäev</li>
  <li>Teisipäev</li>
  <li>Kolmapäev</li>
  <li>Neljapäev</li>
  <li>Reede</li>
  <li>Laupäev</li>
  <li>Pühapäev</li>
</ul>

<ul class="days">
@php
$month_beginning = $dd->startOfMonth();
$daysInMonth = 1;
$first_day_num = $month_beginning->dayOfWeek;
$first_day_num = ($first_day_num==0?7:$first_day_num);  //Sunday's index is 0, we have to have it at the end of the week

// Empty day spots
while ($first_day_num>1) {
    echo "<li> </li>";
    $first_day_num -= 1;
}

//print_r($bankValues);

// Esmalt saab eelmise kuu viimase väärtuse!
$bankValue = 0;
$bankSum = 0;

for ($i = 1; $i <= $dd->daysInMonth; $i++) {

        $hoursNeededForThisDay = 8;
        
        $hoursNeededForThisDayYld = 0;  // Universal hours meant for all users, with user_id = null. Not in use currently, as Universal may be overwritten with individual only.
        $hoursNeededForThisDayInd = 0;  // Individual hours set with user_id
        
        $have_individual_hours = false;
        $have_universal_hours = false;

    $thisDay = Carbon\Carbon::parse($dd->format('Y-m-').$i);
    
    //DEBUGS
    echo ''
        //.Carbon\Carbon::now() . "¤"
        //. $thisDay->format('Y-m-d')
        ;
    //print_r($bankDays);
    
    //$link = '?dtf='.$thisDay->format('Y-m-d').'&dtt='.$thisDay->format('Y-m-d').'&uid='.$get_user_id;
    $link = \App::make('url')->to('/').'/reflect?dtf='.$thisDay->format('Y-m-d').'&dtt='.$thisDay->format('Y-m-d').'&uid='.$get_user_id;
if ($is_admin) {
    echo '<a href="'. $link .'">';
}
    echo '<li><span class="calendar-date-month">';
    echo ( $thisDay->isSameDay(Carbon\Carbon::now()) ? '<span class="active">'.$i.'</span>': $i);
    echo '</span>';
if ($is_admin) {
    echo '</a>';
}
    
    foreach($bankDays as $ba) {
        if ($ba->date == $thisDay->format('Y-m-d') && ($ba->user_id == null || $ba->user_id == $get_user_id)) {

            if ($ba->user_id == null) {         // Universal hours
                $have_universal_hours = true;
                $hoursNeededForThisDay = $ba->value_decimal;    //Here we set the hours neede to bankday value, It might be overwritten later on if individual day set exists
            }
            
            if ($ba->user_id == $get_user_id) { //Universal hours
                $have_individual_hours = true;
                $hoursNeededForThisDay = $ba->value_decimal;
                $hoursNeededForThisDayInd = $ba->value_decimal;
            }
if ($is_admin && ($have_individual_hours || $have_universal_hours)) {  
            echo '<br>';
            //echo ($have_individual_hours?'Ind':'Yld');  //Individual or Universal vacation day
            //echo '<i title="'.$ba->comment.'">-'.$ba->user_id.'</i>';              
echo '   
<button title="'.$ba->comment.'" type="button" class="form-edit btn btn-custom btn-primary" data-toggle="modal" data-target="#field-edit-log-'. $ba->id .'">
<i class="fa fa-btn fa-clock-o"></i>'. $ba->value_decimal .'h</button>

<!-- Modal -->
<div id="field-edit-log-'. $ba->id .'" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h3>Päevatunnid:</h3>
                <sup>Mitu tundi see päev peaks töötama</sup>
            </div>
            
            <div class="modal-body">
            '. Form::model($bankDays, ["method" => "PATCH", "route" => ["bankdays.update", $ba->id]])
             . Form::hidden("dtf", $dd->format("Y-m-d"))
             . Form::hidden("bid", $ba->id)
             . Form::hidden("uid", $get_user_id)
             
             . Form::label("kasutaja", "Kasutaja:");
             
             $uup = App\User::where('id',$ba->user_id )->first();
             
             //if ($uup !== null) {
                echo ($uup !== null ? $uup->name . "<br />" : "Üldiselt seatud kõigile, kui pole individuaalselt muudetud.<br />");
             //}
             
             echo Form::label("bdate", "Kuupäev: ")
             . Form::date("bdate", $ba->date) . '<br />';
             
             echo Form::label("value_decimal", "Tundide arv: ")
             . Form::number("value_decimal", $ba->value_decimal, ["class" => "form-control", 'step' => 'any'])
             
             . Form::label("comment", "Kommentaar: ")
             . Form::text("comment", $ba->comment, ["class" => "form-control"])
             .'
            </div>
                  
            <div class="modal-footer">
              <button class="btn btn-danger" type="submit" name="delete" value="delete">Delete</button>
              <button class="btn btn-success" type="submit">Accept!</button>
            '. Form::close() .'
            </div>
        </div>
    </div>
</div>';
}
        }
    }
    
    if ($have_individual_hours && $have_universal_hours){
        $hoursNeededForThisDay = $hoursNeededForThisDayInd;
//echo "Mõlemad on seatud!"; //Mode'l kuvab seda, aga indiv tundi mitte
    }
    
    $hoursPerDay = 0;               // How many hours has been logged for this day in total?
    foreach($dotiLogs as $dlog) {       //Each dotilogs + Each bankdays
        if (Carbon\Carbon::parse($dlog->date_log)->day == $i) {
            $hoursPerDay += $dlog->value_decimal;
        }
    }
    echo '<br>'.$hoursPerDay.'h';   // WORKED TODAY!!!
    
    // bank_days, TODAY & This_USER > TODAY > 
    if (1==2) { 
    
    } elseif (2==3) {
    
    } elseif ($thisDay->dayOfWeek == 6 || $thisDay->dayOfWeek == 0) {
        $hoursNeededForThisDay = 0;
    }
    $bankValue = $bankValue + $hoursPerDay-$hoursNeededForThisDay;
    $bankSum += $hoursPerDay;
    
    //echo '<i title="Panga väärtus"> ('.($bankValue).'h)</i>';    //Goes To Bank
    echo '<i title="Panga väärtus"> ('.(number_format((float)$bankValue, 2, '.', '')).'h)</i>';    //Goes To Bank 
        
    echo '</li>';
}

@endphp
    
</ul>
    

                    <br />
                    
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <strong style="display: inline-block;">
                            @php
                            
                            if ($is_admin){
                                echo 'Kuu summa: ' . $bankSum . ' / '. ($bankValue - $bankSum) .'<br>';
                            }
                            
                            echo 'Saldo seis: ' . $bankValue .'</strong>
                                <h3>Tundide edasikandmine</h3>';
                            
                            if ($forward_job !== null) {
                            echo Form::model($forward_job, ["method" => "PUT", "route" => ["logs.forward"]])
                             . Form::hidden("dtf", $dd->format("Y-m-d"))
                             . Form::hidden("fhid", $forward_job->fieldhabit_id)
                             . Form::hidden("fhdt", $forward_job->date_log)
                             . Form::hidden("uid", $get_user_id)
                             
                             . Form::label("value_decimal", "Tundide arv: ")
                             . Form::number("value_decimal", $bankValue, ["class" => "form-control"])
                             
                             . Form::label("comment", "Kommentaar: ")
                             . Form::text("comment", "Ülekantud tunnid", ["class" => "form-control"]);
                             }
                             
                            @endphp
                            
                             <br /><button class="btn btn-success" type="submit">Lisa!</button>
                                         
                            
                                
                                
                                
                            <div style="display: inline-block;" class="xdecimal-sum">
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
