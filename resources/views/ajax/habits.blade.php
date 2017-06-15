@foreach ($habits as $h)
    {{-- $h --}}
  <div style="padding: 0px 10px; background-color: #ddd; overflow: auto; margin-left: 20px;" >
    <h3>{{ $h->getHabit->name }} [{{ $h->id }}]</h3>
    
    <p style="display: inline-block;">&nbsp; Unit: {{ $h->unit_name }}</p>
    
    <p class="habit-show-more" style="display: inline-block; float: left;"><button><i class="fa fa-cogs"></i></button></p>
        
            <div class="habit-more" style="display: none;">
            <p></p>
                {{ Form::open(['url' => 'fieldhabit', 'method' => 'get']) }}
                {{ Form::hidden('form_name', 'fieldhabit_active') }}
                {{ Form::hidden('fieldhabit_id', $h->id) }}
                  {{-- method_field('GET') --}}
                <label for="activeInput">Active </label>
                    <input
                    class="activeInput"
                        type="checkbox"
                        name="fieldhabit"
                        onClick="this.form.submit()"
                        {{ $h->active?'checked':'' }}
                    />
                {{ Form::close() }}
                </td>
                
                <!-- 123 -->
                
                {{ Form::open(['url' => 'fieldhabit', 'method' => 'get']) }}
                {{ Form::hidden('form_name', 'fieldhabit_public') }}
                {{ Form::hidden('fieldhabit_id', $h->id) }}
                  {{-- method_field('GET') --}}
                <label for="publicInput">Public </label>
                    <input
                    class="publicInput"
                        type="checkbox"
                        name="fieldhabit"
                        onClick="this.form.submit()"
                        {{ $h->public?'checked':'' }}
                    />
                {{ Form::close() }}
                </td>
                
            <label for="commentInput">Comment </label>
            <textarea class="commentInput" >{{ $h->comment }}</textarea>
            <p>Created at: {{ $h->created_at }}</p>
            <p>Updated at: {{ $h->updated_at }}</p>
            </div>
    
  </div>

@endforeach