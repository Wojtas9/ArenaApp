@extends('layouts.app')

@section('content')
<video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-1"></div>
<div class="flex mt-30 mb-30 h-240 max-w-[1400px] mx-auto gap-6 relative z-20">

    <!-- Sidebar -->
    <div class="w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-2xl shadow-lg drop-shadow-xl/50">
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
    <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg drop-shadow-xl/50">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <button id="prev-week" class="text-gray-500 hover:text-gray-700 text-xl">❮</button>
                    <div>
                        <h1 class="text-2xl font-bold">April 13-19, 2020</h1>
                        <p class="text-gray-500">Week 16</p>
                    </div>
                    <button id="next-week" class="text-gray-500 hover:text-gray-700 text-xl">❯</button>
                </div>
            </div>
            <button id="create-event-button" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                Create
            </button>
            
            <!-- Create Event Modal will be included at the end of the file -->

        </div>

        <div class="grid grid-cols-4 gap-6">
            <!-- Main Calendar -->
            <div class="col-span-3">
                <div id="calendar"></div>
                
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
        background-color: rgba(139, 92, 246, 0.1) !important;
    }
    
    /* Event styling */
    .fc-event {
        border-radius: 6px;
        padding: 3px 6px;
        font-size: 0.9rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        border: none !important;
        position: relative;
        overflow: visible !important;
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
        border-color: #8b5cf6;
    }
    
    .fc-timegrid-now-indicator-arrow {
        border-color: #8b5cf6;
        border-width: 5px;
    }
    
    .selected-date {
        background-color: rgba(139, 92, 246, 0.2) !important;
        border-radius: 50%;
    }
    
    #mini-calendar .fc-daygrid-day {
        cursor: pointer;
    }
    
    #mini-calendar .fc-col-header-cell {
        padding: 4px 0;
    }
    
    /* Week number indicator */
    .fc-toolbar-title::after {
        content: " - Week 16";
        font-size: 0.9rem;
        opacity: 0.7;
        margin-left: 5px;
    }
    
    /* Improve calendar container */
    #calendar {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    
    /* Improve time slots appearance */
    .fc-timegrid-slot-lane {
        background-color: #fafafa;
    }
    
    /* Highlight business hours */
    .fc-timegrid-slot-lane[data-time^="09"],
    .fc-timegrid-slot-lane[data-time^="10"],
    .fc-timegrid-slot-lane[data-time^="11"],
    .fc-timegrid-slot-lane[data-time^="12"],
    .fc-timegrid-slot-lane[data-time^="13"],
    .fc-timegrid-slot-lane[data-time^="14"],
    .fc-timegrid-slot-lane[data-time^="15"],
    .fc-timegrid-slot-lane[data-time^="16"] {
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
        color: #4B5563;
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
            
        // Initialize FullCalendar
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [FullCalendar.dayGridPlugin, FullCalendar.timeGridPlugin, FullCalendar.interactionPlugin],
            initialView: 'timeGridWeek',
            headerToolbar: false,
            height: 'auto',
            allDaySlot: false,
            slotMinTime: '08:00:00',
            slotMaxTime: '18:00:00',
            expandRows: true,
            slotDuration: '01:00:00',
            dayHeaderFormat: { weekday: 'short', day: 'numeric' },
            nowIndicator: true,
            editable: true,
            selectable: true,
            timeZone: 'local', // Use local browser timezone
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            },
            eventDisplay: 'block',
            eventBorderRadius: 6,
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
                        // Process events to ensure proper time handling
                        const processedEvents = events.map(event => {
                            // Convert to local timezone for display
                            return {
                                ...event,
                                start: new Date(event.start_time),
                                end: new Date(event.end_time),
                                title: event.title,
                                backgroundColor: event.category_color,
                                borderColor: event.category_color,
                                extendedProps: {
                                    category: event.category_name,
                                    category_id: event.category_id,
                                    description: event.description,
                                    created_by_name: event.created_by_name
                                }
                            };
                        });
                        
                        // Store all events for filtering
                        allEvents = processedEvents;
                        // Apply initial filtering
                        const filteredEvents = filterEventsByCategories(processedEvents);
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
                
                // Set the start and end times in the form
                document.getElementById('event-start').value = info.startStr.slice(0, 16);
                document.getElementById('event-end').value = info.endStr.slice(0, 16);
                
                // Ensure categories are loaded for the form
                loadEventFormData();
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
                    detailsPanel.className = 'fixed bottom-0 left-0 right-0 bg-white rounded-t-lg shadow-lg z-50 transition-transform duration-300 transform translate-y-0';
                    document.body.appendChild(detailsPanel);
                }
                
                // Populate event details
                detailsPanel.innerHTML = `
                    <div class="p-6 bg-white rounded-t-lg shadow-lg max-w-3xl mx-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">${event.title}</h3>
                            <div class="flex gap-2">
                                <button id="edit-event" class="text-blue-500 hover:text-blue-700 p-1 rounded hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button id="delete-event" class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button id="close-details" class="text-gray-500 hover:text-gray-700 p-1 rounded hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-3">
                                <p class="text-gray-500 text-sm mb-1 font-medium">Time</p>
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ${new Date(event.start).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${new Date(event.end).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                </p>
                            </div>
                            <div class="mb-3">
                                <p class="text-gray-500 text-sm mb-1 font-medium">Date</p>
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    ${new Date(event.start).toLocaleDateString([], {weekday: 'long', month: 'long', day: 'numeric'})}
                                </p>
                            </div>
                            <div class="mb-3">
                                <p class="text-gray-500 text-sm mb-1 font-medium">Category</p>
                                <p class="flex items-center">
                                    <span class="w-3 h-3 rounded-full mr-2" style="background-color: ${event.backgroundColor}"></span>
                                    ${props.category || 'Uncategorized'}
                                </p>
                            </div>
                            <div class="mb-3">
                                <p class="text-gray-500 text-sm mb-1 font-medium">Created by</p>
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    ${props.created_by_name || 'Unknown'}
                                </p>
                            </div>
                        </div>
                        ${props.description ? `
                        <div class="mt-4 border-t pt-4">
                            <p class="text-gray-500 text-sm mb-2 font-medium">Description</p>
                            <p class="text-gray-700">${props.description}</p>
                        </div>
                        ` : ''}
                        <div class="mt-4 flex justify-end">
                            <button id="close-details-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">Close</button>
                        </div>
                    </div>
                `;
                
                detailsPanel.style.display = 'block';
                
                // Add close button event listeners
                document.getElementById('close-details').addEventListener('click', function() {
                    detailsPanel.style.display = 'none';
                });
                
                document.getElementById('close-details-btn').addEventListener('click', function() {
                    detailsPanel.style.display = 'none';
                });
                
                // Add edit button event listener
                document.getElementById('edit-event').addEventListener('click', function() {
                    // Here you would open a modal for editing the event
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
                            alert('Failed to delete event. Please try again.');
                        });
                    }
                });
            }
        });
        calendar.render();

        // Update calendar title
        function updateCalendarTitle() {
            const view = calendar.view;
            const start = new Date(view.activeStart);
            const end = new Date(view.activeEnd);
            end.setDate(end.getDate() - 1); // Adjust to get the last day of the visible range
            
            const startMonth = start.toLocaleString('default', { month: 'long' });
            const endMonth = end.toLocaleString('default', { month: 'long' });
            
            let title;
            if (startMonth === endMonth) {
                title = `${startMonth} ${start.getDate()}-${end.getDate()}, ${start.getFullYear()}`;
            } else {
                title = `${startMonth} ${start.getDate()} - ${endMonth} ${end.getDate()}, ${start.getFullYear()}`;
            }
            
            document.getElementById('calendar-title').textContent = title;
        }
        
        // Update calendar title and header date on initial load
        updateCalendarTitle();
        updateHeaderDate(calendar);

        
        // Connect main calendar navigation buttons
        document.getElementById('prev-week').addEventListener('click', function() {
            calendar.prev();
            updateCalendarTitle();
            updateHeaderDate(calendar);
            // Sync mini calendar if month changes
            const calDate = calendar.getDate();
            const miniDate = miniCalendar.getDate();
            if (calDate.getMonth() !== miniDate.getMonth() || 
                calDate.getFullYear() !== miniDate.getFullYear()) {
                miniCalendar.gotoDate(calDate);
                updateMiniCalendarTitle();
            }
        });
        
        document.getElementById('next-week').addEventListener('click', function() {
            calendar.next();
            updateCalendarTitle();
            updateHeaderDate(calendar);
            // Sync mini calendar if month changes
            const calDate = calendar.getDate();
            const miniDate = miniCalendar.getDate();
            if (calDate.getMonth() !== miniDate.getMonth() || 
                calDate.getFullYear() !== miniDate.getFullYear()) {
                miniCalendar.gotoDate(calDate);
                updateMiniCalendarTitle();
            }
        });

        // Connect category checkboxes to event filtering
        document.querySelectorAll('input[type="checkbox"][id^="cat"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                filterEvents();
            });
        });
        
        // Function to filter events based on selected categories
        function filterEvents() {
            const categoryColors = {
                'cat1': '#10B981', // Product Design - green
                'cat2': '#3B82F6', // Software Engineering - blue
                'cat4': '#EF4444', // Marketing - red
            };
            
            // Get all checked categories
            const checkedCategories = [];
            document.querySelectorAll('input[type="checkbox"][id^="cat"]:checked').forEach(checkbox => {
                checkedCategories.push(categoryColors[checkbox.id]);
            });
            
            // Filter events
            const allEvents = calendar.getEvents();
            allEvents.forEach(event => {
                if (checkedCategories.includes(event.backgroundColor)) {
                    event.setProp('display', 'block');
                } else {
                    event.setProp('display', 'none');
                }
            });
        }
        
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
        
        // Initialize Mini Calendar

        // Function to update the header date display
        function updateHeaderDate(calendar) {
            const view = calendar.view;
            const start = new Date(view.activeStart);
            const end = new Date(view.activeEnd);
            end.setDate(end.getDate() - 1); // Adjust to get the last day of the visible range
            
            // Format: April 13-19, 2020
            const startMonth = start.toLocaleString('default', { month: 'long' });
            const startDay = start.getDate();
            const endDay = end.getDate();
            const year = start.getFullYear();
            
            let dateRangeText;
            if (startMonth === end.toLocaleString('default', { month: 'long' })) {
                // Same month
                dateRangeText = `${startMonth} ${startDay}-${endDay}, ${year}`;
            } else {
                // Different months
                const endMonth = end.toLocaleString('default', { month: 'long' });
                dateRangeText = `${startMonth} ${startDay} - ${endMonth} ${endDay}, ${year}`;
            }
            
            // Update the header text
            document.querySelector('.text-2xl.font-bold').textContent = dateRangeText;
            
            // Update week number
            const weekNum = getWeekNumber(start);
            document.querySelector('.text-gray-500').textContent = `Week ${weekNum}`;
        }
        
        // Function to calculate ISO week number
        function getWeekNumber(date) {
            // Copy date to avoid modifying the original
            const target = new Date(date.valueOf());
            // ISO week starts on Monday
            const dayNr = (date.getDay() + 6) % 7;
            // Set target date to the Thursday of current week (ISO week date definition)
            target.setDate(target.getDate() - dayNr + 3);
            // Get first day of the year
            const firstThursday = new Date(target.getFullYear(), 0, 1);
            // If January 1 is not a Thursday, find the first Thursday of the year
            if (firstThursday.getDay() !== 4) {
                firstThursday.setMonth(0, 1 + ((4 - firstThursday.getDay()) + 7) % 7);
            }
            // Calculate week number: Number of weeks between target date and first Thursday
            const weekNumber = 1 + Math.ceil((target - firstThursday) / (7 * 24 * 60 * 60 * 1000));
            return weekNumber;
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
            
            // Ensure form data is loaded
            loadEventFormData();
        });
        
        // Close modal buttons
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('create-event-modal').classList.add('hidden');
        });
        
        document.getElementById('cancel-event').addEventListener('click', function() {
            document.getElementById('create-event-modal').classList.add('hidden');
        });
        
        // Function to load all data needed for the event form
        function loadEventFormData() {
            // Load categories into the select dropdown
            fetch('/api/categories')
                .then(response => response.json())
                .then(categories => {
                    const select = document.getElementById('event-category');
                    // Clear existing options
                    while (select.options.length > 0) {
                        select.remove(0);
                    }
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        option.style.color = category.color;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading categories:', error));
                
            // Load spots (venues)
            fetch('/api/spots')
                .then(response => response.json())
                .then(spots => {
                    const spotSelect = document.getElementById('event-spot');
                    // Clear existing options
                    while (spotSelect.options.length > 0) {
                        spotSelect.remove(0);
                    }
                    spots.forEach(spot => {
                        const option = document.createElement('option');
                        option.value = spot.id;
                        option.textContent = spot.name;
                        spotSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading spots:', error));
                
            // Load instructors
            fetch('/api/instructors')
                .then(response => response.json())
                .then(instructors => {
                    const instructorSelect = document.getElementById('event-instructor');
                    // Clear existing options
                    while (instructorSelect.options.length > 0) {
                        instructorSelect.remove(0);
                    }
                    instructors.forEach(instructor => {
                        const option = document.createElement('option');
                        option.value = instructor.id;
                        option.textContent = instructor.name;
                        instructorSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading instructors:', error));
        }
        
        // Initial load of form data
        loadEventFormData();
        
        // Handle form submission
        document.getElementById('event-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Fix timezone issues by adjusting the dates
            const startTime = new Date(formData.get('start_time'));
            const endTime = new Date(formData.get('end_time'));
            
            const eventData = {
                title: formData.get('title'),
                start_time: startTime.toISOString(),
                end_time: endTime.toISOString(),
                category_id: formData.get('category_id'),
                spot_id: formData.get('spot_id') || null,
                instructor_id: formData.get('instructor_id') || null,
                priority: formData.get('priority') || 0,
                description: formData.get('description'),
                is_all_day: formData.get('is_all_day') === 'on',
                created_by: {{ Auth::id() }}
            };
            
            // Validate form data
            if (!eventData.title) {
                alert('Please enter a title for the event');
                return;
            }
            
            if (!eventData.category_id) {
                alert('Please select a category for the event');
                return;
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
                    return response.text().then(text => {
                        throw new Error('Failed to create event: ' + text);
                    });
                }
                return response.json();
            })
            .then(event => {
                // Close the modal
                document.getElementById('create-event-modal').classList.add('hidden');
                
                // Reset the form
                document.getElementById('event-form').reset();
                
                // Refresh the calendar
                calendar.refetchEvents();
                
                // Show success message
                alert('Event created successfully!');
            })
            .catch(error => {
                console.error('Error creating event:', error);
                alert('Failed to create event. Please try again.');
            });
        });
        
        // Initialize Mini Calendar
        const miniCalendarEl = document.getElementById('mini-calendar');
        const miniCalendar = new FullCalendar.Calendar(miniCalendarEl, {
            plugins: [FullCalendar.dayGridPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: false, // We'll use our custom header
            height: 'auto',
            dayHeaderFormat: { weekday: 'narrow' },
            fixedWeekCount: false,
            showNonCurrentDates: false,
            initialDate: calendar.getDate(), // Sync with main calendar
            dateClick: function(info) {
                // Handle date click - navigate main calendar to this date
                calendar.gotoDate(info.date);
                updateCalendarTitle();
                
                // Highlight selected date
                document.querySelectorAll('#mini-calendar .fc-day').forEach(el => {
                    el.classList.remove('selected-date');
                });
                info.dayEl.classList.add('selected-date');
            },
            datesSet: function(info) {
                // Highlight current date when view changes
                const today = new Date();
                if (info.view.currentStart <= today && today < info.view.currentEnd) {
                    setTimeout(() => {
                        const todayEl = miniCalendar.el.querySelector('.fc-day-today');
                        if (todayEl) {
                            todayEl.classList.add('selected-date');
                        }
                    }, 0);
                }
            }
        });
        miniCalendar.render();
        
        // Highlight current date on initial load
        setTimeout(() => {
            const todayEl = miniCalendar.el.querySelector('.fc-day-today');
            if (todayEl) {
                todayEl.classList.add('selected-date');
            }
        }, 0);
        
        // Connect mini calendar navigation buttons
        document.getElementById('mini-prev').addEventListener('click', function() {
            miniCalendar.prev();
            updateMiniCalendarTitle();
        });
        
        document.getElementById('mini-next').addEventListener('click', function() {
            miniCalendar.next();
            updateMiniCalendarTitle();
        });
        
        // Function to update mini calendar title
        function updateMiniCalendarTitle() {
            const date = miniCalendar.getDate();
            const monthName = date.toLocaleString('default', { month: 'long' });
            const year = date.getFullYear();
            document.getElementById('mini-calendar-title').textContent = `${monthName} ${year}`;
            
            // Sync main calendar with mini calendar when month changes
            if (calendar.view.type === 'timeGridWeek') {
                // Find the first day of the selected month in the mini calendar
                const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
                // Only update main calendar if the month is different
                const currentMainDate = calendar.getDate();
                if (currentMainDate.getMonth() !== date.getMonth() || 
                    currentMainDate.getFullYear() !== date.getFullYear()) {
                    calendar.gotoDate(firstDayOfMonth);
                    updateCalendarTitle();
                }
            }
        }
        
        // Initialize with current month/year
        updateMiniCalendarTitle();
    });
</script>
    <!-- Include Event Creation Modal -->
    @include('calendar.create-event-modal')
@endsection