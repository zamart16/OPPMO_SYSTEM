<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Login</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Axios for AJAX -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <!-- Smooth Animation -->
  <style>
    @keyframes fadeSlide {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-slide {
      animation: fadeSlide 0.8s ease-out forwards;
    }
  </style>
</head>

<body class="bg-gray-100">

  <!-- MAIN CONTAINER -->
  <div class="flex min-h-screen">

    <!-- LEFT SIDE (FULL BACKGROUND IMAGE) -->
    <div class="hidden lg:block w-1/2 relative h-screen">

      <!-- Background Image -->
      <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('login-logo.png') }}');"
      ></div>

      <!-- Dark Overlay -->
      <div class="absolute inset-0"></div>

      <!-- Content -->
      {{-- <div class="relative z-10 flex h-full flex-col justify-center px-16 text-white">
        <h1 class="text-4xl font-bold mb-4 animate-fade-slide">
          Welcome Back
        </h1>
        <p class="text-lg opacity-90 max-w-md animate-fade-slide">
          Login to manage your requests, track progress, and stay productive.
        </p>
      </div> --}}
    </div>

    <!-- RIGHT SIDE (LOGIN FORM) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6">

      <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 animate-fade-slide">

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
          Sign In
        </h2>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
          SUPPLIER’S EVALUATION SYSTEM
        </h2>
        <p class="text-sm text-gray-500 mb-6">
          Please enter your credentials
        </p>

        <form class="space-y-5">

          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Email Address
            </label>
            <input
              type="email"
              placeholder="you@example.com"
              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
              required
            />
          </div>

          <!-- Password -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Password
            </label>
            <input
              type="password"
              placeholder="••••••••"
              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
              required
            />
          </div>

          <!-- Remember & Forgot -->
          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2">
              <input type="checkbox" class="rounded text-blue-600">
              Remember me
            </label>
            <a href="#" class="text-blue-600 hover:underline">
              Forgot password?
            </a>
          </div>

          <!-- Button -->
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg"
          >
            Login
          </button>

        </form>

                          <!-- Register Link -->
        <p class="text-center text-sm text-gray-600 mt-4">
          Don't have an account?
          <button onclick="openModal()" class="text-blue-600 hover:underline font-medium">
            Register here
          </button>
        </p>

        <!-- Footer -->
        {{-- <p class="text-center text-sm text-gray-500 mt-6">
          © 2026 Your Company. All rights reserved.
        </p> --}}

      </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const loginForm = document.querySelector('form');

    if (!loginForm) return;

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = loginForm.querySelector('input[type="email"]').value.trim();
        const password = loginForm.querySelector('input[type="password"]').value.trim();

        if (!email || !password) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Fields',
                text: 'Please enter your email and password.'
            });
            return;
        }

        Swal.fire({
            title: 'Logging in...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await axios.post('/login', {
                email: email,
                password: password
            });

            Swal.close();

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.data.message,
                confirmButtonText: 'Continue'
            }).then(() => {

                const role = response.data.user.role;

                if (role === 'administrator') {
                    window.location.href = '/admin-dashboard';
                } else if (role === 'end_user') {
                    window.location.href = '/end-user';
                } else {
                    window.location.href = '/';
                }
            });

        } catch (error) {

            Swal.close();

            let message = 'Something went wrong. Please try again.';

            if (error.response && error.response.data.message) {
                message = error.response.data.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: message
            });
        }

    });

});
</script>









  </div>




<!-- Register Modal -->
<div id="registerModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50 overflow-auto backdrop-blur-sm transition-opacity duration-300">
  <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl p-8 md:p-12 relative transform scale-90 opacity-0 transition-all duration-300 ease-out max-h-[90vh] overflow-y-auto" id="modalContent">

    <!-- Close Button -->
    <button onclick="closeModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 text-3xl transition-colors duration-200">&times;</button>

    <h2 class="text-4xl font-bold text-gray-800 mb-4">Register Account</h2>
    <p class="text-md text-gray-500 mb-8">Create your account to access the system</p>

    <!-- AJAX Form -->
    <form id="registerForm" class="space-y-8">

      <!-- Full Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
        <input type="text" name="name" class="w-full px-6 py-4 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md transition-all duration-200" required>
      </div>

      <!-- Department -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
        <input type="text" name="department" id="departmentInput" class="w-full px-6 py-4 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md transition-all duration-200" required>
      </div>

      <!-- Role Account -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Role Account</label>
        <select name="role" class="w-full px-6 py-4 rounded-2xl border border-gray-300 bg-white focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md transition-all duration-200" required>
          <option value="" disabled selected>Select Role</option>
          <option value="end_user">End-User</option>
          <option value="administrator">Administrator</option>
        </select>
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" name="email" class="w-full px-6 py-4 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md transition-all duration-200" required>
      </div>

      <!-- Password Field -->
      <div class="relative">
        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" class="w-full px-6 py-4 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md transition-all duration-200 pr-12" required>
          <!-- Eye Button -->
          <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <!-- Default Eye SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Confirm Password Field -->
      <div class="relative">
        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
        <div class="relative">
          <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-6 py-4 rounded-2xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md transition-all duration-200 pr-12" required>
          <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
      </div>



      <!-- Capture Image -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Image (Camera)</label>

        <!-- Start Camera Button -->
        <button type="button" id="startCameraBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-2xl mb-2 shadow-md transition-all duration-200">
          Start Camera
        </button>

        <!-- Camera Box -->
        <div class="relative w-full rounded-2xl border border-gray-300 overflow-hidden shadow-md mb-3 max-h-[50vh]">

          <!-- Video & Canvas -->
          <video id="cameraStream" autoplay class="w-full h-[50vh] object-cover hidden transition-all duration-300 rounded-t-2xl"></video>
          <canvas id="cameraPreview" class="w-full h-[50vh] object-cover hidden transition-all duration-300 rounded-t-2xl"></canvas>

          <!-- Capture & Retake Buttons Overlay -->
          <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-4 bg-black bg-opacity-30 rounded-xl p-2 z-20">
            <button type="button" id="captureBtn" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-2xl shadow-md hidden transition-all duration-200">
              Capture
            </button>
            <button type="button" id="retakeBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-6 rounded-2xl shadow-md hidden transition-all duration-200">
              Retake
            </button>
          </div>

        </div>

        <!-- Hidden input -->
        <input type="hidden" name="image" id="capturedImage">
      </div>

      <!-- Submit -->
      <button type="submit" id="registerBtn" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-4 rounded-2xl font-semibold shadow-lg transition-all duration-200">
        Register
      </button>

    </form>
  </div>
