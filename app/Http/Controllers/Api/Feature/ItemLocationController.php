<?php

namespace App\Http\Controllers\Api\Feature;

use App\Http\Controllers\Controller;
use App\Models\ItemLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemLocationController extends Controller
{
    /**
     * @param $data
     * @param int $code
     * @param null $message
     * @param null $error
     * @return mixed
     */
    public function response($data, int $code = 200, $message = null, $error = null)
    {
        $body = [
            'code' => $code,
            'message' => $message == null ? ($code == 200 ? 'Success' : 'Failed') : $message,
            'error' => $error,
            'data' => $data
        ];

        return response()->json($body, $code);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => ['required'],
            'storage_id' => ['required'],
            'stock' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $this->response(null, 400, 'Validation failed', $validator->errors());
        }

        $location = new ItemLocation();
        $location->item_id = $request->item_id;
        $location->warehouse_storage_id = $request->storage_id;
        $location->stock = $request->stock;
        $location->save();

        return $this->response($location, 200, 'Location store success');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => ['required'],
            'storage_id' => ['required'],
            'stock' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $this->response(null, 400, 'Validation failed', $validator->errors());
        }

        try {
            $location = ItemLocation::findOrFail($request->location_id);
            $location->item_id = $request->item_id;
            $location->warehouse_storage_id = $request->storage_id;
            $location->stock = $request->stock;
            $location->save();
        } catch (ModelNotFoundException $e) {
            return $this->response(null, 404, $e->getMessage(), $e);
        }

        return $this->response($location, 200, 'Location store success');
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function destroy(Request $request)
    {
        try {
            $location = ItemLocation::findOrFail($request->location_id);
            $location->delete();
        } catch (ModelNotFoundException $e) {
            return $this->response(null, 404, $e->getMessage(), $e);
        }
    }
}
