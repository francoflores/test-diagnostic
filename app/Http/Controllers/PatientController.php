<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registers = Patient::with('diagnostics')->take(500)->get();

        return response()->json([
            'success' => true,
            'patients' => $registers
        ], 200);
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
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'dni' => 'required|unique:patients|max:255',
            'email' => 'email|unique:patients',
            'diagnostics'  => 'sometimes|array',
            'diagnostics.*.diagnostic' => 'required',
            'diagnostics.*.diagnostic_date' => 'required|date'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $register = new Patient();
        $register->name = $request['name'];
        $register->last_name = $request['last_name'];
        $register->dni = $request['dni'];
        $register->email = $request['email'] ?? null;
        $register->phone = $request['phone'] ?? null;
        $register->address = $request['address'] ?? null;
        $register->save();

        if(isset($request['diagnostics'])) {
            $diagnostics = [];
            foreach ($request['diagnostics'] as $diagnostic) {
                array_push(
                    $diagnostics,
                    [
                        'diagnostic' => $diagnostic['diagnostic'],
                        'diagnostic_date' => $diagnostic['diagnostic_date']
                    ]
                );
            }

            if(count($diagnostic) > 0) {
                $register->diagnostics()->createMany($diagnostics);
            }

            $register->diagnostics;
        }

        return response()->json([
            'success' => true,
            'patient' => $register
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
        $register = Patient::with('diagnostics')->find($id);

        if($register != null) {
            $register->diagnostics;
            return response()->json([
                'success' => true,
                'patient' => $register
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'patient' => null
            ], 400);
        }
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
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'dni' => ['required', 'max:255', Rule::unique('patients')->ignore($id)],
            'email' => ['email', Rule::unique('patients')->ignore($id)],
            'diagnostics'  => 'sometimes|array',
            'diagnostics.*.diagnostic' => 'required',
            'diagnostics.*.diagnostic_date' => 'required|date'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $register = Patient::find($id);

        if($register != null) {
            $register->name = $request['name'];
            $register->last_name = $request['last_name'];
            $register->dni = $request['dni'];
            $register->email = $request['email'] ?? null;
            $register->phone = $request['phone'] ?? null;
            $register->address = $request['address'] ?? null;
            $register->save();
            //$register->diagnostics;

            if(isset($request['diagnostics'])) {
                $diagnostics = [];
                foreach ($request['diagnostics'] as $diagnostic) {
                    if(isset($diagnostic['id'])) {
                        $registerDiagnostic = Diagnostic::find($diagnostic['id']);
                        if($registerDiagnostic) {
                            $registerDiagnostic->diagnostic = $diagnostic['diagnostic'];
                            $registerDiagnostic->diagnostic_date = $diagnostic['diagnostic_date'];
                            $registerDiagnostic->save();
                        }
                    }
                    else {
                        array_push(
                            $diagnostics,
                            [
                                'diagnostic' => $diagnostic['diagnostic'],
                                'diagnostic_date' => $diagnostic['diagnostic_date']
                            ]
                        );
                    }

                }

                if(count($diagnostic) > 0) {
                    $register->diagnostics()->createMany($diagnostics);
                }
                $register->diagnostics;
            }

            return response()->json([
                'success' => true,
                'patient' => $register
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'patient' => null
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
        $register = Patient::find($id);

        if($register != null) {
            $register->diagnostics()->delete();
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
