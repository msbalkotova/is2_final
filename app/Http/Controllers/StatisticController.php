<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class StatisticController extends Controller
{
    public function index() {
        $departments = \DB::table('departments')->get();
    	return view('statistics.index', ['departments'=> $departments]);
    }

    public function getOverallStats(Request $request, $dept) {
        $tekuchest = \DB::table('tekuchest_kompanii')->get();
        $titlesPodepam = \DB::table('titlesPodepam')->where('dept_no', '=', $dept)->get();

        $results = ['tekuchest' => $tekuchest, 'titlesPodepam' => $titlesPodepam];

        return response()->json($results);
    }

    public function getSingleStats(Request $request, $emp) {
    	$salaries = Employee::join('salaries', 'salaries.emp_no', '=', 'employees.emp_no')
    	->where('employees.emp_no', '=', $emp)->get();

    	$titles = Employee::join('titles', 'titles.emp_no', '=', 'employees.emp_no')
    	->where('employees.emp_no', '=', $emp)->orderBy('titles.from_date', 'asc')->get();

    	$depts = Employee::join('dept_emp', 'dept_emp.emp_no', '=', 'employees.emp_no')
    	->join('departments', 'departments.dept_no', '=', 'dept_emp.dept_no')
    	->where('employees.emp_no', '=', $emp)->orderBy('dept_emp.from_date', 'asc')->get();

    	$results = ['salaries' => $salaries, 'titles' => $titles, 'depts' => $depts];

    	return response()->json($results);
    }
}
