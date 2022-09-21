<?php

namespace Leads\Twill\Capsules\Leads\Http\Controllers;

// use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Http\Controllers\Controller;
use Leads\Twill\Capsules\Leads\Models\Lead;

class LeadController extends Controller
{
    protected $moduleName = 'leads';

    protected $indexOptions = [
        'permalink' => false,
    ];

    //   /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {
        return view('admin.leads.leads');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param \App\Models\Lead $lead
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Lead $lead)
    {
        //
    }
}
