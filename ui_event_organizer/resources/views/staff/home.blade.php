@extends('staff/app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Order List</div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Order 1</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Order 2</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Order 3</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Order 4</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Order 5</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info">Order 6</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
        margin: 0 auto;
        width: 600px;
    }
</style>
@endsection