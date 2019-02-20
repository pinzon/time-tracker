<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function get(Request $request)
    {
        $tasks = Task::get();
        $now =  time();

        foreach ($tasks as $index => $task) {
            if ($task->active){
                if($now >= $task->shouldEndAt){
                    $task->secondsLeft = 0;
                }else{
                    $task->secondsLeft = $task->shouldEndAt - $now;
                }

                $task->save();
            }
        }

        return response()->json([
            'tasks' => $tasks
        ]);
    }

    public function new(Request $request)
    {
        $hours = intval($request->hours);
        $minutes = intval($request->minutes);
        $seconds = intval($request->seconds);
        
        $task = new Task;
        $task->name =  $request->name;
        $task->hours =  $hours;
        $task->minutes = $minutes;
        $task->seconds = $seconds;
        $task->secondsLeft = ($hours * 3600) + ($minutes * 60) + $seconds;
        $task->createdAt = time();
        $task->shouldEndAt = $task->createdAt + $task->secondsLeft;
        $task->save();

        return response()->json([
            'task' => $task
        ]);
    }

    public function edit(Request $request)
    {
        $result = ['error' => 1, 'info' => 'Task Not Found' ];

        $hours = intval($request->hours);
        $minutes = intval($request->minutes);
        $seconds = intval($request->seconds);
        
        $task = Task::find($request->id);
        if($task){
            $task->name =  $request->name;
            $task->hours =  $hours;
            $task->minutes = $minutes;
            $task->seconds = $seconds;
            $task->secondsLeft = ($hours * 3600) + ($minutes * 60) + $seconds;
            $task->shouldEndAt = time() + $task->secondsLeft;
            $task->save();

            $result['error'] = 0;
            $result['info'] = 'No error';
            $result['task'] = $task;
        }

        return response()->json($result);
    }

    public function delete(Request $request){
        Task::where('id',$request->id)->delete();

        return response()->json([
            'error' => 0
        ]);
    }

}
