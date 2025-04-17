<!DOCTYPE html>
<html>
<head>
    <title>Submission Report</title>
    <style>
        /* Base Styles */
        @page {
            margin: 1cm;
        }

        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #2c3e50;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        /* Header Styles */
        .report-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2c3e50;
            position: relative;
        }

        .report-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            page-break-inside: auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2c3e50;
        }

        /* Division Header */
        .division-header {
            background-color: #f1f3f5;
            font-weight: 600;
            text-align: left;
            padding: 12px;
            color: #2c3e50;
            border-bottom: 2px solid #e0e0e0;
        }

        /* Status Indicators */
        .status-uploaded {
            color: #28a745;
            font-weight: 500;
            background-color: rgba(40, 167, 69, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        .status-not-uploaded {
            color: #dc3545;
            font-weight: 500;
            background-color: rgba(220, 53, 69, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        /* Print Specific Styles */
        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            table {
                page-break-inside: auto;
                box-shadow: none;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            .status-uploaded, .status-not-uploaded {
                background-color: transparent;
                padding: 0;
            }
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(0, 0, 0, 0.05);
            pointer-events: none;
            z-index: -1;
            font-weight: bold;
        
        }
    </style>
</head>
<body>
    <div class="watermark" >LJKU</div>

    <div class="report-header">
        <div class="report-title">Certificate Submission Report</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Division</th>
                <th>Enrollment No.</th>
                <th>Name</th>
                @foreach($courses as $courseId => $course)
                    <th>{{ $course }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($grouped as $division => $group)
                <tr class="division-header">
                    <td colspan="{{ 4 + count($courses) }}">Division {{ $division }}</td>
                </tr>
                @php $serial = 1; @endphp
                @foreach($group as $student)
                    <tr>
                        <td>{{ $serial++ }}</td>
                        <td>{{ $student->division }}</td>
                        <td>{{ $student->enrollment_no }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        @foreach($coursesIds as $cid)
                            @php
                                $key = $student->enrollment_no . '-' . $cid;
                            @endphp
                            <td>
                                @if(in_array($key, $submittedMap))
                                    <span class="status-uploaded">Uploaded</span>
                                @else
                                    <span class="status-not-uploaded">Not Uploaded</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
