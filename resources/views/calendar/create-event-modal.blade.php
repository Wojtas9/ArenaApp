<!-- Event Creation Modal -->
<div id="create-event-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium text-gray-900">Create New Event</h3>
                <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="event-form" class="space-y-4">
                <div>
                    <label for="event-title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="event-title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="event-start" class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="datetime-local" id="event-start" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label for="event-end" class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="datetime-local" id="event-end" name="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>
                
                <div>
                    <label for="event-category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="event-category" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Select a category</option>
                        <!-- Categories will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="event-spot" class="block text-sm font-medium text-gray-700">Venue</label>
                    <select id="event-spot" name="spot_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a venue (optional)</option>
                        <!-- Spots will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="event-instructor" class="block text-sm font-medium text-gray-700">Instructor</label>
                    <select id="event-instructor" name="instructor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select an instructor (optional)</option>
                        <!-- Instructors will be loaded dynamically -->
                    </select>
                </div>
                
                <div>
                    <label for="event-priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select id="event-priority" name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="0">None</option>
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>
                
                <div>
                    <label for="event-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="event-description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                
                <div class="flex items-center">
                    <input id="event-all-day" name="is_all_day" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="event-all-day" class="ml-2 block text-sm text-gray-900">All day event</label>
                </div>
                
                <div class="flex justify-end pt-2">
                    <button type="button" id="cancel-event" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createButton = document.getElementById('create-event-button');
        const modal = document.getElementById('create-event-modal');
        const closeModal = document.getElementById('close-modal');
        const cancelEvent = document.getElementById('cancel-event');
        const eventForm = document.getElementById('event-form');
        
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
        
        // Open modal when Create button is clicked
        createButton.addEventListener('click', function() {
            modal.classList.remove('hidden');
            
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
        });
        
        cancelEvent.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Handle form submission
        eventForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
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
                calendar.addEvent({
                    id: event.id,
                    title: event.title,
                    start: event.start_time,
                    end: event.end_time,
                    allDay: event.is_all_day,
                    backgroundColor: event.color,
                    borderColor: event.color,
                    extendedProps: {
                        description: event.description,
                        category: event.category.name,
                        spot: event.spot ? event.spot.name : null,
                        instructor: event.instructor ? event.instructor.name : null,
                        priority: event.priority
                    }
                });
                
                // Close the modal and reset the form
                modal.classList.add('hidden');
                eventForm.reset();
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