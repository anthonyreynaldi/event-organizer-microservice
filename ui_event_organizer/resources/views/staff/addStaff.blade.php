@extends('staff/app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Add New Staff</div>
                <div class="card-body">
                    <!-- <form method="POST"> -->
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="phoneNum">Phone Number</label>
                            <input type="text" name="phoneNum" id="phoneNum" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <button type="submit" class="btn btn-primary btnSub">Add</button>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <a href="http://127.0.0.1:8000/staff" class="btn btn-secondary" id="btnLog">Back to homepage</a>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
        margin: 0 auto;
        width: 400px;
    }

    .btnSub {
        max-width: 30%;
    }

    #btnLog {
        max-width: 50%;
    }
</style>
@endsection