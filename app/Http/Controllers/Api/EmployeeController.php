<?php

namespace App\Http\Controllers\Api;

use App\Deduction;
use App\Earning;
use App\EmergencyContact;
use App\Employee;
use App\EmployeeDocuments;
use App\EmployeeSocial;
use App\EmployeeWorkingHours;
use App\EmploymentManagement;
use App\GovernmentID;
use App\Http\Controllers\Controller;
use App\Payslip;
use App\PersonalDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{

    public function myProfile()
    {

        $profile_data['user'] = User::where('id', auth()->user()->id)->first();
        $profile_data['employee'] = Employee::where('user_id', auth()->user()->id)->first();
        $profile_data['personal_details'] = PersonalDetails::where('user_id', auth()->user()->id)->first();
        $profile_data['employment_management'] = EmploymentManagement::where('user_id', auth()->user()->id)->get();
        $profile_data['employee_working_hours'] = EmployeeWorkingHours::where('user_id', auth()->user()->id)->get();
        $profile_data['employee_social'] = EmployeeSocial::where('user_id', auth()->user()->id)->get();
        $profile_data['government_i_d_s'] = GovernmentID::where('user_id', auth()->user()->id)->get();
        $profile_data['emergency_contact'] = EmergencyContact::where('user_id', auth()->user()->id)->get();
        $profile_data['employee_documents'] = EmployeeDocuments::where('user_id', auth()->user()->id)->get();

        return response()->json($profile_data);
    }

    public function getProfile($user_id)
    {
        $user = User::find($user_id);

        if(!$user)
            return response()->json('User Not Found.', 404);

        $profile_data['user'] = $user;
        $profile_data['employee'] = Employee::where('user_id', $user->id)->first();
        $profile_data['personal_details'] = PersonalDetails::where('user_id', $user->id)->first();
        $profile_data['employment_management'] = EmploymentManagement::where('user_id', $user->id)->get();
        $profile_data['employee_working_hours'] = EmployeeWorkingHours::where('user_id', $user->id)->get();
        $profile_data['employee_social'] = EmployeeSocial::where('user_id', $user->id)->get();
        $profile_data['government_i_d_s'] = GovernmentID::where('user_id', $user->id)->get();
        $profile_data['emergency_contact'] = EmergencyContact::where('user_id', $user->id)->get();
        $profile_data['employee_documents'] = EmployeeDocuments::where('user_id', $user->id)->get();

        return response()->json($profile_data);
    }

    public function updatePersonalDetails(Request $request)
    {
        $user = User::find($request->route('user'));

        if(!$user)
            return response()->json('User Not Found.', 404);

        $success = PersonalDetails::where('user_id',  $user->id)
            ->update([
                "nationality" => $request->nationality,
                "mob_nos" => $request->mob_nos,
                "tel_nos" => $request->tel_nos,
                "marital_status" => $request->marital_status,
                "gender" => $request->gender,
                "age" => $request->age,
                "date_of_birth" => $request->date_of_birth,
                "home_address" => $request->home_address,
                "skype" => $request->skype,
                "work_email_address" => $request->work_email_address,
                "personal_email" => $request->personal_email,
                "work_tel_nos" => $request->work_tel_nos,
                "work_mob_nos" => $request->work_mob_nos,
                "bank_name" => $request->bank_name,
                "bank_account" => $request->bank_account
            ]);

        if ($success)
            return response()->json('updated', 200);
        else
            return response()->json('failed', 500);
    }

    public function updateEmergencyContact(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'relationship' => 'required',
            'contact_nos' => 'required'
        ]);


        $emc = EmergencyContact::where('id', $request->route('id'))
            ->update(["name" => $request->name, "relationship" => $request->relationship, "contact_nos" => $request->contact_nos,]);


        if ($emc)
            return response()->json('Updated', 200);
        else
            return response()->json('Failed', 500);


    }

    public function updateSocial(Request $request){

        $this->validate($request, [
            'social_name' => 'required',
            'social_link' => 'required',
        ]);

        $social_links = EmployeeSocial::where('id', $request->route('id'))
            ->update(["social_name" => $request->social_name, "social_link" => $request->social_link,]);


        if ($social_links)
            return response()->json('updated', 200);
        else
            return response()->json('failed', 500);


    }

    public function addSocial(Request $request){

        $user =  User::find($request->route('user'));

        if(!$user)
            return response()->json('User Not Found.', 404);

        $this->validate($request, [
            'social_name' => 'required',
            'social_link' => 'required',
        ]);

        $social = new EmployeeSocial;
        $social->social_name = $request->input('social_name');
        $social->social_link = $request->input('social_link');
        $social->user_id = $user->id;
        $social->save();


        if ($social)
            return response()->json($social, 200);
        else
            return response()->json('failed', 500);


    }

    public function updateGovID(Request $request){

        $this->validate($request, [
            'id_name' => 'required',
            'id_no' => 'required',
        ]);

        $government_update = GovernmentID::where('id', $request->route('id'))
            ->update(["id_name" => $request->id_name, "id_no" => $request->id_no,]);


        if ($government_update)
            return response()->json('updated', 200);
        else
            return response()->json('failed', 500);


    }

    public function addGovID(Request $request){

        $user =  User::find($request->route('user'));

        if(!$user)
            return response()->json('User Not Found.', 404);


        $this->validate($request, [
            'id_name' => 'required',
            'id_no' => 'required'
        ]);

        $gov = new GovernmentID;
        $gov->id_name = $request->input('id_name');
        $gov->id_no = $request->input('id_no');
        $gov->user_id = $user->id;
        $gov->save();


        if ($gov)
            return response()->json($gov, 200);
        else
            return response()->json('failed', 500);
    }

    public function addEmergencyContact(Request $request){

        $user =  User::find($request->route('user'));

        if(!$user)
            return response()->json('User Not Found.', 404);

        $this->validate($request, [
            'name' => 'required',
            'relationship' => 'required',
            'contact_nos' => 'required'
        ]);


        $emg = new EmergencyContact;
        $emg->name = $request->input('name');
        $emg->relationship = $request->input('relationship');
        $emg->contact_nos = $request->input('contact_nos');
        $emg->user_id = Auth::user()->id;
        $emg->save();


        if ($emg)
            return response()->json($emg, 200);
        else
            return response()->json('failed', 500);

    }

    public function uploadProfileImage(Request $request){

        $image = $request->file('img');
        $user =  User::find($request->route('user'));

        if ($user) {

            if ($user->type == 2) {
                $res = Employee::where('user_id', $user->id)->first();

                if ($res) {

                    File::delete(public_path('images/client/' . $res->profile_image));

                    $basename = Str::random();
                    $original = $basename . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('images/client'), $original);
                    $res->profile_image = $original;
                    $res->save();

                    return response()->json(["success" => true, "filename"  => $original], 201);

                } else
                    return response()->json('Employee Not Found.', 404);
            }
        } else
            return response()->json('User Not Found.', 404);
    }

    public function search(Request $request){

        $employees = User::join('employees', 'users.id', '=', 'employees.user_id')
            ->where('users.type','2');

        if ($request->input('status'))
            $employees->where('employees.status', $request->input('status'));

        if ($request->input('order'))
            $employees->orderBy(explode(',',$request->input('order'))[0], explode(',',$request->input('order'))[1]);

        if ($request->input('user'))
            $employees->where('user_id',$request->input('user'));

        $employees->get(['users.display_name', 'users.email', 'employees.*']);


        if ($employees)
            return response()->json($employees);
        else
            return response()->json(["employee" => null], 404);

    }

    public function store(Request $request){

        $emp = $request->input('emp');

        $data = Employee::create($emp);

        if ($data)
            return response()->json(["message" => "success", "employee" => $data]);
        else
            return response()->json(["message" => "unsuccessful", "result" => $data], 404);
    }

    public function toggleEmployee($emp_id){

        $employee = Employee::find($emp_id);

        if (!$employee)
            return response()->json("Employee not found", 404);

        $employee->status = $employee->status === '0' ? '1' : '0';

        $employee->save();

        return response()->json($employee);
    }

    public function earnings(Request $request){

        $start_date = new Carbon($request->input('start_date'));

        $end_date = new Carbon($request->input('end_date'));

        $basic = Earning::where('user_id', $request->route('user'))->where('type', 'basic')
            ->where(function($query) use ($end_date) {
                $query->where('date', '<=', $end_date->format('Y-m-d'))
                    ->orWhere('date', null);
            })
            ->orderBy('date', 'DESC')
            ->first();

        $allowance = Earning::where('user_id', $request->route('user'))->where('type', 'allowance')
            ->where(function($query) use ($end_date) {
                $query->where('date', '<=', $end_date->format('Y-m-d'))
                    ->orWhere('date', null);
            })
            ->orderBy('date', 'DESC')
            ->first();

        $increase = Earning::where('user_id', $request->route('user'))
            ->where('type', 'increase')
            ->where('date', '<=', $end_date->format('Y-m-d'))
            ->get();

        $adjustments = Earning::where('user_id', $request->route('user'))
            ->where('type', 'adjustment')
            ->where('date', '>=', $start_date->format('Y-m-d'))
            ->where('date', '<=', $end_date->format('Y-m-d'))
            ->get();

        $earnings = Earning::where('user_id', $request->route('user'))
            ->where('type', '!=', 'basic')
            ->where('type', '!=', 'allowance')
            ->where('type', '!=', 'increase')
            ->where('type', '!=', 'adjustment')
            ->where('date', '>=', $start_date->format('Y-m-d'))
            ->where('date', '<=', $end_date->format('Y-m-d'))
            ->get();

        if ($basic)
            return response()->json(
                [
                    "message" => 'found',
                    "earnings" => $earnings,
                    "basic" => $basic,
                    'allowance' => $allowance,
                    'increase' => $increase,
                    'adjustments' => $adjustments
                ],
                200
            );
        else
            return response()->json(["message" => 'not found'], 404);

    }

    public function deductions(Request $request){

        $start_date = new Carbon($request->input('start_date'));

        $end_date = new Carbon($request->input('end_date'));

        $tax = Deduction::where('user_id', $request->route('user'))
            ->where('type', 'tax')
            ->where(function($query) use ($end_date) {
                $query->where('date', '<=', $end_date->format('Y-m-d'))
                    ->orWhere('date', null);
            })
            ->orderBy('date', 'DESC')
            ->first();

        $sss = Deduction::where('user_id', $request->route('user'))->where('type', 'sss')
            ->where(function($query) use ($end_date) {
                $query->where('date', '<=', $end_date->format('Y-m-d'))
                    ->orWhere('date', null);
            })
            ->orderBy('date', 'DESC')
            ->first();

        $pag_ibig = Deduction::where('user_id', $request->route('user'))->where('type', 'pag-ibig')
            ->where(function($query) use ($end_date) {
                $query->where('date', '<=', $end_date->format('Y-m-d'))
                    ->orWhere('date', null);
            })
            ->orderBy('date', 'DESC')
            ->first();

        $phic = Deduction::where('user_id', $request->route('user'))->where('type', 'phic')
            ->where(function($query) use ($end_date) {
                $query->where('date', '<=', $end_date->format('Y-m-d'))
                    ->orWhere('date', null);
            })
            ->orderBy('date', 'DESC')
            ->first();

        $absent = Deduction::where('user_id', $request->route('user'))
            ->where(function ($query) {
                $query->where('type', 'absent')
                    ->orWhere('type', 'leave');
            })
            ->where('date', '>=', $start_date->format('Y-m-d'))
            ->where('date', '<=', $end_date->format('Y-m-d'))
            ->get();

        $deductions = Deduction::where('user_id', $request->route('user'))
            ->where('type', '!=', 'tax')
            ->where('type', '!=', 'sss')
            ->where('type', '!=', 'pag-ibig')
            ->where('type', '!=', 'phic')
            ->where('type', '!=', 'absent')
            ->where('type', '!=', 'leave')
            ->where('date', '>=', $start_date->format('Y-m-d'))
            ->where('date', '<=', $end_date->format('Y-m-d'))
            ->get();

        if ($deductions)
            return response()->json(
                [
                    "message" => 'found',
                    "deductions" => $deductions,
                    "tax" => $tax,
                    "sss" => $sss,
                    "pag_ibig" => $pag_ibig,
                    "phic" => $phic,
                    "absent" => $absent
                ],
                200
            );
        else
            return response()->json(["message" => 'not found'], 404);
    }

    public function storeEarning(Request $request){
        $data = $request->input('earning');

        $res = Earning::create($data);

        if ($res)
            return response()->json(["message" => "success", "earning" => $res], 200);
        else
            return response()->json(["message" => "unsuccessful", "earning" => $res], 404);
    }

    public function storeDeduction(Request $request){

        $data = $request->input('deduction');

        $res = Deduction::create($data);

        if ($res)
            return response()->json(["message" => "success", "deduction" => $res], 200);
        else
            return response()->json(["message" => "unsuccessful", "deduction" => $res], 404);

    }

    public function storePayslip(Request $request){

        $payslip = [
            'user_id' => $request->input('user_id'),
            'pay_period_start' => $request->input('pslip.pay_period_start'),
            'pay_period_end' => $request->input('pslip.pay_period_end'),
            'total_gross' => $request->input('pslip.total_gross'),
            'total_reimbursement' => $request->input('pslip.total_reimbursement'),
            'total_deduction' => $request->input('pslip.total_deduction'),
            'total_net' => $request->input('pslip.total_net'),
            'status' => '1'
        ];

        $data = Payslip::create($payslip);

        if ($data)
            return response()->json(["message" => "success"], 201);
        else
            return response()->json(["message" => $data], 400);

    }

    public function getPayrolls(){

        $payslip = Payslip::join('users', 'payslips.user_id', '=', 'users.id')
            ->where('users.type', '2')
            ->orderBy('payslips.pay_period_end', 'DESC')
            ->get(['users.name', 'payslips.*']);

        if ($payslip)
            return response()->json(["message" => "found", "payrolls" => $payslip], 200);
        else
            return response()->json(["message" => "not found", "error" => $payslip], 404);

    }

    public function getPayslips(Request $request){

        $payslip = Payslip::where('user_id', $request->route('user_id'))
            ->where('status', '0')
            ->orderBy('pay_period_end', 'DESC')->get();

        if ($payslip)
            return response()->json(["message" => "found", "payslips" => $payslip], 200);
        else
            return response()->json(["message" => "not found", "error" => $payslip], 404);
    }

    public function getPayslip(Request $request){

        $payslip = Payslip::find($request->route('payslip_id'));

        if ($payslip)
            return response()->json(["message" => "found", "payslip" => $payslip], 200);
        else
            return response()->json(["message" => "not found", "error" => $payslip], 404);

    }

    public function togglePayslip(Request $request){

        $payslip = Payslip::find($request->input('payslip_id'));

        $payslip->status = $payslip->status === '0' ? '1' : '0';

        $payslip->save();

        if ($payslip)
            return response()->json(["message" => "success", "payslip" => $payslip], 200);
        else
            return response()->json(["message" => "not found"], 404);
    }
}
