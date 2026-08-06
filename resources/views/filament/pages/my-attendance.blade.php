<x-filament-panels::page>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    {{-- Mark Attendance Button --}}
    <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div>
                <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Mark Today's Attendance</h3>
                <p style="color:#64748b;font-size:0.875rem;">Tap to mark your attendance with GPS location and selfie verification</p>
            </div>
            <button 
                id="markAttendanceBtn"
                onclick="markAttendance()"
                style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;padding:0.75rem 1.5rem;border-radius:0.5rem;font-weight:600;border:none;cursor:pointer;transition:all 0.25s ease;box-shadow:0 4px 10px rgba(16,185,129,0.28);"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 16px rgba(16,185,129,0.4)';"
                onmouseout="this.style.transform='';this.style.boxShadow='0 4px 10px rgba(16,185,129,0.28)';"
            >
                <span style="display:flex;align-items:center;gap:0.5rem;">
                    <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mark Attendance
                </span>
            </button>
        </div>
        
        @if($this->todayAttendance)
            <div style="margin-top:1rem;padding:1rem;background:#d1fae5;border:1px solid #10b981;border-radius:0.5rem;color:#065f46;">
                <strong>Attendance already marked for today!</strong> Check-in time: {{ \Carbon\Carbon::parse($this->todayAttendance->check_in)->format('h:i A') }}
            </div>
            <script>
                document.getElementById('markAttendanceBtn').disabled = true;
                document.getElementById('markAttendanceBtn').style.opacity = '0.5';
                document.getElementById('markAttendanceBtn').style.cursor = 'not-allowed';
            </script>
        @endif
        
        {{-- Hidden camera preview and capture --}}
        <div id="cameraSection" style="display:none;margin-top:1.5rem;">
            <div style="display:flex;flex-direction:column;align-items:center;gap:1rem;">
                <div style="position:relative;width:100%;max-width:400px;">
                    <video id="cameraPreview" autoplay playsinline muted style="width:100%;border-radius:0.5rem;border:2px solid #e2e8f0;background:#000;"></video>
                    <div id="cameraLoading" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#fff;font-size:0.875rem;">Starting camera...</div>
                </div>
                <canvas id="cameraCanvas" style="display:none;"></canvas>
                <div id="captureButtons" style="display:flex;gap:1rem;">
                    <button 
                        id="captureBtn"
                        onclick="captureSelfie()"
                        style="background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;padding:0.75rem 1.5rem;border-radius:0.5rem;font-weight:600;border:none;cursor:pointer;transition:all 0.25s ease;"
                    >
                        Capture Selfie
                    </button>
                    <button 
                        id="cancelCameraBtn"
                        onclick="cancelCamera()"
                        style="background:#ef4444;color:#fff;padding:0.75rem 1.5rem;border-radius:0.5rem;font-weight:600;border:none;cursor:pointer;transition:all 0.25s ease;"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        {{-- Captured selfie preview --}}
        <div id="previewSection" style="display:none;margin-top:1.5rem;">
            <div style="display:flex;flex-direction:column;align-items:center;gap:1rem;">
                <h4 style="color:#0f172a;font-size:1rem;font-weight:600;">Review Your Selfie</h4>
                <img id="capturedPreview" style="width:100%;max-width:400px;border-radius:0.5rem;border:2px solid #e2e8f0;" />
                <div id="previewButtons" style="display:flex;gap:1rem;">
                    <button 
                        id="retakeBtn"
                        onclick="retakeSelfie()"
                        style="background:#f59e0b;color:#fff;padding:0.75rem 1.5rem;border-radius:0.5rem;font-weight:600;border:none;cursor:pointer;transition:all 0.25s ease;"
                    >
                        Retake
                    </button>
                    <button 
                        id="submitBtn"
                        onclick="submitAttendance()"
                        style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;padding:0.75rem 1.5rem;border-radius:0.5rem;font-weight:600;border:none;cursor:pointer;transition:all 0.25s ease;"
                    >
                        Submit Attendance
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Status messages --}}
        <div id="statusMessage" style="display:none;margin-top:1rem;padding:1rem;border-radius:0.5rem;"></div>
    </div>

    {{-- Premium Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1.25rem;">
        @php
            $userId = auth()->id();
            $present = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'present')->count();
            $absent = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'absent')->count();
            $leave = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'leave')->count();
            $late = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'late')->count();
            $total = $present + $absent + $leave + $late;
            $rate  = $total > 0 ? round(($present / $total) * 100) : 0;
        @endphp

        {{-- Present --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#10b981,#059669);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(16,185,129,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Present</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $present }}</h3>
            <p style="color:#10b981;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Absent --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(239,68,68,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Absent</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $absent }}</h3>
            <p style="color:#ef4444;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Leave --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(245,158,11,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Leave</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $leave }}</h3>
            <p style="color:#f59e0b;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Late --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(139,92,246,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Late</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $late }}</h3>
            <p style="color:#8b5cf6;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Attendance Rate --}}
        <div style="background:linear-gradient(135deg,#1e2d5a,#2d4a8a);border-radius:1rem;padding:1.5rem;border:1px solid #2d4a8a;box-shadow:0 4px 14px rgba(30,45,90,0.25);">
            <div style="width:3rem;height:3rem;background:rgba(255,255,255,0.12);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                <svg style="width:1.5rem;height:1.5rem;color:#ffffff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Attendance Rate</p>
            <h3 style="color:#ffffff;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $rate }}%</h3>
            <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">Monthly Score</p>
        </div>

    </div>

    {{-- Attendance History Table --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Attendance History</h3>
            <p style="color:#64748b;font-size:0.875rem;">Your complete monthly attendance log</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>

<script>
let currentLatitude = null;
let currentLongitude = null;
let capturedSelfie = null;
let cameraStream = null;

async function markAttendance() {
    const statusDiv = document.getElementById('statusMessage');
    const cameraSection = document.getElementById('cameraSection');
    const markBtn = document.getElementById('markAttendanceBtn');
    
    try {
        // Show loading state
        markBtn.disabled = true;
        markBtn.innerHTML = '<span style="display:flex;align-items:center;gap:0.5rem;"><svg style="width:1.25rem;height:1.25rem;animation:spin 1s linear infinite;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Processing...</span>';
        
        // Request GPS permission and get location
        showStatus('Requesting GPS location...', 'info');
        
        if (!navigator.geolocation) {
            throw new Error('GPS_NOT_SUPPORTED');
        }
        
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            });
        });
        
        // Validate GPS coordinates
        if (!position.coords || typeof position.coords.latitude !== 'number' || typeof position.coords.longitude !== 'number') {
            throw new Error('INVALID_COORDINATES');
        }
        
        if (position.coords.latitude < -90 || position.coords.latitude > 90 ||
            position.coords.longitude < -180 || position.coords.longitude > 180) {
            throw new Error('INVALID_COORDINATES');
        }
        
        currentLatitude = position.coords.latitude;
        currentLongitude = position.coords.longitude;
        
        showStatus('GPS location captured. Starting camera...', 'info');
        
        // Request camera permission and start video
        cameraSection.style.display = 'block';
        
        try {
            // Request front camera only, no gallery selection
            cameraStream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: { exact: 'user' }, // Force front camera
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                },
                audio: false // No audio needed
            });
            
            const video = document.getElementById('cameraPreview');
            const loadingDiv = document.getElementById('cameraLoading');
            
            video.srcObject = cameraStream;
            
            // Hide loading when video is ready
            video.onloadedmetadata = () => {
                loadingDiv.style.display = 'none';
            };
            
            showStatus('Camera ready. Please capture your selfie.', 'success');
            
        } catch (cameraError) {
            console.error('Camera error:', cameraError);
            
            // Fallback to user-facing mode if exact fails
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'user',
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    },
                    audio: false
                });
                
                const video = document.getElementById('cameraPreview');
                const loadingDiv = document.getElementById('cameraLoading');
                
                video.srcObject = cameraStream;
                video.onloadedmetadata = () => {
                    loadingDiv.style.display = 'none';
                };
                
                showStatus('Camera ready. Please capture your selfie.', 'success');
                
            } catch (fallbackError) {
                throw new Error('CAMERA_NOT_AVAILABLE');
            }
        }
        
    } catch (error) {
        console.error('Error:', error);
        
        let errorMessage = 'An error occurred. Please try again.';
        
        if (error.message === 'GPS_NOT_SUPPORTED') {
            errorMessage = 'GPS is not supported by your browser. Please use a modern browser.';
        } else if (error.code === 1 || error.message === 'PERMISSION_DENIED') {
            errorMessage = 'GPS permission denied. Please enable location services in your browser settings.';
        } else if (error.code === 2 || error.message === 'POSITION_UNAVAILABLE') {
            errorMessage = 'Unable to retrieve GPS location. Please ensure GPS is enabled and try again.';
        } else if (error.code === 3 || error.message === 'TIMEOUT') {
            errorMessage = 'GPS location request timed out. Please check your connection and try again.';
        } else if (error.message === 'INVALID_COORDINATES') {
            errorMessage = 'Invalid GPS coordinates received. Please try again.';
        } else if (error.message === 'CAMERA_NOT_AVAILABLE') {
            errorMessage = 'Camera permission denied or camera not available. Please enable camera access in your browser settings.';
        } else if (error.name === 'NotAllowedError') {
            errorMessage = 'Camera permission denied. Please enable camera access in your browser settings.';
        } else if (error.name === 'NotFoundError') {
            errorMessage = 'No camera found on your device. Please ensure you have a working camera.';
        } else if (error.name === 'NotReadableError') {
            errorMessage = 'Camera is already in use by another application. Please close other apps and try again.';
        }
        
        showStatus(errorMessage, 'error');
        resetUI();
    }
}

