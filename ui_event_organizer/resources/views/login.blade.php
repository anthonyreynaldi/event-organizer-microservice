<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
</head>

<body>
    <div class="container">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center">Login</div>
                        <div class="card-body">
                            <!-- <form method="POST"> -->
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
                                    <button class="btn btn-primary btnSub" id = "btnSub">Login</button>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <label class="text-center" for="btnReg">Don't have account?</label>
                                    <a href="http://127.0.0.1:8000/register" class="btn btn-secondary" id="btnReg">Register as Client</a>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $("#btnSub").click(function(){
                // username = 'tipen-stafff'
                // password = 'budak1'
                username = $("#username").val()
                password = $("#password").val()
                role = $("#role").val()
                if(role == 2) {
                    url = "http://localhost:8001/login/staff"
                } else {
                    url = "http://localhost:8001/login/client"
                }
                datas = {
                    username :username,
                    password : password,
                    url : url
                }
                console.log(datas)
                if(username != "" && password != "") {
                    $.ajax({
                        method : "POST",
                        data : datas,
                        url : "http://127.0.0.1:8000/api/login",
                        success : function(response) {
                            alert(response['message']);
                            console.log(response)
                        },
                        error : function(response) {
                            console.log(response)
                        }
                    })
                }
            })
        })
    </script>
</body>
</html>