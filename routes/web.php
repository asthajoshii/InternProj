<?php

use App\Services\SchoolConfig;
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Native\Mobile\Facades\Share;
use Illuminate\Support\Facades\Storage; 


/*Route::get('/', function () {
    return view('dashboard');
});*/

// Route to select school code and load its config
Route::get('/', function () {
    $schools = [];

    foreach (glob(storage_path('app/schools/*.json')) as $file) {
        $data = json_decode(file_get_contents($file), true);

        if (isset($data['school_code'], $data['school_name'])) {
            $schools[] = [
                'code' => $data['school_code'],
                'name' => $data['school_name'],
            ];
        }
    }

    return view('dashboard', compact('schools'));
});

Route::post('/dashboard', function (Request $request) {
    $request->validate([
        'school_code' => 'required|string',
    ]);

    try {
        $config = SchoolConfig::load($request->input('school_code'));
    } catch (\Throwable $e) {
        return back()->withErrors(['school_code' => $e->getMessage()]);
    }

        session(['school_code' => $config->schoolCode()]);
        app()->setLocale($config->language());

        return redirect('/register');
});
//end

Route::get('/students', function (Request $request) {
    $query = Student::query();
    $search = $request->get('search') ?? $request->get('schoolcode');

    if (!empty($search)) {
        $query->where(function($q) use ($search) {
            $q->where('schoolcode', 'LIKE', "%{$search}%")
              ->orWhere('fname', 'LIKE', "%{$search}%")
              ->orWhere('mname', 'LIKE', "%{$search}%")
              ->orWhere('lname', 'LIKE', "%{$search}%")
              ->orWhere('erpid', 'LIKE', "%{$search}%")
              ->orWhere('rollno', 'LIKE', "%{$search}%")
              ->orWhere('class', 'LIKE', "%{$search}%")
              ->orWhere('div', 'LIKE', "%{$search}%")
              ->orWhere('pcontact', 'LIKE', "%{$search}%");
        });
    }

    $students = $query->orderBy('id', 'desc')->get();
    $count = Student::count();
    $schools = Student::select('schoolcode')->distinct()->whereNotNull('schoolcode')->where('schoolcode', '!=', '')->pluck('schoolcode');

    $schoolCode = $search;

    return view('students', compact('students', 'count', 'schoolCode', 'schools', 'search'));
});

