<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CmsManagement;
use App\Models\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CmsManagementController extends Controller
{
    public function edit()
    {

        $cmsManagement = CmsManagement::findOrFail(1);
        return view('backend.cms.edit', compact('cmsManagement'));
    }

    public function update(Request $request)
    {
        $cms = CmsManagement::findOrFail(1);
        $cms->phone = $request->phone;
        $cms->email = $request->email;
        $cms->address = $request->address;
        $cms->privacy_policy = $request->privacy_policy;
        $cms->user_privacy_policy = $request->user_privacy_policy;
        $cms->terms = $request->terms;
        $cms->astrologer_live_charges_per_min = $request->astrologer_live_charges_per_min;
        $cms->boost_charges = $request->boost_charges;
        $cms->save();
        return back()->with('success', 'CMS save successfully!');
    }


    public function userQuery()
    {
        $contacts = Contact::orderBy('id', 'desc')->get();
        return view('backend.contact.index', compact('contacts'));
    }



    public function userQueryDelete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return back()->with('success', 'Record Delete Successfully!');
        return view('backend.contact.index', compact('contacts'));
    }
}
