<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

use Validator;
use Illuminate\Support\Facades\Hash;
/**

* @OA\Post(
*     path="/api/login",
*     summary="Authenticate",
*     @OA\Parameter(
*         name="phone",
*         in="query",
*         description="Client's phone",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Parameter(
*         name="password",
*         in="query",
*         description="Client's password",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Response(response="200", description="Login successful"),
*     @OA\Response(response="401", description="Invalid credentials")
* )

* @OA\Post(
*     path="/api/clients",
*     summary="Client Create",
*     @OA\Parameter(
*         name="name",
*         in="query",
*         description="Client's name",
*         required=false,
*         @OA\Schema(type="string")
*     ),
*     @OA\Parameter(
*         name="phone",
*         in="query",
*         description="Client's phone",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Parameter(
*         name="password",
*         in="query",
*         description="Client's password",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Response(response="200", description="Created successfuly"),
* )


* @OA\Put(
*     path="/api/clients",
*     summary="Client update",
*     @OA\Parameter(
*         name="name",
*         in="query",
*         description="Client's name",
*         required=false,
*         @OA\Schema(type="string")
*     ),
*     @OA\Parameter(
*         name="phone",
*         in="query",
*         description="Client's phone",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Parameter(
*         name="password",
*         in="query",
*         description="Client's password",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Response(response="200", description="Updated successfuly"),
* )

* @OA\Delete(
*     path="/api/clients",
*     summary="Client update",
*     @OA\Parameter(
*         name="id",
*         in="query",
*         description="Client's id",
*         required=true,
*         @OA\Schema(type="string")
*     ),
*     @OA\Response(response="200", description="Updated successfuly"),
* )
*/
class ClientController extends Controller
{
    public function index()
    {
        $clients=Client::get();
        return response()->json([
          'clients' => $clients
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 404);
        }

        $client = new Client();
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->password =  bcrypt($request->password);

        $client->save();

        $notification= trans('Created Successfully');
        return response()->json(['message' => $notification], 200);

    }

    public function update(Request $request,$id)
    {
        $client = Client::find($id);
        $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'password' => 'required'
        ]);
        if($validator->fails()){
          return response()->json(['message' => $validator->errors()], 404);
        }
        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->password =  bcrypt($request->password);

        $client->save();

        $notification= trans('Updated Successfully');
        return response()->json(['message' => $notification], 200);
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        $notification=  trans('Delete Successfully');
        return response()->json(['message' => $notification], 200);
    }

    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){

          return response()->json(['message' => $validator->errors()], 404);

        }

        $input = $request->all();

        $input['password'] =  bcrypt($input['password']);

        $client = Client::create($input);

        $notification= trans('Registered Successfully');
        return response()->json(['message' => $notification], 200);
    }
    public function login(Request $request)

    {

        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])){

            $client = Auth::user();

            $notification= trans('Logged in Successfully');
            return response()->json(['message' => $notification], 200);
        }else{
          $notification= trans('Unauthorised');
          return response()->json(['message' => $notification], 401);
        }

    }

}
