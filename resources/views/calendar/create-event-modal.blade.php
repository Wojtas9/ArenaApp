<!-- Event Creation Modal -->
<div id="create-event-modal" class="fixed inset-0 hidden overflow-y-auto h-full w-full z-50">
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" id="modal-backdrop"></div>
    <div class="relative mx-auto p-0 w-full max-w-md shadow-xl rounded-2xl bg-white z-[60] overflow-hidden transform transition-all animate-fade-in" style="margin-top: 10vh;">
        <div class="bg-purple-600 p-4 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Create New Event</h3>
                <button id="close-modal" class="text-white hover:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-5">
            <form id="event-form" class="space-y-5">
                <div>
                    <label for="event-title" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Title</label>
                    <input type="text" id="event-title" name="title" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="event-start" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Start Time</label>
                        <input type="datetime-local" id="event-start" name="start_time" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                    </div>
                    <div>
                        <label for="event-end" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">End Time</label>
                        <input type="datetime-local" id="event-end" name="end_time" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                    </div>
                </div>
                
                <div>
                    <label for="event-category" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Category</label>
                    <select id="event-category" name="category_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                        <option value="">Select a category</option>
                        <!-- Categories will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="event-spot" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Spot</label>
                    <select id="event-spot" name="spot_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors">
                        <option value="">Select a Spot (optional)</option>
                        <!-- Spots will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="event-instructor" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Coach</label>
                    <select id="event-instructor" name="instructor_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors">
                        <option value="">Select a Coach (optional)</option>
                        <!-- Instructors will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="event-priority" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Priority</label>
                    <select id="event-priority" name="priority" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors">
                        <option value="0">None</option>
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>
                
                <div>
                    <label for="event-description" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Description</label>
                    <textarea id="event-description" name="description" rows="3" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors"></textarea>
                </div>
                
                <div class="flex items-center">
                    <input id="event-all-day" name="is_all_day" type="checkbox" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="event-all-day" class="ml-2 block text-sm text-gray-700">All day event</label>
                </div>
                
                <div class="flex justify-end pt-2">
                    <button type="button" id="cancel-event" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors mr-3 font-medium">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium shadow-md">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Notification -->
<div id="success-notification" class="hidden fixed top-4 right-4 bg-purple-600 text-white px-5 py-3 rounded-lg shadow-xl z-[70] transform transition-all duration-300 animate-fade-in" style="transform: translateY(-100%)">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">Event created successfully!</span>
    </div>
</div>

