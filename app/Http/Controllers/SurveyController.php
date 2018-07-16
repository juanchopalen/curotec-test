<?php

namespace App\Http\Controllers;

use App\Survey;
use App\User;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Method list surveys
     * @return response
     */
    public function index()
    {
        return Survey::search(request()->search)
            ->orderBy(request()->orderBy, request()->desc == 'true' ? 'DESC' : 'ASC')
            ->paginate(5);
    }

    /**
     * Method stores survey
     * @return response
     */
    public function store()
    {
        $survey = Survey::create(request()->all());
        $survey->save();

        return [
            'message' => 'survey stored succefully',
            'id' => $survey->id,
        ];
    }

    /**
     * Method updates survey
     * @param  integer $id
     * @return response
     */
    public function update($id)
    {
        $survey = Survey::find($id);
        $survey->fill(request()->all());
        $survey->save();

        return ['message' => 'survey updated succefully'];
    }

    /**
     * Method destroys survey
     * @param  integer $id
     * @return response
     */
    public function delete($id)
    {
        $survey = Survey::destroy($id);

        return ['message' => 'survey deleted succefully'];
    }

    /**
     * Methos to assign a survey to user
     * @return response
     */
    public function assignUser()
    {
        $user = User::find(request()['user_id']);

        $user->survey_id = request()['survey_id'];

        $user->save();

        return ['message' => 'survey assigned succefully'];
    }
}
