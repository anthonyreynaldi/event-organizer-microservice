@extends('app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Login</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mt-1">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required autofocus>
                        </div>
                        <div class="form-group mt-1">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group mt-3 input-group">
                            <label class="input-group-text" for="role">Login As</label>
                            <select class="form-select" id="role">
                                <option selected value="1">Client</option>
                                <option value="2">Staff</option>
                            </select>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <button type="submit" class="btn btn-primary btnSub">Login</button>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <label class="text-center" for="btnReg">Don't have account?</label>
                            <a href="{{ route('register') }}" class="btn btn-secondary" id="btnReg">Register as Client</a>
                        </div>
                    </form>
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

    #btnReg {
        max-width: 50%;
    }
</style>
@endsection