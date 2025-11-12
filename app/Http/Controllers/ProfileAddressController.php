<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\StoreAddressRequest;
use App\Http\Requests\Profile\UpdateAddressRequest;
use App\Interfaces\AddressRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileAddressController extends Controller
{
    public function __construct(
        private readonly AddressRepositoryInterface $addresses
    ) {}

    public function index()
    {
        try {
            $user = Auth::user();
            $addresses = $this->addresses->allForUser($user->id);
            return view('profile.addresses.index', compact('addresses', 'user'));
        } catch (Exception $e) {
            Log::error('Gagal memuat daftar alamat: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat memuat daftar alamat.');
        }
    }

    public function create()
    {
        return view('profile.addresses.create');
    }

    public function store(StoreAddressRequest $request)
    {
        try {
            $this->addresses->create($request->validated(), Auth::id());
            return redirect()->route('profile.addresses.index')->with('success', 'Alamat berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Gagal menambahkan alamat.');
        }
    }

    public function show($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            return view('profile.addresses.show', compact('address'));
        } catch (Exception $e) {
            return back()->withErrors('Gagal menampilkan detail alamat.');
        }
    }

    public function edit($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            return view('profile.addresses.edit', compact('address'));
        } catch (Exception $e) {
            return back()->withErrors('Tidak dapat membuka form edit alamat.');
        }
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            $this->addresses->update($address, $request->validated());
            return redirect()->route('profile.addresses.index')->with('success', 'Alamat berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Gagal memperbarui alamat.');
        }
    }

    public function destroy($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            $this->addresses->delete($address);
            return redirect()->route('profile.addresses.index')->with('success', 'Alamat berhasil dihapus.');
        } catch (Exception $e) {
            return back()->withErrors('Gagal menghapus alamat.');
        }
    }

    public function setDefault($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            $this->addresses->setDefault($address, Auth::id());
            return back()->with('success', 'Alamat utama berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->withErrors('Gagal mengatur alamat utama.');
        }
    }
}