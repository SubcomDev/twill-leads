<?php

namespace Leads\Twill\Capsules\Leads\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Leads\Twill\Capsules\Leads\Repositories\LeadRepository;
use Leads\Twill\Capsules\Leads\Models\Lead;
use Illuminate\Support\Facades\Mail;
use Leads\Twill\Capsules\Leads\Mail\ContactMail;

class ContactController extends Controller
{

    public function __construct(LeadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('admin.blocks.leadcontact');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required|email',
        //     'phone_nr' => 'required|digits:10|numeric',
        //     'company' => 'required',
        //     'message' => 'required'
        // ]);

        $adminEmail = "donaldodemiri@gmail.com";

        $lead = \Leads\Twill\Capsules\Leads\Models\Lead::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'subject' => $request['subject'],
            'phone_nr' => $request['phone_nr'],
            'company' => $request['company'],
            'message' => $request['message'],
        ]);

        $lead->save();

        Mail::to("donaldodemiri@gmail.com")->send(new ContactMail($lead));

        return back()->with(['success' => 'Thank you for contact us. we will contact you shortly.']);
    }
}