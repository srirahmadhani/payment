<?php
namespace App\Http\Controllers;

use App\Employee;
use App\User;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('employee.index', compact('employee','authposition','authname'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $position = Position::all();
        
        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('employee.create', compact('position','authposition','authname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $this->validate($request,[
            // 'NIK' => ['required','unique:employees'],
            // 'password' => ['required','min:8'],
            // 'email' => ['required', 'unique:users'],
          
            


            'NIK' => 'required|max:16|unique:employees',
            'password' => 'required|min:8',
            'email' => 'required|unique:users',
            'phone' => 'required|max:12|unique:employees'
        ]);

        $id_user = User::create([
            'email' => $request->email, 
            'password' => Hash::make($request['password']), 
            'level' => 1, 
            'register_date' => date("Y-m-d H:i:s") 
        ])->id;

        $employee = Employee::create([
            'NIK' => $request->NIK, 
            'employee_name' => $request->nama, 
            'gender' => $request->gender, 
            'phone' => $request->phone, 
            'address' => $request->alamat, 
            'id_position' => $request->jabataan, 
            'employee_id' => $id_user
        ]);

        DB::commit();
        return redirect()->route('employee.index')
            ->with('Status', 'Data Pegawai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = DB::table('employees')
                ->join('users','users.id','=','employees.employee_id')
                ->join('positions','positions.position_id','=','employees.id_position')
                ->select('users.*','employees.*','positions.position_name')
                ->where('employees.employee_id','=', $id)
                ->first();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');

        return view('employee.show', compact('employee','authposition','authname'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $position = Position::All();

        $authposition = session()->get('id_position');
        $authname = session()->get('name');
        
        // $pengunjung=Pengunjung::where('id_pengunjung','=',$id)->first();
        return view('/employee.edit', compact('employee', 'position', 'authposition','authname'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();

        $employee = Employee::find($id);

        // $employee = update ($request->all());
        // return redirect('/employee')->with ('sukses')
        $employee->employee_name = $request->nama;
        $employee->gender = $request->gender;
        $employee->phone = $request->hp;
        $employee->address = $request->alamat;
        $employee->id_position = $request->jabataan;
        $employee->save();

        $user = User::find($id);

        $user->email = $request->email;

        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }

        $user->status = $request->status;
        
        $user->save();

        DB::commit();
        
        return redirect()
            ->route('employee.index')
            ->with('Status', 'data pegawai berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $employee = Employee::where('employee_id', '=', $id)->delete();
        // $user = User::where('id_user', '=', $id)->delete();
        // return redirect()
        //     ->route('employee.index')
        //     ->with('Status', 'data pegawai berhasil dihapus!');
    
      
        $user = User::where('id', '=', $id)->delete();
        $employee = Employee::where('employee_id', '=', $id)->delete();

        return redirect()
            ->route('employee.index')
            ->with('Status', 'data pengunjung berhasil dihapus!');

    }


}

