<select id="survey-{{$user->id}}">
    <option value="">Select a survey</option>
    @foreach(\App\Survey::all() as $survey)
        <option value="{{ $survey->id }}" {{ $user->survey_id == $survey->id ? 'selected' : ''}}>{{$survey->name}}</option>
    @endforeach
</select>
<a href="#" class="btn btn-xs btn-success" onClick="save_survey('{{$user->id}}');"><i class="fa fa-check"></i></a>

<script type="text/javascript">
    function save_survey(user_id){
        axios.post('/save_survey', {
                user_id: user_id,
                survey_id: $('#survey-' + user_id).val()
            }).then(response => {
                alert(response.data.message)
            })
            .catch(error => {
                alert( "error" );
            })
    }
</script>
