<?php
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('dashboard');
});

Route::get('/students', function (Request $request) {
    $query = Student::query();
    $schoolCode = $request->get('schoolcode');

    if ($schoolCode) {
        $query->where('schoolcode', 'LIKE', "%{$schoolCode}%");
    }

    $students = $query->orderBy('id', 'desc')->get();
    $count = Student::count();
    $schools = Student::select('schoolcode')->distinct()->pluck('schoolcode');

    return view('students', compact('students', 'count', 'schoolCode', 'schools'));
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
        'pname' => 'required',
        'pcontact' => 'required',
        'address1' => 'required',
        'pincode' => 'required',
    ]);

    $data = $request->only([
        'schoolcode', 'erpid', 'rollno',
        'fname', 'mname', 'lname',
        'class', 'div',
        'dob', 'bloodgroup',
        'pname', 'pcontact',
        'address1', 'address2', 'landmark', 'pincode',
    ]);

    // Handle photo if provided (Base64 or path)
    if ($request->filled('photo')) {
        $photoInput = $request->photo;
        $photoData = null;

        if (str_starts_with($photoInput, 'data:image')) {
            $rawBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $photoInput);
            $photoData = base64_decode(str_replace(' ', '+', $rawBase64));
        } elseif (str_starts_with($photoInput, 'file://')) {
            $filePath = str_replace('file://', '', $photoInput);
            if (file_exists($filePath)) {
                $photoData = file_get_contents($filePath);
            }
        } elseif (file_exists($photoInput)) {
            $photoData = file_get_contents($photoInput);
        }

        if ($photoData) {
            $dir = storage_path('app/public/photos');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $filename = 'photos/' . uniqid('student_') . '.png';
            file_put_contents(storage_path('app/public/' . $filename), $photoData);
            $data['photo'] = $filename;
        } else {
            // Keep existing photo if not changed during update
            if ($request->filled('id') && (!str_starts_with($photoInput, 'file://') && !str_starts_with($photoInput, 'data:'))) {
                $existing = Student::find($request->id);
                if ($existing && $existing->photo) {
                    $data['photo'] = $existing->photo;
                } else {
                    $data['photo'] = $photoInput;
                }
            } else {
                $data['photo'] = $photoInput;
            }
        }
    }

    if ($request->filled('id')) {
        $student = Student::findOrFail($request->id);
        $student->update($data);
    } else {
        $student = Student::create($data);
    }

    $count = Student::count();
    return view('success', compact('student', 'count'));
});

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Native\Mobile\Events\Camera\PhotoTaken;
use Native\Mobile\Events\Gallery\MediaSelected;

function getPhotoAsBase64($path) {
    if (!$path) return null;
    if (str_starts_with($path, 'data:image')) return $path;

    $cleanPath = str_replace('file://', '', $path);
    if (file_exists($cleanPath)) {
        $content = @file_get_contents($cleanPath);
        if ($content) {
            return 'data:image/jpeg;base64,' . base64_encode($content);
        }
    }
    return $path;
}

Event::listen(PhotoTaken::class, function (PhotoTaken $event) {
    Log::info('PhotoTaken event received!', ['path' => $event->path]);
    $path = $event->path;
    if ($path) {
        $base64 = getPhotoAsBase64($path);
        Cache::put('latest_photo', $base64, 120);
    }
});

Event::listen(MediaSelected::class, function ($event) {
    Log::info('MediaSelected event received!', ['event' => $event]);
    $path = null;
    if (is_object($event)) {
        $path = $event->path ?? null;
        if (!$path && isset($event->files) && is_array($event->files) && count($event->files) > 0) {
            $fileObj = $event->files[0];
            $path = is_array($fileObj) ? ($fileObj['path'] ?? null) : ($fileObj->path ?? null);
        }
    } elseif (is_array($event)) {
        $path = $event['path'] ?? ($event['files'][0]['path'] ?? null);
    }

    if ($path) {
        $base64 = getPhotoAsBase64($path);
        Cache::put('latest_photo', $base64, 120);
    }
});

Route::get('/check-photo', function (Request $request) {
    if ($request->has('clear')) {
        Cache::forget('latest_photo');
        return response()->json(['photo' => null]);
    }

    $photo = Cache::pull('latest_photo');
    return response()->json(['photo' => $photo]);
});

Route::get('/convert-path-to-base64', function (Request $request) {
    $path = $request->query('path');
    if (!$path) {
        return response()->json(['base64' => null]);
    }

    $base64 = getPhotoAsBase64($path);
    return response()->json(['base64' => $base64]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/register', function (Request $request) {
    $student = null;
    if ($request->has('id')) {
        $student = Student::find($request->id);
    }

    $schoolCode = $request->schoolcode ?? ($student->schoolcode ?? '');
    $count = Student::count();

    return view('register', compact('student', 'schoolCode', 'count'));
});

Route::get('/students/{id}/edit', function ($id) {
    $student = Student::findOrFail($id);
    $schoolCode = $student->schoolcode;
    $count = Student::count();

    return view('register', compact('student', 'schoolCode', 'count'));
});

Route::get('/success', function () {
    $student = Student::latest()->first();
    $count = Student::count();

    return view('success', compact('student', 'count'));
});
