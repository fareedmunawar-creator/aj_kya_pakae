/**
 * Modal stability fix for Aj Kya Pakae
 * This script ensures modals open and close properly
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all modals with proper configuration
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        // Create a new Bootstrap modal instance with proper configuration
        const modalInstance = new bootstrap.Modal(modal, {
            backdrop: 'static',
            keyboard: true,
            focus: true
        });
        
        // Fix for modal not closing properly
        const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                modalInstance.hide();
            });
        });
        
        // Fix for backdrop issues
        modal.addEventListener('hidden.bs.modal', function() {
            document.body.classList.remove('modal-open');
            const modalBackdrops = document.querySelectorAll('.modal-backdrop');
            modalBackdrops.forEach(backdrop => {
                backdrop.remove();
            });
        });
    });
    
    // Fix for multiple backdrops issue
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            // Remove any lingering backdrops before opening a new modal
            const existingBackdrops = document.querySelectorAll('.modal-backdrop');
            existingBackdrops.forEach(backdrop => {
                backdrop.remove();
            });
            document.body.classList.remove('modal-open');
        });
    });
});