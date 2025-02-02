<?php

namespace App\Livewire\EmailTemplate;

use App\Models\email_template;
use Livewire\Component;

class CreateEmailTemplate extends Component
{
    public $isModalOpen = false;

    // This listener listens for the event emitted from the parent page
    protected $listeners = ['openCreateTemplateModal' => 'openModal'];

    public $template_name;
    public $template_content;

    public function mount()
    {
        $this->isModalOpen = false; // Force modal open
    }


    public function openModal()
    {
        // Open the modal when the event is emitted
        $this->isModalOpen = true;
        logger("Modal opened!");
    }

    public function closeModal()
    {
        // Close the modal when the user clicks to close
        $this->isModalOpen = false;
    }

    public function render()
    {

        return view('livewire.email-template.create-email-template');
    }

    public function saveTemplate()
    {
        // Validation
        $this->validate([
            'template_name' => 'required|string|max:255',
            'template_content' => 'required|string',
        ]);

        // Save the template
        email_template::create([
            'name' => $this->template_name,
            'content' => $this->template_content,
        ]);

        // Close the modal after saving
        $this->isModalOpen = false;

        // Optionally, emit a success message or event
        session()->flash('message', 'Email Template created successfully!');
    }
}
