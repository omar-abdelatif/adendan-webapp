<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Delay;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Http\Requests\SubscriberRequest;

class SubscribersController extends Controller
{
    public function index()
    {
        $members = Subscribers::with('delays')->get();
        return view('pages.Subscriptions.subscribers', compact('members'));
    }
    public function storeSubs(SubscriberRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('id_img') || $request->hasFile('img')) {
            //! ID Image
            $filename = $request->file('id_img');
            $idImg = time() . '.' . $filename->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/subscribers/id/');
            $filename->move($destinationPath, $idImg);
            //! Personal Image
            $filename = $request->file('img');
            $pImg = time() . '.' . $filename->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/subscribers/avatar/');
            $filename->move($destinationPath, $pImg);
            $store = Subscribers::create([
                'member_id' => $request['member_id'],
                'nickname' => $request['nickname'],
                'name' => $request['name'],
                'ssn' => $request['ssn'],
                'address' => $request['address'],
                'birthdate' => $request['birthdate'],
                'mobile_no' => $request['mobile_no'],
                'job' => $request['job'],
                'job_tel' => $request['job_tel'],
                'home_tel' => $request['home_tel'],
                'job_address' => $request['job_address'],
                'job_destination' => $request['job_destination'],
                'martial_status' => $request['martial_status'],
                'membership_type' => $request['membership_type'],
                'educational_qualification' => $request['educational_qualification'],
                'qualification_date' => $request['qualification_date'],
                'img' => $pImg,
                'id_img' => $idImg,
            ]);
        } else {
            $store = Subscribers::create([
                'member_id' => $request['member_id'],
                'nickname' => $request['nickname'],
                'name' => $request['name'],
                'ssn' => $request['ssn'],
                'address' => $request['address'],
                'birthdate' => $request['birthdate'],
                'mobile_no' => $request['mobile_no'],
                'job' => $request['job'],
                'job_tel' => $request['job_tel'],
                'job_address' => $request['job_address'],
                'job_destination' => $request['job_destination'],
                'home_tel' => $request['home_tel'],
                'martial_status' => $request['martial_status'],
                'membership_type' => $request['membership_type'],
                'educational_qualification' => $request['educational_qualification'],
                'qualification_date' => $request['qualification_date'],
            ]);
        }
        if ($store) {
            $notificationSuccess = [
                "message" => "تم الإضافة بنجاح",
                "alert-type" => "success",
            ];
            return redirect()->route('subscriber.all')->with($notificationSuccess);
        } else {
            return redirect()->route('subscriber.all')->withErrors($validatedData);
        }
    }
    public function destroy($id)
    {
        $member = Subscribers::find($id);
        if ($member) {
            //! Single Image
            if ($member->id_img !== null) {
                $oldPath = public_path('assets/images/subscribers/avatar/' . $member->id_img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Delays
            $delays = Delay::where('subscribers_id', $member->id)->first();
            if ($delays != null) {
                $delays->delete();
            }
            $delete = $member->delete();
            if ($delete) {
                $notification = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->route('subscriber.all')->with($notification);
            }
        }
    }
    public function subscriberDetails($id)
    {
        $subscriber = Subscribers::find($id);
        if ($subscriber) {
            return view('pages.Subscriptions.update_subscriber', compact('subscriber'));
        }
    }
    public function update(SubscriberRequest $request)
    {
        $validatedData = $request->validated();
        $id = $request->id;
        $member = Subscribers::findOrFail($id);
        if ($member) {
            //! Remove Personal Image
            if ($request->hasFile('img') && $member->img !== null) {
                $oldPath = public_path('assets/images/subscribers/avatar/' . $member->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Remove ID Image
            if ($request->hasFile('id_img') && $member->id_img !== null) {
                $oldPath = public_path('assets/images/subscribers/id/' . $member->id_img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Upload Personal Image
            if ($request->hasFile('img')) {
                $filename = $request->file('img');
                $pImg = time() . '.' . $filename->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/subscribers/avatar/');
                $filename->move($destinationPath, $pImg);
                $member->img = $pImg;
            }
            //! Update ID Image
            if ($request->hasFile('id_img')) {
                $filename = $request->file('id_img');
                $idImg = time() . '.' . $filename->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/subscribers/id/');
                $filename->move($destinationPath, $idImg);
                $member->id_img = $idImg;
            }
            //! Update Rest Data
            $update = $member->update([
                'member_id' => $request['member_id'],
                'nickname' => $request['nickname'],
                'name' => $request['name'],
                'ssn' => $request['ssn'],
                'address' => $request['address'],
                'birthdate' => $request['birthdate'],
                'mobile_no' => $request['mobile_no'],
                'job' => $request['job'],
                'job_tel' => $request['job_tel'],
                'home_tel' => $request['home_tel'],
                'job_address' => $request['job_address'],
                'job_destination' => $request['job_destination'],
                'martial_status' => $request['martial_status'],
                'membership_type' => $request['membership_type'],
                'educational_qualification' => $request['educational_qualification'],
                'qualification_date' => $request['qualification_date'],
            ]);
            if ($update) {
                $notificationSuccess = [
                    'message' => "تم التعديل بنجاح",
                    'alert-type' => 'success',
                ];
                return redirect()->route('subscriber.details', $member->id)->with($notificationSuccess);
            }
        }
        return redirect()->route('subscriber.all')->withErrors($validatedData);
    }
}
