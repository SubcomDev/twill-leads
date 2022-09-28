<?php
namespace Leads\Twill\Capsules\Leads\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelLocalization;
use Leads\Twill\Capsules\Leads\Models\Lead;
use Leads\Twill\Capsules\Leads\Repositories\LeadRepository;

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
    public function store(Request $request, Lead $lead)
    {
        $role = $lead->role;
        $role = 'newslatter_type';
        $locale = $request->get('locale');
        LaravelLocalization::setLocale($locale);

        /*
         * validate request
         */
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $client = new \Leads\Twill\Capsules\Leads\Models\Lead;
        $client->email = $request->get('email');
        $client->role = $role;
        $exist = Lead::where('email', $client->email)->where('role', $role)->count();
        if ($exist == 0) {
            $client->save();
            return response()->json([
                'message' => __('success.registered'),
            ], 200);
        } else {
            return response()->json([
                'message' => __('success.error'),
            ], 422);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updated(Request $request, $id)
    {

        /*
         * validate request
         */
        // $request->validate([
        //     'email' => ['email','unique:leads'],
        // ]);

        /**
         * create client.
         */
        Lead::where('id', $id)->update(['email' => $request->get('email')]);

        return response()->json([
            'message' => __('success.updated'),
        ], 200);
    }

    public static function delete(Request $request, $id)
    {

        /**
         * delete client.
         */
        Lead::where('id', $id)->forceDelete(['email' => $request->get('email')]);

        return response()->json([
            'message' => __('success.deleted'),
        ], 200);
    }
}