// Route to handle the export of students to Excel
Route::post('/students/export', function (Request $request) {
    $schoolCode = $request->input('schoolcode') ?: null;

    $fileName = 'students_export_' . now()->format('Y-m-d_His') . '.xlsx';
    $relativePath = 'exports/' . $fileName;

    Excel::store(new StudentsExport($schoolCode), $relativePath, 'local');

    $fullPath = Storage::disk('local')->path($relativePath);

    return response()->download($fullPath, $fileName, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
})->name('students.export');

Route::get('/students/export', function () {
    return redirect('/students');
});

//end 

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

    // Handle photo if provided (Base64 or path or cache fallback)
    $photoInput = $request->input('photo') ?: Cache::get('latest_photo');
    if (!empty($photoInput)) {
        $photoData = null;

        if (str_starts_with($photoInput, 'data:image')) {
            $parts = explode(',', $photoInput, 2);
            if (count($parts) === 2) {
                $photoData = base64_decode(str_replace(' ', '+', $parts[1]));
            }
        } elseif (str_starts_with($photoInput, 'file://')) {
            $filePath = str_replace('file://', '', $photoInput);
            if (file_exists($filePath)) {
                $photoData = file_get_contents($filePath);
            }
        } elseif (file_exists($photoInput)) {
            $photoData = file_get_contents($photoInput);
        }

        $dir = storage_path('app/public/photos');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'photos/' . uniqid('student_') . '.png';

        if ($photoData) {
            file_put_contents(storage_path('app/public/' . $filename), $photoData);
            $data['photo'] = $filename;
        } else {
            // Create storage photo entry for mobile capture in dev/jump mode
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"><rect width="100%" height="100%" fill="#17384a" rx="20"/><circle cx="150" cy="120" r="45" fill="#f9a43a"/><text x="150" y="132" font-size="36" text-anchor="middle" fill="#ffffff">📷</text><text x="150" y="200" font-family="sans-serif" font-size="16" font-weight="bold" text-anchor="middle" fill="#ffffff">Student Photo</text><text x="150" y="225" font-family="sans-serif" font-size="12" text-anchor="middle" fill="#d8e1e6">Captured via Camera</text></svg>';
            file_put_contents(storage_path('app/public/' . $filename), $svg);
            $data['photo'] = $filename;
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

function getStudentPhotoSrc($photo) {
    if (empty($photo)) {
        return null;
    }
    if (str_starts_with($photo, 'data:image')) {
        return $photo;
    }

    $cleanPath = ltrim(str_replace('storage/', '', $photo), '/');
    $fullPath = storage_path('app/public/' . $cleanPath);

    if (file_exists($fullPath)) {
        $mime = mime_content_type($fullPath) ?: 'image/png';
        $data = @file_get_contents($fullPath);
        if ($data) {
            return 'data:' . $mime . ';base64,' . base64_encode($data);
        }
    }

    return asset('storage/' . $cleanPath);
}

function getPhotoAsBase64($path) {
    if (!$path) return null;
    if (str_starts_with($path, 'data:image')) return $path;

    $cleanPath = str_replace('file://', '', $path);
    
    // Check if path is relative to storage (e.g. photos/student_xxx.png)
    if (!str_starts_with($cleanPath, '/') && !preg_match('/^[a-zA-Z]:\\\\/', $cleanPath)) {
        $storageFullPath = storage_path('app/public/' . ltrim($cleanPath, '/'));
        if (file_exists($storageFullPath)) {
            $cleanPath = $storageFullPath;
        }
    }

    if (file_exists($cleanPath)) {
        $content = @file_get_contents($cleanPath);
        if ($content) {
            $mime = @mime_content_type($cleanPath) ?: 'image/jpeg';
            return 'data:' . $mime . ';base64,' . base64_encode($content);
        }
    }

    // Fallback: If on Android dev tethered mode where /data/user/0/... file is on phone and PHP is on PC,
    // construct a valid base64 image data URI preview card so JS receives an actual data:image URI!
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400"><rect width="100%" height="100%" fill="#17384a" rx="24"/><circle cx="200" cy="160" r="60" fill="#f9a43a"/><text x="200" y="176" font-size="48" text-anchor="middle" fill="#ffffff">📷</text><text x="200" y="270" font-family="sans-serif" font-size="20" font-weight="bold" text-anchor="middle" fill="#ffffff">Photo Captured!</text><text x="200" y="305" font-family="sans-serif" font-size="14" text-anchor="middle" fill="#d8e1e6">Ready for Form Submission</text></svg>';
    
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

Event::listen(PhotoTaken::class, function (PhotoTaken $event) {
    Log::info('PhotoTaken event received!', ['path' => $event->path]);
    $path = $event->path;
    if (!empty($path)) {
        Cache::put('latest_photo', $path, 300);
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

    if (!empty($path)) {
        Cache::put('latest_photo', $path, 300);
    }
});

Route::get('/check-photo', function (Request $request) {
    if ($request->has('clear')) {
        Cache::forget('latest_photo');
        return response()->json(['photo' => null]);
    }

    $photo = Cache::get('latest_photo');
    if ($photo && !str_starts_with($photo, 'data:image')) {
        $b64 = getPhotoAsBase64($photo);
        if ($b64 && str_starts_with($b64, 'data:image')) {
            return response()->json(['photo' => $b64, 'raw_path' => $photo]);
        }
    }
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

Route::get('/serve-photo', function (Request $request) {
    $path = $request->query('path');
    if ($path) {
        $cleanPath = str_replace('file://', '', $path);
        if (!str_starts_with($cleanPath, '/') && !preg_match('/^[a-zA-Z]:\\\\/', $cleanPath)) {
            $storageFullPath = storage_path('app/public/' . ltrim($cleanPath, '/'));
            if (file_exists($storageFullPath)) {
                $cleanPath = $storageFullPath;
            }
        }
        if (file_exists($cleanPath)) {
            $mime = @mime_content_type($cleanPath) ?: 'image/jpeg';
            return response()->file($cleanPath, ['Content-Type' => $mime]);
        }
    }

    $cached = Cache::get('latest_photo');
    if ($cached && str_starts_with($cached, 'data:image')) {
        $parts = explode(',', $cached, 2);
        if (count($parts) === 2) {
            $data = base64_decode($parts[1]);
            return response($data)->header('Content-Type', 'image/jpeg');
        }
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"><rect width="100%" height="100%" fill="#17384a" rx="20"/><circle cx="150" cy="120" r="45" fill="#f9a43a"/><text x="150" y="132" font-size="36" text-anchor="middle" fill="#ffffff">📷</text><text x="150" y="200" font-family="sans-serif" font-size="16" font-weight="bold" text-anchor="middle" fill="#ffffff">Photo Captured!</text></svg>';
    return response($svg)->header('Content-Type', 'image/svg+xml');
});

Route::post('/store-captured-photo', function (Request $request) {
    $base64 = $request->input('base64');
    if ($base64 && str_starts_with($base64, 'data:image')) {
        $parts = explode(',', $base64, 2);
        if (count($parts) === 2) {
            $data = base64_decode(str_replace(' ', '+', $parts[1]));
            $dir = storage_path('app/public/photos');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = 'photos/' . uniqid('student_') . '.png';
            file_put_contents(storage_path('app/public/' . $filename), $data);
            Cache::put('latest_photo', $filename, 300);
            return response()->json(['success' => true, 'photo' => $filename]);
        }
    }
    return response()->json(['success' => false]);
});

Route::post('/log-diagnostic', function (Request $request) {
    Log::info('[CLIENT-DIAGNOSTIC] ' . $request->input('tag'), ['data' => $request->input('data')]);
    return response()->json(['ok' => true]);
});

Route::get('/register', function (Request $request) {
    $student = null;

    if ($request->has('id')) {
        $student = Student::find($request->id);
    } else {
        Cache::forget('latest_photo');
    }

    $schoolCodeFromSession = session('school_code');

    if (!$schoolCodeFromSession) {
        return redirect('/')
            ->withErrors([
                'school_code' => 'Please select a school first.'
            ]);
    }

    try {
        $config = SchoolConfig::load($schoolCodeFromSession);
    } catch (\Throwable $e) {
        return redirect('/')
            ->withErrors([
                'school_code' => $e->getMessage()
            ]);
    }
    app()->setLocale($config->language());

    $schoolCode = $request->schoolcode
        ?? ($student->schoolcode ?? $config->schoolCode());

    $count = Student::count();

    return view('register', compact(
        'student',
        'schoolCode',
        'count',
        'config'
    ));
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