</div>

<!-- Styles -->
<style>
  /* Modal animation */
  #registerModal.flex { opacity: 1; }
  #modalContent { transform: scale(1); opacity: 1; }
</style>

<!-- Scripts -->
<script>
let stream;

function openModal() {
  const modal = document.getElementById('registerModal');
  const content = document.getElementById('modalContent');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  setTimeout(() => {
    content.classList.add('opacity-100', 'scale-100');
  }, 50);
}

function closeModal() {
  const modal = document.getElementById('registerModal');
  const content = document.getElementById('modalContent');
  content.classList.remove('opacity-100', 'scale-100');
  setTimeout(() => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    if(stream) stream.getTracks().forEach(track => track.stop());
  }, 200);
}

// Toggle password visibility
function togglePassword(id, btn) {
  const input = document.getElementById(id);
  const isPassword = input.type === 'password';
  input.type = isPassword ? 'text' : 'password';

  // Toggle eye icon (eye / eye-off)
  btn.innerHTML = isPassword
    ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
         <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.944-9.543-7a10.05 10.05 0 011.659-3.04m3.09-2.503A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.96 9.96 0 01-1.232 2.675M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
         <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
       </svg>`
    : `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
         <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
         <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
       </svg>`;
}


// Camera logic
const startBtn = document.getElementById('startCameraBtn');
const captureBtn = document.getElementById('captureBtn');
const retakeBtn = document.getElementById('retakeBtn');
const video = document.getElementById('cameraStream');
const canvas = document.getElementById('cameraPreview');
const imageInput = document.getElementById('capturedImage');

startBtn.addEventListener('click', async () => {
  stream = await navigator.mediaDevices.getUserMedia({ video: true });
  video.srcObject = stream;
  video.classList.remove('hidden');
  captureBtn.classList.remove('hidden');
  startBtn.classList.add('hidden');
  canvas.classList.add('hidden');
  retakeBtn.classList.add('hidden');
});

captureBtn.addEventListener('click', () => {
  // Draw video frame to canvas
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);

  // Save image data
  const dataUrl = canvas.toDataURL('image/png');
  imageInput.value = dataUrl;

  // Show canvas and hide video
  video.classList.add('hidden');
  canvas.classList.remove('hidden');
  captureBtn.classList.add('hidden');
  retakeBtn.classList.remove('hidden');

  // Stop the camera automatically
  if (stream) {
    stream.getTracks().forEach(track => track.stop());
    stream = null;
  }
});

retakeBtn.addEventListener('click', () => {
  // Hide canvas, show video placeholder
  canvas.classList.add('hidden');
  captureBtn.classList.add('hidden');
  retakeBtn.classList.add('hidden');
  imageInput.value = '';

  // Show start button again to restart camera
  startBtn.classList.remove('hidden');
});
</script>




<script>
// AJAX registration
const form = document.getElementById('registerForm');
form.addEventListener('submit', async function(e){
    e.preventDefault();
    const formData = new FormData(form);

    Swal.fire({
      title: 'Processing...',
      text: 'Please wait while we create your account.',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    try{
        const res = await axios.post("{{ route('register') }}", formData);
        Swal.fire('Success!', res.data.message || 'Account registered successfully!', 'success');
        form.reset();
        closeModal();
        canvas.classList.add('hidden');
        startCameraBtn.classList.remove('hidden');
    }catch(err){
        console.error(err.response?.data);
        let messages = ['Something went wrong.'];
        if(err.response?.data?.errors){
            messages = [];
            for(let key in err.response.data.errors){
                messages.push(err.response.data.errors[key].join(' '));
            }
        }
        Swal.fire({ icon:'error', title:'Oops...', html: messages.join('<br>') });
    }
});
</script>




<script>
  const departmentInput = document.getElementById('departmentInput');
  let departmentAlertShown = false; // Flag to ensure SweetAlert shows only once

  departmentInput.addEventListener('focus', () => {
    if(!departmentAlertShown) {
      Swal.fire({
        icon: 'info',
        title: 'Attention!',
        text: 'For this input, please input the full department name. Example: "Provincial Procurement Office"',
        confirmButtonText: 'Got it'
      });
      departmentAlertShown = true; // Set flag so it won’t show again
    }
  });

  // Reset the flag whenever the modal is opened
  function openModal() {
    document.getElementById('registerModal').classList.remove('hidden');
    document.getElementById('registerModal').classList.add('flex');
    departmentAlertShown = false; // Reset alert flag for a new session
  }
</script>



</body>
</html>
