<?php

namespace App\Http\Controllers\Api\Feature;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemLocation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
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
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();

        $items = Item::with('locations.storage.aisle.warehouse')
            ->whereHas('locations.storage.aisle.warehouse', function ($query) use ($user) {
                $query->whereIn('id', $user->employees->pluck('warehouse_id')->toArray());
            })
            ->get();

        return $this->response($items);
    }

    public function show(Request $request)
    {
        try {
            $item = Item::with('locations.storage.aisle')->with('locations.storage.row')->findOrFail($request->item_id);

            return $this->response($item);
        } catch (ModelNotFoundException $e) {
            return $this->response(null, 404, $e->getMessage(), $e);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:5', 'max:75'],
            'sku' => ['required', 'min:2', 'max:25'],
            'price' => ['required', 'numeric'],
            'storage_id' => ['required'],
            'stock' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->response(null, 400, 'Validation failed', $validator->errors());
        }

        $item = new Item();

        DB::transaction(function () use ($request, $item) {
            $item->name = $request->name;
            $item->sku = $request->sku;
            $item->price = $request->price;
            $item->save();

            $location = new ItemLocation();
            $location->item_id = $item->id;
            $location->warehouse_storage_id = $request->storage_id;
            $location->stock = $request->stock;
            $location->save();
        });

        return $this->response($item, 200, 'Item store success');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:5', 'max:75'],
            'sku' => ['required', 'min:2', 'max:25'],
            'price' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $this->response(null, 400, 'Validation failed', $validator->errors());
        }

        try {
            $item = Item::findOrFail($request->item_id);
            $item->name = $request->name;
            $item->sku = $request->sku;
            $item->price = $request->price;
            $item->save();

            return $this->response($item, 200, 'Item update success');
        } catch (ModelNotFoundException $e) {
            return $this->response(null, 404, $e->getMessage(), $e);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function destroy(Request $request)
    {
        try {
            $item = Item::findOrFail($request->item_id);
            $item->delete();

            return $this->response($item, 200, 'Item destroy success');
        } catch (ModelNotFoundException $e) {
            return $this->response(null, 404, $e->getMessage(), $e);
        }
    }
}
