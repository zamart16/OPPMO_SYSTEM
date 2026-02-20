<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Supplier Evaluation Management</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3b82f6',
            secondary: '#64748b'
          },
          borderRadius: {
            'none': '0px',
            'sm': '4px',
            DEFAULT: '8px',
            'md': '12px',
            'lg': '16px',
            'xl': '20px',
            '2xl': '24px',
            '3xl': '32px',
            'full': '9999px',
            'button': '8px'
          }
        }
      }
    }
  </script>
  <style>
    :where([class^="ri-"])::before {
      content: "\f3c2";
    }
  </style>
  <style>
    @keyframes fadeInOut {

      0%,
      100% {
        opacity: 0.2;
      }

      50% {
        opacity: 1;
      }
    }

    .animate-fade {
      animation: fadeInOut 1s infinite;
    }
  </style>
</head>

<body class="bg-gray-50 min-h-screen">
  <!-- Loading Modal -->
  <div id="loadingModal" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
    <img src="/logo.png" alt="Logo" class="w-24 h-24 animate-fade" />
  </div>

  <div class="flex h-screen" style="background-color: #6e7ac6">


    <main class="flex-1 overflow-auto">
{{-- <header class="bg-white border-b border-gray-200 px-8 py-4 shadow-md sticky top-0 z-50"> --}}
    <header class="bg-gradient-to-r from-blue-600 to-blue-200 border-b border-gray-200 px-8 py-4 shadow-md sticky top-0 z-50">
  <div class="flex items-center justify-between">

    <!-- Logo and Title -->
    <div class="flex items-center space-x-6">
      <div class="flex-shrink-0">
        <img src="{{asset('logo.png')}}" alt="Logo" class="w-16 h-16 object-contain rounded-lg shadow-md">
      </div>
      <div>
        <h1 class="text-3xl font-semibold text-gray-900">Supplier Evaluation Management</h1>
        <div class="text-sm text-white mt-1">Manage and evaluate suppliers with ease</div>
      </div>
    </div>

    <!-- Centered Links Section -->
    <div class="flex justify-center space-x-12 flex-grow">
    <a
       class="text-gray-900 hover:text-blue-600 text-base font-medium flex items-center space-x-2 transition-all duration-300"
       onclick="openModal()" style="cursor: pointer;">
       <span>User Management</span>
    </a>
      <a href="/evaluation" class="text-gray-900 hover:text-blue-600 text-base font-medium flex items-center space-x-2 transition-all duration-300">
        <span>Evaluation</span>
      </a>
    </div>

    <!-- User Info and Notifications -->
    <div class="flex items-center space-x-6">
      <!-- Notification -->
      <button class="relative group">
        <div class="w-12 h-12 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
          <i class="ri-notification-line text-gray-600 text-2xl"></i>
        </div>
        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border border-white"></span>
      </button>

      <!-- User Info -->
      <div class="flex items-center space-x-3">
        <img src="https://readdy.ai/api/search-image?query=professional%20business%20person%20headshot%20portrait%20with%20clean%20background%20corporate%20style&width=40&height=40&seq=user-avatar&orientation=squarish" alt="User" class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 shadow-lg">
        <div class="text-sm">
          <div class="font-medium text-gray-900">John Anderson</div>
          <div class="text-gray-500">Administrator</div>
        </div>
      </div>
    </div>

  </div>
</header>





      <div class="p-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">


          <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-lg font-semibold text-gray-900">Evaluation Records</h2>

            <div class="flex space-x-2">
              <!-- Button to open the New Evaluation Modal -->
              <button id="openNewEvaluationModalBtn" class="bg-primary text-white px-4 py-2 !rounded-button hover:bg-blue-600 flex items-center">
                <div class="w-4 h-4 flex items-center justify-center mr-2">
                  <i class="ri-add-line"></i>
                </div>
                New Evaluation
              </button>

              <!-- Calculate Evaluations Button (Initially Hidden) -->
              <button id="calculateEvaluationsBtn" class="bg-green-500 text-white px-4 py-2 !rounded-button hover:bg-green-600 flex items-center hidden">
                <div class="w-4 h-4 flex items-center justify-center mr-2">
                  <i class="ri-calculator-line"></i>
                </div>
                Calculate Evaluations
              </button>

              <!-- Clear Button -->
              <button id="clearFiltersBtn" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 flex items-center">
                <div class="w-4 h-4 flex items-center justify-center mr-2">
                  <i class="ri-refresh-line"></i>
                </div>
                Clear
              </button>
            </div>
            </div>


            <!-- Filters -->
            <div class="flex flex-wrap items-center space-x-4 mb-6">

              <!-- Search -->
              <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <div class="w-4 h-4 flex items-center justify-center">
                    <i class="ri-search-line text-gray-400"></i>
                  </div>
                </div>
                <input id="searchInput" type="text" placeholder="Search evaluations..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
              </div>

              <!-- Department Filter -->
              <select id="departmentFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm pr-8">
                <option value="">All Departments</option>

                <!-- Set 1 -->
                <option value="DSPH">DSPH</option>
                <option value="PHO">PHO</option>
                <option value="GMDH">GMDH</option>
                <option value="PEO">PEO</option>
                <option value="PBO">PBO</option>
                <option value="PACCO">PACCO</option>
                <option value="PSWDO">PSWDO</option>
                <option value="PICTO">PICTO</option>
                <option value="DILG">DILG</option>
                <option value="NCIP">NCIP</option>
                <option value="VGO">VGO</option>
                <option value="PMO GOODS">PMO GOODS</option>
                <option value="Provincial Chaplaincy">Provincial Chaplaincy</option>
                <option value="RTC 5">RTC 5</option>
                <option value="LRA-ROD">LRA-ROD</option>

                <!-- Set 2 -->
                <option value="PEDIPO">PEDIPO</option>
                <option value="PCO">PCO</option>
                <option value="PMO INFRA">PMO INFRA</option>
                <option value="PGO-Executive">PGO-Executive</option>
                <option value="PTO">PTO</option>
                <option value="PHDMO">PHDMO</option>
                <option value="OPAG">OPAG</option>
                <option value="PIO">PIO</option>
                <option value="SP">SP</option>
                <option value="PENRO">PENRO</option>
                <option value="PGSO">PGSO</option>
                <option value="COA">COA</option>
                <option value="COMELEC">COMELEC</option>
                <option value="Provincial Prosecutor">Provincial Prosecutor</option>
                <option value="Parks & Plaza / Janitorial">Parks & Plaza / Janitorial</option>

                <!-- Set 3 -->
                <option value="PESO">PESO</option>
                <option value="PPDO">PPDO</option>
                <option value="PDRRMO">PDRRMO</option>
                <option value="PLO">PLO</option>
                <option value="PTDPO">PTDPO</option>
                <option value="PCSMO (WARDEN & CSU)">PCSMO (WARDEN & CSU)</option>
                <option value="PVET">PVET</option>
                <option value="PGO-ADMIN">PGO-ADMIN</option>
                <option value="PIASO">PIASO</option>
                <option value="PHRMO">PHRMO</option>
                <option value="SEF">SEF</option>
                <option value="PASSO">PASSO</option>
                <option value="PGO-OSP">PGO-OSP</option>
                <option value="Muslim Affairs">Muslim Affairs</option>
                <option value="BFP">BFP</option>
              </select>

              <!-- Start & End Date Container -->
              <div class="flex flex-col border border-gray-300 rounded-lg p-4 bg-white shadow-sm w-full max-w-md">
                <!-- Dates Container -->
                <div class="flex flex-col sm:flex-row sm:space-x-4 gap-4">
                  <!-- Start Date -->
                  <div class="flex flex-col text-sm text-gray-700 flex-1">
                    <label for="startDateFilter" class="mb-1 font-medium">Start Date</label>
                    <input id="startDateFilter" type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" aria-label="Start date for evaluation filter">
                  </div>

                  <!-- End Date -->
                  <div class="flex flex-col text-sm text-gray-700 flex-1">
                    <label for="endDateFilter" class="mb-1 font-medium">End Date</label>
                    <input id="endDateFilter" type="date" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" aria-label="End date for evaluation filter">
                  </div>
                </div>
              </div>




              <!-- Calculation -->
              <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                <div>
                  Show
                  <select id="entriesPerPage" class="border border-gray-300 rounded px-2 py-1 mx-1 pr-6">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                  </select>
                  entries
                </div>
              </div>
            </div>



 <div class="overflow-x-auto">
  <table class="w-full border-collapse table-auto" id="evaluationTable">
    <thead class="bg-gray-50">
      <tr>
        <!-- Add a checkbox column for selecting rows -->
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
          <input type="checkbox" id="selectAllCheckbox" class="select-all-checkbox">
        </th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No.</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier Name</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Purchase Order</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evaluation Date</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evaluator</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evaluation Score</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
      </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200">
      <!-- Rows will be dynamically inserted here -->
    </tbody>
  </table>
