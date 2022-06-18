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
            <form>
                <div class="form-goup">
                    <label for="">Todo</label>
                    <input type="text" name="" id="" class="form-control" placeholder="Todo">
                    <label for="">Description</label>
                    <textarea name="" id="" cols="30" rows="5"></textarea>
                    <input type="submit" value="Add Todo" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>

</div>

<script src="{{ url('js/index.js') }}"></script>
@endsection