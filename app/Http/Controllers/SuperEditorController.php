<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SuperEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperEditorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SuperEditor::with('user')->latest()->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }

        return view('pages.super-editor.index');
    }

    public function create()
    {
        return view('pages.super-editor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:user,email'],
            'password' => ['required'],
            'alamat' => 'required',
            'no_hp' => ['required', 'unique:super_editor,no_hp', 'numeric', 'digits_between:10,12'],
            'jabatan' => 'required',
            'is_active' => ['required', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'super_editor',
            'is_active' => $request->is_active
        ]);

        SuperEditor::create([
            'id_user' => $user->id_user,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan
        ]);

        return redirect()->route('super-editor')->with('success', 'Super Editor created successfully.');
    }

    public function edit($id)
    {
        $data = SuperEditor::with('user')->findOrFail($id);

        return view('pages.super-editor.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = SuperEditor::with('user')->findOrFail($id);

        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'alamat' => 'required',
            'no_hp' => ['required', 'unique:super_editor,no_hp,' . $id . ',id_super_editor', 'numeric', 'digits_between:10,12'],
            'jabatan' => 'required',
            'is_active' => ['required', 'in:0,1'],
        ];

        if ($request->email != $data->user->email) {
            $rules['email'] = ['required', 'email', 'unique:user,email,' . $id . ',id_user'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data->update([
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan
        ]);

        $user = User::findOrFail($data->id_user);
        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $data->user->password,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('super-editor')->with('success', 'Super Editor updated successfully.');
    }

    // public function destroy(Request $request)
    // {
    //     $data = SuperEditor::findOrFail($request->id);
    //     $data->delete();

    //     $user = User::findOrFail($data->id_user);
    //     $user->delete();

    //     return redirect()->route('super-editor')->with('success', 'Super Editor deleted successfully.');
    // }
}
