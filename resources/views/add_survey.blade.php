<select>
    <option value="">Select a survey</option>
    @foreach(\App\Survey::all() as $survey)
        <option value="{{ $survey->id }}" {{ $user->survey_id == $survey->id ? 'selected' : ''}}>{{$survey->name}}</option>
    @endforeach
</select>

<a href="" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-save"></i></a>