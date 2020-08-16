<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function showUnverified()
    {
        return User::where('role', 3)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = '';
        if($request->photo){
            //dd($request->photo);
            $file = $request->photo;
            $name = uniqid() . '_' . time(). '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/profiles';
            $res = $file->move($path, $name);
            //dd($name);
        }

        $result = User::findOrFail($id)
                        ->update([
                            'first_name'    => $request->first_name,
                            'middle_name'   => $request->middle_name,
                            'last_name'     => $request->last_name,
                            'address1'      => $request->address1,
                            'address2'      => $request->address2,
                            'barangay'      => $request->barangay,
                            'city'          => $request->city,
                            'province'      => $request->province,
                            'mobile_number' => $request->mobile_number,
                            'email'         => $request->email,
                            'profile_img'   => $name,
                            // 'password'      => Hash::make($request->password)
                        ]);


        if($result){
            return response()->json([], 200);
        }else{
            return response()->json([], 422);
        }
    }

    public function updateRole(Request $request, $id)
    {
        $result = User::findOrFail($id)
                        ->update([ 'role' => 2]);

        if($result){
            return response()->json([], 200);
        }else{
            return response()->json([], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
