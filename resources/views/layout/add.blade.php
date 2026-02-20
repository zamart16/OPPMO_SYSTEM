<!-- New Evaluation Modal -->
<div id="newEvaluationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-5xl w-full max-h-screen overflow-y-auto border border-gray-100">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 rounded-t-xl">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-xl font-bold text-white">SUPPLIER'S EVALUATION FORM</h3>
            <p class="text-blue-100 text-sm mt-1">Performance Assessment & Rating System</p>
          </div>
          <button id="closeNewEvaluationModalBtn" class="text-white hover:text-gray-200 transition-colors">
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
                    <input id="new_supplier_name" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                  </div>
                  <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Purchase Order / Contract No.:</label>
                    <input id="new_po_no" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                  </div>
                  <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Date of Evaluation:</label>
                    <input id="new_date_evaluation" type="date" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                  </div>
                  <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">Covered Period:</label>
                    <input id="new_covered_period" type="text" class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800">
                  </div>
                </div>
                <div class="mb-6">
                  <label class="text-sm font-semibold text-gray-700 mb-2 block uppercase tracking-wide">
                    Evaluated by (Office Name):
                  </label>
                  <input
    id="new_office_name"
    type="text"
    class="w-full border-0 border-b-2 border-gray-300 px-1 py-3 text-base focus:outline-none focus:border-primary bg-transparent font-medium text-gray-800"
    @if(!auth()->user()->isAdmin())
        value="{{ auth()->user()->department ?? '' }}"
        readonly
    @endif
>

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
            <input id="price_1_option_4" type="radio" name="price_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>4 - Highly Reasonable <span class="bg-yellow-200 px-1 rounded">(20%)</span></strong><br>• Bid amount is reasonable based on the brand/services delivered.<br>• Pricing is consistent with current market rates (brand or market scooping / historical data)<br>• No competitive</span>
          </label>
          <label class="flex items-start">
            <input id="price_1_option_3" type="radio" name="price_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>3 - Reasonable <span class="bg-yellow-200 px-1 rounded">(15%)</span></strong><br>• Bid amount generally aligns with brand/services delivered.<br>• Minor discrepancies in pricing but still within acceptable market range.<br>• No significant cost or overpricing based on brand/services delivered.</span>
          </label>
          <label class="flex items-start">
            <input id="price_1_option_2" type="radio" name="price_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>2 - Moderately Reasonable <span class="bg-yellow-200 px-1 rounded">(10%)</span></strong><br>• Some mismatch between bid amount and brand/services delivered.<br>• The bid amount is notably higher than the prevailing market range based on the brand/services delivered.</span>
          </label>
          <label class="flex items-start">
            <input id="price_1_option_1" type="radio" name="price_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>1 - Not Reasonable <span class="bg-yellow-200 px-1 rounded">(5%)</span></strong><br>• The bid amount is higher than the prevailing market price against the brand/services delivered.</span>
          </label>
        </div>
      </div>
    </td>
<td class="p-3 align-top">
    <textarea id="form_remarks_price_1" name="form_remarks_price_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
