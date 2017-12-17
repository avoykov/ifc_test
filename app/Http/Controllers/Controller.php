<?php

namespace App\Http\Controllers;

use App\ApiRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handler for getting external requests to API.
     *
     * @param Request $request
     * @return string
     */
    public function handler(Request $request)
    {
        try {
            // Whole params should be numeric.
            $request->validate([
                '*' => 'required|numeric',
            ]);

            $data = $request->all();
            DB::transaction(function () use ($data) {
                $input = [
                    'token' => str_random(40),
                    'data' => $data,
                    'count' => ApiRequest::all()->count(),
                ];


                ApiRequest::create(['data' => $input]);
            });
        } catch (\Exception $ex) {
            return Response::json(['status' => false, 'message' => 'Wrong params.']);
        } catch (\Throwable $e) {
            return Response::json(['status' => false, 'message' => 'Error during writing to db.']);
        }

        return Response::json(['status' => true, 'message' => 'Successfully saved.']);
    }
}
