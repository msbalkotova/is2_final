<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
    public function index() {
    	$departments = \DB::table('departments')->get();
    	return view('employee.index', ['departments' => $departments]);
    }

    public function search(Request $request) {
    	$dept_managers = array();
    	$dept_manager = \DB::table('dept_manager')->where('to_date', '=', '9999-01-01')->get();

    	foreach($dept_manager as $data) {
    		array_push($dept_managers, $data->emp_no);
    	}

    	$employees = Employee::
        join('titles', 'titles.emp_no', '=', 'employees.emp_no')
    	->join('salaries', 'salaries.emp_no', '=', 'employees.emp_no')
    	->join('dept_emp', 'dept_emp.emp_no', '=', 'employees.emp_no')
    	->join('departments', 'departments.dept_no', '=', 'dept_emp.dept_no')
    	->where('titles.to_date', '=', '9999-01-01')
    	->where('salaries.to_date', '=', '9999-01-01')
    	->where('dept_emp.to_date', '=', '9999-01-01')
    	->where('dept_emp.dept_no', 'LIKE', '%'.$request->get('dept').'%')
    	->where(\DB::raw('CONCAT(first_name, " ", last_name)'), 'LIKE', '%'.$request->get('name').'%')
        ->limit(1000)
    	->get();
    	return view('employee.search', ['employees' => $employees, 'dept_managers' => $dept_managers]);
    }
}