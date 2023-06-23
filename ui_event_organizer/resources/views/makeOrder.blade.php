@extends('app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Make Order</div>
                <div class="card-body">
                    <!-- <form method="POST"> -->
                        @csrf
                        <div class="form-group">
                            <label for="start">Start Date</label>
                            <input name="" id="start" class="form-control" type="date" required>
                        </div>
                        <div class="form-group">
                            <label for="end">End Date</label>
                            <input name="" id="end" class="form-control" type="date" required>
                        </div>
                        <div class="form-group">
                            <label for="paket">Paket</label>
                            <select id = "paket" class="form-select" aria-label="Default select example" required>
                                <option selected disabled>Pilih Paket</option>
                                <option value="1">Pernikahan</option>
                                <option value="2">Sweet Seventeen</option>
                                <option value="3">Lamaran</option>
                                <option value="4">Graduation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <input type="text" name="notes" id="notes" class="form-control" required>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <button type="submit" class="btn btn-primary btnSub" id="btnSub">Make Order</button>
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
    $(document).ready(function(){
        $("#btnSub").click(function(){
            start_date = $("#start").val()
            end_date = $("#end").val()
            paket = $("#paket").val()
            notes = $("#notes").val()
            url = ":5503/order"
            datas = {
                start_date:start_date,
                end_date:end_date,
                note:notes,
                package_id:paket,
                client_id:{{session()->get('client_id')}},
                staff_id: '0',
                url : url
            }
            if(start_date != "" && end_date != "" && paket != "" && notes != "") {
                $.ajax({
                    method : "POST",
                    data : datas,
                    url : "http://127.0.0.1:8000/api/",
                    success : function(response) {
                        alert(response['message']);
                        console.log(response)

                        window.location.href = "";
                    },
                    error : function(response) {
                        console.log(response)
                    }
                })
            } else {
                console.log("ga lengkap")
            }
        })
    })
</script>
@endsection