<?php

namespace Leads\Twill\Capsules\Leads\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Leads\Twill\Capsules\Leads\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeadController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leads()
    {
        return view('admin.leads');
    }
    public function list(Request $request)
    {
        $item_per_page = $request->get('item_per_page') ? $request->get('item_per_page') : 50;

        $q = $request->get('q');
        $leads = new Lead();

        $leads = $leads->orderBy('created_at','DESC');
        if ($q) {
            $leads = $leads->where('email', 'like', '%' . $q . '%');
        }

        return $leads->paginate($item_per_page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lead = Lead::where('id', $id)->delete();

        return  $lead;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=leads-' . date("Y-m-d-h-i-s") . '.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, array('Id','Email','Created_at','FirstName','LastName','Azienda','Phone','Message','Type'));

        $leads = Lead::get();

        if (count($leads) > 0) {

            foreach ($leads as $lead) {

                $lead_row = [
                    $lead['id'],
                    ucfirst($lead['email']),
                    $lead->created_at->format('d, m, Y, h:m:s'),
                    $lead['first_name'],
                    $lead['last_name'],
                    $lead['company'],
                    chunk_split($lead['phone_nr'], 3, ' '),
                    $lead['message'],
                    $lead['role'],

                ];

                fputcsv($output, $lead_row);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function updateExported($ids)
    {
        $leads = Lead::whereIn('id', $ids)->update(['exported_at' => Carbon::now()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function bulkDelete(Request $request)
    {
        $ids = isset($request->ids) ? explode(',', $request->ids) : [];
        $leads = Lead::whereIn('id', $ids)->delete();

        return Lead::paginate();
    }

}