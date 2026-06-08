# MyAppointment - Web Programming II Final Project

MyAppointment is a modern, web-based Clinic and Hospital Appointment Management System developed as a final project for Web Programming II. Built with Laravel, TailwindCSS v4, Bootstrap 5, and Alpine.js, it streamlines the booking, queue management, and examination process for patients, doctors, and administrative staff.

---

## Technical Stack & Architecture

This project is built using a modern PHP/JS ecosystem:

- **Framework:** Laravel 13.x (PHP 8.3+)
- **Styling & UI:** TailwindCSS v4 (integrated via Vite plugin), Bootstrap 5.3, and Custom CSS
- **Interactive UI:** Alpine.js for lightweight reactivity
- **Database:** PostgreSQL utilizing ULIDs (Universally Unique Lexicographical Identifiers) for robust database scaling and security
- **Testing:** PHPUnit integration tests

---

## Role-Based Features

MyAppointment implements a secure, role-based access control system split into three roles:

| Role | Key Capabilities |
| :--- | :--- |
| **Patient** | - Register and manage a patient profile.<br>- Book appointments with specific doctors and polyclinics.<br>- View appointment schedules and real-time statuses (Pending, Approved, Cancelled, Completed).<br>- Access personal medical history records, diagnostic summaries, actions, and prescriptions. |
| **Doctor** | - Access a personalized doctor dashboard.<br>- View assigned patient appointments.<br>- Approve or cancel booking requests.<br>- Record medical findings (diagnoses, treatments, and prescriptions) for patients during checkups. |
| **Admin** | - Comprehensive user management (CRUD operations for Users, Doctors, Patients, and Clinics).<br>- Operational queue management (create queues, track queue progress, mark entries as completed, or delete queue entries).<br>- View historical queue logs. |

---

## Project Structure

The project organizes its web routes into context-specific modules:

- **Routes:**
  - `routes/web.php` - General landing, authentication, and registration routes.
  - `routes/admin.php` - Protected endpoints for system administrators.
  - `routes/doctor.php` - Secure dashboard and examination endpoints for doctors.
  - `routes/patient.php` - Portal for booking appointments and checking medical histories.

- **Models:**
  - `User` - Authentication account base with role definitions (`admin`, `doctor`, `patient`).
  - `Patient` - Profile details linked to a user account (address, birthdate, phone).
  - `Doctor` - Profile details containing specializations.
  - `Clinic` - Polyclinic definitions (e.g. Umum, Gigi, Anak).
  - `Appointment` - Bookings linking Patient, Doctor, and Clinic with scheduling date and status.
  - `MedicalRecord` - Examination details recorded after appointment completion.

---

## Getting Started

### Prerequisites

Ensure you have the following installed on your machine:
- PHP >= 8.3
- Composer
- Node.js & NPM
- Database engine (PostgreSQL is used by default)

### Setup & Installation

You can set up the application using either the automated setup script or the manual steps below.

#### Option 1: Automated Setup (Recommended)

The project includes a pre-configured Composer command that installs dependencies, creates files, runs migrations, and compiles UI assets automatically:

```bash
composer run setup
```

#### Option 2: Manual Installation

If you prefer executing steps manually, run the following commands in order:

1. **Clone & Navigate:**
   ```bash
   git clone <repository-url>
   cd MyAppointment
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   Copy the example environment file and generate the application key:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Prepare Database:**
   Ensure database configuration in `.env` is correct. Then run migrations and database seeders to populate initial clinics, users, and histories:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets:**
   ```bash
   npm run build
   ```

---

## Running the Application

### Development Environment

To run the full suite concurrently (including PHP local server, Vite hot-reload, and queue listeners), run:

```bash
composer run dev
```

Alternatively, you can run the primary services in separate terminal windows:
```bash
# Terminal 1: Run the Laravel built-in web server
php artisan serve

# Terminal 2: Run the Vite asset compiler
npm run dev
```

---

## Seeded Authentication Accounts

You can log in to the system using the following seeded testing credentials. The default password for all seeded accounts is **`password`**.

| Role | Username | Email Address | Password |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `admin@hospital.com` | `password` |
| **Doctor** | `doctor1` ... `doctor10` | `doctor[1-10]@hospital.com` | `password` |
| **Patient** | `patient1` ... `patient40` | `patient[1-40]@gmail.com` | `password` |

---

## Running Tests

To verify code correctness and route protections, run the suite of feature tests:

```bash
composer run test
```

Or run directly through artisan:
```bash
php artisan test
```

---

## Academic Information

This project is a final project submission for the Web Programming II course.

| Identifier | Details |
| :--- | :--- |
| **Course** | Web Programming II (Pemrograman Web II) |
| **Course Instructor** | Ir. Muhammad Alkaff, S.Kom., M.Kom., Ph.D. |
| **Institution** | Lambung Mangkurat University (Universitas Lambung Mangkurat) |
| **Academic Year** | 2026 |
| **Development Group** | Group 6 |
| **Group Members** | - Achmad Reihan Alfaiz (2410817210019)<br>- Afrian Pradipta Rizky (2410817210028)<br>- Helga Lathif Martiza (2410817210025) |