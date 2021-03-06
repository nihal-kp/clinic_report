<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="col-10 mt-5 mx-auto">
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ URL::to('/report/pdf/'.$report->id ) }}">Export to PDF</a>
            </div>
            <div class="card">
                <div class="card-header bg-secondary">
                    {{-- <h6 class="text-white"></h6> --}}
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td colspan="3"><img src="/images/{{$report->clinic_logo}}" width="50"></td>
                            <td colspan="1"><h2>{{$report->clinic_name}}</h2></td>
                        </tr>
                        <tr>
                            <th>Physician Name:</th>
                            <td>{{$report->physician_name}}</td>
                            <th>Physician Contact:</th>
                            <td>{{$report->physician_contact}}</td>
                        </tr>
                        <tr>
                            <th>Patient First Name:</th>
                            <td>{{$report->patient_first_name}}</td>
                            <th>Patient Last Name:</th>
                            <td>{{$report->patient_last_name}}</td>
                        </tr>
                        <tr>
                            <th>Patient DOB:</th>
                            <td>{{$report->patient_dob}}</td>
                            <th>Patient Contact:</th>
                            <td>{{$report->patient_contact}}</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="pt-5">Chief Complaint:</th>
                        </tr>
                        <tr>
                            <td colspan="4">{!! $report->chief_complaint !!}</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="pt-5">Consultation Note:</th>
                        </tr>
                        <tr>
                            <td colspan="4">{!! $report->consultation_note !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>