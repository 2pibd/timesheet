<span>
    <!-- Add New Button -->
    <button
        wire:click="openModal"
        class="btn btn-sm bg-blue-600 btn-secondary rounded hover:bg-blue-700">
        Add New Permission
    </button>

    <!-- Success/Error Message Popup Modal -->
    @if (session()->has('message') || session()->has('error'))
        <div class="modal fade show" tabindex="-1" id="messageModal" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">
                            @if(session()->has('message'))
                                Success
                            @elseif(session()->has('error'))
                                Error
                            @endif
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        @if(session()->has('message'))
                            {{ session('message') }}
                        @elseif(session()->has('error'))
                            {{ session('error') }}
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Ensure modal is displayed and handled correctly with Bootstrap
                var myModal = new bootstrap.Modal(document.getElementById('messageModal'), {
                    keyboard: false
                });
                myModal.show();
            });
        </script>
    @endif

<!-- Modal for Add Permission -->
    <div class="modal fade @if($isOpen) show @endif" tabindex="-1" style="display: @if($isOpen) block @else none @endif;" aria-labelledby="permissionModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModal">Add Permission</h5>
                    <button
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                        wire:click="closeModal">
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="permission" class="form-label">Permission Name</label>
                        <input
                            type="text"
                            id="permission"
                            wire:model="permission" value=""
                            class="form-control @error('permission') is-invalid @enderror">
                        @error('permission')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        wire:click="closeModal">
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        wire:click="savePermission">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Backdrop for Modal -->
    @if($isOpen)
        <div class="modal-backdrop fade show"></div>
    @endif
</span>
