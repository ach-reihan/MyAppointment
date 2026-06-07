<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\MasterDataService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MasterDataController
{
    public function __construct(
        protected MasterDataService $masterDataService
    ) {}

    public function users(): View
    {
        return view('admin.master-data.users', [
            'users' => $this->masterDataService->getUsers(),
        ]);
    }

    public function storeUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:Admin,Dokter,Pasien',
        ]);

        $this->masterDataService->createUser([
            'username' => $validated['username'],
            'password' => $validated['password'],
            'role'     => $validated['role'],
        ]);

        return response()->json(['success' => true]);
    }

    public function updateUser(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'password' => 'nullable|string|min:8',
            'role'     => 'required|string|in:Admin,Dokter,Pasien',
        ]);

        $this->masterDataService->updateUser($id, [
            'password' => $validated['password'] ?? null,
            'role'     => $validated['role'],
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyUser(string $id): JsonResponse
    {
        $this->masterDataService->deleteUser($id);
        return response()->json(['success' => true]);
    }

    public function doctors(): View
    {
        return view('admin.master-data.doctors', [
            'doctors' => $this->masterDataService->getDoctors()
        ]);
    }

    public function storeDoctor(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string',
            'specialization' => 'required|string|in:Umum,Penyakit Dalam,Spesialis Anak,Bedah',
            'clinics'        => 'nullable|array',
            'clinics.*'      => 'string',
        ]);

        $this->masterDataService->createDoctor([
            'name'           => $validated['name'],
            'specialization' => $validated['specialization'],
            'clinics'        => $validated['clinics'] ?? [],
        ]);

        return response()->json(['success' => true]);
    }

    public function updateDoctor(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name'           => 'required|string',
            'specialization' => 'required|string|in:Umum,Penyakit Dalam,Spesialis Anak,Bedah',
            'clinics'        => 'nullable|array',
            'clinics.*'      => 'string',
        ]);

        $this->masterDataService->updateDoctor($id, [
            'name'           => $validated['name'],
            'specialization' => $validated['specialization'],
            'clinics'        => $validated['clinics'] ?? [],
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyDoctor(string $id): JsonResponse
    {
        $this->masterDataService->deleteDoctor($id);
        return response()->json(['success' => true]);
    }

    public function patients(): View
    {
        return view('admin.master-data.patients', [
            'patients' => $this->masterDataService->getPatients()
        ]);
    }

    public function storePatient(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'          => 'required|string',
            'phone_number'  => 'required|string|regex:/^[0-9+\-\s]+$/',
            'date_of_birth' => 'required|string',
            'address'       => 'required|string',
        ]);

        $this->masterDataService->createPatient([
            'name'          => $validated['name'],
            'phone_number'  => $validated['phone_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'address'       => $validated['address'],
        ]);

        return response()->json(['success' => true]);
    }

    public function updatePatient(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name'          => 'required|string',
            'phone_number'  => 'required|string|regex:/^[0-9+\-\s]+$/',
            'date_of_birth' => 'required|string',
            'address'       => 'required|string',
        ]);

        $this->masterDataService->updatePatient($id, [
            'name'          => $validated['name'],
            'phone_number'  => $validated['phone_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'address'       => $validated['address'],
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyPatient(string $id): JsonResponse
    {
        $this->masterDataService->deletePatient($id);
        return response()->json(['success' => true]);
    }

    public function polyclinics(): View
    {
        return view('admin.master-data.polyclinics', [
            'polyclinics' => $this->masterDataService->getPolyclinics()
        ]);
    }

    public function storePolyclinic(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|in:Poli Umum,Poli Anak,Poli Jantung,Poli Gigi,VIP',
            'description' => 'required|string',
            'status'      => 'required|string|in:AKTIF,NON-AKTIF,MAINTENANCE',
        ]);

        $this->masterDataService->createPolyclinic([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
        ]);

        return response()->json(['success' => true]);
    }

    public function updatePolyclinic(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|in:Poli Umum,Poli Anak,Poli Jantung,Poli Gigi,VIP',
            'description' => 'required|string',
            'status'      => 'required|string|in:AKTIF,NON-AKTIF,MAINTENANCE',
        ]);

        $this->masterDataService->updatePolyclinic($id, [
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyPolyclinic(string $id): JsonResponse
    {
        $this->masterDataService->deletePolyclinic($id);
        return response()->json(['success' => true]);
    }
}