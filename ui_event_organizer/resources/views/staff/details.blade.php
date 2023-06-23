@extends('/staff/app')

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
                        <h5 class="card-text">End Date : <span id="end_date">end date</span></h5>
                        <br>
                        <p class="card-text">Client Name : <span id="client_name">Client Name</span></p>
                        <p class="card-text">Client Phone Number : <span id="client_phone_num">client phone num</span></p>
                        <p class="card-text">Note : <span id="note">Notes</span></p>
                        <p class="card-text">Staff PIC : <span id="staff_name">Nama stafff</span></p>
                        <p class="card-text">Staff Phone Number : <span id="staff_phone_num">Staff phone num</span></p>
                        <p class="card-text">Price : <span id="package_price">Price</span></p>
                        <button type="button" class="btn btn-success" id = "btnTake" >Take Request</button>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Event</button>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <!-- <td>Tanggal</td> -->
                                            <!-- <td>Tanggal Selesai<td> -->
                                            <td>Start</td>
                                            <td>End</td>
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
<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="start" class="form-label">Start Time</label>
            <input id = "start" class="form-control" type="datetime-local" placeholder="Default input" aria-label="default input example" require>
        </div>
        <div class="mb-3">
            <label for="end" class="form-label">End Time</label>
            <input id = "end" class="form-control" type="datetime-local" placeholder="Default input" aria-label="default input example" required>
        </div>
        <div class="mb-3">
            <label for="pic" class="form-label">Staff PIC</label>
            <select id = "pic" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Pilih PIC</option>
                <!-- <option value="1">Tipen</option>
                <option value="2">Susin</option>
                <option value="3">Tuny</option> -->
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input id = "description" class="form-control" type="text" placeholder="Default input" aria-label="default input example" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
    </div>
    </div>
</div>
</div>
<!-- style -->
<style>
    .card {
        margin: 0 auto;
        width: 600px;
    }
</style>
<script>
    $(document).ready(function(){
        var url = $(location).attr('href'),
        parts = url.split("/"),
        order_id = parts[parts.length-1];
        datas = {
            url : ":5501/staff"
        }
        $.ajax({
            method : "GET",
            data : datas,
            url : "http://127.0.0.1:8000/api/",
            success : function(response) {
                len = response['data'].length
                console.log(len);
                for ($i = 0; $i<len;$i++) {
                    $("#pic").append("<option value='"+response['data'][$i]['staff_id']+"'>"+response['data'][$i]['name']+"</option>")
                }
                console.log(response)
            },
            error : function(response) {
                console.log(response)
            }
        })
        $("#save").click(function(){
            start = $("#start").val()
            end = $("#end").val()
            pic = $("#pic").val()
            desc = $("#description").val()
            datas = {
                start : start,
                end : end,
                description : desc,
                order_id : order_id,
                staff_id : pic,
                url : ":5504/event"
            }
            if(start != "" && end != "" && pic != "" && desc != "") {
                $.ajax({
                    method : "POST",
                    data : datas,
                    url : "http://127.0.0.1:8000/api/",
                    success : function(response) {
                        alert(response['message']);
                        window.location.href = "";
                    },
                    error : function(response) {
                        console.log(response)
                    }
                })
            } else {
                alert("tolong semua file untuk diisi")
            }
        })
        var temp = window.location.pathname.split("/");
        var order_id = temp[temp.length - 1];
        $("#btnTake").click(function(){
            datas = {
                staff_id : {{session()->get('staff_id')}},
                url: ':5503/order/'+order_id
            }
            $.ajax({
                method : "PUT",
                data : datas,
                url : "http://127.0.0.1:8000/api/",
                success : function(response) {
                    alert(response['message']);
                    window.location.href = "";
                },
                error : function(response) {
                    console.log(response)
                }
            })
        })
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
                    "package_price",
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

        $.ajax({
            method : "GET",
            data : {
                url : ":5504/event/"+order_id
            },
            url : "http://127.0.0.1:8000/api/",
            success : function(response) {
                events = response['data']

                console.log(events);
                for (i in events) {
                    event = events[i];

                    $("#table_body").append(
                        `
                        <tr>
                            <td>`+ event['start'] +`</td>
                            <td>`+ event['end'] +`</td>
                            <td>`+ event['name'] +`</td>
                            <td>`+ event['description'] +`</td>
                        </tr>
                        `
                    );
                }
                console.log(response['data']);
            },
            error : function(response) {
                console.log(response)
            }
        })
    })
</script>
@endsection