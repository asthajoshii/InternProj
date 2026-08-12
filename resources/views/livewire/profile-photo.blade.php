<div 
    onclick="capturePhotoNative()"
    style="
        border:2px dashed #e0e0e0;
        border-radius:20px;
        padding:20px;
        display:flex;
        align-items:center;
        gap:15px;
        cursor:pointer;
        background:white; 
        box-shadow:0 4px 10px rgba(0,0,0,0.05);
    "
>
    <div style="
        background:#fce9d9;
        padding:15px;
        border-radius:15px;
    ">
        📷
    </div>
    <div>
        <p style="font-weight:600; margin:0;">Capture photo</p>
        <p style="margin:0; color:#777; font-size:14px;">
            Front-facing, plain background. You'll crop it next.
        </p>
    </div>
</div>
<div>
    <button wire:click="capturePhoto" type="button">
        📷 Take Photo
    </button>

    @if ($photoPath)
        <div style="margin-top:15px;">
            <img src="{{ $photoPath }}" width="150" style="border-radius:10px;">
        </div>
    @endif
</div>


<script>


    function capturePhotoNative() {
        
        alert("NativePHP working ✅");
        await Camera.getPhoto();

        // if (window.NativePHP) {
        //     alert("NativePHP working ✅");
        //     Camera.GetPhoto();
        // } else {
        //     alert("Not in NativePHP ❌");
        // }
    }
</script>