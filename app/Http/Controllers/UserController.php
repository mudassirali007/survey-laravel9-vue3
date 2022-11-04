<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SurveyTaken;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return response()->json(User::has('surveyTaken')->paginate(15));
    }
}
