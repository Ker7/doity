@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <table>
                    <tr>
                        <td>Name</td><td>email</td><td>Updated at</td><td></td>
                    </tr>
                    <tr>
                    {{ Form::Model( Auth::user(), ['route' => 'profile.update'] ) }}
                    {{ Form::hidden('form_name', 'profile_update') }}
                    {{ method_field('PUT') }}
                    <td>{{ Form::text('name') }}</td>
                    <td>{{ Auth::user()->email }}</td>
                    <td>{{ Auth::user()->updated_at }}</td>
                    <td>{{ Form::submit('Save') }}</td>
                    {{ Form::close() }}    
                    </tr>
                </table>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