function captureSelfie() {
    const video = document.getElementById('cameraPreview');
    const canvas = document.getElementById('cameraCanvas');
    
    if (!video.videoWidth || !video.videoHeight) {
        showStatus('Camera not ready. Please wait a moment and try again.', 'error');
        return;
    }
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    const ctx = canvas.getContext('2d');
    
    // Mirror the image horizontally for selfie (front camera)
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    ctx.setTransform(1, 0, 0, 1, 0, 0); // Reset transform
    
    capturedSelfie = canvas.toDataURL('image/jpeg', 0.85);
    
    // Stop camera stream
    stopCamera();
    
    // Show preview
    document.getElementById('cameraSection').style.display = 'none';
    document.getElementById('previewSection').style.display = 'block';
    document.getElementById('capturedPreview').src = capturedSelfie;
    
    showStatus('Selfie captured. Please review and submit.', 'success');
}

function retakeSelfie() {
    capturedSelfie = null;
    document.getElementById('previewSection').style.display = 'none';
    document.getElementById('cameraSection').style.display = 'block';
    
    // Restart camera
    startCamera();
}

function cancelCamera() {
    stopCamera();
    document.getElementById('cameraSection').style.display = 'none';
    resetUI();
    showStatus('Attendance marking cancelled.', 'info');
}

