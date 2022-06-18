@extends('layout')
@section('title', 'Todo')
@section('content')
<div class="container-fluid">
    <div class="row"><h1 class="text-justify">TODO LIST</h1></div>
    <div class="row">
        <div class="col-9">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Todo</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="todo_list">
                <!-- Get data from ajax -->
            </tbody>
            </table>
        </div>

        <div class="col-3">
            <form id="todo_form">
                <div class="form-goup">
                    <label for="">Todo</label>
                    <input type="text" name="todo" id="" class="form-control" placeholder="Todo">
                    <label for="">Description</label>
                    <textarea name="description" id="" cols="30" rows="5"></textarea>
                    <input type="submit" value="Add Todo" class="btn btn-success" id="addTodoBtn">
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        //Call function to get and display to table
        fetchTodo();
        
        //Function to get data
        function fetchTodo() {
            $.ajax({
                type: "GET",
                url: "{{ route('todo.show') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response.status)
                    //display data
                    if(response.status == 200) {
                        $.each(response.todos, function(key, todo) {
                            $("#todo_list").append("\
                            <tr>\
                                <td>"+ todo.id +"</td>\
                                <td>"+ todo.title +"</td>\
                                <td>"+ todo.description +"</td>\
                                <td>UPDATE DELETE</td>\
                            </tr>\
                            ");
                        });
                    }

                    //display no data
                    if(response.status == 400) {
                        $("#todo_list").append("\
                            <tr>\
                                <td>No Todo List</td>\
                            </tr>\
                        ");
                    }
                    
                 
                }
            });
        }




    });
</script>
@endsection