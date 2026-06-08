<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Services\Patient\PatientServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class PatientAppointmentHistoryTest extends TestCase
{
    use RefreshDatabase;

    private User $patientUser;
    private Patient $patient;
    private Doctor $doctor;
    private Clinic $clinic;

    protected function setUp(): void
    {
        parent::setUp();

        $this->patientUser = User::create([
            'name' => 'Gamani Viktor',
            'username' => 'gamaniviktor',
            'email' => 'gamani@test.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
        ]);

        $this->patient = Patient::create([
            'user_id' => $this->patientUser->id,
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'address' => 'Test Address',
        ]);

        $doctorUser = User::create([
            'name' => 'Kala Nababan',
            'username' => 'kalajani',
            'email' => 'kala@test.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
        ]);

        $this->doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'Anak',
        ]);

        $this->clinic = Clinic::create([
            'name' => 'Poli Anak',
            'description' => 'Children Clinic',
        ]);
    }

    public function test_cancelled_appointment_moves_to_history(): void
    {
        // 1. Create a pending appointment
        $pendingAppt = Appointment::create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'clinic_id' => $this->clinic->id,
            'appointment_datetime' => Carbon::now()->addDays(5),
            'status' => 'pending',
            'complaint' => 'Anak demam tinggi',
        ]);

        // 2. Create a cancelled appointment
        $cancelledAppt = Appointment::create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'clinic_id' => $this->clinic->id,
            'appointment_datetime' => Carbon::now()->subDays(2),
            'status' => 'cancelled',
            'complaint' => 'Anak batuk pilek',
        ]);

        // 3. Authenticate patient and run service calls
        $this->actingAs($this->patientUser);
        $service = app(PatientServices::class);

        $upcoming = $service->getUpcomingAppointments();
        $history = $service->getPatientHistory();

        // 4. Assertions on service results
        // Upcoming should only contain the pending one
        $this->assertCount(1, $upcoming);
        $this->assertEquals($pendingAppt->id, $upcoming[0]['id']);

        // History should contain the cancelled one
        $this->assertCount(1, $history);
        $this->assertEquals($cancelledAppt->id, $history[0]['id']);
        $this->assertTrue($history[0]['is_cancelled']);
        $this->assertEquals('Dibatalkan', $history[0]['type']);

        // 5. Test Patient Dashboard view loads and renders components correctly
        $response = $this->get(route('patient.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Gamani Viktor');
        $response->assertSee('Kala Nababan');      // Doctor name
        $response->assertSee('Dibatalkan');        // Canceled history item

        // 6. Test Medical History Detail view for cancelled appointment
        $detailResponse = $this->get(route('patient.MedicalHistory.Detail', $cancelledAppt->id));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Pendaftaran Dibatalkan');
        $detailResponse->assertSee('Tidak ada tindakan (Dibatalkan)');
    }
}
