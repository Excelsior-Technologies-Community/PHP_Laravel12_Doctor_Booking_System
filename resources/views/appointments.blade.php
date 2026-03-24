<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: white;
        }

        header {
            background: #1f2937;
            padding: 15px 40px;
            display: flex;
            gap: 20px;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        header a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        header a i {
            margin-right: 6px;
        }

        header a:hover {
            color: #38bdf8;
        }

        .container {
            padding: 40px;
            max-width: 900px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #38bdf8;
            margin-bottom: 30px;
        }

        .card {
            background: #1e293b;
            padding: 20px;
            margin: 15px auto;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        p {
            margin: 5px 0;
            font-size: 16px;
        }

        .cancel-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #ef4444;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background: #dc2626;
        }
    </style>
</head>

<body>

    <header>
        <a href="/"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="/book"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
        <a href="/doctors"><i class="fas fa-user-md"></i> Doctors</a>
        <a href="/patients"><i class="fas fa-user"></i> Patients</a>
        <a href="/appointments"><i class="fas fa-calendar-check"></i> Appointments</a>
    </header>

    <div class="container">
        <h2>All Appointments</h2>
        @foreach($appointments as $a)
            <div class="card">
                <p><strong>Doctor:</strong> {{ $a->doctor->name }}</p>
                <p><strong>Patient:</strong> {{ $a->patient->name }}</p>
                <p><strong>Date:</strong> {{ $a->date }}</p>
                <p><strong>Time:</strong> {{ $a->time }}</p>
                <a href="/cancel/{{ $a->id }}" class="cancel-btn"><i class="fas fa-times-circle"></i> Cancel</a>
            </div>
        @endforeach
    </div>

</body>

</html>