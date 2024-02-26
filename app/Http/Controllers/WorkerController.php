<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Requests\WorkersRequest;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::all();
        return view('pages.workers', compact('workers'));
    }
    public function storeWorker(WorkersRequest $request)
    {
        $validation = $request->validated();
        $store = Worker::create($validation);
        if ($store) {
            $notificationSuccess = [
                "message" => "تم الإضافة بنجاح",
                "alert-type" => "success"
            ];
            return redirect()->route('workers.all')->with($notificationSuccess);
        } else {
            return redirect()->route('workers.all')->withErrors($validation);
        }
    }
    public function delete($id)
    {
        $worker = Worker::find($id);
        if ($worker) {
            $delete = $worker->delete();
            if ($delete) {
                $notificationSuccess = [
                    "message" => "تم الحذف بنجاح!",
                    "alert-type" => "success"
                ];
                return redirect()->route('workers.all')->with($notificationSuccess);
            }
        }
        return redirect()->route('workers.all')->withErrors('حدث خطأ ما');
    }
    public function update(WorkersRequest $request)
    {
        $validated = $request->validated();
        $workerId = $request->id;
        $worker = Worker::find($workerId);
        if ($workerId) {
            $update = $worker->update([
                'name' =>  $request->name,
                'location' => $request->location,
                'phone_number' => $request->phone_number,
                'craft' => $request->craft,
                'other_craft' => $request->other_craft
            ]);
            if ($update) {
                $notificationSuccess = [
                    "message" => "تم التعديل بنجاح!",
                    "alert-type" => "success"
                ];
                return redirect()->route('workers.all')->with($notificationSuccess);
            }
        }
        return redirect()->route('workers.all')->withErrors($validated);
    }
}
