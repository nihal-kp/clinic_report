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
        {{-- <div class="col-md-12">
            <div id="showimages"></div>
        </div> --}}
        <div class="col-10 mt-5 mx-auto">
            <div class="card">
                <div class="card-header bg-secondary">
                    {{-- <h6 class="text-white"></h6> --}}
                </div>
                <div class="card-body">
                    <form class="image-upload" action="{{ route('report') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Clinic Name" name="clinic_name" value="{{ old('clinic_name') }}" required>
                                @error("clinic_name")
                                <p style="color:red">{{$errors->first("clinic_name")}}</p>
                                @enderror
                            </div>
                            <div class="col">
                                <label class="custom-file-label">Clinic Logo</label>
                                <input type="file" class="custom-file-input" id="customFile" name="clinic_logo" value="{{ old('clinic_logo') }}" required>
                                @error("clinic_logo")
                                <p style="color:red">{{$errors->first("clinic_logo")}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Physician Name" name="physician_name"  value="{{ old('physician_name') }}" required>
                                @error("physician_name")
                                <p style="color:red">{{$errors->first("physician_name")}}</p>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Physician Contact" name="physician_contact" value="{{ old('physician_contact') }}" required>
                                @error("physician_contact")
                                <p style="color:red">{{$errors->first("physician_contact")}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Patient First Name" name="patient_first_name" value="{{ old('patient_first_name') }}" required>
                                @error("patient_first_name")
                                <p style="color:red">{{$errors->first("patient_first_name")}}</p>
                                @enderror
                            </div>
                            <div class="col"> 
                                <input type="text" class="form-control" placeholder="Patient Last Name" name="patient_last_name" value="{{ old('patient_last_name') }}" required>
                                @error("patient_last_name")
                                <p style="color:red">{{$errors->first("patient_last_name")}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Patient DOB" name="patient_dob" value="{{ old('patient_dob') }}" required>
                                @error("patient_dob")
                                <p style="color:red">{{$errors->first("patient_dob")}}</p>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Patient Contact" name="patient_contact" value="{{ old('patient_contact') }}" required>
                                @error("patient_contact")
                                <p style="color:red">{{$errors->first("patient_contact")}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mt-4">
                                <label class="col-8">Chief Complaint</label> <p class="col-4 ml-auto">Max 5000 characters allowed</p>
                            </div>
                            <textarea name="chief_complaint" rows="5" cols="40" class="form-control tinymce-editor">{{ old('chief_complaint') }}</textarea>
                            @error("chief_complaint")
                                <p style="color:red">{{$errors->first("chief_complaint")}}</p>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <div class="row mt-4">
                                <label class="col-8">Consultation Note</label> <p class="col-4 ml-auto">Max 5000 characters allowed</p>
                            </div>
                            <textarea name="consultation_note" rows="5" cols="40" class="form-control tinymce-editor">{{ old('consultation_note') }}</textarea>
                            @error("consultation_note")
                                <p style="color:red">{{$errors->first("consultation_note")}}</p>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
                        </div>
                    </form>
                </div>
                <a href="" class="ml-auto mr-3" data-toggle="modal" data-target="#myModal">View Previous Consultations</a>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                
                <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Previous Consultations</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <span data-href="/reports" id="export" class="btn btn-info" onclick="exportReports(event.target);">Export to CSV</span>
                        <table class="table">
                            <tr>
                                <th>SI No.</th>
                                <th>Clinic Name</th>
                                <th>Physician Name</th>
                                <th>Patient Name</th>
                                <th colspan="2">Chief Complaint</th>
                                <th colspan="2">Consultation Note</th>
                                <th>Actions</th>
                            </tr>
                            <?php $i = 1; ?>
                            @foreach ($reports as $report)
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>{{$report->clinic_name}}</td>
                                    <td>{{$report->physician_name}}</td>
                                    <td>{{$report->patient_first_name." ".$report->patient_last_name}}</td>
                                    <td colspan="2">{!! $report->chief_complaint !!}</td>
                                    <td colspan="2">{!! $report->consultation_note !!}</td>
                                    <td><a class="btn btn-primary" href="{{ URL::to('/report/pdf/'.$report->id ) }}">Export to PDF</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>  
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 100,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        function exportReports(_this) {
            let _url = $(_this).data('href');
            window.location.href = _url;
        }
    </script>
</body>
</html>