async function startCamera() {
    try {
        const video = document.getElementById('cameraPreview');
        const loadingDiv = document.getElementById('cameraLoading');
        
        loadingDiv.style.display = 'block';
        
        cameraStream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: 'user',
                width: { ideal: 640 },
                height: { ideal: 480 }
            },
            audio: false
        });
        
        video.srcObject = cameraStream;
        video.onloadedmetadata = () => {
            loadingDiv.style.display = 'none';
        };
        
    } catch (error) {
        console.error('Camera restart error:', error);
        showStatus('Failed to restart camera. Please refresh the page and try again.', 'error');
        resetUI();
    }
}

function stopCamera() {
    if (cameraStream) {
        cameraStream.getTracks().forEach(track => track.stop());
        cameraStream = null;
    }
}

async function submitAttendance() {
    const statusDiv = document.getElementById('statusMessage');
    const submitBtn = document.getElementById('submitBtn');
    
    if (!currentLatitude || !currentLongitude || !capturedSelfie) {
        showStatus('Missing required data. Please start over.', 'error');
        return;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Submitting...';
    
    showStatus('Submitting attendance...', 'info');
    
    try {
        // Convert base64 to blob
        const response = await fetch(capturedSelfie);
        const blob = await response.blob();
        const formData = new FormData();
        
        formData.append('latitude', currentLatitude);
        formData.append('longitude', currentLongitude);
        formData.append('selfie', blob, 'selfie.jpg');
        
        const submitResponse = await fetch('/attendance/mark', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            credentials: 'same-origin',
            body: formData
        });
        
        const data = await submitResponse.json();
        
        if (submitResponse.ok && data.success) {
            showStatus('Attendance marked successfully! ✓', 'success');
            
            // Update UI without full reload
            updateSuccessUI();
            
        } else if (submitResponse.status === 409) {
            showStatus('Attendance already marked for today. Please refresh the page.', 'error');
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showStatus(data.message || 'Failed to mark attendance. Please try again.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit Attendance';
        }
        
    } catch (error) {
        console.error('Submit error:', error);
        
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            showStatus('Network error. Please check your internet connection and try again.', 'error');
        } else {
            showStatus('Error submitting attendance: ' + error.message, 'error');
        }
        
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Submit Attendance';
    }
}

