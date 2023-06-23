@extends('staff/app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Order List</div>
                <div class="card-body">
                    <div class="list-group" id = "order_list">
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
        $.ajax({
            method : "GET",
            data : {
                url : ":5503/order"
            },
            url : "http://127.0.0.1:8000/api/",
            success : function(response) {
                len = response['data'].length
                console.log(len);
                for ($i = 0; $i<len;$i++) {
                    console.log(response['data'][$i]);
                    $("#order_list").append('<a href="http://127.0.0.1:8000/staff/details/'+response['data'][$i]['order_id']+'" class="list-group-item list-group-item-action list-group-item-info">Order '+response['data'][$i]['order_id']+'</a>');
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