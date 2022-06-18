@extends('layout')
@section('title', 'Todo')
@section('content')
<div class="container-fluid">
    <div class="row-12"><h1 class="text-center">TODO LIST</h1></div>
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
                    <input type="text" name="todo" id="" class="form-control" placeholder="Todo"><br>
                    <span id="todoError"></span><br>
                    <label for="">Description</label>
                    <textarea name="description" id="" cols="30" rows="5"></textarea><br>
                    <span id="descriptionError"></span><br>
                    <input type="submit" value="Add Todo" class="btn btn-success">
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
                                <td>"+ todo.todo +"</td>\
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
                                <td class='text-center' colspan='4'>No Todo List</td>\
                            </tr>\
                        ");
                    }
                }
            });
        }


        //Add Todo
        $("#todo_form").submit(function(e) {
            //Set up csrf token
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf_token']").attr('content')
                }
            });

            e.preventDefault();
            var data = {
                todo: $("input[name='todo']").val(),
                description: $("textarea[name='description']").val()
            };

            $.ajax({
                type: "POST",
                url: "{{ route('todo.store') }}",
                data: data,
                dataType: "json",
                success: function(response) {

                    //Append newly added todo
                    if(response.status == 200) {
                        $("#todo_list").append("\
                        <tr>\
                        <td>"+ response.todoId +"</td>\
                        <td>"+ response.todo.todo +"</td>\
                        <td>"+ response.todo.description +"</td>\
                        <td></td>\
                        </tr>");
                    }

                    //Clear error message
                    $("#todoError").text("");
                    $("#descriptionError").text("");

                    //Execute error validation message
                    if(response.status == 400) {
                        $("#todoError").text(response.errors.todo);
                        $("#descriptionError").text(response.errors.description);
                    }

                }

            });
            

            


        });


    });
</script>
@endsection