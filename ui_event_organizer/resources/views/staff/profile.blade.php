@extends('staff/app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Profile</div>
                <div class="card-body">
                    <!-- <form method="POST"> -->
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="username" id="name" class="form-control" value="{{ session()->get('name') }}" required autofocus disabled>
                        </div>
                        <div class="form-group">
                            <label for="phonenum">Phone Number</label>
                            <input type="text" name="username" id="phonenum" class="form-control" value="{{ session()->get('phone_num') }}" required autofocus disabled>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="{{ session()->get('username') }}" required autofocus disabled>
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