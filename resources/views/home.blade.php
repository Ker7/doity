@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">

                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-btn fa-clone"></i>New Field</button>
                
                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                
                        {!! Form::model($field, ['action' => 'FieldController@store']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('color', 'Colour') !!}
                            <input class="form-control" type="color" id="colorForField" name="colorForField" style="width: 60px;"/>
                        </div>
                        <button class="btn btn-success" type="submit">Add the Car!</button>
                            
                        {!! Form::close() !!}
                      
                    </div>
                </div>
                
                    <!--<a href="#" style="color:#fff;"><i class="fa fa-btn fa-clone"></i>New Field</a>-->
                    {{ Auth::user()->name }}, {{ $specialWelcome }}
                </div>
 
<!--                <div id="main-message-div" class="panel-body">
                    You are logged in!
                </div>-->
                    
                <div class="panel-body">

                    {{-- With $userFields var from HomeController@index --}}
                    @include('doti-circle')
                    
                    {{-- With $userFields var from HomeController@index --}}
                    @include('doti-field-rows')
                    
                    {{-- @if (count($userFieldsUnactive) > 0) --}}
                    
                        {{-- With $userFieldsUnactive var from HomeController@index --}}
                        
                    {{--    @include('doti-field-rows-unactives')
                    @endif --}}
                    
                    
                </div>
                
                    <div id="ajax-box" style="display: inline-block;"></div>
                    <div id="ajax-box2" style="display: inline-block;"></div>
                
            </div>
        </div>
    </div>
</div>
@endsection
