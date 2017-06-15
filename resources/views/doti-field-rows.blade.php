<div class="home-fields-cont">
    
    @foreach ($userFields as $kei => $userField)
    <div
        id="home-field-row-{{ $userField->id }}"
        class="home-field-row"
        data-row-fieldid="{{ $userField->id }}"
        style="display:{{ ($userField->id == $openField?'block':'none') }};">
        <table>
        <tbody>
        <tr style="border-bottom: 1px solid rgb(198, 178, 204)">
            <td>Field</td>
            <td>A</td>
            <td>P</td>
            <td>Created</td>
            <td>Changed</td>
        </tr>
        <tr>
            <td>{{ $userField->getField->name }} </td>
            <td>
                {{ Form::open() }}
                {{ Form::hidden('form_name', 'field_active') }}
                {{ Form::hidden('field_id', $userField->id) }}
                {{ method_field('PATCH') }}
                    <input
                        type="checkbox"
                        name="field"
                        onClick="this.form.submit()"
                        {{ $userField->active?'checked':'' }}
                    />
                {{ Form::close() }}</td>
            <td>
                {{ Form::open() }}
                {{ Form::hidden('form_name', 'field_public') }}
                {{ Form::hidden('field_id', $userField->id) }}
                {{ method_field('PATCH') }}
                    <input
                        type="checkbox"
                        name="field"
                        onClick="this.form.submit()"
                        {{ $userField->public?'checked':'' }}
                    />
                {{ Form::close() }}
            </td>
            <td>{{ Carbon\Carbon::parse($userField->created_at)->format('jS F') }}</td>
            <td>{{ Carbon\Carbon::parse($userField->updated_at)->format('jS F') }} :: </td>
                
            <td>
                <button type="button" title="New habit!" class="btn btn-success btn-sm" data-toggle="modal" data-target="#habitAddModal-{{$userField->id}}"><i class="fa fa-btn fa-clone"></i></button>
                
                <!-- Modal -->
                <div id="habitAddModal-{{$userField->id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                
                      <div class="modal-header">
                        <h3>Add a Habit for {{ $userField->getField->name }}</h3>
                      </div>
                        
                      <div class="modal-body">
                      
                        {{ Form::open(['url' => 'fieldhabit', 'method' => 'post']) }}
                        {{ Form::hidden('form_name', 'fieldhabit_add') }}
                        {{ Form::hidden('field_id', $userField->id) }}
                        {{-- Form::model('', '') --}}
                        {{-- method_field('PATCH') --}}
                
                        {{-- @var $field from HomeController --}}
                        {{-- Form::model($newHabit, ['action' => 'FieldController@store']) --}}

                
                        <div class="form-group">
                          {!! Form::label('name', 'Name of Habit') !!}
                          {!! Form::text('name', '', ['class' => 'form-control']) !!}
                        </div>
                            
                        <div class="form-group">
                          {!! Form::label('name', 'Name of Unit to measure with(eg. Walks, laps, interviews)') !!}
                          {!! Form::text('unit_name', '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('name', '[NOT USED ATM]Type of Unit(Decimal, Time, Percentage)') !!}
                          {!! Form::text('unit_type', '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('name', 'Comment for this habit.') !!}
                          {!! Form::textarea('comment', '', ['class' => 'form-control']) !!}
                        </div>
                            
                      </div>
                            
                      <div class="modal-footer">
                        <button id="addHabit" class="btn btn-success" type="submit">Add!</button>
                {{ Form::close() }}
                      </div>
                      
                    </div>  
                  </div>
                </div>
                
            </td>
        </tr>
        </tbody>
        </table>
            
            {{-- $logs = $userField->getHabits()->where('internal', 1)->first()->getLogs; --}}
        <!--<pre>{{-- print_r($userField) --}}</pre>-->
            
        {{-- With $userFields var from HomeController@index --}}
        {{-- @include('doti-field-month') --}}

    </div>
    @endforeach

</div>