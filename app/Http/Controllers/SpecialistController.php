<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;
use Validator;

class SpecialistController extends Controller
{
  public function index()
  {
      $specialists=Specialist::get();
      return response()->json([
        'specialists' => $specialists
      ]);
  }

  public function store(Request $request)
  {
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255'
      ]);
      if($validator->fails()){
          return response()->json(['message' => $validator->errors()], 200);
      }

      $specialist = new Specialist();
      $specialist->name = $request->name;
      $specialist->description = $request->description;
      $specialist->timing = $request->timing;
      $specialist->save();

      $notification= trans('Created Successfully');
      return response()->json(['message' => $notification], 200);

  }

  public function update(Request $request,$id)
  {
      $specialist = Specialist::find($id);
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255'
      ]);
      if($validator->fails()){
          return response()->json(['message' => $validator->errors()], 200);
      }
      $specialist->name = $request->name;
      $specialist->description = $request->description;
      $specialist->timing = $request->timing;
      $specialist->save();

      $notification= trans('Updated Successfully');
      return response()->json(['message' => $notification], 200);
  }

  public function destroy($id)
  {
      $specialist = Specialist::find($id);
      $specialist->delete();

      $notification=  trans('Delete Successfully');
      return response()->json(['message' => $notification], 200);
  }
}
