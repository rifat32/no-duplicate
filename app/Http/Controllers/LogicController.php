<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogicController extends Controller
{
  public function createDuplicate(Request $req) {
      $user = Auth::user();
      $userId = $user->id;
      DB::table('duplicates')
      ->insert([
        'title' => $req->title,
        'text' => $req->text,
        'userId'=> $userId
      ]);
 return  response()->json([
     'status' => 201
 ]);
  }
  public function getDuplicate(Request $req) {
    $user = Auth::user();
    $userId = $user->id;
    $data = DB::table('duplicates')
    ->where([
        'userId' => $userId
    ])
    ->get();
return  response()->json([
   'status' => 200,
   'data' => $data
]);
}
public function deleteDuplicate(Request $req,$id) {
    $user = Auth::user();
    $userId = $user->id;
    DB::table('duplicates')
    ->where([
        'id' => $id,
        'userId' => $userId
    ])
    ->delete();
return  response()->json([
   'status' => 200
]);
}
public function updateDuplicate(Request $req,$id) {

    $user = Auth::user();
    $userId = $user->id;
    DB::table('duplicates')
    ->where([
        'id' => $id,
        'userId'=> $userId
    ])
    ->update([
      'title' => $req->title,
      'text' => $req->text
    ]);
return  response()->json([
   'status' => 200
]);
}
public function duplicateCount(Request $req) {
    $user = Auth::user();
    $userId = $user->id;
    $inputText = $req->text;
    $table = DB::table('duplicate_counts');
    $tableQuery = $table->where([
        'text' => $inputText,
        'userId' => $userId
    ]);
    if($tableQuery->exists()){
        $text = $tableQuery->first();
        $countStr = $text->count;
        $count =  (int)$countStr;
        $tableQuery->update([
        'count' => $count + 1
        ]);
        return response()->json([
       'status' => 200,
       'previousCount' =>$count,
       'updatedCount' => $count + 1,
       'text' => $inputText
            ]);
    }
    else {
        $table->insert([
            'text' => $inputText,
            'userId' => $userId,
            'count' => 1
        ]);
        return response()->json([
            'status' => 201,
            'text' => $inputText
                 ]);

    }
}


}
