# PHP_Laravel12_Doctor_Booking_System


## Project Description

The Doctor Booking System is a simple and modern web application built with Laravel 12. It allows patients to book appointments with doctors, while administrators or users can manage doctors, patients, and appointments through an intuitive dashboard interface.

This system is designed for small clinics or hospitals where keeping track of appointments, doctors, and patients in a centralized system is necessary. It uses a dark-themed responsive UI with cards and forms for a clean user experience.

The project demonstrates practical usage of Laravel models, migrations, controllers, routing, Blade templating, and relationships between entities.



## Features

- Dashboard: Overview of doctors, patients, appointments.
- Book Appointment: Patients can select doctor, date, and time.
- View Doctors & Patients: List all doctors and patients.
- Manage Appointments: View all appointments and cancel if needed.
- Responsive Dark Mode UI.


## Technologies

- Laravel 12 
- PHP 8.x
- MySQL
- Blade Templates, CSS / Flexbox / Grid
- Font Awesome



---

## Installation Steps

---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Doctor_Booking_System "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Doctor_Booking_System

```

#### Explanation:

Installs a fresh Laravel 12 project in a new folder.

Navigates into the project directory to run further commands.




## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_doctor_booking
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_doctor_booking

```

### Then Run:

```
php artisan migrate

```


#### Explanation:

Connects Laravel to MySQL and creates default tables for the project.




## STEP 3: Create Models + Migrations 

### Run:

```
php artisan make:model Doctor -m
php artisan make:model Patient -m
php artisan make:model Appointment -m

```

#### Explanation: 

Creates models and migration files for Doctors, Patients, and Appointments.




## STEP 4: Database Structure

### Open: database/migrations/xxxx_create_doctors_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialization');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

```

#### Explanation: 

Defines the doctors table with name, specialization, and phone columns.




### Open: database/migrations/xxxx_create_patients_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

```

#### Explanation: 

Defines the patients table with basic patient info.




### Open: database/migrations/xxxx_create_appointments_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->string('status')->default('Booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

```

#### Explanation: 

Appointments table links doctors and patients with date, time, and status.


### Then Run:

```
php artisan migrate

```

#### Explanation: 

Creates the three tables in the database.





## STEP 5: Model Relationships


### app/Models/Doctor.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'specialization', 'phone'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

```

#### Explanation: 

A doctor can have multiple appointments.



### app/Models/Patient.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone']; // ✅ allow mass assignment

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

```

#### Explanation: 

A patient can have multiple appointments.




### app/Models/Appointment.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'patient_id', 'date', 'time']; // ✅ allow mass assignment

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

```

#### Explanation: 

An appointment belongs to one doctor and one patient.




## STEP 6: Create Controller

### Run:

```
php artisan make:controller BookingController

```

### Open: app/Http/Controllers/BookingController.php

```
<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('index', compact('doctors'));
    }

    public function book(Request $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->back()->with('success', 'Appointment Booked!');
    }

    public function appointments()
    {
        $appointments = Appointment::with('doctor', 'patient')->get();
        return view('appointments', compact('appointments'));
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        return view('doctors', compact('doctors'));
    }

    public function patients()
    {
        $patients = Patient::all();
        return view('patients', compact('patients'));
    }

    public function dashboard()
    {
        $doctor_count = Doctor::count();
        $patient_count = Patient::count();
        $appointment_count = Appointment::count();
        return view('dashboard', compact('doctor_count', 'patient_count', 'appointment_count'));
    }

    public function cancel($id)
    {
        Appointment::find($id)->delete();
        return back();
    }
}

```

#### Explanation: 

Contains functions to display dashboards, book appointments, list doctors/patients/appointments, and cancel appointments.





## STEP 7: Add Routes

### routes/web.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// Dashboard as first page
Route::get('/', [BookingController::class, 'dashboard']);

// Booking Form
Route::get('/book', [BookingController::class, 'index']); // show form
Route::post('/book', [BookingController::class, 'book']); // submit form

// Other pages
Route::get('/appointments', [BookingController::class, 'appointments']);
Route::get('/cancel/{id}', [BookingController::class, 'cancel']);
Route::get('/doctors', [BookingController::class, 'doctors']);
Route::get('/patients', [BookingController::class, 'patients']);

```

#### Explanation: 

Defines all URL routes for the dashboard, booking, viewing doctors/patients/appointments, and canceling appointments.




## STEP 8: View Blade UI


### resources/views/index.blade.php

```
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

```


### resources/views/appointments.blade.php

```
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

```



### resources/views/dashboard.blade.php

```
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

```



### resources/views/doctors.blade.php

```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Doctors</title>
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
            max-width: 800px;
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
        <h2>All Doctors</h2>
        @foreach($doctors as $doctor)
            <div class="card">
                <p><strong>Name:</strong> {{ $doctor->name }}</p>
                <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
            </div>
        @endforeach
    </div>

</body>

</html>

```


### resources/views/patients.blade.php

```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Patients</title>
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
            max-width: 800px;
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
        <h2>All Patients</h2>
        @foreach($patients as $patient)
            <div class="card">
                <p><strong>Name:</strong> {{ $patient->name }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                <p><strong>Phone:</strong> {{ $patient->phone }}</p>
            </div>
        @endforeach
    </div>

</body>

</html>

```

#### Explanation: 

Blade files create the user interface with dark mode, cards, forms, and a top navbar with icons for consistency.





## STEP 9: Add Dummy Doctors

### Run:

```
php artisan tinker

```

### Write:

```
\App\Models\Doctor::create(['name'=>'Dr. Smith','specialization'=>'Cardiologist','phone'=>'123456']);
\App\Models\Doctor::create(['name'=>'Dr. John','specialization'=>'Dentist','phone'=>'987654']);

```

#### Explanation: 

Adds sample doctor records to test booking functionality.




## STEP 10: Run the App  

### Start dev server:

```
php artisan serve

```

### Open in browser:

```
http://127.0.0.1:8000

```

#### Explanation:

Starts the Laravel development server.

Access the Doctor Booking System in your browser.



## Expected Output:


### Dashboard Overview:


<img src="screenshots/Screenshot 2026-03-24 141300.png" width="900">


### Book Appointment Form:


<img src="screenshots/Screenshot 2026-03-24 141625.png" width="900">


### Booking Confirmation / Success Message:


<img src="screenshots/Screenshot 2026-03-24 141635.png" width="900">


### Doctors List:


<img src="screenshots/Screenshot 2026-03-24 141645.png" width="900">


### Patients List:


<img src="screenshots/Screenshot 2026-03-24 141827.png" width="900">


### Appointments List: 


<img src="screenshots/Screenshot 2026-03-24 141837.png" width="900">


### Updated Dashboard:


<img src="screenshots/Screenshot 2026-03-24 141846.png" width="900">



---

## Project Folder Structure:

```
PHP_Laravel12_Doctor_Booking_System/
│
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── BookingController.php
│   │   ├── Middleware/
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── Appointment.php
│   │   ├── Doctor.php
│   │   └── Patient.php
│   ├── Providers/
│   └── ...
│
├── bootstrap/
│   └── cache/
│
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── xxxx_create_doctors_table.php
│   │   ├── xxxx_create_patients_table.php
│   │   └── xxxx_create_appointments_table.php
│   └── seeders/
│
├── public/
│   ├── index.php
│   └── ...
│
├── resources/
│   ├── views/
│   │   ├── index.blade.php
│   │   ├── appointments.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── doctors.blade.php
│   │   └── patients.blade.php
│   └── ...
│
├── routes/
│   └── web.php
│
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── tests/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock

```
