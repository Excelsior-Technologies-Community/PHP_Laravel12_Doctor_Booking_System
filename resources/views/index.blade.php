<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: #fff;
        }

        /* Top Navbar */
        .navbar {
            background: #1f2937;
            padding: 15px 40px;
            display: flex;
            justify-content: flex-start;
            gap: 25px;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .navbar a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .navbar a:hover {
            color: #38bdf8;
        }

        /* Container for form */
        .container {
            max-width: 450px;
            margin: 40px auto;
            padding: 20px;
        }

        /* Card */
        .card {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            color: #38bdf8;
            margin-bottom: 25px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #38bdf8;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }

        button:hover {
            background: #0ea5e9;
        }

        .link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #38bdf8;
            text-decoration: none;
            font-weight: bold;
        }

        .success {
            background: #16a34a;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        @media(max-width:500px) {
            .container {
                width: 90%;
            }

            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <div class="navbar">
        <a href="/"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="/book"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
        <a href="/doctors"><i class="fas fa-user-md"></i> Doctors</a>
        <a href="/patients"><i class="fas fa-user"></i> Patients</a>
        <a href="/appointments"><i class="fas fa-calendar-check"></i> Appointments</a>
    </div>

    <!-- Booking Form -->
    <div class="container">
        <div class="card">
            <h2>Book Appointment</h2>

            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="/book">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone" required>

                <select name="doctor_id" required>
                    <option value="" disabled selected>Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                    @endforeach
                </select>

                <input type="date" name="date" required>
                <input type="time" name="time" required>

                <button type="submit"><i class="fas fa-paper-plane"></i> Book Appointment</button>
            </form>

            <a href="/appointments" class="link"><i class="fas fa-eye"></i> View Appointments →</a>
        </div>
    </div>

</body>

</html>