</td>
  </tr>

  <tr class="border-b border-gray-400">
    <td class="border-r border-gray-400 p-3 align-top">
      <div class="mb-3">
        <div class="font-medium mb-2">B. QUALITY / SERVICE LEVEL (30%)</div>
        <div class="space-y-1 text-xs">
          <label class="flex items-start">
            <input id="quality_1_option_4" type="radio" name="quality_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>4 - Goods delivered according to specifications, and acceptable quality <span class="bg-yellow-200 px-1 rounded">(30%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="quality_1_option_3" type="radio" name="quality_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>3 - Goods delivered in accordance with specifications, with minor damages, defects, or workmanship issues, which were immediately corrected without affecting functionality or project timeline. <span class="bg-yellow-200 px-1 rounded">(22.5%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="quality_1_option_2" type="radio" name="quality_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>2 - Goods delivered in accordance with specifications and of fair to low quality <span class="bg-yellow-200 px-1 rounded">(15%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="quality_1_option_1" type="radio" name="quality_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>1 - Goods delivered with recurring or significant damages, defects, or workmanship issues, affecting functionality and functionality <span class="bg-yellow-200 px-1 rounded">(6.25%)</span></strong></span>
          </label>
        </div>
      </div>
    </td>
<td class="p-3 align-top">
    <textarea id="form_remarks_quality_1" name="form_remarks_quality_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
</td>
  </tr>

  <tr class="border-b border-gray-400">
    <td class="border-r border-gray-400 p-3 align-top">
      <div class="mb-3">
        <div class="font-medium mb-2">C. CUSTOMER CARE / AFTER SALES SERVICE (25%)</div>
        <div class="space-y-1 text-xs">
          <label class="flex items-start">
            <input id="customercare_1_option_4" type="radio" name="customercare_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>4 - Accessible and easy to contact, responsive to inquiries / complaints, adaptable to certain needs of the end-user</strong> and has competent staff to handle end-user's concerns. <strong><span class="bg-yellow-200 px-1 rounded">(25%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="customercare_1_option_3" type="radio" name="customercare_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>3 - If one (1) of the details given in item #4 is lacking <span class="bg-yellow-200 px-1 rounded">(18.75%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="customercare_1_option_2" type="radio" name="customercare_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>2 - If any two (2) of the details given in item #4 is lacking <span class="bg-yellow-200 px-1 rounded">(12.5%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="customercare_1_option_1" type="radio" name="customercare_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>1 - If any three (3) of the details given in item #4 is lacking <span class="bg-yellow-200 px-1 rounded">(6.25%)</span></strong></span>
          </label>
        </div>
      </div>
    </td>
<td class="p-3 align-top">
    <textarea id="form_remarks_customercare_1" name="form_remarks_customercare_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
</td>
  </tr>

  <tr>
    <td class="border-r border-gray-400 p-3 align-top">
      <div class="mb-3">
        <div class="font-medium mb-2">D. DELIVERY FULFILLMENT (25%)</div>
        <div class="space-y-1 text-xs">
          <label class="flex items-start">
            <input id="delivery_1_option_4" type="radio" name="delivery_1" value="4" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>4 - Goods / Services delivered on Time <span class="bg-yellow-200 px-1 rounded">(25%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="delivery_1_option_3" type="radio" name="delivery_1" value="3" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>3 - Goods / Services delivered, One (1) to Five (5) days after the expiration of the delivery period <span class="bg-yellow-200 px-1 rounded">(18.75%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="delivery_1_option_2" type="radio" name="delivery_1" value="2" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>2 - Goods / Services delivered, Six (6) to Ten (10) days after the expiration of the delivery period <span class="bg-yellow-200 px-1 rounded">(12.5%)</span></strong></span>
          </label>
          <label class="flex items-start">
            <input id="delivery_1_option_1" type="radio" name="delivery_1" value="1" class="mt-1 mr-2 w-5 h-5 flex-shrink-0">
            <span><strong>1 - Goods / Services delivered, eleven (11) or more days after the expiration of the delivery period <span class="bg-yellow-200 px-1 rounded">(6.25%)</span></strong></span>
          </label>
        </div>
      </div>
    </td>
<td class="p-3 align-top">
    <textarea id="form_remarks_delivery_1" name="form_remarks_delivery_1" class="w-full h-32 border border-gray-300 p-2 text-xs resize-none"></textarea>
</td>
  </tr>

</tbody>

                  </table>
                </div>
                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-4 text-white mb-6">
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
            </div>
          </div>
        </div>
<!-- Digital Authorization Section -->
<div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
  <h4 class="text-lg font-bold text-gray-800 mb-6 pb-3 border-b border-gray-300">
    Digital Authorization
  </h4>

  <div>
    <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
      <div class="w-6 h-6 flex items-center justify-center mr-2 bg-primary text-white rounded-full">
        <i class="ri-user-line text-sm"></i>
      </div>
      Prepared by:
    </h5>

    <!-- Input section for Add Modal -->
    <div id="add_preparedBySection">
      <input id="add_full_name" type="text" placeholder="Enter full name" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-sm mb-3 focus:outline-none focus:border-primary">
      <input id="add_designation" type="text" placeholder="Enter designation" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-sm mb-4 focus:outline-none focus:border-primary">
      <button id="add_captureEvaluatorBtn" class="bg-gradient-to-r from-primary to-blue-600 text-white px-4 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700">Capture Face for Authorization</button>
    </div>

    <!-- Captured section for Add Modal -->
    <div id="add_evaluatorCaptured" class="hidden">
      <div class="text-sm text-gray-700 mb-2">
        <strong>Prepared by:</strong> <span id="add_evaluatorName"></span><br>
        <strong>Designation:</strong> <span id="add_evaluatorDesignation"></span>
      </div>

      <div class="text-xs text-gray-500 mb-3">
        Authorized using Human Computer Authentication.
      </div>

      <img id="add_evaluatorImage"
           src=""
           alt="Evaluator"
           class="w-24 h-24 rounded-lg object-cover border border-gray-300">
    </div>
  </div>

  <div class="flex justify-end space-x-4 mt-8">
    <button id="cancelNewEvaluationModalBtn" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50">Cancel</button>
    <button id="submitEvaluationBtn" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-600">Submit Evaluation</button>
  </div>
</div>

      </div>
    </div>
  </div>
</div>

<!-- Camera Modal for Face Capture -->
<div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Face Capture Authorization</h3>
          <button id="closeCameraModal" class="text-gray-400 hover:text-gray-600">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="ri-close-line"></i>
            </div>
          </button>
        </div>
      </div>
      <div class="p-6">
        <div id="cameraPreview" class="mb-4">
          <video id="cameraVideo" class="w-full h-64 rounded-lg object-cover hidden"></video>
          <canvas id="captureCanvas" class="hidden"></canvas>
          <div id="cameraPlaceholder" class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
            <div class="text-center">
              <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="ri-camera-line text-4xl text-gray-400"></i>
              </div>
              <p class="text-gray-500">Camera preview will appear here</p>
            </div>
          </div>
        </div>
        <div id="capturedImagePreview" class="hidden mb-4">
          <img id="capturedImage" src="" alt="Captured" class="w-full h-64 object-cover rounded-lg">
          <div class="mt-3 text-center">
            <button id="retakeBtn" class="text-primary hover:text-blue-700 text-sm">
              <div class="w-4 h-4 flex items-center justify-center mr-1 inline-block">
                <i class="ri-refresh-line"></i>
              </div>
              Retake
            </button>
          </div>
        </div>
        <div class="flex justify-center space-x-4">
          <button id="captureBtn" class="bg-primary text-white px-6 py-2 !rounded-button hover:bg-blue-600 whitespace-nowrap">
            <div class="w-4 h-4 flex items-center justify-center mr-2 inline-block">
              <i class="ri-camera-line"></i>
            </div>
            Capture
          </button>
          <button id="confirmCaptureBtn" class="bg-green-600 text-white px-6 py-2 !rounded-button hover:bg-green-700 whitespace-nowrap hidden">
            <div class="w-4 h-4 flex items-center justify-center mr-2 inline-block">
              <i class="ri-check-line"></i>
            </div>
            Confirm
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const ratingDisplay = document.querySelector('.po-rating');  // Element to display the total rating
    const evaluationFormsContainer = document.getElementById('evaluationFormsContainer');  // The container holding evaluation forms
    const totalPOsCount = document.getElementById('totalPOsCount');  // Element showing total number of POs
    const currentRatingDisplay = document.getElementById('currentRating');  // Element for the current rating
    const statusText = document.getElementById('statusText');  // Element to show the status (PASSED/FAILED)

    // Weight mapping for the criteria
    const percentageMap = {
        1: {1: 5, 2: 10, 3: 15, 4: 20},
        2: {1: 6.25, 2: 15, 3: 22.5, 4: 30},
        3: {1: 6.25, 2: 12.5, 3: 18.75, 4: 25},
        4: {1: 6.25, 2: 12.5, 3: 18.75, 4: 25}
    };

    // Criteria mapping to get the radio button name dynamically
    const criteriaMap = {
        1: 'price',
        2: 'quality',
        3: 'customercare',
        4: 'delivery'
    };

    // Function to calculate total score for a single PO
    function calculateTotalScore(form) {
        let totalScore = 0;

        // Loop through the criteria for each form (PO)
        for (let i = 1; i <= 4; i++) {
            const radioName = `${criteriaMap[i]}_${form.dataset.formId}`;
            const selectedRadio = form.querySelector(`input[name="${radioName}"]:checked`);

            if (selectedRadio) {
                const rating = parseInt(selectedRadio.value, 10);  // Get selected rating (1-4)
                totalScore += percentageMap[i][rating];  // Add the weighted score based on the rating
            }
        }

        return totalScore;
    }

    // Function to calculate the overall average rating
    function calculateOverallRating() {
        let totalScore = 0;
        let totalPOs = 0;

        // Loop through all the evaluation forms
        const evaluationForms = evaluationFormsContainer.querySelectorAll('.evaluation-form-item');

        evaluationForms.forEach(form => {
            const formScore = calculateTotalScore(form);
            if (formScore > 0) {
                totalScore += formScore;
                totalPOs++;
            }
        });

        // Update the overall rating and PO count
        const averageRating = totalPOs > 0 ? (totalScore / totalPOs).toFixed(2) : 0;
        currentRatingDisplay.textContent = averageRating;  // Update the overall rating display
        totalPOsCount.textContent = totalPOs;  // Update the PO count display

        // Update the status text based on the average rating
        if (averageRating >= 60) {
            statusText.textContent = "PASSED";
            statusText.classList.remove('text-red-300');
            statusText.classList.add('text-green-300');
        } else {
            statusText.textContent = "FAILED";
            statusText.classList.remove('text-green-300');
            statusText.classList.add('text-red-300');
        }
    }

    // Add event listeners to all radio buttons within the evaluation form items
    evaluationFormsContainer.addEventListener('change', function (event) {
        if (event.target.type === 'radio') {
            calculateOverallRating();  // Recalculate overall rating whenever a radio button is changed
        }
    });

    // Initialize calculation when the page loads (for any pre-selected radio buttons)
    calculateOverallRating();
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {

  // Camera Elements
  const captureEvaluatorBtn = document.getElementById('add_captureEvaluatorBtn');
  const cameraModal = document.getElementById('cameraModal');
  const closeCameraModal = document.getElementById('closeCameraModal');
  const captureBtn = document.getElementById('captureBtn');
  const confirmCaptureBtn = document.getElementById('confirmCaptureBtn');
  const retakeBtn = document.getElementById('retakeBtn');

  const video = document.getElementById('cameraVideo');
  const canvas = document.getElementById('captureCanvas');
  const capturedImage = document.getElementById('capturedImage');

  const cameraPlaceholder = document.getElementById('cameraPlaceholder');
  const capturedPreview = document.getElementById('capturedImagePreview');

  // Add modal evaluator inputs & outputs
  const evaluatorNameInput = document.getElementById('add_full_name');
  const evaluatorDesignationInput = document.getElementById('add_designation');

  const evaluatorCaptured = document.getElementById('add_evaluatorCaptured');
  const evaluatorName = document.getElementById('add_evaluatorName');
  const evaluatorDesignation = document.getElementById('add_evaluatorDesignation');
  const evaluatorImage = document.getElementById('add_evaluatorImage');
  const preparedBySection = document.getElementById('add_preparedBySection');

  let stream = null;

  // OPEN CAMERA
  captureEvaluatorBtn.addEventListener('click', async function() {
    if (!evaluatorNameInput.value || !evaluatorDesignationInput.value) {
      alert("Please enter full name and designation first.");
      return;
    }

    cameraModal.classList.remove('hidden');

    try {
      stream = await navigator.mediaDevices.getUserMedia({ video: true });
      video.srcObject = stream;

      video.onloadedmetadata = () => {
        video.play();
        video.classList.remove('hidden');
        cameraPlaceholder.classList.add('hidden');
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
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageData = canvas.toDataURL("image/png");
    capturedImage.src = imageData;

    video.classList.add('hidden');
    capturedPreview.classList.remove('hidden');

    captureBtn.classList.add('hidden');
    confirmCaptureBtn.classList.remove('hidden');
  });

  // RETAKE IMAGE
  retakeBtn.addEventListener('click', function() {
    capturedPreview.classList.add('hidden');
    video.classList.remove('hidden');
    captureBtn.classList.remove('hidden');
    confirmCaptureBtn.classList.add('hidden');
  });

  // CONFIRM CAPTURE
  confirmCaptureBtn.addEventListener('click', function() {
    evaluatorName.textContent = evaluatorNameInput.value;
    evaluatorDesignation.textContent = evaluatorDesignationInput.value;
    evaluatorImage.src = capturedImage.src;

    preparedBySection.classList.add('hidden');
    evaluatorCaptured.classList.remove('hidden');

    stopCamera();
    cameraModal.classList.add('hidden');
  });

  // CLOSE CAMERA MODAL
  closeCameraModal.addEventListener('click', function() {
    stopCamera();
    cameraModal.classList.add('hidden');
  });

  // CLICK OUTSIDE CAMERA MODAL
  cameraModal.addEventListener('click', function(e) {
    if (e.target === cameraModal) {
      stopCamera();
      cameraModal.classList.add('hidden');
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

