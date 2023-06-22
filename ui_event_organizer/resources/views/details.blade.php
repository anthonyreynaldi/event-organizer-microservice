@extends('app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">Order Details</div>
                <div class="card-body">
                    <div class="list-group">
                        <h3 class="card-title">Pernikahan</h3>
                        <h5 class="card-text">Start Date : 2023-06-19</h5>
                        <h5 class="card-text">Start Date : 2023-06-20</h5>
                        <br>
                        <p class="card-text">Client Name : Tipen</p>
                        <p class="card-text">Client Phone Number : 08123456789</p>
                        <p class="card-text">Note : Minta yang mewah ya mas</p>
                        <p class="card-text">Staff PIC : Staff Tipen</p>
                        <p class="card-text">Staff Phone Number : 08123456789</p>
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
                                Day 1
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Jam Mulai</td>
                                            <td>Jam Selesai</td>
                                            <td>PIC</td>
                                            <td>Deskripsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>09:30:00</td>
                                            <td>11:00:00</td>
                                            <td>Staff Tipen</td>
                                            <td>Pemberkatan pernikahan oleh Romo Aloysius di Gereja</td>
                                        </tr>
                                        <tr>
                                            <td>11:30:00</td>
                                            <td>13:00:00</td>
                                            <td>Staff Susin</td>
                                            <td>Sesi Foto bersama keluarga besar di gereja</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                Day 2
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Jam Mulai</td>
                                            <td>Jam Selesai</td>
                                            <td>PIC</td>
                                            <td>Deskripsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>17:00:00</td>
                                            <td>21:00:00</td>
                                            <td>Staff Susin</td>
                                            <td>Wedding Party di depan rumah (sewa terop)</td>
                                        </tr>
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
@endsection