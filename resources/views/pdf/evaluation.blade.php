<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Evaluation</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { background: linear-gradient(to right, #2563eb, #1d4ed8); color: white; padding: 20px; border-radius: 10px 10px 0 0; }
        .header h3 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0 0; font-size: 12px; color: #dbeafe; }

        .section { padding: 15px; margin-bottom: 10px; border-radius: 10px; background: #f9fafb; border: 1px solid #e5e7eb; }
        .section h4 { margin: 0 0 10px; font-size: 14px; font-weight: bold; color: #1e3a8a; }

        input, textarea { width: 100%; border: 1px solid #d1d5db; padding: 5px; font-size: 12px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #9ca3af; padding: 5px; text-align: left; font-size: 12px; }
        th { background: #374151; color: white; }

        .po-rating { font-weight: bold; font-size: 16px; text-align: center; padding: 10px; background: linear-gradient(to right, #16a34a, #15803d); color: white; border-radius: 5px; margin-top: 10px; }
        .status { font-weight: bold; text-align: center; padding: 5px; color: white; border-radius: 5px; margin-top: 5px; }
        .status.pass { background-color: #16a34a; }
        .status.fail { background-color: #dc2626; }

        .evaluator-info { margin-top: 15px; }
        .evaluator-info img { width: 80px; height: 80px; border-radius: 10px; border: 1px solid #d1d5db; }

    </style>
</head>
<body>

<div class="header">
    <h3>SUPPLIER'S EVALUATION FORM</h3>
    <p>Performance Assessment & Rating System</p>
</div>

<div class="section">
    <h4>Basic Information</h4>
    <p><strong>Name of Supplier:</strong> {{ $evaluation->supplier_name }}</p>
    <p><strong>Purchase Order / Contract No.:</strong> {{ $evaluation->po_no }}</p>
    <p><strong>Date of Evaluation:</strong> {{ $evaluation->date_evaluation }}</p>
    <p><strong>Covered Period:</strong> {{ $evaluation->covered_period }}</p>
    <p><strong>Evaluated by (Office Name):</strong> {{ $evaluation->office_name }}</p>
</div>

<div class="section">
    <h4>Evaluation Criteria</h4>
    <table>
        <thead>
            <tr>
                <th>CRITERIA</th>
                <th>REMARKS / COMMENTS</th>
                <th>RATING (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluation->criteriaScores as $score)
            <tr>
                <td>
                    @switch($score->criteria_id)
                        @case(1) PRICE (20%) @break
                        @case(2) QUALITY / SERVICE LEVEL (30%) @break
                        @case(3) CUSTOMER CARE / AFTER SALES (25%) @break
                        @case(4) DELIVERY FULFILLMENT (25%) @break
                    @endswitch
                </td>
                <td>{{ $score->remarks ?? '-' }}</td>
                <td>
                    @php
                        $percentageMap = [1 => [1=>5,2=>10,3=>15,4=>20], 2=>[1=>6.25,2=>15,3=>22.5,4=>30], 3=>[1=>6.25,2=>12.5,3=>18.75,4=>25], 4=>[1=>6.25,2=>12.5,3=>18.75,4=>25]];
                        $scorePercent = $percentageMap[$score->criteria_id][$score->number_rating] ?? 0;
                    @endphp
                    {{ $scorePercent }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="po-rating">
        PO Rating: {{ round($evaluation->criteriaScores->sum(function($s) use ($percentageMap){ return $percentageMap[$s->criteria_id][$s->number_rating] ?? 0; }), 2) }}%
    </div>

    @php
        $totalScore = $evaluation->criteriaScores->sum(function($s) use ($percentageMap){ return $percentageMap[$s->criteria_id][$s->number_rating] ?? 0; });
    @endphp

    <div class="status {{ $totalScore >= 60 ? 'pass' : 'fail' }}">
        {{ $totalScore >= 60 ? 'PASSED' : 'FAILED' }}
    </div>
</div>

@if($evaluation->digitalApprovals && $evaluation->digitalApprovals->count() > 0)
<div class="section evaluator-info">
    <h4>Digital Authorization</h4>
    @foreach($evaluation->digitalApprovals as $approval)
        <p><strong>Prepared by:</strong> {{ $approval->full_name }}</p>
        <p><strong>Designation:</strong> {{ $approval->designation ?? '-' }}</p>
        <img src="{{ public_path($approval->image ?? '/default-image.png') }}" alt="Evaluator">
    @endforeach
</div>
@endif

</body>
</html>
