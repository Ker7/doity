@foreach ($habits as $h)
    {{-- $h --}}
  <div style="padding: 0px 10px; background-color: #ddd; overflow: auto; margin-left: 20px;" >
    <h3>{{ $h->getHabit->name }}</h3>
    
    <p style="display: inline-block;">&nbsp; Unit: {{ $h->unit_name }}</p>
    
    <p class="habit-show-more" style="display: inline-block; float: left;"> -open- </p>
        
            <div class="habit-more" style="display: none;">
            <p>Active1: {{ $h->active }}</p>
                
                {{ Form::open(['url' => 'fieldhabit', 'method' => 'get']) }}
                {{ Form::hidden('form_name', 'fieldhabit_active') }}
                {{ Form::hidden('fieldhabit_id', $h->id) }}
                {{-- method_field('GET') --}}
                    <input
                        type="checkbox"
                        name="fieldhabit"
                        onClick="this.form.submit()"
                        {{ $h->active?'checked':'' }}
                    />
                {{ Form::close() }}</td>
                
            <p>Is Public: {{ $h->public }}</p>
            <p>Comment: {{ $h->comment }}</p>
            <p>Created at: {{ $h->created_at }}</p>
            <p>Updated at: {{ $h->updated_at }}</p>
            </div>
    
  </div>

@endforeach