<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     
    public function index()
    {
        $users = User::with('roles')->get(); 

        return view('users.index', compact('users'));
    }
 
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
 
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    public function assignRole(Request $request, $id)
    {
        
        $request->validate([
            'role' => 'required|string|in:admin,mod,customer',
        ]);
        $user = User::findOrFail($id);
        $role = $request->input('role');
        $user->roles()->detach();
        $user->assignRole($role);
        $user->permissions()->detach();
        if ($role == 'admin') {
        
            $user->givePermissionTo(Permission::all());
        } elseif ($role == 'mod') {
           
            $user->givePermissionTo([
                'view products',
                'create products',
                'edit products',
                'statistic products'
            ]);
        } elseif ($role == 'customer') {
            $user->givePermissionTo(['cart']);
        }
     
        return redirect()->route('user.index')->with('success', 'Role assigned successfully.');
    }
    

}
