<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Booking Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: #fff;
        }

        header {
            background: #1f2937;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            color: #38bdf8;
        }

        nav a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #38bdf8;
        }

        .container {
            padding: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 28px;
            color: #38bdf8;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background: #1e293b;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7);
        }

        .card i {
            font-size: 36px;
            margin-bottom: 15px;
            color: #38bdf8;
        }

        .card h3 {
            margin: 10px 0;
            font-size: 20px;
            color: #fff;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card a {
            display: inline-block;
            padding: 8px 15px;
            background: #38bdf8;
            color: #000;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .card a:hover {
            background: #0ea5e9;
        }

        @media (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            nav a {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Doctor Booking Dashboard</h1>
        <nav>
            <a href="/"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="/book"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
            <a href="/doctors"><i class="fas fa-user-md"></i> Doctors</a>
            <a href="/patients"><i class="fas fa-user"></i> Patients</a>
            <a href="/appointments"><i class="fas fa-calendar-check"></i> Appointments</a>
        </nav>
    </header>

    <div class="container">
        <h2>Overview</h2>
        <div class="cards">
            <div class="card">
                <i class="fas fa-user-md"></i>
                <h3>Doctors</h3>
                <p>{{ $doctor_count }}</p>
                <a href="/doctors">View Doctors</a>
            </div>

            <div class="card">
                <i class="fas fa-user"></i>
                <h3>Patients</h3>
                <p>{{ $patient_count }}</p>
                <a href="/patients">View Patients</a>
            </div>

            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Appointments</h3>
                <p>{{ $appointment_count }}</p>
                <a href="/appointments">View Appointments</a>
            </div>
        </div>
    </div>

</body>

</html>