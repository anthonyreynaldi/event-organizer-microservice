@extends('app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">Order Details</div>
                <div class="card-body">
                    <div class="list-group">
                        <h3 class="card-title"><span id="package_name">package name</span></h3>
                        <h5 class="card-text">Start Date : <span id="start_date">start date</span> </h5>
                        <h5 class="card-text">Start Date : <span id="end_date">end date</span></h5>
                        <br>
                        <p class="card-text">Client Name : <span id="client_name">Client Name</span></p>
                        <p class="card-text">Client Phone Number : <span id="client_phone_num">client phone num</span></p>
                        <p class="card-text">Note : <span id="note">Notes</span></p>
                        <p class="card-text">Staff PIC : <span id="staff_name">Nama stafff</span></p>
                        <p class="card-text">Staff Phone Number : <span id="staff_phone_num">Staff phone num</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Event Details</div>
                <div class="card-body">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                Details
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Tanggal Mulai</td>
                                            <td>Tanggal Selesai<td>
                                            <td>Jam Mulai</td>
                                            <td>Jam Selesai</td>
                                            <td>PIC</td>
                                            <td>Deskripsi</td>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                        
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
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

<script>
    $(document).ready(function(){
        var temp = window.location.pathname.split("/");
        var order_id = temp[temp.length - 1];

        $.ajax({
            method : "GET",
            data : {
                url : ":5503/order/"+order_id
            },
            url : "http://127.0.0.1:8000/api/",
            success : function(response) {
                order = response['data'][0]

                data = [
                    "package_name",
                    "start_date",
                    "end_date",
                    "client_name",
                    "client_phone_num",
                    "note",
                    "staff_name",
                    "staff_phone_num",
                ]

                console.log(order);
                for (i in data) {
                    console.log(data[i]);
                    console.log(order[data[i]]);
                    $("#"+data[i]).text(order[data[i]]);
                }
                console.log(response['data']);
            },
            error : function(response) {
                console.log(response)
            }
        })
    });
</script>
@endsection