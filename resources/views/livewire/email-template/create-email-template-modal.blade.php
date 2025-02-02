<div>
    <!-- Modal: Display only if isModalOpen is true -->
    @if($isModalOpen)
        <div class="modal fade show" tabindex="-1" style="display:block" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Email Template</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for creating the email template -->
                        <form wire:submit.prevent="saveTemplate">
                            <div class="mb-3">
                                <label for="template_name" class="form-label">Template Name</label>
                                <input type="text" id="template_name" class="form-control" wire:model="template_name" />
                                @error('template_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="template_content" class="form-label">Template Content</label>
                                <textarea id="template_content" class="form-control" wire:model="template_content"></textarea>
                                @error('template_content') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save Template</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
