<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('datatable');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $users = User::select(['id', 'name', 'email', 'password', 'survey_id', 'created_at', 'updated_at']);

        return Datatables::of($users)
            ->addColumn('action', function($user){
                return view('assignSurvey', compact('user'))->render();
            })
            ->make(true);
    }
}