<!-- Error Notification -->
<div id="error-notification" class="hidden fixed top-4 right-4 bg-red-600 text-white px-5 py-3 rounded-lg shadow-xl z-[70] transform transition-all duration-300 animate-fade-in" style="transform: translateY(-100%)">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium" id="error-message">Failed to create event</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createButton = document.getElementById('create-event-button');
        const modal = document.getElementById('create-event-modal');
        const closeModal = document.getElementById('close-modal');
        const cancelEvent = document.getElementById('cancel-event');
        const eventForm = document.getElementById('event-form');
        const notification = document.getElementById('success-notification');
        
        // Use the global calendar instance
        
        // Load categories
        fetch('/api/categories')
            .then(response => response.json())
            .then(categories => {
                const categorySelect = document.getElementById('event-category');
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
                const spotSelect = document.getElementById('event-spot');
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
                const instructorSelect = document.getElementById('event-instructor');
                instructors.forEach(instructor => {
                    const option = document.createElement('option');
                    option.value = instructor.id;
                    option.textContent = instructor.name;
                    instructorSelect.appendChild(option);
                });
            });
        
        // Open modal when Create button is clicked
        createButton.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.getElementById('calendar').classList.add('blur-effect');
            
            // Set default start and end times
            const now = new Date();
            const startTime = new Date(now);
            startTime.setMinutes(Math.ceil(now.getMinutes() / 30) * 30); // Round to nearest half hour
            const endTime = new Date(startTime);
            endTime.setHours(endTime.getHours() + 1); // Default 1 hour duration
            
            document.getElementById('event-start').value = formatDateTimeForInput(startTime);
            document.getElementById('event-end').value = formatDateTimeForInput(endTime);
        });
        
        // Close modal
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
            document.getElementById('calendar').classList.remove('blur-effect');
        });
        
        // Listen for start time changes to ensure end time is valid
        document.getElementById('event-start').addEventListener('change', function() {
            const startTime = new Date(this.value);
            const endTimeInput = document.getElementById('event-end');
            const endTime = new Date(endTimeInput.value);
            
            // If end time is before start time, set end time to start time + 1 hour
            if (endTime < startTime) {
                const newEndTime = new Date(startTime);
                newEndTime.setHours(newEndTime.getHours() + 1);
                
                // Format the new end time for the datetime-local input
                endTimeInput.value = formatDateTimeForInput(newEndTime);
            }
        });
        
        // Handle escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.getElementById('calendar').classList.remove('blur-effect');
                eventForm.reset();
            }
        });
        
        cancelEvent.addEventListener('click', function() {
            modal.classList.add('hidden');
            document.getElementById('calendar').classList.remove('blur-effect');
            eventForm.reset();
        });
        
        // Handle form submission
        eventForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate that end time is after or equal to start time
            const startTime = new Date(document.getElementById('event-start').value);
            const endTime = new Date(document.getElementById('event-end').value);
            
            if (endTime < startTime) {
                // Show error notification
                const errorNotification = document.getElementById('error-notification');
                if (errorNotification) {
                    const errorMessage = document.getElementById('error-message');
                    if (errorMessage) {
                        errorMessage.textContent = 'The end time must be after or equal to start time.';
                    }
                    
                    errorNotification.classList.remove('hidden');
                    errorNotification.style.transform = 'translateY(0)';
                    
                    // Hide notification after 5 seconds
                    setTimeout(function() {
                        errorNotification.style.transform = 'translateY(-100%)';
                        setTimeout(function() {
                            errorNotification.classList.add('hidden');
                        }, 300);
                    }, 5000);
                } else {
                    alert('The end time must be after or equal to start time.');
                }
                
                return; // Stop form submission
            }
            
            const formData = new FormData(eventForm);
            const eventData = {};
            
            formData.forEach((value, key) => {
                if (key === 'is_all_day') {
                    eventData[key] = true;
                } else if (value) {
                    eventData[key] = value;
                }
            });
            
            // If is_all_day wasn't checked, set it to false
            if (!eventData.hasOwnProperty('is_all_day')) {
                eventData.is_all_day = false;
            }
            
            // Get the color from the selected category
            const categorySelect = document.getElementById('event-category');
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.color) {
                eventData.color = selectedOption.dataset.color;
            }
            
            fetch('/api/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(eventData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to create event');
                }
                return response.json();
            })
            .then(event => {
                // Add the new event to the calendar
                if (typeof window.calendar !== 'undefined') {
                    // Just refresh the calendar to show the new event
                    // This prevents double event creation
                    window.calendar.refetchEvents();
                }
                
                // Close the modal and reset the form
                modal.classList.add('hidden');
                document.getElementById('calendar').classList.remove('blur-effect');
                eventForm.reset();
                
                // Show success notification
                notification.classList.remove('hidden');
                notification.style.transform = 'translateY(0)';
                
                // Auto-hide notification after 3 seconds
                setTimeout(() => {
                    notification.style.transform = 'translateY(-100%)';
                    setTimeout(() => {
                        notification.classList.add('hidden');
                        notification.style.transform = '';
                    }, 300);
                }, 3000);
            })
            .catch(error => {
                console.error('Error creating event:', error);
                // You could show an error notification here
            });
        });
        
        // Helper function to format date for datetime-local input
        function formatDateTimeForInput(date) {
            return date.getFullYear() + '-' + 
                   padZero(date.getMonth() + 1) + '-' + 
                   padZero(date.getDate()) + 'T' + 
                   padZero(date.getHours()) + ':' + 
                   padZero(date.getMinutes());
        }
        
        function padZero(num) {
            return num.toString().padStart(2, '0');
        }
    });
</script>