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
            Log::error('Failed to load address list: ' . $e->getMessage());
            return back()->withErrors('Failed to load address list.');
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
            return redirect()->route('profile.addresses.index')->with('success', 'Address added successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Failed to add address.');
        }
    }

    public function show($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            return view('profile.addresses.show', compact('address'));
        } catch (Exception $e) {
            return back()->withErrors('Failed to display address details.');
        }
    }

    public function edit($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            return view('profile.addresses.edit', compact('address'));
        } catch (Exception $e) {
            return back()->withErrors('Failed to open edit address form.');
        }
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            $this->addresses->update($address, $request->validated());
            return redirect()->route('profile.addresses.index')->with('success', 'Address updated successfully.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors('Failed to update address.');
        }
    }

    public function destroy($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            $this->addresses->delete($address);
            return redirect()->route('profile.addresses.index')->with('success', 'Address deleted successfully.');
        } catch (Exception $e) {
            return back()->withErrors('Failed to delete address.');
        }
    }

    public function setDefault($id)
    {
        try {
            $address = $this->addresses->findOrFail($id);
            $this->addresses->setDefault($address, Auth::id());
            return back()->with('success', 'Default address updated successfully.');
        } catch (Exception $e) {
            return back()->withErrors('Failed to set default address.');
        }
    }
}