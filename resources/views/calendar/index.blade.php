@extends('layouts.app')

@section('content')
<video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-1"></div>
<div class="flex h-screen max-w-[1400px] mx-auto gap-6 relative z-20 py-8">

    <!-- Sidebar -->
    <div class="w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-2xl shadow-lg drop-shadow-xl/50 h-full">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 rounded-full bg-[#8C508F] flex items-center justify-center">
                <span class="text-xl">👨‍💼</span>
            </div>
            <div>
                <h3 class="font-semibold">{{ Auth::user()->name }}</h3>
                <p class="text-sm opacity-70">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>

        <nav class="space-y-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#e57373] transition-colors">
                <span class="text-xl">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#e57373] transition-colors">
                <span class="text-xl">📁</span>
                <span>Folders</span>
            </a>
            <a href="{{ route('calendar') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#e57373] transition-colors">
                <span class="text-xl">📅</span>
                <span>Calendar</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#e57373] transition-colors">
                <span class="text-xl">⚙️</span>
                <span>Settings</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="flex items-center gap-3 p-3 rounded hover:bg-red-700 transition-colors w-full text-left">
                    <span class="text-xl">🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg drop-shadow-xl/50 flex flex-col h-full">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <button id="prev-week" class="text-gray-500 hover:text-gray-700 text-xl">❮</button>
                    <div class="text-center">
                        <div id="calendar-range" class="text-sm text-gray-600"></div>
                    </div>
                    <button id="next-week" class="text-gray-500 hover:text-gray-700 text-xl">❯</button>
                </div>
            </div>
            <button id="create-event-button" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                Create
            </button>
        </div>

        <div class="grid grid-cols-4 gap-6 flex-1 min-h-0">
            <!-- Main Calendar -->
            <div class="col-span-3 h-full">
                <div id="calendar" class="h-full"></div>
                
            </div>

            <!-- Sidebar -->
            <div class="col-span-1">
                <!-- Mini Calendar -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-3">
                        <button id="mini-prev" class="text-gray-500 hover:text-gray-700">❮</button>
                        <h3 id="mini-calendar-title" class="text-lg font-semibold">April 2020</h3>
                        <button id="mini-next" class="text-gray-500 hover:text-gray-700">❯</button>
                    </div>
                    <div id="mini-calendar"></div>
                </div>

                <!-- Categories -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-3">Categories</h3>
                    <div id="categories-container" class="space-y-3">
                        <!-- Categories will be loaded dynamically -->
                        <div class="text-center py-2">
                            <div class="animate-spin inline-block w-6 h-6 border-2 border-purple-500 border-t-transparent rounded-full"></div>
                            <p class="text-sm text-gray-500 mt-1">Loading categories...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Calendar Styling */
    .fc-day-today {
        background-color: rgba(114, 215, 255, 0.25) !important;
    }
    
    /* Blur effect for modal backdrop */
    .blur-effect {
        filter: blur(4px);
        transition: filter 0.3s ease;
    }
    
    /* Event styling */
    .fc-event {
        border-radius: 0px 15px 15px 0px;
        padding: 3px 6px;
        font-size: 0.9rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: visible !important;
        /* Create a darker left border using pseudo-element */
        border-left: none !important;
    }
    
    /* Add darker border using pseudo-element */
    .fc-event::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background-color: inherit;
        filter: brightness(0.7) saturate(1.2);
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        z-index: 1; /* Ensure it's above the background but below content */
    }
    
    .category-indicator {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }
    
    .fc-event-title {
        font-weight: 500;
        margin-left: 4px;
    }
    
    .fc-event-time {
        font-weight: 400;
        opacity: 0.8;
        margin-left: 4px;
    }
    
    /* Time grid styling */
    .fc-timegrid-slot {
        height: 45px !important;
        border-color: #f0f0f0 !important;
    }
    
    .fc-timegrid-axis {
        font-size: 0.85rem;
        color: #666;
    }
    
    .fc-col-header-cell {
        padding: 8px 0;
        font-weight: 600;
    }
    
    .fc-timegrid-col {
        background-color: #ffffff;
    }
    
    .fc-timegrid-now-indicator-line {
        border-color: #ff4444;
        left: 0 !important;
        right: 0 !important;
        border-width: 2px;
        z-index: 999;
        width: 100%;
        height:2px;
        pointer-events: none;
    }
    
    .fc-timegrid-now-indicator-arrow {
        border-color:rgb(246, 92, 92);
        border-width: 5px;
    }
    
    .selected-date {
        background-color: rgba(139, 92, 246, 0.2) !important;
        border-radius: 50%;
    }
    
    /* Style for today's date in mini calendar */
    #mini-calendar .fc-day-today .fc-daygrid-day-number {
        font-weight: bold;
    }
    
    /* Style for selected date in mini calendar */
    #mini-calendar .selected-date {
        background-color: rgba(139, 92, 246, 0.2);
        border-radius: 50%;
    }
    
    /* Mini calendar specific styling */
    #mini-calendar {
        font-size: 0.6rem;
        border: none;
    }

    

    #mini-calendar .fc-daygrid-day-top {
        justify-content: center;
    }
    
    #mini-calendar .fc-daygrid-day-number {
        padding: 0px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Style for dates with events (dots) */
    .date-has-event {
        position: relative;
        border: none;
    }
    
    .date-has-event::after {
        content: '';
        position: absolute;
        
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background-color: #8b5cf6;
        border-radius: 50%;
        border: none;
    }
    
    #mini-calendar .fc-daygrid-day {
        cursor: pointer;
        border: none;
    }
    
    #mini-calendar .fc-col-header-cell {
        padding: 4px 0;
        border: none;

    }
    
    /* Week number indicator */
    
    
    /* Improve calendar container */
    #calendar {
        border-radius: 8px;
        overflow: hidden;
        
    }
    
    /* Improve time slots appearance */
    .fc-timegrid-slot-lane {
        background-color: #ffffff;
    }
    

    
    /* Event details panel styling */
    #event-details-panel {
        transform: translateY(100%);
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
    }
    
    #event-details-panel h3 {
        color:rgb(255, 255, 255);
    }
    
    #event-details-panel .text-gray-500 {
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track active categories for filtering
        let activeCategories = [];
        let allEvents = [];

        // Function to update calendar title and range
        function updateCalendarTitle() {
            const currentDate = calendar.getDate();
            const weekStart = new Date(currentDate);
            weekStart.setDate(currentDate.getDate() - currentDate.getDay());
            const weekEnd = new Date(weekStart);
            weekEnd.setDate(weekStart.getDate() + 6);

            // Get week number
            const weekNumber = Math.ceil((((weekStart - new Date(weekStart.getFullYear(), 0, 1)) / 86400000) + 1) / 7);
            
            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Update display - only update the calendar range since calendar-week element doesn't exist
            document.getElementById('calendar-range').textContent = `Week ${weekNumber}: ${formatDate(weekStart)} - ${formatDate(weekEnd)}`;
        }
        
        // Fetch categories from API
        fetch('/api/categories')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch categories');
                }
                return response.json();
            })
            .then(categories => {
                // Populate categories in the sidebar
                const categoriesContainer = document.getElementById('categories-container');
                categoriesContainer.innerHTML = '';
                
                categories.forEach(category => {
                    // Add all categories as active by default
                    activeCategories.push(category.id);
                    
                    const categoryItem = document.createElement('div');
                    categoryItem.className = 'flex items-center';
                    categoryItem.innerHTML = `
                        <input type="checkbox" id="cat-${category.id}" class="mr-2 h-4 w-4 rounded" 
                               style="accent-color: ${category.color}" checked>
                        <label for="cat-${category.id}" class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-2" style="background-color: ${category.color}"></span>
                            <span>${category.name}</span>
                        </label>
                    `;
                    
                    categoriesContainer.appendChild(categoryItem);
                    
                    // Add event listener for category filtering
                    const checkbox = categoryItem.querySelector(`#cat-${category.id}`);
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            // Add category to active list
                            activeCategories.push(category.id);
                        } else {
                            // Remove category from active list
                            activeCategories = activeCategories.filter(id => id !== category.id);
                        }
                        
                        // Filter events based on active categories
                        filterEvents();
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching categories:', error);
                document.getElementById('categories-container').innerHTML = `
                    <div class="text-center py-2">
                        <p class="text-sm text-red-500">Failed to load categories</p>
                    </div>
                `;
            });
            
      
        
        // Initialize main calendar
        const calendarEl = document.getElementById('calendar');

        
        
        // Add event listeners for navigation buttons
        // Connect main calendar navigation buttons
        document.getElementById('prev-week').addEventListener('click', function() {
            calendar.prev();
            updateCalendarTitle();
        });
        
        document.getElementById('next-week').addEventListener('click', function() {
            calendar.next();
            updateCalendarTitle();
        });
        
        window.calendar = new FullCalendar.Calendar(calendarEl, {
           
            plugins: [FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin, FullCalendar.interactionPlugin],
            initialView: 'timeGridWeek',
            headerToolbar: false,
            height: '100%',
            allDaySlot: false,
            slotMinTime: '08:00:00',
            slotMaxTime: '24:00:00',
            expandRows: true,
            slotDuration: '01:00:00',
            dayHeaderFormat: { weekday: 'short', day: 'numeric' },
            nowIndicator: true,
            editable: true,
            selectable: true,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            },
            eventDisplay: 'block',
            eventMaxStack: 3,
            slotEventOverlap: false,
            events: function(info, successCallback, failureCallback) {
                // Fetch events from API
                fetch('/api/events')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch events');
                        }
                        return response.json();
                    })
                    .then(events => {
                        // Store all events for filtering
                        allEvents = events;
                        // Apply initial filtering
                        const filteredEvents = filterEventsByCategories(events);
                        successCallback(filteredEvents);
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    });
            },
            select: function(info) {
                // Handle date selection - open event creation modal
                const modal = document.getElementById('create-event-modal');
                modal.classList.remove('hidden');
                document.getElementById('calendar').classList.add('blur-effect');
                
                // Set the start and end times in the form
                document.getElementById('event-start').value = info.startStr.slice(0, 16);
                document.getElementById('event-end').value = info.endStr.slice(0, 16);
            },
            eventDrop: function(info) {
                // Handle event drag and drop (update event dates)
                const event = info.event;
                
                fetch(`/api/events/${event.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        start_time: event.start.toISOString(),
                        end_time: event.end.toISOString()
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        info.revert(); // Revert the drag if there was an error
                        throw new Error('Failed to update event');
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                    // You could show an error notification here
                });
            },
            eventResize: function(info) {
                // Handle event resize (update event duration)
                const event = info.event;
                
                // Update calendar title when event is resized
                updateCalendarTitle();
                
                fetch(`/api/events/${event.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        end_time: event.end.toISOString()
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        info.revert(); // Revert the resize if there was an error
                        throw new Error('Failed to update event');
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                    // You could show an error notification here
                });
            },
            eventDidMount: function(info) {
                // Add hover effect and additional styling to events
                const eventEl = info.el;
                eventEl.classList.add('hover:shadow-lg', 'transition-shadow');
                
                // Add category color indicator
                const eventColor = info.event.backgroundColor;
                const categoryIndicator = document.createElement('div');
                categoryIndicator.classList.add('category-indicator');
                categoryIndicator.style.backgroundColor = eventColor;
                eventEl.prepend(categoryIndicator);
            },
            eventClick: function(info) {
                // Show event details panel
                const event = info.event;
                const props = event.extendedProps;
                
                // Create or update event details panel
                let detailsPanel = document.getElementById('event-details-panel');
                if (!detailsPanel) {
                    detailsPanel = document.createElement('div');
                    detailsPanel.id = 'event-details-panel';
                    document.body.appendChild(detailsPanel);
                }
                
                // Populate event details
                detailsPanel.innerHTML = `
                    <div class="p-4 bg-white rounded-lg shadow-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">${event.title}</h3>
                            <div class="flex gap-2">
                                <button id="edit-event" class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button id="delete-event" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button id="close-details" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <p class="text-gray-500 text-sm mb-1">Time</p>
                            <p>${event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-gray-500 text-sm mb-1">Category</p>
                            <p class="flex items-center">
                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: ${event.backgroundColor}"></span>
                                ${props.category || 'Uncategorized'}
                            </p>
                        </div>
                               ${props.description ? `
                        <div class="mb-3">
                            <p class="text-gray-500 text-sm mb-1">Description</p>
                            <p>${props.description}</p>
                        </div>
                        ` : ''}
                        ${props.priority > 0 ? `
                        <div class="mb-3">
                            <p class="text-gray-500 text-sm mb-1">Priority</p>
                            <p>${['Low', 'Medium', 'High', 'Urgent'][props.priority]}</p>
                        </div>
                        ` : ''}
                    </div>
                `;
                
                detailsPanel.style.display = 'block';
                
                // Add close button event listener
                document.getElementById('close-details').addEventListener('click', function() {
                    detailsPanel.style.display = 'none';
                });
                
                // Add edit button event listener
                document.getElementById('edit-event').addEventListener('click', function() {
                    // Here you would open a modal for editing the event
                    // For now, we'll just log the event
                    console.log('Edit event:', event);
                    detailsPanel.style.display = 'none';
                });
                
                // Add delete button event listener
                document.getElementById('delete-event').addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this event?')) {
                        fetch(`/api/events/${event.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to delete event');
                            }
                            calendar.getEventById(event.id).remove(); // Remove from calendar
                            detailsPanel.style.display = 'none';
                        })
                        .catch(error => {
                            console.error('Error deleting event:', error);
                            // You could show an error notification here
                        });
                    }
                });
            }
        });
        calendar.render();
        
        // Initialize header date on page load
        updateHeaderDate(calendar);

        
        updateMiniCalendarTitle(calendar);

        // Update calendar title
        function updateCalendarTitle() {
            const currentDate = calendar.getDate();
            const weekStart = new Date(currentDate);
            weekStart.setDate(currentDate.getDate() - currentDate.getDay());
            const weekEnd = new Date(weekStart);
            weekEnd.setDate(weekStart.getDate() + 6);

            // Get week number
            const weekNumber = Math.ceil((((weekStart - new Date(weekStart.getFullYear(), 0, 1)) / 86400000) + 1) / 7);
            
            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Update display
            document.getElementById('calendar-range').textContent = `Week ${weekNumber}: ${formatDate(weekStart)} - ${formatDate(weekEnd)}`;
        }
        
        // Connect main calendar navigation buttons
        document.getElementById('prev-week').addEventListener('click', function() {
            calendar.prev();
            updateCalendarTitle();
            updateHeaderDate(calendar);
            
   
        });
        
        document.getElementById('next-week').addEventListener('click', function() {
            calendar.next();
            updateCalendarTitle();
            updateHeaderDate(calendar);
            

        });
        
        // Initialize header date on load
        updateHeaderDate(calendar);
        // Connect category checkboxes to event filtering
        document.querySelectorAll('input[type="checkbox"][id^="cat"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                filterEvents();
            });
        });
        
        // Function to filter events based on active categories
        function filterEvents() {
            const filteredEvents = filterEventsByCategories(allEvents);
            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        }
        
        // Function to filter events by active categories
        function filterEventsByCategories(events) {
            if (activeCategories.length === 0) {
                return [];
            }
            
            return events.filter(event => {
                // Check if the event's category_id is in the active categories list
                return activeCategories.includes(parseInt(event.extendedProps.category_id));
            });
        }
        
        // Initialize the calendar
        calendar.render();
        
        
        // Update the calendar title when the page loads
        updateCalendarTitle();
        
        // Call updateCalendarTitle whenever the view changes
        calendar.on('datesSet', function() {
            updateCalendarTitle();
        });
        
        // Initialize Mini Calendar
        const miniCalendarEl = document.getElementById('mini-calendar');
        const miniCalendar = new FullCalendar.Calendar(miniCalendarEl, {
            plugins: [FullCalendar.dayGridPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: false,
            height: 'auto',
            dayMaxEvents: 0,
            showNonCurrentDates: true,
            fixedWeekCount: false,
            dateClick: function(info) {
                // Remove selected class from all dates
                document.querySelectorAll('#mini-calendar .selected-date').forEach(el => {
                    el.classList.remove('selected-date');
                });
                
                // Add selected class to clicked date
                info.dayEl.classList.add('selected-date');
                
                // Navigate main calendar to this date
                calendar.gotoDate(info.date);
            }
        });
        miniCalendar.render();
        
        // Connect mini calendar navigation buttons
        document.getElementById('mini-prev').addEventListener('click', function() {
            miniCalendar.prev();
            updateMiniCalendarTitle(miniCalendar);
        });
        
        document.getElementById('mini-next').addEventListener('click', function() {
            miniCalendar.next();
            updateMiniCalendarTitle(miniCalendar);
        });
        
        // Initialize mini calendar title
        updateMiniCalendarTitle(miniCalendar);
        
        // Add event markers to mini calendar
        function addEventMarkersToMiniCalendar() {
            // Get all events from the main calendar
            const events = calendar.getEvents();
            const eventDates = {};
            
            // Collect unique dates that have events
            events.forEach(event => {
                const dateStr = event.start.toISOString().split('T')[0];
                eventDates[dateStr] = true;
            });
            
            // Add markers to dates with events
            document.querySelectorAll('#mini-calendar .fc-daygrid-day').forEach(dayEl => {
                const date = dayEl.getAttribute('data-date');
                if (eventDates[date]) {
                    dayEl.querySelector('.fc-daygrid-day-number').classList.add('date-has-event');
                }
            });
        }
        
        // Call this function after events are loaded
        calendar.on('eventSourceSuccess', function() {
            addEventMarkersToMiniCalendar();
        });
        
        // Also call when mini calendar month changes
        miniCalendar.on('datesSet', function() {
            // Wait for the DOM to update
            setTimeout(addEventMarkersToMiniCalendar, 100);
        });
        
        // Mark specific dates with events as shown in the image (for demo purposes)
        setTimeout(function() {
            const demoEventDates = ['2020-04-02', '2020-04-10', '2020-04-14', '2020-04-16', '2020-04-17', '2020-04-21', '2020-04-30'];
            document.querySelectorAll('#mini-calendar .fc-daygrid-day').forEach(dayEl => {
                const date = dayEl.getAttribute('data-date');
                if (demoEventDates.includes(date)) {
                    dayEl.querySelector('.fc-daygrid-day-number').classList.add('date-has-event');
                }
            });
        }, 500);
        
        function updateHeaderDate(calendar) {
            const date = calendar.getDate();
            const weekNum = getWeekNumber(date);
            const start = calendar.view.activeStart;
            const end = calendar.view.activeEnd;
            const startMonth = start.toLocaleString('default', { month: 'long' });
            const endMonth = end.toLocaleString('default', { month: 'long' });
            const year = start.getFullYear();
            
            // We don't update calendar-range here anymore as it's handled by updateCalendarTitle
            // This prevents conflicts between the two functions
            
            // Update mini calendar title if needed
            updateMiniCalendarTitle(calendar);
        }
        
        // Function to calculate week number
        function getWeekNumber(date) {
            const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
            const pastDaysOfYear = (date - firstDayOfYear) / 86400000;
            return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
        }

        // Event creation modal handling
        document.getElementById('create-event-button').addEventListener('click', function() {
            const modal = document.getElementById('create-event-modal');
            modal.classList.remove('hidden');
            
            // Set default times (current time + 1 hour for end)
            const now = new Date();
            const start = new Date(now);
            const end = new Date(now);
            end.setHours(end.getHours() + 1);
            
            document.getElementById('event-start').value = start.toISOString().slice(0, 16);
            document.getElementById('event-end').value = end.toISOString().slice(0, 16);
        });
        
        // Close modal buttons
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('create-event-modal').classList.add('hidden');
        });
        
        document.getElementById('cancel-event').addEventListener('click', function() {
            document.getElementById('create-event-modal').classList.add('hidden');
        });
        
        // Load categories into the select dropdown
        fetch('/api/categories')
            .then(response => response.json())
            .then(categories => {
                const select = document.getElementById('event-category');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    option.style.color = category.color;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading categories:', error));
            

        
        // Note: Form submission is handled in create-event-modal.blade.php
        // We removed the duplicate event listener here to prevent double submissions
        
        // Mini Calendar already initialized at the beginning of the script
        
    
        
        // Function to update mini calendar title
        function updateMiniCalendarTitle(calendar) {
            const date = calendar.getDate();
            const monthName = date.toLocaleString('default', { month: 'long' });
            const year = date.getFullYear();
            document.getElementById('mini-calendar-title').textContent = `${monthName} ${year}`;
        }
        

    });
</script>
    <!-- Include Event Creation Modal -->
    @include('calendar.create-event-modal')
@endsection