@extends('app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Edit Profile</div>
                <div class="card-body">
                    <!-- <form method="POST"> -->
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <button type="submit" class="btn btn-primary btnSub">Save</button>
                        </div>
                        <input type="hidden" name="client_id" id="id" value="{{ session()->get('client_id') }}">
                        <div class="row mt-3 justify-content-center">
                            <a href="http://127.0.0.1:8000/home" class="btn btn-secondary" id="btnLog">Back to homepage</a>
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

<script>
    $(document).ready(function() {
        $(".btnSub").click(function(e) {
            e.preventDefault(); // Prevent form submission

            var username = $("#username").val();
            var password = $("#password").val();
            var id = $("#id").val();

            if (username !== "" && password !== "") {
                var requestData = {
                    username: username,
                    password: password,
                    url: ":5500/client/"+id
                };

                $.ajax({
                    method: "PUT",
                    data: JSON.stringify(requestData),
                    contentType: "application/json",
                    url: "http://127.0.0.1:8000/api",
                    success: function(response) {
                        // Handle the response here
                        console.log(response);
                        alert("successs update data");

                        $("#username").val("");
                        $("#password").val("");

                        datas = {
                            url : ":5500/client/{{ session()->get('client_id') }}"
                        }

                        $.ajax({
                            method : "GET",                            
                            async: false,
                            data: datas,
                            url : "http://127.0.0.1:8000/api",
                            success : function(response) {
                                // alert(response['message']);
                                console.log(response)

                                $.ajax({
                                    method : "POST",
                                    async: false,
                                    data : response['data'][0],
                                    url : "http://127.0.0.1:8000/api/session",
                                    success : function(response) {
                                        console.log(response);

                                    },
                                    error : function(response) {
                                        console.log(response)
                                    }
                                });
                            },
                            error : function(response) {
                                console.log(response)
                            }
                        });
                    
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }
        });
    });
</script>
@endsection