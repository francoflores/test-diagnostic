<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosticController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'diagnostic' => 'required',
            'diagnostic_date' => 'required|date',
            'patient_id' => 'required|integer|exists:patients,id'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $register = new Diagnostic();
        $register->patient_id = $request['patient_id'];
        $register->diagnostic = $request['diagnostic'];
        $register->diagnostic_date = $request['diagnostic_date'];

        $register->save();

        $register->patient;

        return response()->json([
            'success' => true,
            'diagnostic' => $register
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'diagnostic' => 'required',
            'diagnostic_date' => 'required|date',
            'patient_id' => 'required|integer|exists:patients,id'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $register = Diagnostic::find($id);

        if($register != null) {
            $register->patient_id = $request['patient_id'];
            $register->diagnostic = $request['diagnostic'];
            $register->diagnostic_date = $request['diagnostic_date'];
            $register->save();

            return response()->json([
                'success' => true,
                'diagnostic' => $register
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'diagnostic' => null
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $register = Diagnostic::find($id);

        if($register != null) {
            $register->delete();

            return response()->json([
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
            ], 400);
        }
    }
}
