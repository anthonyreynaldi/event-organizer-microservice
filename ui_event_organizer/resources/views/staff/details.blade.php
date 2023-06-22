@extends('/staff/app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-2">
            <div class="card">
                <div class="card-header">Order Details</div>
                <div class="card-body">
                    <div class="list-group">
                        <h3 class="card-title">Lamaran</h3>
                        <h5 class="card-text">Start Date : 2023-10-10</h5>
                        <h5 class="card-text">Start Date : 2023-10-10</h5>
                        <br>
                        <p class="card-text">Client Name : Tuny</p>
                        <p class="card-text">Client Phone Number : 08123456789</p>
                        <p class="card-text">Note : Mau lamaran yang Chinese banget, keluarga saya totok soalnya (✿◡‿◡)</p>
                        <p class="card-text">Staff PIC : <button type="button" class="btn btn-success">Take Request</button></p>
                        <p class="card-text">Staff Phone Number : -</p>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Event</button>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <td>Jam Mulai</td>
                                            <td>Jam Selesai</td>
                                            <td>PIC</td>
                                            <td>Deskripsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Event</button>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <td>Jam Mulai</td>
                                            <td>Jam Selesai</td>
                                            <td>PIC</td>
                                            <td>Deskripsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
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
            <input id = "start" class="form-control" type="text" placeholder="Default input" aria-label="default input example" require>
        </div>
        <div class="mb-3">
            <label for="end" class="form-label">End Time</label>
            <input id = "end" class="form-control" type="text" placeholder="Default input" aria-label="default input example" required>
        </div>
        <div class="mb-3">
            <label for="pic" class="form-label">Staff PIC</label>
            <select id = "pic" class="form-select" aria-label="Default select example" required>
                <option selected disabled>Pilih PIC</option>
                <option value="1">Tipen</option>
                <option value="2">Susin</option>
                <option value="3">Tuny</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input id = "description" class="form-control" type="text" placeholder="Default input" aria-label="default input example" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
@endsection