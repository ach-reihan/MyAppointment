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

    public function test_completed_appointment_moves_to_history(): void
    {
        // 1. Create a completed appointment (e.g. marked completed by admin, without medical record)
        $completedApptNoRecord = Appointment::create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'clinic_id' => $this->clinic->id,
            'appointment_datetime' => Carbon::now()->subDays(3),
            'status' => 'completed',
            'complaint' => 'Sakit pinggang',
        ]);

        // 2. Create a completed appointment with medical record (completed by doctor)
        $completedApptWithRecord = Appointment::create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'clinic_id' => $this->clinic->id,
            'appointment_datetime' => Carbon::now()->subDays(1),
            'status' => 'completed',
            'complaint' => 'Sakit mata',
        ]);

        $medicalRecord = MedicalRecord::create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'appointment_id' => $completedApptWithRecord->id,
            'checkup_date' => Carbon::now()->subDays(1),
            'diagnoses' => 'Kelelahan mata',
            'action' => 'Diberikan tetes mata',
            'prescription' => 'Tetes Mata Cendo X',
        ]);

        // 3. Authenticate patient and run service calls
        $this->actingAs($this->patientUser);
        $service = app(PatientServices::class);

        $upcoming = $service->getUpcomingAppointments();
        $history = $service->getPatientHistory();

        // Upcoming should not contain completed appointments
        $this->assertCount(0, $upcoming);

        // History should contain both completed appointments
        $this->assertCount(2, $history);

        // Assertions for appointment with medical record
        $this->assertEquals($completedApptWithRecord->id, $history[0]['id']);
        $this->assertEquals('Kelelahan mata', $history[0]['diagnosis']);
        $this->assertEquals('Diberikan tetes mata', $history[0]['treatment']);

        // Assertions for appointment without medical record (completed by admin)
        $this->assertEquals($completedApptNoRecord->id, $history[1]['id']);
        $this->assertEquals('Pemeriksaan Selesai', $history[1]['diagnosis']);
        $this->assertEquals('Tidak ada tindakan (Selesai)', $history[1]['treatment']);

        // Test Medical History Detail views
        $detailResponseRecord = $this->get(route('patient.MedicalHistory.Detail', $completedApptWithRecord->id));
        $detailResponseRecord->assertStatus(200);
        $detailResponseRecord->assertSee('Kelelahan mata');
        $detailResponseRecord->assertSee('Diberikan tetes mata');

        $detailResponseNoRecord = $this->get(route('patient.MedicalHistory.Detail', $completedApptNoRecord->id));
        $detailResponseNoRecord->assertStatus(200);
        $detailResponseNoRecord->assertSee('Pemeriksaan Selesai');
        $detailResponseNoRecord->assertSee('Tidak ada tindakan (Selesai)');
    }
}
