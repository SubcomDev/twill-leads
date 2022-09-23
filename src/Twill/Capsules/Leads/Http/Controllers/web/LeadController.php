<?php

namespace Leads\Twill\Capsules\Leads\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Leads\Twill\Capsules\Leads\Repositories\LeadRepository;
use Illuminate\Http\Request;
use Leads\Twill\Capsules\Leads\Models\Lead;
use LaravelLocalization;
use Illuminate\Support\Facades\Lang;
class LeadController extends Controller
{
    public function __construct(LeadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $locale = $request->get('locale');

        LaravelLocalization::setLocale($locale);

         /*
         * validate request
         */
        $request->validate([
            'email' => ['required', 'unique:leads', 'email'],
        ]);

        $client = \Leads\Twill\Capsules\Leads\Models\Lead::create([
            'email' => $request->get('email'),
        ]);

         return response()->json([
            'message' => __('success.registered')
        ], 200);
    }

     /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updated(Request $request,$id)
    {

         /*
         * validate request
         */
        $request->validate([
            'email' => ['email','unique:leads'],
        ]);

        /**
         * create client.
         */
        Lead::where('id',$id)->update(['email' => $request->get('email'),]);

        return response()->json([
            'message' => __('success.updated')
        ], 200);
    }

    public static function delete(Request $request,$id)
    {

        /**
         * delete client.
         */
        Lead::where('id',$id)->delete(['email' => $request->get('email'),]);

        return response()->json([
            'message' => __('success.deleted')
        ], 200);
    }
}