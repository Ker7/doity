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
            <td>Active</td>
            <td>Public</td>
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
            <td>{{ Carbon\Carbon::parse($userField->created_at)->format('jS F, Y') }}</td>
            <td>{{ Carbon\Carbon::parse($userField->updated_at)->format('jS F, Y') }} :: </td>
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