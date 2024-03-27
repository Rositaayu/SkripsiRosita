<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Editor;
use App\Models\Wartawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WartawanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Wartawan::with('user', 'editor')->latest()->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }

        return view('pages.wartawan.index');
    }

    public function create()
    {
        $editor = Editor::with('user')->get();

        return view('pages.wartawan.create', compact('editor'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:super_editor,email'],
            'password' => ['required'],
            'id_editor' => ['required', 'exists:editor,id_editor'],
            'is_active' => ['required', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'wartawan',
            'is_active' => $request->is_active
        ]);

        Wartawan::create([
            'id_user' => $user->id_user,
            'id_editor' => $request->id_editor,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('wartawan')->with('success', 'Wartawan created successfully.');
    }

    public function edit($id)
    {
        $data = Wartawan::with('user', 'editor')->findOrFail($id);
        $editor = Editor::with('user')->get();

        return view('pages.wartawan.edit', compact('data', 'editor'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:super_editor,email,' . $id . ',id_super_editor'],
            'id_editor' => ['required', 'exists:editor,id_editor'],
            'is_active' => ['required', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Wartawan::findOrFail($id);
        $data->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $data->password,
            'id_editor' => $request->id_editor,
        ]);

        $user = User::findOrFail($data->id_user);
        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('wartawan')->with('success', 'Wartawan updated successfully.');
    }
}