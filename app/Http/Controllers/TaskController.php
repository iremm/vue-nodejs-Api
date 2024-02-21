<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
class TaskController extends Controller
{
    //list return mainpage
    public function tasklist()
    {
        $users = User::all();
        $files = File::all();

        $data = [
            'users' => $users,
            'files' => $files
        ];

        return $data;
    }

    //delete crud
    public function delete($userId){
        $user = User::find($userId);
        if($user){
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    
    }
    //update crud
    public function update(Request $request, $userId){
        $user = User::find($request->input('id'));
        if($user){
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->save();
        }
        else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    //add crud
    public function add(Request $request){
        $user = new User();
        if($user){
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->save();
        }
        else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    //upload and save db csv
    //path: storage/uploads
    public function upload(Request $request)
    {
            $files = is_array($request->file('file')) ? $request->file('file') : [$request->file('file')];
            $filePaths = []; 
        
            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $filePaths[] = '/storage/' . $filePath; 

                $file = new File();
                $file->files_name = $fileName;
                $file->files_path = $filePath;
                $file->save();
            }
        
            return response()->json(['file_paths' => $filePaths]);
    
    }

    
    
    
}
