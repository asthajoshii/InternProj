<!DOCTYPE html>
<html>

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>
    <!-- Cropper.js CSS & JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{

    background:#ffffff;
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
}

.phone{

    width:100%;
    max-width:390px;
    background:#ffffff;

    border-radius:35px;

    overflow:hidden;

    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

/* ================= HEADER ================= */

.header{

    background:#17384a;

    height:120px;

    border-bottom-left-radius:35px;
    border-bottom-right-radius:35px;

    display:flex;

    align-items:center;

    padding:20px;
}

.back-btn{
    width:52px;
    height:52px;
    background:#2b4b5d;
    border-radius:15px;

    color:#fff;
    text-decoration:none;   /* Remove underline */
    
    display:flex;
    justify-content:center;
    align-items:center;

    font-size:26px;
    margin-right:18px;
    cursor:pointer;
}

.header-title{

    flex:1;
}

.header-title h2{

    color:white;

    font-size:22px;

    margin-bottom:5px;
}

.header-title p{

    color:#d8e1e6;

    font-size:14px;
}

.saved{

    text-align:center;
}

.saved h2{

    color:#f9a43a;

    font-size:28px;
}

.saved p{

    color:white;

    font-size:12px;

    letter-spacing:1px;
}

/* ================= FORM ================= */

form{

    padding:22px;
}

/* ================= SECTION ================= */

.section-title{

    color:#17384a;

    font-size:13px;

    letter-spacing:4px;

    margin-top:28px;

    margin-bottom:18px;

    font-weight:bold;
}

/* ================= ROW ================= */

.row{

    display:flex;
    allign-items:flex-Start;
    gap:18px;
}

/* ================= FIELD ================= */

.field{

    flex:1;

    margin-bottom:16px;
}

.field label{

    display:block;

    color:#7b8794;

    font-size:10px;
    letter-spacing:0.5px;
    font-weight:bold;

    margin-bottom:8px;
}

.field input,
.field select{

    width:100%;

    height:48px;

    border:1px solid #E4E6EB;

    border-radius:16px;

    padding:0 18px;

    font-size:16px;

    color:#17384a;

    outline:none;

    background:#fff;
}

.field input::placeholder{

    color:#A8B3C0;

    font-size:15px;

    font-weight:400;
}
.field select{

    color:#A8B3C0;
}


.field input:focus,
.field select:focus{

    border:2px solid #f9a43a;
}

/* ================= PHOTO ================= */

.photo-box{

    border:2px dashed #d7dde2;

    border-radius:20px;

    padding:20px;

    display:flex;

    align-items:center;

    gap:15px;

    margin-top:10px;
    cursor: pointer;
    margin-bottom:30px;
}

.camera-box{

    width:60px;

    height:60px;

    background:#fff3e9;

    border-radius:18px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:28px;
}

.photo-text h4{

    color:#17384a;

    font-size:18px;

    margin-bottom:5px;
}

.photo-text p{

    color:#7b8794;

    font-size:13px;

    line-height:20px;
}

/* ================= BUTTON ================= */

.submit-btn{

    width:100%;

    height:54px;

    border:none;

    border-radius:18px;

    background:#f9a43a;

    color:white;

    font-size:20px;

    font-weight:bold;

    cursor:pointer;

    margin:15px 0 30px;
}

.submit-btn:hover{

    background:#f39218;
}

/* ================= PLACEHOLDER ================= */

::placeholder{

    color:#b9b9b9;
}
.error{
    display:block;
    margin-top:6px;
    color:#e74c3c;
    font-size:12px;
    font-weight:500;
}

.input-error{
    border:2px solid #e74c3c !important;
}

</style>

</head>

<body>

<div class="phone">

    <!-- Header -->

    <div class="header">
        <a href="{{ url('/dashboard') }}" class="back-btn" onclick="if(window.history.length > 1){ window.history.back(); return false; }">
            ←
        </a>
                <div class="header-title">

            <h2>{{ isset($student) ? 'Edit Student' : 'New Student' }}</h2>

            <p>
            School - {{ $schoolCode }}
            </p>

        </div>

        <div class="saved">

            <h2>{{ $count }}</h2>

            <p>SAVED</p>

        </div>

    </div>

    <form method="POST" action="/students">

        @csrf
        <input type="hidden" name="id" value="{{ old('id', $student->id ?? '') }}">
        <input type="hidden"
       name="schoolcode"
       value="{{ $schoolCode }}">

        @if ($errors->any())
            <div style="background: #fee2e2; color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <strong style="display:block; margin-bottom:8px; font-size:14px;">Please fix the following errors:</strong>
                <ul style="margin: 0; padding-left: 20px; font-size:13px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ================= IDENTITY ================= -->

        <h3 class="section-title">IDENTITY</h3>

        <div class="row">

            <div class="field">

                <label>ERP ID</label>

                <input
                    type="text"
                    name="erpid"
                    placeholder="ERP ID"
                    value="{{ old('erpid', $student->erpid ?? '') }}"
                    required>

            </div>

            <div class="field">

                <label>ROLL NO.</label>

                <input
                    type="text"
                    name="rollno"
                    placeholder="Roll No"
                    value="{{ old('rollno', $student->rollno ?? '') }}"
                    required>

            </div>

        </div>

        <div class="row">

            <div class="field">

                <label>FIRST NAME</label>

                <input
                    type="text"
                    name="fname"
                    placeholder="First Name"
                    value="{{ old('fname', $student->fname ?? '') }}"
                    required>

            </div>

            <div class="field">

                <label>MIDDLE NAME</label>

                <input
                    type="text"
                    name="mname"
                    placeholder="Middle Name"
                    value="{{ old('mname', $student->mname ?? '') }}">

            </div>

        </div>

        <div class="field">

            <label>LAST NAME</label>

            <input
                type="text"
                name="lname"
                placeholder="Last Name"
                value="{{ old('lname', $student->lname ?? '') }}"
                required>

        </div>

        <!-- FULL NAME -->

        <div class="field">

    <label>
        FULL NAME - prints on the card
    </label>

    <input
        type="text"
        id="fullname"
        placeholder="Auto-filled"
        readonly>

        </div>

        <!-- ================= CLASS DETAILS ================= -->

        <h3 class="section-title">CLASS DETAILS</h3>

        <div class="field">

            <label>STANDARD</label>

            <select name="class" required>

                <option value="">Select Standard</option>

                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ old('class', $student->class ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor

            </select>

        </div>

        <div class="field">

            <label>DIVISION</label>

            <select name="div" required>

                <option value="">Select Division</option>

                @foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $divOption)
                    <option value="{{ $divOption }}" {{ old('div', $student->div ?? '') == $divOption ? 'selected' : '' }}>{{ $divOption }}</option>
                @endforeach

            </select>

        </div>

        <div class="row">

            <div class="field">

                <label>DATE OF BIRTH</label>

                <input
                    type="date"
                    name="dob"
                    id="dob"
                    value="{{ old('dob', $student->dob ?? '') }}">
                    <small id="dobError" class="error"></small>

            </div>

            <div class="field">

                <label>BLOOD GROUP</label>

                <select name="bloodgroup">

                    <option value="">Select</option>

                    @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                        <option value="{{ $bg }}" {{ old('bloodgroup', $student->bloodgroup ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                    @endforeach

                </select>

            </div>

        </div>
                <!-- ================= PARENT / GUARDIAN ================= -->

        <h3 class="section-title">PARENT / GUARDIAN</h3>

        <div class="field">

            <label>PARENT NAME</label>

            <input
                type="text"
                name="pname"
                placeholder="Parent Name"
                value="{{ old('pname', $student->pname ?? '') }}"
                required>

        </div>

        <div class="field">

            <label>MOBILE NUMBER</label>

            <input
                type="text"
                name="pcontact"
                id="pcontact"
                placeholder="9876543210"
                maxlength="10"
                value="{{ old('pcontact', $student->pcontact ?? '') }}"
                required>
            <small id="mobileError" class="error"></small>

        </div>


        <!-- ================= ADDRESS ================= -->

        <h3 class="section-title">ADDRESS</h3>
        <div class="field">
       <input
    type="text"
    name="address1"
    placeholder="Flat / house no., building"
    value="{{ old('address1', $student->address1 ?? '') }}"
    required>
    </div>
<div class="field">
<input
    type="text"
    name="address2"
    placeholder="Street, area"
    value="{{ old('address2', $student->address2 ?? '') }}">
</div>

<div class="row">

    <div class="field">

        <input
            type="text"
            name="landmark"
            placeholder="Landmark"
            value="{{ old('landmark', $student->landmark ?? '') }}">

    </div>

    <div class="field">

        <input
            type="text"
            name="pincode"
            placeholder="PIN code"
            value="{{ old('pincode', $student->pincode ?? '') }}"
            required>

    </div>

</div>

<!-- ================= PHOTO ================= -->
<h3 class="section-title">PHOTO FOR THE CARD</h3>
@php
    $initialPhoto = getStudentPhotoSrc($student->photo ?? null);
@endphp
<input type="hidden" name="photo" id="photoData" value="{{ old('photo', $initialPhoto ?? '') }}">

<!-- Direct file inputs wrapped in touchable labels for WebView camera & gallery triggers -->
<div id="cameraArea" style="margin-bottom:30px;">
    <!-- Choice buttons for Camera, Gallery, and File Picker -->
    <div id="cameraPrompt" style="display:flex; flex-direction:column; gap:12px;">
        <label style="width:100%; padding:16px; background:#17384a; color:white; border:none; border-radius:18px; font-size:16px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; position:relative; overflow:hidden;">
            <span style="font-size:20px;">📷</span> Take Photo with Camera
            <input type="file" id="nativeCameraInput" accept="image/*" capture="environment" onchange="handleFileInputSelect(this)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.01; cursor:pointer; z-index:10;">
        </label>

        <label style="width:100%; padding:16px; background:#f0f4f8; color:#17384a; border:2px dashed #b0c4de; border-radius:18px; font-size:16px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; position:relative; overflow:hidden;">
            <span style="font-size:20px;">🖼️</span> Choose from Gallery
            <input type="file" id="nativeGalleryInput" accept="image/*" onchange="handleFileInputSelect(this)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.01; cursor:pointer; z-index:10;">
        </label>

        <label style="width:100%; display:flex; align-items:center; justify-content:center; gap:10px; padding:14px; background:#ffffff; color:#17384a; border:2px solid #17384a; border-radius:18px; font-size:15px; font-weight:bold; cursor:pointer; position:relative; overflow:hidden;">
            <span style="font-size:18px;">📁</span> Select Image File
            <input type="file" id="localFileInput" accept="image/*" onchange="handleFileInputSelect(this)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.01; cursor:pointer; z-index:10;">
        </label>
    </div>

    <!-- Photo preview after selection & cropping -->
    <div id="photoPreviewBox" style="display:none; text-align:center;">
        <img id="photoPreviewImg" style="width:100%; max-width:260px; height:260px; object-fit:cover; border-radius:20px; border:3px solid #4caf50; box-shadow:0 4px 15px rgba(0,0,0,0.1);" />
        <div style="margin-top:14px; display:flex; gap:8px; justify-content:center; flex-wrap:wrap;">
            <button type="button" onclick="reCropCurrentPhoto()" style="background:#17384a; color:white; border:none; border-radius:12px; padding:10px 16px; font-size:13px; font-weight:bold; cursor:pointer;">
                ✂️ Crop / Adjust
            </button>
            <label style="background:#f9a43a; color:white; border:none; border-radius:12px; padding:10px 16px; font-size:13px; font-weight:bold; cursor:pointer; position:relative; overflow:hidden; display:inline-block;">
                📷 Camera
                <input type="file" accept="image/*" capture="environment" onchange="handleFileInputSelect(this)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.01; cursor:pointer; z-index:10;">
            </label>
            <label style="background:#e0e0e0; color:#333; border:none; border-radius:12px; padding:10px 16px; font-size:13px; cursor:pointer; position:relative; overflow:hidden; display:inline-block;">
                🖼️ Gallery
                <input type="file" accept="image/*" onchange="handleFileInputSelect(this)" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.01; cursor:pointer; z-index:10;">
            </label>
            <label style="background:#e0e0e0; color:#333; border:none; border-radius:12px; padding:10px 16px; font-size:13px; cursor:pointer; position:relative; overflow:hidden; display:inline-block;">
                📁 File
                <input type="file" accept="image/*" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0.01; cursor:pointer; z-index:10;" onchange="handleFileInputSelect(this)">
            </label>
        </div>
    </div>
</div>

<!-- ================= CROPPER MODAL ================= -->
<div id="cropperModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.85); z-index:99999; flex-direction:column; align-items:center; justify-content:center; padding:16px;">
    <div style="background:white; border-radius:24px; width:100%; max-width:380px; padding:20px; text-align:center; display:flex; flex-direction:column; gap:14px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0; color:#17384a; font-size:18px; font-weight:bold;">Crop & Adjust Photo</h3>
            <button type="button" onclick="closeCropper()" style="background:none; border:none; font-size:22px; cursor:pointer; color:#888;">✕</button>
        </div>
        
        <div style="max-height:280px; width:100%; overflow:hidden; border-radius:16px; background:#111; display:flex; justify-content:center; align-items:center;">
            <img id="cropperImage" style="max-width:100%; max-height:280px; display:block;" src="" />
        </div>

        <div style="display:flex; justify-content:center; gap:8px;">
            <button type="button" onclick="rotateCropper(-90)" style="padding:8px 12px; background:#f0f4f8; color:#17384a; border:none; border-radius:10px; font-weight:bold; cursor:pointer;">↺ -90°</button>
            <button type="button" onclick="rotateCropper(90)" style="padding:8px 12px; background:#f0f4f8; color:#17384a; border:none; border-radius:10px; font-weight:bold; cursor:pointer;">↻ +90°</button>
            <button type="button" onclick="zoomCropper(0.1)" style="padding:8px 12px; background:#f0f4f8; color:#17384a; border:none; border-radius:10px; font-weight:bold; cursor:pointer;">🔍 +</button>
            <button type="button" onclick="zoomCropper(-0.1)" style="padding:8px 12px; background:#f0f4f8; color:#17384a; border:none; border-radius:10px; font-weight:bold; cursor:pointer;">🔍 -</button>
        </div>

        <div style="display:flex; gap:10px; margin-top:4px;">
            <button type="button" onclick="closeCropper()" style="flex:1; padding:12px; background:#e0e0e0; color:#333; border:none; border-radius:14px; font-weight:bold; cursor:pointer;">Cancel</button>
            <button type="button" onclick="applyCrop()" style="flex:1; padding:12px; background:#f9a43a; color:white; border:none; border-radius:14px; font-weight:bold; cursor:pointer;">Crop & Apply</button>
        </div>
    </div>
</div>

<canvas id="photoCanvas" style="display:none;"></canvas>

<script>
    // Diagnostic Checks
    console.log("=== DIAGNOSTIC CHECKS ===");
    console.log("Secure context:", window.isSecureContext);
    console.log("Media devices:", navigator.mediaDevices);
    console.log("getUserMedia available:", !!navigator.mediaDevices?.getUserMedia);
    console.log("User Agent:", navigator.userAgent);

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('form[action="/students"]');
        if (form) {
            form.addEventListener('submit', function() {
                console.log("[LOG] Form submit triggered. Photo data length:", document.getElementById('photoData')?.value?.length || 0);
            });
        }

        // Native event listener (Dispatched directly by NativePHP Android Kotlin / iOS Swift container)
        document.addEventListener("native-event", function (e) {
            console.log("[LOG] native-event received in JS:", e.detail);
            var eventName = e.detail?.event || '';
            var payload = e.detail?.payload || {};

            var photoPath = '';
            if (eventName.includes('PhotoTaken')) {
                photoPath = payload.path || '';
            } else if (eventName.includes('MediaSelected')) {
                photoPath = payload.path || (payload.files && payload.files[0] ? payload.files[0].path : '');
            }

            if (photoPath) {
                console.log("[LOG] Direct native photo path captured from container:", photoPath);
                processNativePhotoPath(photoPath);
            }
        });

        // Also register on window.Native if available
        if (window.Native && window.Native.on) {
            window.Native.on('Native\\Mobile\\Events\\Camera\\PhotoTaken', function(payload) {
                if (payload && payload.path) processNativePhotoPath(payload.path);
            });
            window.Native.on('Native\\Mobile\\Events\\Gallery\\MediaSelected', function(payload) {
                var path = payload.path || (payload.files && payload.files[0] ? payload.files[0].path : '');
                if (path) processNativePhotoPath(path);
            });
        }

        // Check if a photo was recently captured (e.g. if camera/gallery intent reloaded the page on Android)
        fetch('/check-photo')
            .then(res => res.json())
            .then(data => {
                if (data && data.photo) {
                    console.log("[LOG] Recovered captured photo on page load:", data.photo);
                    processNativePhotoPath(data.photo);
                }
            })
            .catch(err => console.log("[LOG] Check photo on load error:", err));

        // Existing photo check for edit mode
        var existingPhoto = document.getElementById('photoData')?.value;
        if (existingPhoto) {
            var photoSrc = existingPhoto;
            if (!photoSrc.startsWith('data:') && !photoSrc.startsWith('http') && !photoSrc.startsWith('file:')) {
                photoSrc = '/storage/' + photoSrc;
            }
            document.getElementById('photoPreviewImg').src = photoSrc;
            document.getElementById('cameraPrompt').style.display = 'none';
            document.getElementById('photoPreviewBox').style.display = 'block';
        }
    });

    var photoPollInterval = null;

    function triggerCameraPhoto() {
        console.log("[LOG] Triggering Camera Photo");
        const cameraInput = document.getElementById('nativeCameraInput');
        if (cameraInput) {
            cameraInput.value = '';
            try {
                cameraInput.click();
            } catch(e) {
                console.log("[LOG] Camera input click error:", e);
            }
        }
    }

    function triggerGalleryPhoto() {
        console.log("[LOG] Triggering Gallery Photo");
        const galleryInput = document.getElementById('nativeGalleryInput');
        if (galleryInput) {
            galleryInput.value = '';
            try {
                galleryInput.click();
            } catch(e) {
                console.log("[LOG] Gallery input click error:", e);
            }
        }
    }

    async function tryNativeBridgePhoto(method = 'Camera.GetPhoto') {
        console.log("[LOG] Invoking NativePHP Bridge method:", method);
        
        try { fetch('/check-photo?clear=1'); } catch(e){}

        if (photoPollInterval) clearInterval(photoPollInterval);
        let pollCount = 0;
        photoPollInterval = setInterval(async function() {
            pollCount++;
            if (pollCount > 60) {
                clearInterval(photoPollInterval);
                return;
            }
            try {
                const res = await fetch('/check-photo');
                const data = await res.json();
                if (data && data.photo) {
                    console.log("[LOG] Photo path received from Server Poller:", data.photo);
                    clearInterval(photoPollInterval);
                    processNativePhotoPath(data.photo);
                }
            } catch(e){}
        }, 500);

        try {
            const csrfToken = document.querySelector('input[name="_token"]')?.value || '';
            await fetch('/_native/api/call', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    method: method,
                    params: method === 'Camera.PickMedia' ? { mediaType: 'image', multiple: false } : {}
                })
            });
        } catch(err) {
            console.log("[LOG] NativePHP Bridge Call Error:", err);
        }
    }

    var cropperInstance = null;
    var currentRawPhotoSrc = null;

    function handleFileInputSelect(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            console.log("[LOG] handleFileInputSelect file:", file.name, file.type, file.size);
            if (file.type && !file.type.startsWith('image/') && !file.name.match(/\.(jpg|jpeg|png|webp|heic|bmp)$/i)) {
                alert('Please select a valid image file!');
                input.value = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                if (e.target && e.target.result) {
                    console.log("[LOG] FileReader successfully loaded image file as Base64 (length: " + e.target.result.length + ")");
                    applyBase64ToForm(e.target.result);
                    openCropperModal(e.target.result);
                }
            };
            reader.onerror = function(err) {
                console.log("[LOG] FileReader error:", err);
            };
            reader.readAsDataURL(file);
        }
    }

    function openCropperModal(imageSrc) {
        if (!imageSrc) return;
        currentRawPhotoSrc = imageSrc;

        var modal = document.getElementById('cropperModal');
        var image = document.getElementById('cropperImage');
        if (!modal || !image) return;

        image.src = imageSrc;
        modal.style.display = 'flex';

        if (cropperInstance) {
            try { cropperInstance.destroy(); } catch(e){}
            cropperInstance = null;
        }

        function initCropperWithRetry(attempts = 0) {
            if (typeof Cropper !== 'undefined') {
                cropperInstance = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    checkOrientation: true
                });
            } else if (attempts < 10) {
                setTimeout(function() { initCropperWithRetry(attempts + 1); }, 150);
            }
        }

        setTimeout(function() {
            initCropperWithRetry();
        }, 50);
    }

    function rotateCropper(deg) {
        if (cropperInstance) cropperInstance.rotate(deg);
    }

    function zoomCropper(ratio) {
        if (cropperInstance) cropperInstance.zoom(ratio);
    }

    function closeCropper() {
        var modal = document.getElementById('cropperModal');
        modal.style.display = 'none';
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
    }

    function applyCrop() {
        if (cropperInstance) {
            var canvas = cropperInstance.getCroppedCanvas({ width: 400, height: 400 });
            if (canvas) {
                var croppedDataUrl = canvas.toDataURL('image/jpeg', 0.85);
                applyBase64ToForm(croppedDataUrl);
                closeCropper();
                return;
            }
        }
        applyBase64ToForm(currentRawPhotoSrc);
        closeCropper();
    }

    function reCropCurrentPhoto() {
        if (currentRawPhotoSrc) {
            openCropperModal(currentRawPhotoSrc);
        } else {
            var existingVal = document.getElementById('photoData')?.value || document.getElementById('photoPreviewImg')?.src;
            if (existingVal) openCropperModal(existingVal);
        }
    }

    function convertMobilePathToBase64(path) {
        return new Promise((resolve) => {
            if (!path) return resolve(null);
            if (path.startsWith('data:image')) return resolve(path);

            var formattedPath = path;
            if (!formattedPath.startsWith('file://') && !formattedPath.startsWith('http') && !formattedPath.startsWith('data:')) {
                formattedPath = 'file://' + (formattedPath.startsWith('/') ? formattedPath : '/' + formattedPath);
            }

            var img = new Image();
            img.onload = function() {
                try {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width || 800;
                    canvas.height = img.height || 800;
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    var dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                    console.log("[LOG] Canvas converted mobile photo to Base64 (length: " + dataUrl.length + ")");
                    resolve(dataUrl);
                } catch(e) {
                    console.log("[LOG] Canvas export error:", e);
                    readBlobFallback();
                }
            };
            img.onerror = function() {
                console.log("[LOG] Image load error for path:", formattedPath);
                readBlobFallback();
            };

            function readBlobFallback() {
                fetch(formattedPath)
                    .then(r => r.blob())
                    .then(blob => {
                        var reader = new FileReader();
                        reader.onloadend = function() {
                            if (reader.result && reader.result.startsWith('data:image')) {
                                console.log("[LOG] FileReader blob converted mobile photo to Base64 (length: " + reader.result.length + ")");
                                resolve(reader.result);
                            } else {
                                resolve(null);
                            }
                        };
                        reader.readAsDataURL(blob);
                    })
                    .catch(err => {
                        console.log("[LOG] Fetch blob error for path:", formattedPath, err);
                        resolve(null);
                    });
            }

            img.src = formattedPath;
        });
    }

    async function processNativePhotoPath(path) {
        if (!path) return;
        if (photoPollInterval) clearInterval(photoPollInterval);

        console.log("[LOG] Processing native photo path:", path);

        var base64Data = await convertMobilePathToBase64(path);

        if (!base64Data || !base64Data.startsWith('data:image')) {
            try {
                const res = await fetch('/convert-path-to-base64?path=' + encodeURIComponent(path));
                const data = await res.json();
                if (data && data.base64 && data.base64.startsWith('data:image')) {
                    base64Data = data.base64;
                }
            } catch(e) {}
        }

        if (base64Data && base64Data.startsWith('data:image')) {
            applyBase64ToForm(base64Data);
            openCropperModal(base64Data);
        }
    }

    function applyBase64ToForm(base64Data) {
        if (!base64Data) return;
        document.getElementById('photoData').value = base64Data;
        
        var displaySrc = base64Data;
        if (!displaySrc.startsWith('data:') && !displaySrc.startsWith('http') && !displaySrc.startsWith('file:')) {
            displaySrc = 'file://' + (displaySrc.startsWith('/') ? displaySrc : '/' + displaySrc);
        }
        document.getElementById('photoPreviewImg').src = displaySrc;
        document.getElementById('cameraPrompt').style.display = 'none';
        document.getElementById('photoPreviewBox').style.display = 'block';
    }