</div>

<style>
  /* Highlight entire row on hover */
  #evaluationTable tbody tr:hover {
    background-color: rgba(147, 197, 253, 0.2);
  }

  /* PO Score cell styling */
  .po-score {
    font-weight: bold;
    text-align: center;
    border-radius: 4px;
    padding: 2px 6px;
  }

  .po-score.low {
    background-color: #fee2e2;
    color: #b91c1c;
  }

  .po-score.ok {
    background-color: #d1fae5;
    color: #065f46;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', async () => {

  const table = document.getElementById('evaluationTable');
  const tbody = table.querySelector('tbody');
  const searchInput = document.getElementById('searchInput');
  const startDateInput = document.getElementById('startDateFilter');
  const endDateInput = document.getElementById('endDateFilter');
  const clearBtn = document.getElementById('clearFiltersBtn');
  const viewevaluationModal = document.getElementById('viewevaluationModal');
  const closeViewBtn = document.getElementById('closeviewModal');
  const cancelBtn = document.getElementById('cancelBtn');
  const calculateBtn = document.getElementById('calculateEvaluationsBtn'); // NEW button reference

  let evaluations = [];
  let filteredData = [];

  /* ========================= PAGINATION VARIABLES ========================= */
    const entriesSelect = document.getElementById('entriesPerPage');
    const paginationControls = document.getElementById('paginationControls');
    const paginationInfo = document.getElementById('paginationInfo');

    let currentPage = 1;
    let entriesPerPage = parseInt(entriesSelect.value);

  /* ========================= LOADING MODAL ========================= */
  let loadingModal = document.getElementById('loadingModal');
  if (!loadingModal) {
    loadingModal = document.createElement('div');
    loadingModal.id = 'loadingModal';
    loadingModal.style.cssText = `
      position: fixed;
      inset: 0;
      background: rgba(255,255,255,1);
      z-index: 50;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity 0.5s ease;
    `;
    loadingModal.innerHTML = `<img src="/logo.png" style="width:100px;height:100px;animation: fadeInOut 1s infinite;">`;
    document.body.appendChild(loadingModal);

    const style = document.createElement('style');
    style.innerHTML = `@keyframes fadeInOut {0%,100%{opacity:0.2}50%{opacity:1}}`;
    document.head.appendChild(style);
  }

  function showLoading() { loadingModal.style.display = 'flex'; loadingModal.style.opacity = 1; }
  function hideLoading() { loadingModal.style.opacity = 0; setTimeout(() => loadingModal.style.display = 'none', 500); }

  /* ========================= MODAL LOADING OVERLAY ========================= */
  let modalLoader = document.getElementById('modalLoading');
  if (!modalLoader) {
    modalLoader = document.createElement('div');
    modalLoader.id = 'modalLoading';
    modalLoader.className = 'absolute inset-0 bg-white bg-opacity-70 flex items-center justify-center hidden z-50 rounded-xl';
    modalLoader.innerHTML = `<img src="/logo.png" alt="Loading" class="w-16 h-16 animate-pulse">`;
    viewevaluationModal.querySelector('div.flex.items-center.justify-center.min-h-screen').appendChild(modalLoader);
  }

  function showModalLoading() { modalLoader.classList.remove('hidden'); }
  function hideModalLoading() { modalLoader.classList.add('hidden'); }

  /* ========================= SET MODAL TO VIEW-ONLY ========================= */
  function setViewMode() {
    viewevaluationModal.querySelectorAll('input, textarea').forEach(el => el.disabled = true);
    viewevaluationModal.querySelectorAll('input[type="radio"]').forEach(r => r.disabled = true);
    viewevaluationModal.querySelectorAll('button').forEach(btn => {
      if (!btn.id.includes('close') && !btn.id.includes('cancel')) btn.style.display = 'none';
    });
  }

  /* ========================= LOAD EVALUATION INTO MODAL ========================= */
  async function loadEvaluation(evaluationId) {
    viewevaluationModal.classList.remove('hidden');
    showModalLoading();
    try {
      const response = await fetch(`/evaluation/${evaluationId}`);
      if (!response.ok) throw new Error("Failed to fetch evaluation");
      const data = await response.json();
      const evaluation = data.evaluation;
      const evaluator = data.evaluator || { full_name: 'Not Available', designation: 'Not Available', image: '/default-image.png' };

      document.getElementById('supplier_name').value = evaluation.supplier_name || '';
      document.getElementById('po_no').value = evaluation.po_no || '';
      document.getElementById('date_evaluation').value = evaluation.date_evaluation || '';
      document.getElementById('covered_period').value = evaluation.covered_period || '';
      document.getElementById('office_name').value = evaluation.office_name || '';

      const capturedSection = document.getElementById('evaluatorCaptured');
      document.getElementById('evaluatorName').textContent = evaluator.full_name;
      document.getElementById('evaluatorDesignation').textContent = evaluator.designation;
      document.getElementById('evaluatorImage').src = evaluator.image || '/default-image.png';
      capturedSection.classList.remove('hidden');

      viewevaluationModal.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
      viewevaluationModal.querySelectorAll('textarea').forEach(t => t.value = '');

      const percentageMap = {1:{1:5,2:10,3:15,4:20},2:{1:6.25,2:15,3:22.5,4:30},3:{1:6.25,2:12.5,3:18.75,4:25},4:{1:6.25,2:12.5,3:18.75,4:25}};
      const criteriaMap = {1:'price_1',2:'quality_1',3:'customercare_1',4:'delivery_1'};

      let totalScore = 0;
      if (evaluation.criteria_scores) {
        evaluation.criteria_scores.forEach(score => {
          const radioName = criteriaMap[score.criteria_id];
          const radio = viewevaluationModal.querySelector(`input[name="${radioName}"][value="${score.number_rating}"]`);
          if (radio) radio.checked = true;
          const remarksField = document.getElementById(`remarks_${radioName}`);
          if (remarksField) remarksField.value = score.remarks || '';
          totalScore += percentageMap[score.criteria_id][score.number_rating];
        });
      }

      viewevaluationModal.querySelector('.po-rating').textContent = totalScore.toFixed(2);

      const statusText = document.getElementById('statusText');
      const hasHeadApproval = evaluation.digital_approvals?.some(a => a.role === 'Head');
      if (!hasHeadApproval) {
        statusText.textContent = "For HEAD REVIEW";
        statusText.className = "font-bold text-yellow-800";
      } else if (totalScore >= 60) {
        statusText.textContent = "PASSED";
        statusText.className = "font-bold text-green-300";
      } else {
        statusText.textContent = "FAILED";
        statusText.className = "font-bold text-red-300";
      }

      setViewMode();
    } catch (err) {
      console.error(err);
      Swal.fire('Error', err.message, 'error');
    } finally { hideModalLoading(); }
  }

  /* ========================= RENDER TABLE WITH CHECKBOX ========================= */
  function renderTable(data) {
    tbody.innerHTML = '';
    if (data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="10" class="px-6 py-4 text-center text-gray-500">No evaluations found.</td></tr>`;
      return;
    }

    data.forEach((eval, index) => {
      const hasHeadApproval = eval.digital_approvals?.some(a => a.role === 'Head');
      const status = !hasHeadApproval ? "HEAD REVIEW" : eval.eval_score >= 60 ? "Approved" : "Fail!";

        // Check if the evaluation score is below 60 to apply the red color
     const evalScoreClass = eval.eval_score < 60 ? 'text-red-600 border-2 border-red-600' : 'text-green-600 border-2 border-green-600';

      const row = document.createElement('tr');
      row.innerHTML = `
        <td class="px-6 py-4 text-sm text-gray-500">
          <input type="checkbox" class="row-checkbox" data-id="${eval.id}">
        </td>
        <td class="px-6 py-4 text-sm text-gray-500">${index + 1}</td>
        <td class="px-6 py-4 text-sm font-medium text-gray-900">${eval.supplier_name}</td>
        <td class="px-6 py-4 text-sm text-gray-500">${eval.po_no}</td>
        <td class="px-6 py-4 text-sm text-gray-500">${eval.date_evaluation}</td>
        <td class="px-6 py-4 text-sm text-gray-500">${eval.evaluator}</td>
        <td class="px-6 py-4 text-sm text-gray-500">${eval.department}</td>
        <td class="px-6 py-4 text-sm ${evalScoreClass}"><strong>${eval.eval_score}%</strong></td>
        <td class="px-6 py-4">
          <span class="px-2 py-1 text-xs font-semibold rounded-full
            ${status === 'Approved' ? 'bg-green-100 text-green-800' :
              status === 'Fail!' ? 'bg-red-100 text-red-800' :
              'bg-yellow-100 text-yellow-800'}">
            ${status}
          </span>
        </td>
<td class="px-6 py-4 text-right relative">
  <div class="inline-block text-left relative">

    <!-- Dropdown Button -->
    <button onclick="toggleDropdown(this)"
            class="text-gray-600 hover:text-gray-900 focus:outline-none">
      <i class="ri-more-2-fill text-xl"></i>
    </button>

    <!-- Dropdown Menu -->
    <div class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-blue-50 border border-blue-200 rounded-lg shadow-lg z-50">

      <button
        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 viewEvaluationBtn"
        data-id="${eval.id}">
        <i class="ri-eye-line mr-2"></i> View
      </button>
      <button
        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-blue-100 updateEvaluationBtn"
        data-id="${eval.id}">
        <i class="ri-edit-line mr-2"></i> Update
      </button>

      <a href="/evaluation/download/${eval.id}"
         target="_blank"
         class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">
        <i class="ri-file-download-line mr-2"></i> Download
      </a>

    </div>
  </div>
</td>

      `;
      tbody.appendChild(row);
    });

    // Checkbox functionality & calculate button logic
    const rowCheckboxes = tbody.querySelectorAll('.row-checkbox');
    rowCheckboxes.forEach(cb => cb.addEventListener('change', () => {
      const selectedCount = tbody.querySelectorAll('.row-checkbox:checked').length;

      // Show the button only when 2 or more checkboxes are selected
      if (selectedCount >= 2) {
        calculateBtn.classList.remove('hidden');
        calculateBtn.textContent = `Calculate Evaluations (${selectedCount})`;
      } else {
        calculateBtn.classList.add('hidden');
      }
    }));

    // Handle Select All checkbox
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.addEventListener('change', () => {
      const isChecked = selectAllCheckbox.checked;
      rowCheckboxes.forEach(cb => cb.checked = isChecked);

      // Show the calculate button if 2 or more checkboxes are selected
      const selectedCount = tbody.querySelectorAll('.row-checkbox:checked').length;
      if (selectedCount >= 2) {
        calculateBtn.classList.remove('hidden');
        calculateBtn.textContent = `Calculate Evaluations (${selectedCount})`;
      } else {
        calculateBtn.classList.add('hidden');
      }
    });

    // Attach view events
    document.querySelectorAll('.viewEvaluationBtn').forEach(btn => {
      btn.addEventListener('click', () => loadEvaluation(btn.dataset.id));
    });
  }

  /* ========================= FETCH DATA ========================= */
  showLoading();
  try {
    const response = await fetch('/evaluation/list');
    if (!response.ok) throw new Error('Failed to fetch evaluations');
    evaluations = await response.json();
    renderTable(evaluations);
  } catch (err) {
    console.error(err);
    tbody.innerHTML = `<tr><td colspan="10" class="px-6 py-4 text-center text-red-500">${err.message}</td></tr>`;
  } finally { hideLoading(); }

  /* ========================= CALCULATE BUTTON ACTION ========================= */
calculateBtn?.addEventListener('click', () => {

  const selectedCheckboxes = Array.from(
    tbody.querySelectorAll('.row-checkbox:checked')
  );

  if (selectedCheckboxes.length < 2) return;

  let totalScore = 0;
  let supplierSet = new Set();
  let poList = [];
  let deptSet = new Set();
  let evaluationCards = '';

  selectedCheckboxes.forEach(cb => {
    const id = cb.dataset.id;
    const evaluation = evaluations.find(e => e.id == id);
    if (!evaluation) return;

    const score = parseFloat(evaluation.eval_score);

    totalScore += score;
    supplierSet.add(evaluation.supplier_name);
    poList.push(evaluation.po_no);
    deptSet.add(evaluation.department);

    evaluationCards += `
      <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:10px 14px;
        border-radius:10px;
        background:#f8fafc;
        margin-bottom:8px;
        border:1px solid #e5e7eb;
      ">
        <div>
          <div style="font-weight:600;color:#1f2937">
            ${evaluation.supplier_name}
          </div>
          <div style="font-size:13px;color:#6b7280">
            PO: ${evaluation.po_no}
          </div>
        </div>
        <div style="
          font-weight:bold;
          font-size:16px;
          color:#2563eb;
        ">
          ${score.toFixed(2)}%
        </div>
      </div>
    `;
  });

  const overallScore = totalScore / selectedCheckboxes.length;

  const isPassed = overallScore >= 60;
  const badgeColor = isPassed ? '#16a34a' : '#dc2626';
  const badgeText = isPassed ? 'PASSED' : 'FAILED';

  Swal.fire({
    width: 800,
    background: '#ffffff',
    confirmButtonColor: '#2563eb',
    html: `
      <div style="text-align:left">

        <!-- HEADER -->
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
          <div>
            <h2 style="margin:0;font-size:22px;font-weight:600;color:#111827">
              Overall Evaluation Result
            </h2>
            <div style="
              display:inline-block;
              margin-top:6px;
              padding:4px 10px;
              border-radius:20px;
              font-size:12px;
              font-weight:600;
              color:white;
              background:${badgeColor};
            ">
              ${badgeText}
            </div>
          </div>

          <div style="
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            color:white;
            padding:14px 18px;
            border-radius:14px;
            font-size:20px;
            font-weight:bold;
            box-shadow:0 4px 14px rgba(0,0,0,0.15);
          ">
            ${overallScore.toFixed(2)}%
          </div>
        </div>

        <!-- INFO -->
        <div style="margin-bottom:18px;font-size:14px;color:#374151">
          <p><strong>Supplier:</strong> ${Array.from(supplierSet).join(', ')}</p>
          <p><strong>Purchase Order(s):</strong> ${poList.join(', ')}</p>
          <p><strong>Department:</strong> ${Array.from(deptSet).join(', ')}</p>
          <p><strong>Selected Evaluations:</strong> ${selectedCheckboxes.length}</p>
        </div>

        <!-- PROGRESS BAR -->
        <div style="
          width:100%;
          height:10px;
          background:#e5e7eb;
          border-radius:20px;
          overflow:hidden;
          margin-bottom:20px;
        ">
          <div style="
            width:${overallScore}%;
            height:100%;
            background:linear-gradient(90deg,#2563eb,#4f46e5);
            transition:width 0.6s ease;
          "></div>
        </div>

        <!-- INDIVIDUAL SCORES -->
        <div>
          <h3 style="margin-bottom:10px;font-size:16px;font-weight:600;color:#111827">
            Individual Evaluation Scores
          </h3>
          <div style="max-height:220px;overflow-y:auto;padding-right:4px">
            ${evaluationCards}
          </div>
        </div>

      </div>
    `
  });

});

/* ========================= UPDATE PAGINATION INFO ========================= */
function updatePaginationInfo(start, end, total) {
  paginationInfo.textContent = `Showing ${start} to ${end} of ${total} results`;
}

/* ========================= RENDER PAGINATION BUTTONS ========================= */
function renderPaginationButtons(dataLength) {

  const totalPages = Math.ceil(dataLength / entriesPerPage);
  paginationControls.innerHTML = '';

  if (totalPages <= 1) return;

  // Previous button
  const prevBtn = document.createElement('button');
  prevBtn.textContent = 'Previous';
  prevBtn.className = 'px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50';
  prevBtn.disabled = currentPage === 1;
  prevBtn.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      renderTable(filteredData.length ? filteredData : evaluations);
      renderPaginationButtons((filteredData.length ? filteredData : evaluations).length);
    }
  });
  paginationControls.appendChild(prevBtn);

  // Page number buttons
  for (let i = 1; i <= totalPages; i++) {
    const pageBtn = document.createElement('button');
    pageBtn.textContent = i;
    pageBtn.className = `px-3 py-1 rounded text-sm ${
      currentPage === i
        ? 'bg-primary text-white'
        : 'border border-gray-300 hover:bg-gray-50'
    }`;

    pageBtn.addEventListener('click', () => {
      currentPage = i;
      renderTable(filteredData.length ? filteredData : evaluations);
      renderPaginationButtons((filteredData.length ? filteredData : evaluations).length);
    });

    paginationControls.appendChild(pageBtn);
  }

  // Next button
  const nextBtn = document.createElement('button');
  nextBtn.textContent = 'Next';
  nextBtn.className = 'px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50';
  nextBtn.disabled = currentPage === totalPages;
  nextBtn.addEventListener('click', () => {
    if (currentPage < totalPages) {
      currentPage++;
      renderTable(filteredData.length ? filteredData : evaluations);
      renderPaginationButtons((filteredData.length ? filteredData : evaluations).length);
    }
  });

  paginationControls.appendChild(nextBtn);
}






  /* ========================= CLOSE MODAL ========================= */
  function hideViewModal() { viewevaluationModal.classList.add('hidden'); }
  if (closeViewBtn) closeViewBtn.addEventListener('click', hideViewModal);
  if (cancelBtn) cancelBtn.addEventListener('click', hideViewModal);
  viewevaluationModal.addEventListener('click', e => { if (e.target === viewevaluationModal) hideViewModal(); });

  /* ========================= FILTERS ========================= */
  function applyFilters() {
    const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
    const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
    const query = searchInput.value.toLowerCase().trim();

    filteredData = evaluations.filter(eval => {
      const evalDate = new Date(eval.date_evaluation);
      if (startDate && evalDate < startDate) return false;
      if (endDate && evalDate > endDate) return false;
      return eval.supplier_name.toLowerCase().includes(query) ||
             eval.po_no.toLowerCase().includes(query) ||
             (!eval.digital_approvals?.some(a => a.role === 'Head') ? 'For HEAD REVIEW' : '').includes(query) ||
             (eval.eval_score >= 60 ? 'approved' : 'fail!').includes(query);
    });

    renderTable(filteredData);
  }

  searchInput.addEventListener('input', applyFilters);
  startDateInput.addEventListener('change', applyFilters);
  endDateInput.addEventListener('change', applyFilters);
  clearBtn.addEventListener('click', () => {
    startDateInput.value = '';
    endDateInput.value = '';
    searchInput.value = '';
    renderTable(evaluations);
  });

});
</script>

<script>
function toggleDropdown(button) {
    // Close other open dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu !== button.nextElementSibling) {
            menu.classList.add('hidden');
        }
    });

    // Toggle current dropdown
    button.nextElementSibling.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>



                <div class="px-6 py-4 border-t border-gray-200">
                  <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500" id="paginationInfo">
                      Showing 0 to 0 of 0 results
                    </div>

                    <div class="flex items-center space-x-2" id="paginationControls">
                      <!-- Pagination buttons will be inserted here dynamically -->
                    </div>
                  </div>
                </div>
          </div>
        </div>
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {

      // New Evaluation Modal
      const openNewEvaluationModalBtn = document.getElementById('openNewEvaluationModalBtn');
      const newEvaluationModal = document.getElementById('newEvaluationModal');
      const closeNewEvaluationModalBtn = document.getElementById('closeNewEvaluationModalBtn');
      const cancelNewEvaluationModalBtn = document.getElementById('cancelNewEvaluationModalBtn');

      // View Evaluation Modal (existing modal)
      const viewevaluationModal = document.getElementById('viewevaluationModal');
      const closeViewBtn = document.getElementById('closeviewModal');

      // Open New Evaluation Modal
      openNewEvaluationModalBtn.addEventListener('click', () => {
        newEvaluationModal.classList.remove('hidden'); // Show the New Evaluation modal
      });

      // Close New Evaluation Modal
      closeNewEvaluationModalBtn.addEventListener('click', () => {
        newEvaluationModal.classList.add('hidden'); // Hide the New Evaluation modal
      });

      // Cancel New Evaluation Modal
      cancelNewEvaluationModalBtn.addEventListener('click', () => {
        newEvaluationModal.classList.add('hidden'); // Hide the New Evaluation modal
      });

      // Close View Evaluation Modal (Existing modal)
      closeViewBtn.addEventListener('click', () => {
        viewevaluationModal.classList.add('hidden'); // Hide the View Evaluation modal
      });

    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const captureEvaluatorBtnNew = document.getElementById('captureEvaluatorBtnNew'); // Capture button to open the camera
      const cameraModal = document.getElementById('cameraModal'); // Modal for capturing image
      const closeCameraModal = document.getElementById('closeCameraModal'); // Button to close camera modal
      const captureBtn = document.getElementById('captureBtn'); // Button to capture image
      const confirmCaptureBtn = document.getElementById('confirmCaptureBtn'); // Button to confirm capture
      const retakeBtn = document.getElementById('retakeBtn'); // Button to retake image

      const video = document.getElementById('cameraVideo'); // Video stream element
      const canvas = document.getElementById('captureCanvas'); // Canvas to draw the captured image
      const capturedImage = document.getElementById('capturedImage'); // Image element to hold captured image

      const cameraPlaceholder = document.getElementById('cameraPlaceholder'); // Placeholder when camera is not active
      const capturedPreview = document.getElementById('capturedImagePreview'); // Preview of the captured image

      const evaluatorNameInput = document.getElementById('full_name_new'); // Input for evaluator name
      const evaluatorDesignationInput = document.getElementById('designation_new'); // Input for evaluator designation

      const evaluatorCaptured = document.getElementById('evaluatorCaptured'); // Section to show after capture is complete
      const evaluatorName = document.getElementById('evaluatorName'); // Element to display evaluator's name
      const evaluatorDesignation = document.getElementById('evaluatorDesignation'); // Element to display evaluator's designation
      const evaluatorImage = document.getElementById('evaluatorImage'); // Element to display captured image
      const preparedBySection = document.getElementById('preparedBySection'); // Section with name and designation input

      let stream = null;

      // OPEN CAMERA
      captureEvaluatorBtnNew.addEventListener('click', async function() {

        if (!evaluatorNameInput.value || !evaluatorDesignationInput.value) {
          alert("Please enter full name and designation first.");
          return;
        }

        cameraModal.classList.remove('hidden'); // Show camera modal

        try {
          // Get user media (camera)
          stream = await navigator.mediaDevices.getUserMedia({
            video: true
          });

          // Set the video source to the camera stream
          video.srcObject = stream;

          // Wait for video metadata to load (important for video playback)
          video.onloadedmetadata = () => {
            video.play();
            video.classList.remove('hidden'); // Show the video element
            cameraPlaceholder.classList.add('hidden'); // Hide the placeholder
          };

        } catch (error) {
          alert("Camera access denied or not available.");
          console.error(error);
        }
      });

      // CAPTURE IMAGE
      captureBtn.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height); // Capture image from the video stream

        const imageData = canvas.toDataURL("image/png"); // Convert the captured image to base64 format
        capturedImage.src = imageData; // Set the captured image to the image element

        video.classList.add('hidden');
        capturedPreview.classList.remove('hidden'); // Show the captured image preview

        captureBtn.classList.add('hidden');
        confirmCaptureBtn.classList.remove('hidden'); // Show confirm button
      });

      // RETAKE
      retakeBtn.addEventListener('click', function() {

        capturedPreview.classList.add('hidden');
        video.classList.remove('hidden'); // Show video feed again

        captureBtn.classList.remove('hidden');
        confirmCaptureBtn.classList.add('hidden'); // Hide confirm button when retaking
      });

      // CONFIRM CAPTURE
      confirmCaptureBtn.addEventListener('click', function() {

        evaluatorName.textContent = evaluatorNameInput.value; // Set evaluator's name
        evaluatorDesignation.textContent = evaluatorDesignationInput.value; // Set evaluator's designation
        evaluatorImage.src = capturedImage.src; // Set the captured image to the evaluator's image

        preparedBySection.classList.add('hidden'); // Hide the "prepared by" section
        evaluatorCaptured.classList.remove('hidden'); // Show the "evaluator captured" section

        stopCamera(); // Stop the camera
        cameraModal.classList.add('hidden'); // Close the camera modal
      });

      // CLOSE CAMERA MODAL
      closeCameraModal.addEventListener('click', function() {
        stopCamera();
        cameraModal.classList.add('hidden'); // Close camera modal
      });

      // CLICK OUTSIDE CAMERA MODAL
      cameraModal.addEventListener('click', function(e) {
        if (e.target === cameraModal) {
          stopCamera();
          cameraModal.classList.add('hidden'); // Close modal if clicked outside
        }
      });

      function stopCamera() {
        if (stream) {
          stream.getTracks().forEach(track => track.stop());
          stream = null;
        }

        video.srcObject = null;

        video.classList.add('hidden');
        capturedPreview.classList.add('hidden');
        captureBtn.classList.remove('hidden');
        confirmCaptureBtn.classList.add('hidden');
        cameraPlaceholder.classList.remove('hidden');
      }

    });
  </script>




    @include('layout.add')

  <div id="viewevaluationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-xl shadow-2xl max-w-5xl w-full max-h-screen overflow-y-auto border border-gray-100">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 rounded-t-xl">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-xl font-bold text-white">SUPPLIER'S EVALUATION FORM</h3>
              <p class="text-blue-100 text-sm mt-1">Performance Assessment & Rating System</p>
            </div>
            <button id="closeviewModal" class="text-white hover:text-gray-200 transition-colors">
              <div class="w-6 h-6 flex items-center justify-center">
                <i class="ri-close-line text-xl"></i>
              </div>
            </button>
          </div>
        </div>
        <div class="p-8">
          <div class="mb-8">
          </div>
          <div id="basicInformationSection" class="mb-8">
            <div hidden class="bg-gray-50 rounded-xl p-6 border border-gray-200">
              <h4 class="text-lg font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-300 flex items-center justify-between">
                Basic Information
                <div class="flex items-center space-x-3">
                  <button id="minimizeAllBtn" class="border border-gray-300 text-gray-700 px-4 py-2 !rounded-button hover:bg-gray-50 whitespace-nowrap text-sm">
                    <div class="w-4 h-4 flex items-center justify-center mr-2 inline-block">
                      <i class="ri-subtract-line"></i>
                    </div>
                    Minimize All
                  </button>
                  <button id="addPOBtn" class="bg-primary text-white px-4 py-2 !rounded-button hover:bg-blue-600 whitespace-nowrap text-sm">
                    <div class="w-4 h-4 flex items-center justify-center mr-2 inline-block">
                      <i class="ri-add-line"></i>
                    </div>
                    Add Another PO
                  </button>
                </div>
              </h4>
            </div>
          </div>
          <div class="mb-8">
            <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-primary">
              <h4 class="text-base font-bold text-primary mb-3 flex items-center">
                <div class="w-5 h-5 flex items-center justify-center mr-2">
                  <i class="ri-information-line"></i>
                </div>
                INSTRUCTIONS
              </h4>
              <div class="space-y-2 text-sm text-gray-700">
                <p class="flex items-start">
                  <span class="font-bold text-primary mr-2 mt-0.5">1.</span>
                  <span>Check the box which corresponds to the supplier's performance based on the Purchase Order/Contract listed above.</span>
                </p>
                <p class="flex items-start">
                  <span class="font-bold text-primary mr-2 mt-0.5">2.</span>
                  <span>In the Remarks / Specific Comments Column, please provide the details especially incidents/description of the delivery in case it fell beyond what was expected. You may use additional sheet, if necessary.</span>
                </p>
                <p class="flex items-start">
                  <span class="font-bold text-primary mr-2 mt-0.5">3.</span>
                  <span>When multiple POs are added, each evaluation will be calculated separately and combined for the overall rating.</span>
                </p>
              </div>
            </div>
          </div>
          <div id="evaluationFormsContainer">
            <div class="evaluation-form-item mb-8" data-form-id="1">
              <div class="bg-white border-2 border-primary rounded-xl shadow-lg">
                <div class="bg-gradient-to-r from-primary to-blue-600 px-6 py-4 rounded-t-xl">
                  <div class="flex items-center justify-between">
                    <h4 class="text-lg font-bold text-white flex items-center">
                      <div class="w-5 h-5 flex items-center justify-center mr-2">
                        <i class="ri-file-text-line"></i>
                      </div>
                      EVALUATION FORM
                    </h4>
                    <div class="flex items-center space-x-2">
                      <button class="collapse-toggle text-white hover:text-gray-200 transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                          <i class="ri-subtract-line"></i>
                        </div>
                      </button>
                      <button class="remove-po-btn text-white hover:text-red-200 transition-colors hidden">
                        <div class="w-5 h-5 flex items-center justify-center">
                          <i class="ri-close-line"></i>
                        </div>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-content p-6">
                  <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                      <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">NAME OF SUPPLIER:</label>
                      <input id="supplier_name" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Purchase Order / Contract No.:</label>
                      <input id="po_no" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Date of Evaluation:</label>
                      <input id="date_evaluation" type="date" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Covered Period:</label>
                      <input id="covered_period" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                    </div>
                  </div>
                  <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Evaluated by (Office Name):</label>
                    <input id="office_name" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                  </div>
                  <div class="border-2 border-gray-300 rounded-xl mb-8 overflow-hidden shadow-sm">
                    <table class="w-full text-sm">
                      <thead>
                        <tr class="bg-gradient-to-r from-gray-800 to-gray-700 border-b border-gray-400">
                          <th class="border-r border-gray-500 p-4 text-left font-bold text-white uppercase tracking-wide">EVALUATION CRITERIA</th>
                          <th class="p-4 text-left font-bold text-white uppercase tracking-wide">REMARKS / SPECIFIC COMMENTS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="border-b border-gray-400">
                          <td class="border-r border-gray-400 p-3 align-top">
                            <div class="mb-3">
                              <div class="font-medium mb-2">A. PRICE (20%)</div>
                              <div class="space-y-1 text-xs">
                                <label class="flex items-start">
                                  <input id="" type="radio" name="price_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>4 - Highly Reasonable <span class="bg-yellow-200 px-1 rounded">(20%)</span></strong><br>• Bid amount is reasonable based on the brand/services delivered.<br>• Pricing is consistent with current market rates (brand or market scooping / historical data)<br>• No competitive</span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="price_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>3 - Reasonable <span class="bg-yellow-200 px-1 rounded">(15%)</span></strong><br>• Bid amount generally aligns with brand/services delivered.<br>• Minor discrepancies in pricing but still within acceptable market range.<br>• No significant cost or overpricing based on brand/services delivered.</span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="price_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>2 - Moderately Reasonable <span class="bg-yellow-200 px-1 rounded">(10%)</span></strong><br>• Some mismatch between bid amount and brand/services delivered.<br>• The bid amount is notably higher than the prevailing market range based on the brand/services delivered.</span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="price_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>1 - Not Reasonable <span class="bg-yellow-200 px-1 rounded">(5%)</span></strong><br>• The bid amount is higher than the prevailing market price against the brand/services delivered.</span>
                                </label>
                              </div>
                            </div>
                          </td>
                          <td class="p-3 align-top">
                            <textarea id="remarks_price_1" name="remarks_price_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
                          </td>
                        </tr>

                        <tr class="border-b border-gray-400">
                          <td class="border-r border-gray-400 p-3 align-top">
                            <div class="mb-3">
                              <div class="font-medium mb-2">B. QUALITY / SERVICE LEVEL (30%)</div>
                              <div class="space-y-1 text-xs">
                                <label class="flex items-start">
                                  <input id="" type="radio" name="quality_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>4 - Goods delivered according to specifications, and acceptable quality <span class="bg-yellow-200 px-1 rounded">(30%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="quality_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>3 - Goods delivered in accordance with specifications, with minor damages, defects, or workmanship issues, which were immediately corrected without affecting functionality or project timeline. <span class="bg-yellow-200 px-1 rounded">(22.5%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="quality_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>2 - Goods delivered in accordance with specifications and of fair to low quality <span class="bg-yellow-200 px-1 rounded">(15%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="quality_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>1 - Goods delivered with recurring or significant damages, defects, or workmanship issues, affecting functionality and functionality <span class="bg-yellow-200 px-1 rounded">(6.25%)</span></strong></span>
                                </label>
                              </div>
                            </div>
                          </td>
                          <td class="p-3 align-top">
                            <textarea id="remarks_quality_1" name="remarks_quality_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
                          </td>
                        </tr>

                        <tr class="border-b border-gray-400">
                          <td class="border-r border-gray-400 p-3 align-top">
                            <div class="mb-3">
                              <div class="font-medium mb-2">C. CUSTOMER CARE / AFTER SALES SERVICE (25%)</div>
                              <div class="space-y-1 text-xs">
                                <label class="flex items-start">
                                  <input id="" type="radio" name="customercare_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>4 - Accessible and easy to contact, responsive to inquiries / complaints, adaptable to certain needs of the end-user</strong> and has competent staff to handle end-user's concerns. <strong><span class="bg-yellow-200 px-1 rounded">(25%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="customercare_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>3 - If one (1) of the details given in item #4 is lacking <span class="bg-yellow-200 px-1 rounded">(18.75%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="customercare_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>2 - If any two (2) of the details given in item #4 is lacking <span class="bg-yellow-200 px-1 rounded">(12.5%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="customercare_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>1 - If any three (3) of the details given in item #4 is lacking <span class="bg-yellow-200 px-1 rounded">(6.25%)</span></strong></span>
                                </label>
                              </div>
                            </div>
                          </td>
                          <td class="p-3 align-top">
                            <textarea id="remarks_customercare_1" name="remarks_customercare_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
                          </td>
                        </tr>

                        <tr>
                          <td class="border-r border-gray-400 p-3 align-top">
                            <div class="mb-3">
                              <div class="font-medium mb-2">D. DELIVERY FULFILLMENT (25%)</div>
                              <div class="space-y-1 text-xs">
                                <label class="flex items-start">
                                  <input id="" type="radio" name="delivery_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>4 - Goods / Services delivered on Time <span class="bg-yellow-200 px-1 rounded">(25%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="delivery_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>3 - Goods / Services delivered, One (1) to Five (5) days after the expiration of the delivery period <span class="bg-yellow-200 px-1 rounded">(18.75%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="delivery_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>2 - Goods / Services delivered, Six (6) to Ten (10) days after the expiration of the delivery period <span class="bg-yellow-200 px-1 rounded">(12.5%)</span></strong></span>
                                </label>
                                <label class="flex items-start">
                                  <input id="" type="radio" name="delivery_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
                                  <span><strong>1 - Goods / Services delivered, eleven (11) or more days after the expiration of the delivery period <span class="bg-yellow-200 px-1 rounded">(6.25%)</span></strong></span>
                                </label>
                              </div>
                            </div>
                          </td>
                          <td class="p-3 align-top">
                            <textarea id="remarks_delivery_1" name="remarks_delivery_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                  <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-4 text-white mb-6">
                    <div class="text-center">
                      <h5 class="text-sm font-bold mb-2">PO RATING</h5>
                      <div class="text-xl font-bold">
                        <span class="po-rating">0</span>%
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div hidden class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white">
              <div class="text-center">
                <h4 class="text-lg font-bold mb-4">OVERALL RATING CALCULATION</h4>
                <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
                  <div class="text-sm mb-2 opacity-90">
                    Average Rating from <span id="totalPOsCount">1</span> PO(s)
                  </div>
                  <div class="text-3xl font-bold">
                    <span id="currentRating">0</span>%
                  </div>
                  <div class="text-sm opacity-90 mt-1">Overall Average Score</div>
                </div>
                <div class="flex items-center justify-center space-x-4">
                  <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                    <div class="text-xs opacity-90">Passing Rate</div>
                    <div class="font-bold">60%</div>
                  </div>
                  <div id="ratingStatus" class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                    <div class="text-xs opacity-90">Status</div>
                    <div class="font-bold" id="statusText">Pending</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

<div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
  <h4 class="text-lg font-bold text-gray-800 mb-6 pb-3 border-b border-gray-300">
    Digital Authorization
  </h4>

  <!-- TWO PANEL LAYOUT -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- ================= LEFT PANEL : END USER ================= -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
      <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
        <div class="w-6 h-6 flex items-center justify-center mr-2 bg-primary text-white rounded-full">
          <i class="ri-user-line text-sm"></i>
        </div>
        End-User (Prepared By)
      </h5>

      <div id="evaluatorCaptured" class="hidden">
        <div class="text-sm text-gray-700 mb-2">
          <strong>Name:</strong> <span id="evaluatorName"></span><br>
          <strong>Designation:</strong> <span id="evaluatorDesignation"></span>
        </div>

        <div class="text-xs text-gray-500 mb-3">
          This Supplier Evaluation is authenticated and authorized through
          computer-generated facial recognition technology, which serves
          as an official signature in place of a handwritten signature.
        </div>

        <img id="evaluatorImage"
             src=""
             alt="Evaluator"
             class="w-24 h-24 rounded-lg object-cover border border-gray-300">
      </div>

      <div id="noEvaluator" class="text-sm text-gray-400 hidden">
        No End-User signature available.
      </div>
    </div>


    <!-- ================= RIGHT PANEL : HEAD ================= -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
      <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
        <div class="w-6 h-6 flex items-center justify-center mr-2 bg-green-600 text-white rounded-full">
          <i class="ri-shield-user-line text-sm"></i>
        </div>
        Head of Office
      </h5>

      <div id="headCaptured" class="hidden">
        <div class="text-sm text-gray-700 mb-2">
          <strong>Name:</strong> <span id="headName"></span><br>
          <strong>Designation:</strong> <span id="headDesignation"></span>
        </div>

        <div class="text-xs text-gray-500 mb-3">
          This evaluation has been reviewed and digitally approved
          through secured facial authentication technology.
        </div>

        <img id="headImage"
             src=""
             alt="Head Signature"
             class="w-24 h-24 rounded-lg object-cover border border-gray-300">
      </div>

      <div id="pendingHead" class="text-sm font-semibold text-red-500 hidden">
        Pending Head Review
      </div>
    </div>

  </div>

  <!-- ACTION -->
  <div class="flex justify-end mt-8">
    <button id="cancelViewModalBtn"
      class="border border-gray-300 text-gray-700 px-6 py-2 !rounded-button hover:bg-gray-50 whitespace-nowrap">
      Cancel
    </button>
  </div>
</div>




        </div>
      </div>
    </div>
  </div>






  {{-- FORM SUBMISSION --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

  const submitBtn = document.getElementById('submitEvaluationBtn');
  const evaluationFormsContainer = document.getElementById('evaluationFormsContainer');

  submitBtn.addEventListener('click', async function() {

    // SweetAlert confirm before submission
    const confirmResult = await Swal.fire({
      title: 'Are you sure?',
      text: "You are about to submit this evaluation!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, submit it!',
      cancelButtonText: 'Cancel'
    });

    if (!confirmResult.isConfirmed) return;

    const evaluations = [];

    // Loop through each evaluation form (PO)
    const evaluationForms = evaluationFormsContainer.querySelectorAll('.evaluation-form-item');

    for (const form of evaluationForms) {
      const formId = form.getAttribute('data-form-id');

      // Evaluation table data
      const evalData = {
        supplier_name: form.querySelector('#new_supplier_name')?.value.trim() || '',
        po_no: form.querySelector('#new_po_no')?.value.trim() || '',
        date_evaluation: form.querySelector('#new_date_evaluation')?.value || '',
        covered_period: form.querySelector('#new_covered_period')?.value || '',
        office_name: form.querySelector('#new_office_name')?.value.trim() || '',
        criteria: []
      };

      // Criteria mapping (must match DB criteria_id)
      const criteriaMapping = [
        { id: 1, name: 'price' },
        { id: 2, name: 'quality' },
        { id: 3, name: 'customercare' },
        { id: 4, name: 'delivery' }
      ];

      // Collect rating and remarks for each criteria
      criteriaMapping.forEach(c => {
        evalData.criteria.push({
          criteria_id: c.id,
          rating: form.querySelector(`input[name="${c.name}_${formId}"]:checked`)?.value || null,
          remarks: form.querySelector(`#form_remarks_${c.name}_${formId}`)?.value.trim() || ''
        });
      });

      evaluations.push(evalData);
    }

    // Digital Authorization info (Add Modal IDs)
    const evaluator = {
      name: document.getElementById('add_evaluatorName')?.textContent.trim(),
      designation: document.getElementById('add_evaluatorDesignation')?.textContent.trim(),
      image: document.getElementById('add_evaluatorImage')?.src || ''
    };

    if (!evaluator.name || !evaluator.designation || !evaluator.image) {
      Swal.fire({
        icon: 'error',
        title: 'Digital Authorization Required',
        text: 'Please complete digital authorization (capture face) before submitting.'
      });
      return;
    }

    const payload = {
      evaluations,
      evaluator
    };

    try {
      Swal.fire({
        title: 'Submitting Evaluation...',
        text: 'Please wait while your evaluation is being saved.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });

      const response = await fetch('/evaluation/store', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      if (response.ok && data.success !== false) {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: data.message || 'Evaluation submitted successfully.'
        }).then(() => location.reload());
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: data.message || 'Failed to submit evaluation.'
        });
      }

    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: err.message || 'An unexpected error occurred.'
      });
    }

  });

});
</script>


  {{-- END --}}





  <!-- XL CALCULATION MODAL -->