function updateSuccessUI() {
    // Hide the entire attendance marking section
    const attendanceSection = document.querySelector('div[style*="background:#fff;border-radius:1rem;padding:1.5rem"]');
    if (attendanceSection) {
        attendanceSection.style.display = 'none';
    }
    
    // Show success status card
    const statsCards = document.querySelector('div[style*="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr))"]');
    if (statsCards) {
        const successCard = document.createElement('div');
        successCard.style.cssText = 'background:linear-gradient(135deg,#10b981,#059669);border-radius:1rem;padding:1.5rem;border:1px solid #10b981;box-shadow:0 4px 14px rgba(16,185,129,0.25);grid-column: 1 / -1;';
        successCard.innerHTML = `
            <div style="display:flex;align-items:center;gap:1rem;">
                <div style="width:3rem;height:3rem;background:rgba(255,255,255,0.2);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 style="color:#fff;font-size:1.25rem;font-weight:700;margin-bottom:0.25rem;">Present Today</h3>
                    <p style="color:rgba(255,255,255,0.9);font-size:0.875rem;">Check-in: ${new Date().toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}</p>
                </div>
            </div>
            <div style="margin-top:1rem;display:flex;gap:1rem;flex-wrap:wrap;">
                <span style="display:flex;align-items:center;gap:0.375rem;color:rgba(255,255,255,0.9);font-size:0.875rem;background:rgba(255,255,255,0.15);padding:0.375rem 0.75rem;border-radius:0.375rem;">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Location Captured ✓
                </span>
                <span style="display:flex;align-items:center;gap:0.375rem;color:rgba(255,255,255,0.9);font-size:0.875rem;background:rgba(255,255,255,0.15);padding:0.375rem 0.75rem;border-radius:0.375rem;">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Selfie Captured ✓
                </span>
            </div>
        `;
        
        statsCards.insertBefore(successCard, statsCards.firstChild);
    }
    
    // Refresh the table after a short delay
    setTimeout(() => {
        window.location.reload();
    }, 3000);
}

function resetUI() {
    const markBtn = document.getElementById('markAttendanceBtn');
    markBtn.disabled = false;
    markBtn.innerHTML = '<span style="display:flex;align-items:center;gap:0.5rem;"><svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Mark Attendance</span>';
    
    stopCamera();
    document.getElementById('cameraSection').style.display = 'none';
    document.getElementById('previewSection').style.display = 'none';
}

function showStatus(message, type) {
    const statusDiv = document.getElementById('statusMessage');
    statusDiv.style.display = 'block';
    statusDiv.textContent = message;
    
    if (type === 'success') {
        statusDiv.style.background = '#d1fae5';
        statusDiv.style.color = '#065f46';
        statusDiv.style.border = '1px solid #10b981';
    } else if (type === 'error') {
        statusDiv.style.background = '#fee2e2';
        statusDiv.style.color = '#991b1b';
        statusDiv.style.border = '1px solid #ef4444';
    } else {
        statusDiv.style.background = '#dbeafe';
        statusDiv.style.color = '#1e40af';
        statusDiv.style.border = '1px solid #3b82f6';
    }
}

// Add spin animation
const style = document.createElement('style');
style.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
document.head.appendChild(style);

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    stopCamera();
});
</script>
</x-filament-panels::page>
