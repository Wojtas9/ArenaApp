<div id="edit-event-modal" class="fixed inset-0 hidden overflow-y-auto h-full w-full z-50">
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" id="edit-modal-backdrop"></div>
    <div class="relative mx-auto p-0 w-full max-w-md shadow-xl rounded-2xl bg-white z-[60] overflow-hidden transform transition-all animate-fade-in" style="margin-top: 10vh;">
        <div class="p-4 text-white" id="edit-modal-header" style="background-color: #8C508F;">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Edit Event</h3>
                <button id="close-edit-modal" class="text-white hover:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-5">
            <form id="edit-event-form" class="space-y-5">
                <input type="hidden" id="edit-event-id" name="id">
                <div>
                    <label for="edit-event-title" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Title</label>
                    <input type="text" id="edit-event-title" name="title" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit-event-start" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Start Time</label>
                        <input type="datetime-local" id="edit-event-start" name="start_time" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                    </div>
                    <div>
                        <label for="edit-event-end" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">End Time</label>
                        <input type="datetime-local" id="edit-event-end" name="end_time" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                    </div>
                </div>
                
                <div>
                    <label for="edit-event-category" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Category</label>
                    <select id="edit-event-category" name="category_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                        <option value="">Select a category</option>
                        <!-- Categories will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="edit-event-spot" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Venue</label>
                    <select id="edit-event-spot" name="spot_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors">
                        <option value="">Select a venue (optional)</option>
                        <!-- Spots will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="edit-event-instructor" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Instructor</label>
                    <select id="edit-event-instructor" name="instructor_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors">
                        <option value="">Select an instructor (optional)</option>
                        <!-- Instructors will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="edit-event-priority" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Priority</label>
                    <select id="edit-event-priority" name="priority" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors">
                        <option value="0">None</option>
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>
                
                <div>
                    <label for="edit-event-description" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Description</label>
                    <textarea id="edit-event-description" name="description" rows="3" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors"></textarea>
                </div>
                
                <div class="flex items-center">
                    <input id="edit-event-all-day" name="is_all_day" type="checkbox" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="edit-event-all-day" class="ml-2 block text-sm text-gray-700">All day event</label>
                </div>
                
                <div class="flex justify-end pt-2">
                    <button type="button" id="cancel-edit-event" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors mr-3 font-medium">Cancel</button>
                    <button type="submit" id="update-event-button" class="px-5 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium shadow-md">Update Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Success Notification -->
<div id="update-success-notification" class="hidden fixed top-4 right-4 text-white px-5 py-3 rounded-lg shadow-xl z-[70] transform transition-all duration-300 animate-fade-in" style="transform: translateY(-100%); background-color: #8C508F;">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">Event updated successfully!</span>
    </div>
</div>

