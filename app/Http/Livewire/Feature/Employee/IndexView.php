<?php

namespace App\Http\Livewire\Feature\Employee;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class IndexView extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search_value = '';

    /**
     * Reset the page when search value is updated
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $user = Auth::user();
        $search_value = $this->search_value;

        $employees = Employee::with('warehouse')->whereHas('warehouse', function ($wh_query) use ($user) {
            $wh_query->where('user_id', $user->id);
        })->with('user')->whereHas('user', function ($user_query) use ($search_value) {
            $user_query->where('email', 'like', '%'.$search_value.'%');
        })->paginate(10);

        return view('livewire.feature.employee.index-view', ['employees' => $employees])
            ->extends('layouts.dashboard')
            ->section('main');
    }

    /**
     * Redirect to specified route name
     *
     * @param string $route_name    The route name declared on routing file
     * @param $param                The data sent to specified $route_name, default is null
     *
     * @return RedirectResponse
     */
    public function redirect_page(string $route_name, $param = null)
    {
        if (isset($param)) {
            return redirect()->route($route_name, $param);
        } else {
            return redirect()->route($route_name);
        }
    }
}
