<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task= Task::all();
        return Response::json([
            'data'=> $task->transform($task)
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task=new Task();

        $task->name=$request->name;
        $task->priority=$request->prioryty;
        $task->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task=Task::find($id);

        if(!$task)
            {
            return Response::json([
                'error'=>[
                    'message'=>'Lesson does not exists',
                    'code'=>195
                ]
            ],404);
        }
            return Response::json([
                'data'=> $task->toArray()
            ],200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task=new Task();

        $task->name=$request->name;
        $task->priority=$request->prioryty;
        $task->done=$request->done;
        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
    }

    public function transformCollection($task)
    {
        return array_map([$this, 'transform'], $task->toArray());
    }


    public function transform($task)
    {
            return[
                'name'=> $task['name'],
                'priority'=> $task['priority'],
                'done'=> $task['done']
            ];
    }
}
