<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

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

}