<!-- ===================== MODERN XL CALCULATION MODAL ===================== -->
<div id="calculationModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-500">

  <div id="calculationModalContent"
       class="relative w-11/12 max-w-5xl rounded-3xl shadow-2xl
              bg-white/80 backdrop-blur-xl border border-white/30
              transform scale-90 opacity-0 transition-all duration-500 ease-out overflow-hidden">

    <!-- Gradient Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold tracking-wide">
          Overall Evaluation Result
        </h2>

        <!-- Score Circle -->
        <div class="relative">
          <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30">
            <span id="calcScore"
                  class="text-xl font-bold text-white"></span>%
          </div>
        </div>
      </div>
    </div>

    <!-- Body -->
    <div class="p-8">

      <!-- Info Cards -->
      <div class="grid md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white shadow-md rounded-xl p-4 border">
          <p class="text-xs text-gray-500 uppercase tracking-wide">Supplier</p>
          <p id="calcSupplier" class="text-lg font-semibold text-gray-800"></p>
        </div>

        <div class="bg-white shadow-md rounded-xl p-4 border">
          <p class="text-xs text-gray-500 uppercase tracking-wide">Purchase Orders</p>
          <p id="calcPO" class="text-lg font-semibold text-gray-800 break-words"></p>
        </div>

        <div class="bg-white shadow-md rounded-xl p-4 border">
          <p class="text-xs text-gray-500 uppercase tracking-wide">Department</p>
          <p id="calcDept" class="text-lg font-semibold text-gray-800"></p>
        </div>

      </div>

      <!-- Selected Count -->
      <div class="mb-6 text-center">
        <p class="text-gray-600 text-lg">
          Selected Evaluations:
          <span id="calcCount" class="font-bold text-indigo-600"></span>
        </p>
      </div>

      <!-- Progress Bar -->
      <div class="w-full bg-gray-200 rounded-full h-4 mb-8 overflow-hidden">
        <div id="scoreProgress"
             class="h-4 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-700"
             style="width:0%">
        </div>
      </div>

      <!-- Individual Evaluation Scores -->
      <div>
        <h3 class="text-lg font-semibold mb-4 text-gray-700">
          Individual Evaluation Scores
        </h3>

        <div id="evaluationScoreList"
             class="space-y-3 max-h-64 overflow-y-auto pr-2">
          <!-- JS will insert each evaluation here -->
        </div>
      </div>

      <!-- Footer -->
      <div class="mt-10 text-center">
        <button id="closeCalcModal"
                class="px-8 py-3 bg-gradient-to-r from-gray-700 to-gray-900
                       text-white rounded-xl shadow-lg hover:scale-105
                       hover:shadow-xl transition-all duration-300">
          Close
        </button>
      </div>

    </div>

  </div>
</div>

<style>
@keyframes flyInModern {
  from {
    transform: translateY(-30px) scale(0.92);
    opacity: 0;
  }
  to {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
}

.modal-fly {
  animation: flyInModern 0.45s cubic-bezier(.16,.84,.44,1) forwards;
}
</style>


@include('layout.user')
</body>

</html>
