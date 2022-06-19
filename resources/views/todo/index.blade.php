@extends('layout')
@section('title', 'Todo')
@section('content')
<div class="container">
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

        <div class="col-3 border">
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


<!-- EDIT -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Update Todo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="todo_form_edit">
            <div class="form-goup">
                <label for="">Todo</label>
                <input type="text" name="todoEdit" id="todoEdit" class="form-control" placeholder="Todo"><br>
                <span id="todoEditError"></span><br>
                <label for="">Description</label><br>
                <textarea name="descriptionEdit" id="descriptionEdit" cols="30" rows="5"></textarea><br>
                <span id="descriptionEditError"></span><br>
                <input type="hidden" name="idEdit" id="idEdit" value="">
            </div>
            <div class="modal-footer">
                <input type="submit" value="Update" class="btn btn-primary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
      </div>

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
                    //display data
                    if(response.status == 200) {
                        $.each(response.todos, function(key, todo) {
                            $("#todo_list").append("\
                            <tr>\
                                <td>"+ todo.id +"</td>\
                                <td>"+ todo.todo +"</td>\
                                <td>"+ todo.description +"</td>\
                                <td><button type='button' class='btn btn-primary' id='editButton' data-bs-toggle='modal' data-bs-target='#editModal' value='"+ todo.id +"'>UPDATE</button><button class='btn btn-danger' id='deleteButton' value='"+ todo.id +"'>DELETE</button></td>\
                            </tr>\
                            ");
                        });
                    }

                    //display no data
                    if(response.status == 400) {
                        $("#todo_list").append("\
                            <tr>\
                                <td class='text-center' colspan='4' id='noTodoList'>No Todo List</td>\
                            </tr>\
                        ");
                    }
                }
            });
        }


        //Add Function
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
                    //Clear input Field
                    $("input[name='todo']").val(""),
                    $("textarea[name='description']").val("")


                    //Append newly added todo
                    if(response.status == 200) {
                        $('#noTodoList').remove();
                        $("#todo_list").append("\
                        <tr>\
                        <td>"+ response.todoId +"</td>\
                        <td>"+ response.todo.todo +"</td>\
                        <td>"+ response.todo.description +"</td>\
                        <td><button class='btn btn-primary' id='editButton' data-bs-toggle='modal' data-bs-target='#editModal' value='"+ response.todoId +"'>UPDATE</button><button class='btn btn-danger' id='deleteButton' value='"+ response.todoId +"'>DELETE</button></td>\
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


        //Delete function
        $(document).on('click', '#deleteButton', function(e) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf_token']").attr('content')
                }
            });

            //Passing the ID to URL
            var url = "{{ route('todo.delete', ':id')}}"
            var id = $(this).val();
            url = url.replace(":id", id);

            $.ajax({
                type: "DELETE",
                url: url,
                success: function(response) {
                    $("#todo_list").html("");
                    fetchTodo();
                }
            });
        });

        //Edit Todo and pass data to modal
        $(document).on('click', '#editButton', function() {

            //Passing the ID to URL
            var url = "{{ route('todo.edit', ':id')}}";
            var id = $(this).val();
            url = url.replace(":id", id);

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response){
                    $("#todoEdit").val(response.todo.todo);
                    $("#descriptionEdit").val(response.todo.description);
                    $("#idEdit").val(response.todo.id);
                }
            });
        });


        //Update
        $("#todo_form_edit").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf_token']").attr('content')
                }
            });

            var url = "{{ route('todo.update', ':id')}}";
            var id =  $("input[name='idEdit']").val();
            url = url.replace(":id", id);

            var data = {
                todo: $("input[name='todoEdit']").val(),
                description: $("textarea[name='descriptionEdit']").val()
            }

            $.ajax({
                type: "PUT",
                url: url,
                data: data,
                dataType: "json",
                success: function(response) {
                    //Clear error message
                    $("#todoEditError").text("");
                    $("#descriptionEditError").text("");
                    if(response.status == 400) {
                        $("#todoEditError").text(response.errors.todo);
                        $("#descriptionEditError").text(response.errors.description);
                    }

                    if(response.status == 200) {
                        $("#editModal").modal("hide");
                        $("#todo_list").html("");
                        fetchTodo();
                    }

                }
            });



        });

    });
</script>


@endsection