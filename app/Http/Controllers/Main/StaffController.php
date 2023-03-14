<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index');
    }

    public function render() 
    {
        $staff = Staff::all();
        $view = [
            'data' => view('staff.render')->with([
                'staff' => $staff
            ])->render()
        ];

        return response()->json($view);
    }

    public function create() 
    {
        $view = [
            'data' => view('staff.create')->render()
        ];

        return response()->json($view);
    }

    public function store(StaffRequest $request)
    {
        try {
            $role = Role::where('name', 'Staff')->first();

            $checkUser = User::where('username', $request->user)->first();

            if (!$checkUser) {
                $userData = [
                    'username' => $request->user,
                    'password' => bcrypt($request->password),
                    'role_id' => $role->id
                ];
    
                if($request->hasFile('image')) {
                    //get filename with extension
                    $filenamewithextension = $request->file('image')->getClientOriginalName();
    
                    //get file extension
                    $extension = $request->file('image')->getClientOriginalExtension();
    
                    //filename to store
                    $filenametostore = $request->name . '-' . time() . '.' . $extension;
                    $save_path = 'assets/uploads/media/users';
    
                    if (!file_exists($save_path)) {
                        mkdir($save_path, 666, true);
                    }
                    $img = Image::make($request->file('image')->getRealPath());
                    $img->resize(512, 512);
                    $img->save($save_path . '/' . $filenametostore);
    
                    $userData['image'] = $save_path . '/' . $filenametostore;
                }
    
                $user = User::create($userData);
    
                $data = [
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ];
    
                Staff::create($data);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil tersimpan',
                    'title' => 'Berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Username sudah digunakan, mohon gunakan username lainnya',
                    'title' => 'Info'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function edit($id) 
    {
        $staff = Staff::with('user')->where('id', $id)->first();
        
        $view = [
            'data' => view('staff.edit', compact('staff'))->render()
        ];

        return response()->json($view);
    }

    public function update(StaffRequest $request)
    {
        try {
            $user = User::find($request->user_id);
            $allUser = User::pluck('username')->toArray();
            $remove = array_search($user->username, $allUser);
            // dd($remove);
            // $remove != false ? array_splice($allUser, $remove) : '';

            if($remove !== false) {
                array_splice($allUser, $remove, 1);
            }
            // dd($remove);

            // dd($allUser);

            if(!in_array($request->user, $allUser)) {
                $userData = [
                    'username' => $request->user,
                    // 'password' => Hash::make($request->new_password)
                    // 'password' => bcrypt($request->password),
                ];

                if($request->new_password != '') {
                    $userData['password'] = Hash::make($request->new_password);
                }
    
                // Password
                // if($request->has('current_password') && $request->current_password != '') {
                    // if($request->new_password == '' || $request->confirmation_password == '') {
                    //     return response()->json([
                    //         'status' => 'error',
                    //         'message' => 'Password harus diisi',
                    //         'title' => 'Gagal',
                    //     ]);
                    // } else {
                    //     if(!Hash::check($request->current_password, $user->password)) {
                    //         return response()->json([
                    //             'status' => 'error',
                    //             'message' => 'Password lama tidak sesuai',
                    //             'title' => 'Gagal'
                    //         ]);
                    //     } else {
                    //         $userData['password'] = Hash::make($request->new_password);
                    //     }
                    // }
                // }
    
                if($request->hasFile('image')) {
                    unlink($user->image);
                    //get filename with extension
                    $filenamewithextension = $request->file('image')->getClientOriginalName();
    
                    //get file extension
                    $extension = $request->file('image')->getClientOriginalExtension();
    
                    //filename to store
                    $filenametostore = $request->name . '-' . time() . '.' . $extension;
                    $save_path = 'assets/uploads/media/users';
    
                    if (!file_exists($save_path)) {
                        mkdir($save_path, 666, true);
                    }
                    $img = Image::make($request->file('image')->getRealPath());
                    $img->resize(512, 512);
                    $img->save($save_path . '/' . $filenametostore);
    
                    $userData['image'] = $save_path . '/' . $filenametostore;
                }
    
                $user->update($userData);
    
                $data = [
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ];
    
                Staff::where('user_id', $request->user_id)->update($data);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil tersimpan',
                    'title' => 'Berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Username sudah digunakan, mohon gunakan username lainnya',
                    'title' => 'Info'
                ]);
            }

            

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $staff = Staff::find($id);
            unlink($staff->user->image);
            $staff->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }
}
