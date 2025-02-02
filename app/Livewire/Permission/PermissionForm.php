<?php

namespace App\Livewire\Permission;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Console\Command;
class PermissionForm extends Component
{
    public $permission; // Field for the permission name
    public $isOpen = false; // To toggle modal visibility

    protected $listeners = ['triggerAddPermissionModal'];

    protected $rules = [
        'permission' => 'required|string|max:255|unique:permissions,name', // Adjust validation as needed
    ];

    public function triggerAddPermissionModal()
    {
        \Log::info('triggerAddPermissionModal called');
        $this->isOpen = true;
    }


    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset(['permission', 'isOpen']); // Reset form fields and modal state
    }

    public function savePermission()
    {
        $this->validate(); // Automatically uses the `$rules` property

        // Save the permission
      $result =  Artisan::call('permission:module', [
            'module' => $this->permission, // Pass the permission as an argument
        ]);

       // Permission::create(['name' => $this->permission]);

        // Capture the output of the command
        $output = Artisan::output(); // Get the command output

        // Show the result message
     //   session()->flash('message', $output);
        // Check if the Artisan command was successful and set an appropriate message
        if ($result === 0) {
            // Success message
            session()->flash('message', 'Permission created successfully!');
        } else {
            // Error message
            session()->flash('error', 'An error occurred while creating the permission.');
        }
        // Reset the form and close the modal
        $this->reset(['permission', 'isOpen']);

        // Emit an event to refresh the permission table (if applicable)
       // $this->emitTo('refreshPermissionTable');
    }


    public function render()
    {
        return view('livewire.permission.permission-form');
    }
}
