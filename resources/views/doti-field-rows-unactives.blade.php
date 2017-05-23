<div class="home-fields-cont">
    <h3>Non Active Fields:</h3>
    @php
    //print_r($userFieldsUnactive);
    @endphp
    
    <div
        id="home-field-row"
        class="home-field-row">
        <table>
        <tbody>
        <tr style="border-bottom: 1px solid rgb(198, 178, 204)">
            <td>Field</td>
            <td>Active</td>
            <td>Public</td>
            <td>Created</td>
            <td>Changed</td>
        </tr>
    @foreach ($userFieldsUnactive as $kei => $userFieldUa)

        <tr>
            <td>{{ $userFieldUa->getField->name }} </td>
            <td>
                {{ Form::open() }}
                {{ Form::hidden('form_name', 'field_active') }}
                {{ Form::hidden('field_id', $userFieldUa->id) }}
                {{ method_field('PATCH') }}
                    <input
                        type="checkbox"
                        name="field"
                        onClick="this.form.submit()"
                        {{ $userFieldUa->active?'checked':'' }}
                    />
                {{ Form::close() }}</td>
            <td>
                {{ Form::open() }}
                {{ Form::hidden('form_name', 'field_public') }}
                {{ Form::hidden('field_id', $userFieldUa->id) }}
                {{ method_field('PATCH') }}
                    <input
                        type="checkbox"
                        name="field"
                        onClick="this.form.submit()"
                        {{ $userFieldUa->public?'checked':'' }}
                    />
                {{ Form::close() }}
            </td>
            <td>{{ Carbon\Carbon::parse($userFieldUa->created_at)->format('jS F, Y') }}</td>
            <td>{{ Carbon\Carbon::parse($userFieldUa->updated_at)->format('jS F, Y') }} :: </td>
        </tr>

    @endforeach
    </tbody>
    </table>
            
        {{-- $logs = $userFieldUa->getHabits()->where('internal', 1)->first()->getLogs; --}}
        <!--<pre>{{-- print_r($userFieldUa) --}}</pre>-->
            
        {{-- With $userFieldUas var from HomeController@index --}}
        {{-- @include('doti-field-month') --}}

    </div>
        
</div>