<!-- Update Error Notification -->
<div id="update-error-notification" class="hidden fixed top-4 right-4 bg-red-600 text-white px-5 py-3 rounded-lg shadow-xl z-[70] transform transition-all duration-300 animate-fade-in" style="transform: translateY(-100%);">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium" id="update-error-message">Failed to update event</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('edit-event-modal');
        const closeEditModal = document.getElementById('close-edit-modal');
        const cancelEditEvent = document.getElementById('cancel-edit-event');
        const editEventForm = document.getElementById('edit-event-form');
        const updateSuccessNotification = document.getElementById('update-success-notification');
        const editModalHeader = document.getElementById('edit-modal-header');
        const updateEventButton = document.getElementById('update-event-button');
        let currentCategoryColor = '#8C508F'; // Default color
        
        // Load categories
        fetch('/api/categories')
            .then(response => response.json())
            .then(categories => {
                const categorySelect = document.getElementById('edit-event-category');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    option.dataset.color = category.color;
                    categorySelect.appendChild(option);
                });
            });
        
        // Load spots (venues)
        fetch('/api/spots')
            .then(response => response.json())
            .then(spots => {
                const spotSelect = document.getElementById('edit-event-spot');
                spots.forEach(spot => {
                    const option = document.createElement('option');
                    option.value = spot.id;
                    option.textContent = spot.name;
                    spotSelect.appendChild(option);
                });
            });
            
        // Load instructors
        fetch('/api/instructors')
            .then(response => response.json())
            .then(instructors => {
                const instructorSelect = document.getElementById('edit-event-instructor');
                instructors.forEach(instructor => {
                    const option = document.createElement('option');
                    option.value = instructor.id;
                    option.textContent = instructor.name;
                    instructorSelect.appendChild(option);
                });
            });
        
        // Close modal when clicking the close button
        closeEditModal.addEventListener('click', function() {
            editModal.classList.add('hidden');
            document.getElementById('calendar').classList.remove('blur-effect');
        });
        
        // Close modal when clicking the cancel button
        cancelEditEvent.addEventListener('click', function() {
            editModal.classList.add('hidden');
            document.getElementById('calendar').classList.remove('blur-effect');
        });
        
        // Close modal when clicking outside the modal
        document.getElementById('edit-modal-backdrop').addEventListener('click', function() {
            editModal.classList.add('hidden');
            document.getElementById('calendar').classList.remove('blur-effect');
        });
        
        // Function to update UI elements with category color
        function updateCategoryColor(color) {
            if (!color) return;
            
            currentCategoryColor = color;
            editModalHeader.style.backgroundColor = color;
            updateEventButton.style.backgroundColor = color;
            updateEventButton.style.borderColor = color;
            
            // Calculate hover color (slightly darker)
            const hoverColor = adjustColor(color, -20);
            
            // Apply hover effect using a style element
            let styleEl = document.getElementById('edit-button-hover-style');
            if (!styleEl) {
                styleEl = document.createElement('style');
                styleEl.id = 'edit-button-hover-style';
                document.head.appendChild(styleEl);
            }
            
            styleEl.textContent = `
                #update-event-button:hover {
                    background-color: ${hoverColor} !important;
                    border-color: ${hoverColor} !important;
                }
            `;
            
            // Update success notification color
            updateSuccessNotification.style.backgroundColor = color;
        }
        
        // Helper function to adjust color brightness
        function adjustColor(color, amount) {
            return '#' + color.replace(/^#/, '').replace(/../g, color => ('0' + Math.min(255, Math.max(0, parseInt(color, 16) + amount)).toString(16)).substr(-2));
        }
        
        // Handle form submission
        editEventForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate that end time is after or equal to start time
            const startTime = new Date(document.getElementById('edit-event-start').value);
            const endTime = new Date(document.getElementById('edit-event-end').value);
            
            if (endTime < startTime) {
                // Show error notification
                const errorNotification = document.getElementById('update-error-notification');
                const errorMessage = document.getElementById('update-error-message');
                errorMessage.textContent = 'The end time must be after or equal to start time.';
                
                errorNotification.classList.remove('hidden');
                errorNotification.style.transform = 'translateY(0)';
                
                // Hide notification after 5 seconds
                setTimeout(function() {
                    errorNotification.style.transform = 'translateY(-100%)';
                    setTimeout(function() {
                        errorNotification.classList.add('hidden');
                    }, 300);
                }, 5000);
                
                return; // Stop form submission
            }
            
            const formData = new FormData(editEventForm);
            const eventId = document.getElementById('edit-event-id').value;
            
            // Convert form data to JSON
            const jsonData = {};
            formData.forEach((value, key) => {
                if (key === 'is_all_day') {
                    jsonData[key] = true;
                } else {
                    jsonData[key] = value;
                }
            });
            
            // If is_all_day checkbox is not checked, set it to false
            if (!formData.has('is_all_day')) {
                jsonData['is_all_day'] = false;
            }
            
            // Send the data to the server
            fetch(`/api/events/${eventId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(text || 'Failed to update event');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Close the modal
                editModal.classList.add('hidden');
                document.getElementById('calendar').classList.remove('blur-effect');
                
                // Update success notification color to match category
                updateSuccessNotification.style.backgroundColor = currentCategoryColor;
                
                // Show success notification
                updateSuccessNotification.classList.remove('hidden');
                updateSuccessNotification.style.transform = 'translateY(0)';
                
                // Hide notification after 3 seconds
                setTimeout(function() {
                    updateSuccessNotification.style.transform = 'translateY(-100%)';
                    setTimeout(function() {
                        updateSuccessNotification.classList.add('hidden');
                    }, 300);
                }, 3000);
                
                // Refresh the calendar
                calendar.refetchEvents();
            })
            .catch(error => {
                console.error('Error updating event:', error);
                // Show error notification
                const errorNotification = document.getElementById('update-error-notification');
                const errorMessage = document.getElementById('update-error-message');
                errorMessage.textContent = error.message || 'Failed to update event';
                
                errorNotification.classList.remove('hidden');
                errorNotification.style.transform = 'translateY(0)';
                
                // Hide notification after 5 seconds
                setTimeout(function() {
                    errorNotification.style.transform = 'translateY(-100%)';
                    setTimeout(function() {
                        errorNotification.classList.add('hidden');
                    }, 300);
                }, 5000);
            });
        });
        
        // Listen for category selection changes
        document.getElementById('edit-event-category').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.dataset.color) {
                updateCategoryColor(selectedOption.dataset.color);
            }
        });
        
        // Listen for start time changes to ensure end time is valid
        document.getElementById('edit-event-start').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTimeInput = document.getElementById('edit-event-end');
            const endTime = new Date(endTimeInput.value);
            
            // If end time is before start time, set end time to start time + 1 hour
            if (endTime < startTime) {
                const newEndTime = new Date(startTime);
                newEndTime.setHours(newEndTime.getHours() + 1);
                
                // Format the new end time for the datetime-local input
                const formattedEndTime = newEndTime.toISOString().slice(0, 16);
                endTimeInput.value = formattedEndTime;
            }
        });
        
        // This function will be called from the main script when the edit button is clicked
        window.populateEditForm = function(event) {
            // Set form fields with event data
            document.getElementById('edit-event-id').value = event.id;
            document.getElementById('edit-event-title').value = event.title;
            document.getElementById('edit-event-start').value = event.start.toISOString().slice(0, 16);
            document.getElementById('edit-event-end').value = event.end.toISOString().slice(0, 16);
            document.getElementById('edit-event-description').value = event.extendedProps.description || '';
            document.getElementById('edit-event-priority').value = event.extendedProps.priority || 0;
            document.getElementById('edit-event-all-day').checked = event.allDay;
            
            // Set category if available
            if (event.extendedProps.category_id) {
                document.getElementById('edit-event-category').value = event.extendedProps.category_id;
                
                // Set category color if available
                if (event.backgroundColor) {
                    updateCategoryColor(event.backgroundColor);
                }
            }
            
            // Set spot if available
            if (event.extendedProps.spot_id) {
                document.getElementById('edit-event-spot').value = event.extendedProps.spot_id;
            }
            
            // Set instructor if available
            if (event.extendedProps.instructor_id) {
                document.getElementById('edit-event-instructor').value = event.extendedProps.instructor_id;
            }
            
            // Show the modal
            editModal.classList.remove('hidden');
            document.getElementById('calendar').classList.add('blur-effect');
        }
    });
</script>