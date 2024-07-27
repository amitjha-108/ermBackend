<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    //Superadmin register api
    public function registerSuperadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'contact' => 'required|string|max:20|unique:users',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,
            'contact' => $request->contact,
            'photo' => $photoPath ?? null,
        ]);

        $token = $user->createToken('auth-token')->accessToken;

        return response()->json(['user' => $user, 'access_token' => $token], 201);
    }

    // Login API
    public function login(Request $request)
    {
        $credentials = $request->only('contact', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->accessToken;

            return response()->json(['message' => 'User Logged In Successfully!', 'user' => $user, 'access_token' => $token], 200);
        } else {
            return response()->json(['message' => 'Invalid Credentials'], 200);
        }
    }

    //add employee with some details to create username and password
    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20|unique:users',
            'role' => 'required|string',
            'officialID' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'role' => $request->role,
            'officialID' => $request->officialID,
            'password' => Hash::make($request->contact),
        ]);

        return response()->json(['message' => 'Employee Added Successfully!', 'user' => $user], 201);
    }

    //list all employees with role filter
    public function getEmployees(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $role = $request->input('role');
        $employees = User::where('role', $role)->get();

        return response()->json(['message' => 'Data Retrieved Successfully!', 'employees' => $employees], 200);
    }

    public function getEmployeeById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Employee not found.'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function updateEmployee(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20|unique:users,contact,' . $user->id,
            'role' => 'required|string',
            'officialID' => 'nullable|string',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'nullable|string',
            'designation' => 'nullable|string',
            'officeLocation' => 'nullable|string',
            'department' => 'nullable|string',
            'education' => 'nullable|string',
            'pan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'aadhar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'passbook' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'offerLetter' => 'nullable|mimes:pdf|max:10240',
            'PFNO' => 'nullable|string',
            'ESINO' => 'nullable|string',
            'joiningDate' => 'nullable|string',
            'leavingDate' => 'nullable|string',
            'jobStatus' => 'nullable|string',
            'about' => 'nullable|string',
            'dob' => 'nullable|string',
            'salary' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user->name = $request->input('name', $user->name);
        $user->contact = $request->input('contact', $user->contact);
        $user->role = $request->input('role', $user->role);
        $user->officialID = $request->input('officialID', $user->officialID);
        $user->email = $request->input('email', $user->email);
        $user->address = $request->input('address', $user->address);
        $user->designation = $request->input('designation', $user->designation);
        $user->officeLocation = $request->input('officeLocation', $user->officeLocation);
        $user->department = $request->input('department', $user->department);
        $user->education = $request->input('education', $user->education);
        $user->PFNO = $request->input('PFNO', $user->PFNO);
        $user->ESINO = $request->input('ESINO', $user->ESINO);
        $user->joiningDate = $request->input('joiningDate', $user->joiningDate);
        $user->leavingDate = $request->input('leavingDate', $user->leavingDate);
        $user->jobStatus = $request->input('jobStatus', $user->jobStatus);
        $user->about = $request->input('about', $user->about);
        $user->dob = $request->input('dob', $user->dob);
        $user->salary = $request->input('salary', $user->salary);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photo = $request->file('photo');
            $user->photo = $photo->store('images', 'public');
        }

        if ($request->hasFile('pan')) {
            if ($user->pan) {
                Storage::disk('public')->delete($user->pan);
            }
            $pan = $request->file('pan');
            $user->pan = $pan->store('pan', 'public');
        }

        if ($request->hasFile('aadhar')) {
            if ($user->aadhar) {
                Storage::disk('public')->delete($user->aadhar);
            }
            $aadhar = $request->file('aadhar');
            $user->aadhar = $aadhar->store('aadhar', 'public');
        }

        if ($request->hasFile('passbook')) {
            if ($user->passbook) {
                Storage::disk('public')->delete($user->passbook);
            }
            $passbook = $request->file('passbook');
            $user->passbook = $passbook->store('passbook', 'public');
        }

        if ($request->hasFile('offerLetter')) {
            if ($user->offerLetter) {
                Storage::disk('public')->delete($user->offerLetter);
            }
            $offerLetter = $request->file('offerLetter');
            $user->offerLetter = $offerLetter->store('offerLetter', 'public');
        }
        $user->save();

        return response()->json(['message' => 'Employee updated successfully!', 'user' => $user], 200);
    }


    public function deleteEmployee($id)
    {
        $employee = User::find($id);

        if (! $employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully!'], 200);
    }

    public function addClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $client = Client::create($request->all());

        return response()->json(['message' => 'Client Added Successfully!', 'client' => $client], 201);
    }

    public function updateClient(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $client = Client::find($id);

        if (! $client) {
            return response()->json(['error' => 'Client not found'], 404);
        }

        $client->name = $request->input('name', $client->name);
        $client->website = $request->input('website', $client->website);
        $client->description = $request->input('description', $client->description);
        $client->save();

        return response()->json(['message' => 'Client Updated Successfully!', 'client' => $client], 200);
    }

    public function getClients()
    {
        $clients = Client::all();

        return response()->json(['message' => 'Clients retrieved successfully!', 'clients' => $clients], 200);
    }

    public function deleteClient($id)
    {
        $client = Client::find($id);

        if (! $client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
        $client->delete();

        return response()->json(['message' => 'Client deleted successfully!'], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'designation' => 'required|string',
            'officeLocation' => 'required|string',
            'department' => 'required|string',
            'education' => 'required|string',
            'pan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'aadhar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'passbook' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'offerLetter' => 'nullable|mimes:pdf|max:10240',
            'PFNO' => 'nullable|string',
            'ESINO' => 'nullable|string',
            'joiningDate' => 'nullable|string',
            'leavingDate' => 'nullable|string',
            'jobStatus' => 'nullable|string',
            'about' => 'nullable|string',
            'dob' => 'nullable|string',
            'salary' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photo = $request->file('photo');
            $photoPath = $photo->store('images', 'public');
            $user->photo = $photoPath;
        }

        if ($request->hasFile('pan')) {
            if ($user->pan) {
                Storage::disk('public')->delete($user->pan);
            }
            $pan = $request->file('pan');
            $panPath = $pan->store('pan', 'public');
            $user->pan = $panPath;
        }

        if ($request->hasFile('aadhar')) {
            if ($user->aadhar) {
                Storage::disk('public')->delete($user->aadhar);
            }
            $aadhar = $request->file('aadhar');
            $aadharPath = $aadhar->store('aadhar', 'public');
            $user->aadhar = $aadharPath;
        }

        if ($request->hasFile('passbook')) {
            if ($user->passbook) {
                Storage::disk('public')->delete($user->passbook);
            }
            $passbook = $request->file('passbook');
            $passbookPath = $passbook->store('passbook', 'public');
            $user->passbook = $passbookPath;
        }

        if ($request->hasFile('offerLetter')) {
            if ($user->offerLetter) {
                Storage::disk('public')->delete($user->offerLetter);
            }
            $offerLetter = $request->file('offerLetter');
            $offerLetterPath = $offerLetter->store('offerLetter', 'public');
            $user->offerLetter = $offerLetterPath;
        }

        $user->email = $request->input('email', $user->email);
        $user->address = $request->input('address', $user->address);
        $user->designation = $request->input('designation', $user->designation);
        $user->officeLocation = $request->input('officeLocation', $user->officeLocation);
        $user->department = $request->input('department', $user->department);
        $user->education = $request->input('education', $user->education);
        $user->PFNO = $request->input('PFNO', $user->PFNO);
        $user->ESINO = $request->input('ESINO', $user->ESINO);
        $user->joiningDate = $request->input('joiningDate', $user->joiningDate);
        $user->leavingDate = $request->input('leavingDate', $user->leavingDate);
        $user->jobStatus = $request->input('jobStatus', $user->jobStatus);
        $user->about = $request->input('about', $user->about);
        $user->dob = $request->input('dob', $user->dob);
        $user->salary = $request->input('salary', $user->salary);

        $user->save();

        return response()->json(['message' => 'Profile updated successfully!', 'user' => $user], 200);
    }
}
