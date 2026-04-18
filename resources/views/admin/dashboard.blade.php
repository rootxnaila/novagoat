@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard Admin Kambing</h2>
        <div class="row">

            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Kambing</h5>
                        <p class="display-4 font-weight-bold">50</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Kambing Sakit</h5>
                        <p class="display-4">3</p>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Jadwal Suntik Hari Ini</h5>
                        <p class="display-4">12</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/api/dashboard/stats') //url api
            .then(response => response.json())
            .then(result => {
                if(result.status === 'success') {
                    document.getElementById('total-kambing').innerText = result.data.total_kambing;
                    document.getElementById('kambing-sakit').innerText = result.data.kambing_sakit;
                    document.getElementById('jadwal-suntik').innerText = result.data.jadwal_hari_ini;
                }
            })
            .catch(error => console.error('Waduh, ada error ambil data:', error));
    });
</script>
@endsection