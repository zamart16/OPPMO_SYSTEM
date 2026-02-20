<!-- User Management Modal -->
<div id="userManagementModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-7xl w-full max-h-screen overflow-y-auto border border-gray-100">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 rounded-t-xl">
        <div class="flex items-center justify-between">
          <h3 class="text-xl font-bold text-white">USER MANAGEMENT</h3>
          <button id="closeModalBtn" class="text-white hover:text-gray-200 transition-colors" onclick="closeModal()">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="ri-close-line text-xl"></i>
            </div>
          </button>
        </div>
      </div>

      <!-- Table Content -->
      <div class="p-8 overflow-x-auto">
        <p class="text-gray-700 text-lg mb-4"><strong>Pending User's Account</strong></p>

        <table class="min-w-full table-auto text-sm text-gray-700 border-collapse">
          <thead>
            <tr class="bg-blue-50">
              <th class="px-4 py-2 border-b font-semibold text-left">No.</th>
              <th class="px-4 py-2 border-b font-semibold text-left">Full Name</th>
              <th class="px-4 py-2 border-b font-semibold text-left">Email Address</th>
              <th class="px-4 py-2 border-b font-semibold text-left">Department</th>
              <th class="px-4 py-2 border-b font-semibold text-left">Role</th>
              <th class="px-4 py-2 border-b font-semibold text-left">Image</th>
              <th class="px-4 py-2 border-b font-semibold text-left">Action</th>
            </tr>
          </thead>
          <tbody id="inactiveUsersTableBody">
            <tr>
              <td colspan="5" class="text-center py-4 text-gray-500">
                Loading users...
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Image Preview Modal -->
<div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-70 hidden z-60 flex items-center justify-center p-4">
  <div class="relative">
    <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-2xl hover:text-gray-200">
      &times;
    </button>
    <img id="previewImage" src="" class="max-h-[80vh] max-w-[80vw] rounded-lg shadow-lg object-contain">
  </div>
</div>

<script>
// Function to open the user management modal
function openModal() {
  document.getElementById('userManagementModal').classList.remove('hidden');
  fetchInactiveUsers();
}

// Function to close the user management modal
function closeModal() {
  document.getElementById('userManagementModal').classList.add('hidden');
}

// Fetch inactive users and populate the table
async function fetchInactiveUsers() {
  const tableBody = document.getElementById('inactiveUsersTableBody');

  tableBody.innerHTML = `
    <tr>
      <td colspan="5" class="text-center py-4 text-gray-500">
        Loading users...
      </td>
    </tr>
  `;

  try {
    const response = await fetch('/admin/users/inactive');
    const users = await response.json();

    if (!response.ok) throw new Error('Failed to fetch users');

    if (users.length === 0) {
      tableBody.innerHTML = `
        <tr>
          <td colspan="5" class="text-center py-4 text-gray-500">
            No inactive users found.
          </td>
        </tr>
      `;
      return;
    }

    tableBody.innerHTML = '';

    users.forEach((user, index) => {

      const imageUrl = user.image ? user.image : '/default-avatar.png';

      tableBody.innerHTML += `
        <tr class="hover:bg-blue-50 transition">
          <td class="px-4 py-3 border-b">${index + 1}</td>
          <td class="px-4 py-3 border-b font-medium">${user.name}</td>
          <td class="px-4 py-3 border-b">${user.email}</td>
          <td class="px-4 py-3 border-b">${user.department}</td>
          <td class="px-4 py-3 border-b">${user.role}</td>
          <td class="px-4 py-3 border-b">
            <img
              src="${imageUrl}"
              class="w-10 h-10 rounded-full object-cover border border-gray-300 cursor-pointer transition-transform hover:scale-110"
              onclick="openImageModal('${imageUrl}')"
              alt="${user.name}"
            >
          </td>
          <td class="px-4 py-3 border-b">
            <button
              id="activateBtn-${user.id}"
              onclick="activateUser(${user.id})"
              class="text-green-600 hover:text-green-800 font-medium flex items-center space-x-1">
              <i class="ri-check-line"></i>
              <span>Activate</span>
            </button>
          </td>
        </tr>
      `;
    });

  } catch (error) {
    tableBody.innerHTML = `
      <tr>
        <td colspan="5" class="text-center py-4 text-red-500">
          Failed to load users.
        </td>
      </tr>
    `;
  }
}

// Function to activate a user
async function activateUser(userId) {
  const result = await Swal.fire({
    title: 'Activate User?',
    text: 'This user will be set to active.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, activate',
    confirmButtonColor: '#2563eb'
  });

  if (!result.isConfirmed) return;

  const button = document.getElementById(`activateBtn-${userId}`);
  button.innerHTML = `<i class="ri-loader-4-line animate-spin"></i> Processing...`;
  button.disabled = true;

  try {
    const response = await fetch(`/admin/users/${userId}/activate`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
      }
    });

    const data = await response.json();

    if (!response.ok) throw new Error(data.message || 'Activation failed');

    await Swal.fire({
      icon: 'success',
      title: 'Activated!',
      text: data.message || 'User activated successfully.',
      timer: 1500,
      showConfirmButton: false
    });

    fetchInactiveUsers(); // Refresh table

  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: error.message
    });

    button.innerHTML = `<i class="ri-check-line"></i> Activate`;
    button.disabled = false;
  }
}

// Function to open the image preview modal
function openImageModal(src) {
  const modal = document.getElementById('imagePreviewModal');
  const img = document.getElementById('previewImage');
  img.src = src;

  // Display the preview image modal on top of the other modal
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  modal.style.zIndex = '1001'; // Ensure it's in front of the other modals
}

// Function to close the image preview modal
function closeImageModal() {
  const modal = document.getElementById('imagePreviewModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

// Add event listener to close the image modal when clicking outside the image
document.getElementById('imagePreviewModal').addEventListener('click', function(event) {
  if (event.target === this) {
    closeImageModal();
  }
});

// Function to make the image preview modal draggable
let isDragging = false;
let offsetX, offsetY;

const imagePreviewModal = document.getElementById('imagePreviewModal');
const modalContent = imagePreviewModal.querySelector('.relative');

modalContent.addEventListener('mousedown', (e) => {
  isDragging = true;
  offsetX = e.clientX - modalContent.offsetLeft;
  offsetY = e.clientY - modalContent.offsetTop;
});

document.addEventListener('mousemove', (e) => {
  if (isDragging) {
    imagePreviewModal.style.left = e.clientX - offsetX + 'px';
    imagePreviewModal.style.top = e.clientY - offsetY + 'px';
  }
});

document.addEventListener('mouseup', () => {
  isDragging = false;
});

</script>

