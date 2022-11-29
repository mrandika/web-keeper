<?php

namespace App\Http\Livewire\Feature\Employee;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class DestroyView extends Component
{
    public $employee_id;

    /**
     * Mount the Livewire component
     * Mounting the component will ONLY set the data once, even the view is refreshed/rerendered.
     *
     * @param $employee_id
     * @return void
     */
    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    /**
     * Render Livewire component
     *
     * @return View
     */
    public function render()
    {
        $employee = Employee::findOrFail($this->employee_id);

        return view('livewire.feature.employee.destroy-view', ['employee' => $employee])
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

    /**
     * Set flash message for this current session
     *
     * @param string $key       Session key
     * @param string $value     Session value
     * @return void
     */
    public function flash_message(string $key, string $value)
    {
        session()->flash($key, $value);
    }

    /**
     * Destroy the $employee_id from database
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $employee = Employee::findOrFail($this->employee_id);
        $employee->delete();

        $this->flash_message('info', "Pegawai dengan nama ".$employee->user->data->fullname()." pada warehouse ".$employee->warehouse->name." berhasil dihapus.");
        $this->redirect_page('employee.index');
    }
}
