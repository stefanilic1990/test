<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //\DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(5);
        return view('questions.index',compact('questions'));
        //dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->questions()->create($request->only('title','body'));

        return redirect()->route('questions.index')->with('success','Vase pitanje je poslato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show',compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if (\Gate::denies('update-question',$question)) {
            abort(403,"Nedozvoljeni pristup");    
        }
        return view('questions.edit',compact('question'));
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('update',$question);
        $question->update($request->only('title','body'));

        if ($request->expectsJson()) {
            return response()->json(
                ["message"=>"Vaše pitanje je izmenjeno",
                "body_html"=>$question->body_html]); 
        }else{
            return redirect()->route('questions.index')->with('success','Vase pitanje je izmenjeno');
        }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete',$question);
        $question->delete();
        
        if (request()->expectsJson()) {
            return response()->json(["message"=>'Pitanje je obrisano']); 
        }else{
            return redirect()->route('questions.index')->with('success','Pitanje je obrisano');
        }
    }

}
