<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Department;
use carbon\Carbon;
use Illuminate\Database\Query\Builder;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Guest;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

class DashboardController extends Controller
{
    use WithExport;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $list = Event::paginate(10);
        return view('dashboard');
    }


    public function dashboard()
    {

        $staffs= DB::table('Staff')
            ->select(
                'Staff.department',
                'Staff.id',
                'Staff.title',
                'Staff.name',
                DB::raw('IFNULL(SUM(Assignments.credit), 0) AS total_credit') // Handle null as 0
            )
            ->leftJoin('Assignments', function ($join) {
                $join->on('Staff.id', '=', 'Assignments.staff_id')
                    ->where('Assignments.year', '=', date('Y')) // Filter assignments by the current year
                    ->whereNull('Assignments.deleted_at'); // Exclude deleted records
            })
            ->groupBy('Staff.id', 'Staff.department', 'Staff.title', 'Staff.name') // Group by staff to calculate total credit
            ->orderBy('Staff.department') // Sort by department
            ->orderBy('total_credit') // Sort by credit in ascending order (lowest credit first)
            ->get()
            ->groupBy('department') // Group result by department after fetching
            ->map(function ($group) {
                return [
                    'highest' => $group->sortByDesc('total_credit')->first(), // Staff with the highest credit
                    'lowest'  => $group->first() // Staff with the lowest or no credit
                ];
            });

        $faculties = Faculty::all();
        $departments = Department::all();
    //    dd($staffs);
        return view('dashboard', compact('faculties', 'departments', 'staffs'));
    }
}
