<?php

namespace App\Http\Controllers\Api\Feature;

use App\Http\Controllers\Controller;
use App\Models\WarehouseStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
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

        $storages = WarehouseStorage::with('aisle.warehouse')->with('row')->whereHas('aisle.warehouse', function ($query) use ($user) {
            $query->whereIn('id', $user->employees->pluck('warehouse_id')->toArray());
        })->get();

        return $this->response($storages);
    }
}
