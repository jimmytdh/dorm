<style>
    h3 {
        transition: all 0.2s ease-in-out;
    }
</style>

<h2 class="font-weight-bold"><span class="text-danger">Hello, </span>{{ auth()->user()->fname.' '.auth()->user()->lname }}</h2>
<hr>
<div class="row mb-8">
    <div class="col-md-12">
        <!-- card -->
        <div class="card bg-light border-0 rounded-4" style="background-image: url({{ asset('images/banner.jpg') }}); background-repeat: no-repeat; background-size: cover; background-position: right">
            <div class="card-body p-lg-5">
                <div class="col-sm-12 col-lg-6">
                    <h1>Welcome to NONESCOST Multi - Purpose Cooperative Dormitory Management System</h1>
                    <p>The Dormitory Management System is designed to streamline dormitory administration by automating tasks like student registrations, room assignments, and occupancy tracking. </p>
                    <a href="{{ url('beds/assignment') }}" class="handle-link btn btn-primary">Bed Assignment</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-6">
        <div class="small-box py-3 bg-primary">
            <div class="inner">
                <h3 class="badge-earning">₱{{ number_format($data['earned'],2) }}</h3>
                <p>{{ date('F') }} earning</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-6">
        <div class="small-box py-3 bg-info">
            <div class="inner">
                <h3 class="badge-created">{{ $data['beds'] }}</h3>
                <p>No. of Beds</p>
            </div>
            <div class="icon">
                <i class="fas fa-bed"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-6">
        <div class="small-box py-3 bg-success">
            <div class="inner">
                <h3 class="badge-pending">{{ $data['residents'] }}</h3>
                <p>Residents</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-6">

        <div class="small-box py-3 bg-warning">
            <div class="inner">
                <h3 class="badge-complete">{{ $data['available'] }}</h3>
                <p>Available Beds</p>
            </div>
            <div class="icon">
                <i class="fas fa-bed"></i>
            </div>
        </div>
    </div>

</div>
<div class="row p-2 hidden">
    <div class="card col-12">
        <div class="card-body">
            <canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $("#loader-wrapper").show();
        function animateValue(id, start, end, duration) {
            end = parseInt(end, 10); // Convert end to a number
            if (end === 0) {
                return true;
            }

            let range = end - start;
            let current = start;
            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(Math.floor(duration / range));
            let obj = $(id);

            let timer = setInterval(function() {
                current += increment;
                obj.text(current);
                if (current === end) {
                    clearInterval(timer);
                }
                console.log('ok')
            }, stepTime);

        }

        setTimeout(function(){
            $("#loader-wrapper").hide();
        },1000);

        animateValue(".badge-created", 0, $('.badge-created').text(), 1000); // Animate from 0 to 100 in 2 seconds
        animateValue(".badge-pending", 0, $('.badge-pending').text(), 1000); // Animate from 0 to 200 in 2 seconds
        animateValue(".badge-complete", 0, $('.badge-complete').text(), 1000); // Animate from 0 to 200 in 2 seconds
    });
</script>
