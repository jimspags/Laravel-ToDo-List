<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index() {
        return view('todo.index');
    }

    //Get todo
    public function show() {
        $todos = Todo::all();
        if(count($todos) > 0) {
            //return if there is a todo list data
            return response()->json([
                'status' => 200,
                'todos' => $todos
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "No Todo List"
            ]);
        }
    }

    public function store(Request $request) {
        //Validate data
        $validator = Validator::make($request->all(), [
            'todo' => ['required','min:3'],
            'description' => ['required', 'min:6']
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        } else {
            $todoId = Todo::create($request->all());
            return response()->json([
                'status' => 200,
                'todo' => $request->all(),
                'todoId' => $todoId->id
            ]);
        }
    }

    public function destroy(Todo $todo) {
        $todo->delete();
        return response()->json([
            'message' => "Successfully Delete: ".$todo->todo
        ]);
    }

    public function edit(Todo $todo) {  
        return response()->json([
            'todo' => $todo
        ]);
    }

    public function update(Todo $todo, Request $request) {
        $validator = Validator::make($request->all(), [
            'todo' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                "status" => 400,
                "errors" => $validator->errors()
            ]);
            
        } else {
            $todo->update($request->all());
            return response()->json([
                "status" => 200,
                "todo" => $todo
            ]);
        }


    }

}
