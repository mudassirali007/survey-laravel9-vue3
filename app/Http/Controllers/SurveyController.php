<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use App\Models\SurveyTaken;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $survey = SurveyTaken::where('user_id',auth()->user()->id)->exists();
        return response()->json($survey, 200);
    }

    public function surveyTaken()
    {
        SurveyTaken::updateOrInsert(['user_id' => auth()->user()->id]);
        return response()->json(true, 200);
    }

    public function surveyStat()
    {
        $q = Question::get(['id','question']);
        $stat = [];
        foreach ($q as $qs){
            $yes = Survey::where([['question_id',$qs['id']],['answer','=','Yes']])->count();
            $no = Survey::where([['question_id',$qs['id']],['answer','=','No']])->count();
            $total = Survey::where([['question_id',$qs['id']]])->count();
            $stat[$qs['id']]['Yes'] = ($yes/$total)*100;
            $stat[$qs['id']]['No'] = ($no/$total)*100;
            $stat[$qs['id']]['qs'] = $qs['question'];
        }
        return response()->json($stat, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Survey::updateOrInsert(
            ['user_id' => auth()->user()->id, 'question_id' => $request->questionId],
            ['answer' => $request->answer]
        );
        return response()->json(['success'=>'true','message' => 'Successfully Done.'], 200);
    }

}
