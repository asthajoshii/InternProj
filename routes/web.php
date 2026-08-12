<?php
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('dashboard');
});

Route::get('/students', function () {
    $students = Student::all();
    $count = Student::count();

    return view('students', compact('students', 'count'));
});

Route::post('/students', function (Request $request) {

    $request->validate([
    'schoolcode' => 'required',
    'erpid' => 'required',
    'rollno' => 'required',

    'fname' => 'required',
    'lname' => 'required',

    'class' => 'required',
    'div' => 'required',

    'dob' => 'nullable',
    'bloodgroup' => 'nullable',

    'pname' => 'required',
    'pcontact' => 'required',

    'address1' => 'required',
    'address2' => 'nullable',
    'landmark' => 'nullable',
    'pincode' => 'required',

    'photo' => 'nullable',
]);
    Student::create($request->all());
    return redirect('/success');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/register', function (Request $request) {

    $schoolCode = $request->school_code;

    $count = Student::count();

    return view('register', compact('schoolCode', 'count'));

});
Route::get('/success', function () {

    $student = Student::latest()->first();

    $count = Student::count();

    return view('success', compact('student','count'));

});
