<?php

namespace App\Http\Controllers;

use App\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Excel;
use File;

class StudentController extends Controller
{
    public function index()
    {
        $students = Students::latest()->paginate(20);
        return view('index', compact('students'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
    }

    public function fileImport()
    {
        return view('add-student');
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        Students::create($request->all());
        return redirect()->route('index')
            ->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $student = Students::find($id);
        return view('show')->with('student', $student);
    }

    public function edit($id)
    {
        $student = Students::find($id);
        return view('edit')->with('student', $student);
    }

    public function update(Request $request, $id)
    {
        $student = Students::find($id);
        $student->update($request->all());
        return redirect()->route('index')
            ->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        Students::destroy($id);
        return redirect()->route('index')
            ->with('success', 'Student deleted successfully');
    }

    public function export()
    {
        $students = Students::all();
        Excel::create('students', function ($excel) use ($students) {
            $excel->sheet('ExportFile', function ($sheet) use ($students) {
                $sheet->fromArray($students);
            });
        })->export('xls');
    }

    public function import(Request $request)
    {
        //validate the xls file
        $this->validate($request, array(
            'file' => 'required'
        ));

        if ($request->hasFile('file')) {
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $path = $request->file->getRealPath();
                $insert = [];
                $result = Excel::load($path, function ($reader) {
//                    $i = 0;
//                    $result = $reader->get();
                })->get();
                $i = 0;
                foreach ($result as $row) {
//                    dump([$i => $row]);
                    if ($i > 1) {
                        if ($row[0] != null) {
                            $insert[] = [
                                'name' => $row[0],
                                'surname' => $row[1]
                            ];
                        }
                    }
                    $i++;
                }
                if (!empty($insert)) {
                    $insertData = DB::table('students')->insert($insert);
                    if ($insertData) {
                        Session::flash('success', 'Your Data has successfully imported');
                    } else {
                        Session::flash('error', 'Error inserting the data..');
                        return redirect()->route('index');
                    }
                }
            }
            return redirect()->route('index');
        } else {
            Session::flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
            return back();
        }
    }
}
