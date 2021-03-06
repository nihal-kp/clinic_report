<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClinicReport;
use PDF;

class ClinicReportController extends Controller
{
    public function index()
    {
        $reports = ClinicReport::get();
        return view('home',['reports'=>$reports]);
    }

    public function store(Request $req)
    {
        // ClinicReport::create($request->all());
        // $report = ClinicReport::where('patient_contact',$request->patient_contact)->first();
        // return view('report',['report'=>$report]);
        $this->validate($req, [
            'clinic_name' => 'required|min:4',
            'physician_name' => 'required|min:4',
            'physician_contact' => 'required|numeric|min:10',
            'patient_first_name' => 'required|min:4',
            'patient_last_name' => 'required|min:2',
            'patient_dob' => 'required',
            'patient_contact' => 'required|numeric|min:10|unique:clinic_reports',
            'chief_complaint' => 'required',
            'consultation_note' => 'required',
            'clinic_logo' => 'file|mimes:png,jpg,jpeg|max:1024',
        ]);
        $report = new ClinicReport;
        $report->clinic_name = $req->clinic_name;
        $report->physician_name = $req->physician_name;
        $report->physician_contact = $req->physician_contact;
        $report->patient_first_name = $req->patient_first_name;
        $report->patient_last_name = $req->patient_last_name;
        $report->patient_dob = $req->patient_dob;
        $report->patient_contact = $req->patient_contact;
        $report->chief_complaint = $req->chief_complaint;
        $report->consultation_note = $req->consultation_note;
        // $report->image = $req->file('image')->store('images');

        if($req->hasFile('clinic_logo')) {
            
            $file = $req->file('clinic_logo') ;
            
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = public_path().'/images/' ;
            $file->move($destinationPath,$fileName);
            $report->clinic_logo = $fileName ;
        }
        else
        {
            return $req;
            $report->clinic_logo = '';
        }
        $report->save();
        $findReport = ClinicReport::where('patient_contact',$req->patient_contact)->first();
        return view('report',['report'=>$findReport]);
    }

    public function exportPDF($id) {
        $report = ClinicReport::find($id);
  
        // share data to view
        view()->share('report',$report);
        $pdf = PDF::loadView('pdf_view', $report);
  
        // download PDF file with download method
        return $pdf->download('CR_'.$report->patient_last_name.'_'.$report->patient_first_name.'_'.$report->patient_dob.'.pdf');
      }

    public function exportCsv(Request $request)
    {
        $fileName = 'clinic_reports.csv';
        $reports = ClinicReport::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Clinic Name', 'Physician Name', 'Physician Contact', 'Patient First Name', 'Patient Last Name', 'Patient DOB', 'Patient Contact', 'Chief Complaint', 'Consultation Note');

        $callback = function() use($reports, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($reports as $report) {
                $row['Clinic Name']  = $report->clinic_name;
                $row['Physician Name']    = $report->physician_name;
                $row['Physician Contact']    = $report->physician_contact;
                $row['Patient First Name']  = $report->patient_first_name;
                $row['Patient Last Name']    = $report->patient_last_name;
                $row['Patient DOB']    = $report->patient_dob;
                $row['Patient Contact']  = $report->patient_contact;
                $row['Chief Complaint']    = $report->chief_complaint;
                $row['Consultation Note']    = $report->consultation_note;

                fputcsv($file, array($row['Clinic Name'], $row['Physician Name'], $row['Physician Contact'], $row['Patient First Name'], $row['Patient Last Name'], $row['Patient DOB'], $row['Patient Contact'], $row['Chief Complaint'], $row['Consultation Note']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
