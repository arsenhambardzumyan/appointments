<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Validator;

class AppointmentController extends Controller
{
  public function index()
  {
      $user = Auth::user();
      $appointments=Appointment::where('client_id', $user->id)->paginate(20);
      return response()->json([
        'appointments' => $appointments
      ]);
  }

  public function store(Request $request)
  {
      $user = Auth::user();
      return Auth::user();
      $validator = Validator::make($request->all(), [
        'specialist_id' => 'required',
        'date' => 'required',
        'time' => 'required',

      ]);
      if($validator->fails()){
          return response()->json(['message' => $validator->errors()], 200);
      }
      $appointment = new Appointment();
      $appointment->client_id = $user->id;
      $appointment->specialist_id = $request->specialist_id;
      $appointment->date = $request->date;
      $appointment->time = $request->time;
      $appointment->save();

      $notification= trans('Created Successfully');
      return response()->json(['message' => $notification], 200);

  }

  public function update(Request $request,$id)
  {
      $appointment = Appointment::find($id);
      $validator = Validator::make($request->all(), [
        'specialist_id' => 'required',
        'date' => 'required',
        'time' => 'required',

      ]);
      if($validator->fails()){
          return response()->json(['message' => $validator->errors()], 200);
      }
      $appointment->client_id = $user->id;
      $appointment->specialist_id = $request->specialist_id;
      $appointment->date = $request->date;
      $appointment->time = $request->time;
      $appointment->save();

      $notification= trans('Updated Successfully');
      return response()->json(['message' => $notification], 200);
  }

  public function destroy($id)
  {
      $appointment = Appointment::find($id);
      $appointment->delete();
      $notification=  trans('Delete Successfully');
      return response()->json(['message' => $notification], 200);
  }
  public function appointmentsByClientId($id)
  {
    $appointments=Appointment::where('client_id', $id)->get();
    return response()->json([
      'appointments' => $appointments
    ]);
  }
}
