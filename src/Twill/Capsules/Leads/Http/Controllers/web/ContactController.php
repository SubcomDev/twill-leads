<?php

namespace Leads\Twill\Capsules\Leads\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Leads\Twill\Capsules\Leads\Repositories\LeadRepository;
use Leads\Twill\Capsules\Leads\Models\Lead;
use Illuminate\Support\Facades\Mail;
use Leads\Twill\Capsules\Leads\Mail\ContactMail;
use A17\Twill\Services\Blocks\Block;
use Carbon\Carbon;

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
    public function store(Request $request, Lead $lead)
    {
        $email = $request->get('admin_email');

        $role = $lead->role;
        $role = 'contact_type';

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['email','unique:leads','required'],
            'message' => 'required'
        ]);

        $lead = \Leads\Twill\Capsules\Leads\Models\Lead::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone_nr' => $request['phone_nr'],
            'company' => $request['company'],
            'message' => $request['message'],
            'role' => $role,

        ]);



        $lead->save();
        Mail::to($email)->send(new \Leads\Twill\Capsules\Leads\Mail\ContactMail($lead));



        return response()->json([
            'message' => __('success.formSuccess')
        ], 200);
    }
}