
Habit name: "{{ $hab->getHabit->name }}"<br/>
Logisid: {{ count($hab->getLogs) }}<br/>

<pre>{{ $userField }}</pre>

label: "{{ $userField->getField->name }}"<br/>
backgroundColor: "{{ $userField->getField->color }}"<br/>