</script>

<!-- ================= BUTTON ================= -->

        <button
            type="submit"
            class="submit-btn">

            Submit Enrollment

        </button>

    </form>

</div>

<script>
const first = document.querySelector('input[name="fname"]');
const middle = document.querySelector('input[name="mname"]');
const last = document.querySelector('input[name="lname"]');
const full = document.getElementById('fullname');

function updateFullName() {
    if (!full) return;

    full.value = [
        first?.value,
        middle?.value,
        last?.value
    ].filter(name => name && name.trim() !== "").join(" ");
}

if (first) first.addEventListener("input", updateFullName);
if (middle) middle.addEventListener("input", updateFullName);
if (last) last.addEventListener("input", updateFullName);
</script>


<script>

const mobile = document.getElementById("pcontact");
const mobileError = document.getElementById("mobileError");

mobile.addEventListener("input", function(){

    const value = mobile.value.trim();

    const valid = /^[6-9][0-9]{9}$/.test(value);

    if(value === ""){

        mobile.classList.remove("input-error");
        mobileError.innerHTML = "";
        return;

    }

    if(valid){

        mobile.classList.remove("input-error");
        mobileError.innerHTML = "";

    }else{

        mobile.classList.add("input-error");
        mobileError.innerHTML =
        "Must be 10 digits starting with 6, 7, 8 or 9.";

    }

});
// ===== DOB Validation =====

const dob = document.getElementById("dob");
const dobError = document.getElementById("dobError");

dob.addEventListener("change", function () {

    if (this.value === "") {
        dobError.textContent = "";
        this.classList.remove("input-error");
        return;
    }

    const birthDate = new Date(this.value);
    const today = new Date();

    let age = today.getFullYear() - birthDate.getFullYear();

    const month = today.getMonth() - birthDate.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 3 || age > 25) {

        dobError.textContent = "Age should be between 3 and 25 years.";

        this.classList.add("input-error");

    } else {

        dobError.textContent = "";

        this.classList.remove("input-error");

    }

});




</script>
</body>
</html>