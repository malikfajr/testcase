<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pegawai.index');
    }

    function getEmployees(Request $request)
    {
        $columns = [null, 'name', 'position_name', 'email', 'phone', 'address', 'jk', 'hire_date', 'end_date', 'status', 'salary']; // kolom yang bisa diorder

        $search = $request->input('search.value');

        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir') ?? 'asc';
        $orderBy = $columns[$orderColumn] ?? 'name';

        $query = DB::table('employees AS e')->select(['e.picture', 'e.first_name', 'e.last_name', 'e.email', 'e.phone', 'e.address', 'e.gender', 'e.hire_date', 'e.end_date', 'e.salary', 'e.status', 'p.title as position_name'])
            ->join(DB::raw('positions as p'), 'e.position_id', '=', 'p.id')
            ->selectRaw(' CONCAT(e.first_name, " ", e.last_name) as name, IF(e.gender, "female", "male") AS jk');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->whereRaw('CONCAT(e.first_name, " ", e.last_name) like ?', ["%$search%"])
                    ->orWhere('e.email', 'like', "%$search%")
                    ->orWhere('p.title', 'like', "%$search%");
            });
        }

        $totalRecords = Employee::count();
        $filteredRecords = $query->count();

        $query->orderBy($orderBy, $orderDir);

        $employees = $query->skip($request->input('start'))
            ->take($request->input('length') ?? 10)
            ->get();;

        return response()->json([
            'draw' => $request->input('draw') ?? 1,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::all();
        return view('pegawai.add', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate and store form data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'position' => 'required|exists:positions,id',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:18',
            'address' => 'required|string',
            'gender' => 'required|boolean',
            'date_of_birth' => 'required|date',
            'hire_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string|max:255',
            'salary' => 'required|numeric|digits_between:5,10',
            'picture_path' => 'required|string',
        ]);



        Employee::create([
            'picture' =>  $validatedData['picture_path'],
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'gender' => $validatedData['gender'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'hire_date' => date('Y-m-d', strtotime($validatedData['hire_date'])),
            'end_date' => date('Y-m-d', strtotime($validatedData['end_date'])),
            'position_id' => $validatedData['position'],
            'salary' => $validatedData['salary'],
            'status' => $validatedData['status'],
            'address' => $validatedData['address']
        ]);

        // Store employee data in the database or any other storage

        return redirect()->route('employee.index')->with('success', 'Data berhasil dimasukkan!');
    }

    public function storeImage(Request $request)
    {
        // Validate the image
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        logs()->info($request->file('picture'));

        // Store the image
        $filePath = $request->file('picture')->store('employee_pictures', 'public');

        return response()->json(['filepath' => $filePath]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
