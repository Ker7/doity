@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">

                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#fieldAddModal"><i class="fa fa-btn fa-clone"></i>New Field</button>
                
                <!-- Modal -->
                <div id="fieldAddModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                
                      <div class="modal-header">
                        <h3>Add a priority field</h3>
                      </div>
                        
                      <div class="modal-body">
                        {{-- @var $field from HomeController --}}
                        {!! Form::model($newField, ['action' => 'FieldController@store']) !!}
                        <div class="form-group">
                          {!! Form::label('name', 'Name') !!}
                          {!! Form::text('name', $newField->name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                          {!! Form::label('color', 'Colour') !!}
                          <input class="form-control" type="color" id="colorForField" name="colorForField" style="width: 60px;"/>
                        </div>
                      </div>
                            
                      <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Add!</button>
                        {!! Form::close() !!}
                      </div>
                      
                    </div>  
                  </div>
                </div>
                
                <!--<a href="#" style="color:#fff;"><i class="fa fa-btn fa-clone"></i>New Field</a>-->
                    {{ Auth::user()->name }}, {{ $specialWelcome }}
                </div>
 
<!--                <div id="main-message-div" class="panel-body">
                    You are logged in!
                </div>-->
                    
                <div class="panel-body">
                
                    <div style="width:50%">

                    {{-- With $userFields var from HomeController@index --}}
                    @include('doti-circle')
                    
                    {{-- With $userFields var from HomeController@index --}}
                    @include('doti-field-rows')
                    
                    {{-- @if (count($userFieldsUnactive) > 0) --}}
                    
                        {{-- With $userFieldsUnactive var from HomeController@index --}}
                        
                    {{--    @include('doti-field-rows-unactives')
                    @endif --}}
                    
                    </div>
                        
                    <div id="habits-block" style="display: inline-block;width:50%"></div>
                    
                </div>
                
                    <div id="ajax-box" style="display: inline-block;"></div>
                    <div id="ajax-box2" style="display: inline-block;"></div>
                
            </div>
        </div>
    </div>
</div>
@endsection
