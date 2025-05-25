@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden min-h-screen">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex flex-col md:flex-row max-w-[1400px] mx-auto gap-6 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
                ['icon' => '👥', 'text' => 'User Management', 'href' => route('admin.users'), 'active_check_route_name' => 'admin.users'],
                ['icon' => '🏟️', 'text' => 'Spots Management', 'href' => route('spots.index'), 'active_check_route_name' => 'spots.index'],
            ],
        ])
        
      

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50 min-h-[500px]">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Training Program</h1>
                <a href="{{ route('training-programs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Back to List
                </a>
            </div>

            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('training-programs.store') }}" id="program-form">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    
                    <!-- Quill.js Editor Container with auto-expanding height -->
                    <div id="editor-container" class="bg-white rounded-lg border border-gray-300 mb-2" style="min-height: 200px; max-height: none;"></div>
                    
                    <!-- Hidden input to store the HTML content -->
                    <input type="hidden" id="description" name="description">
                    
                    <!-- Quill.js CSS -->
                    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                    
                    <!-- Quill.js Script -->
                    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
                </div>

                <div class="mb-4">
                    <label for="todo-list" class="block text-gray-700 dark:text-gray-300 mb-2">To-Do List</label>
                    <div class="bg-white rounded-lg border border-gray-300 p-4">
                        <div id="todo-items" class="space-y-2 mb-4">
                            <!-- Todo items will be added here dynamically -->
                        </div>
                        
                        <div class="flex">
                            <input type="text" id="new-todo-item" class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add a new to-do item...">
                            <button type="button" id="add-todo-btn" class="bg-[#8C508F] hover:bg-[#734072] text-white px-4 py-2 rounded-r-lg">Add</button>
                        </div>
                        
                        <!-- Hidden input to store the JSON todo list -->
                        <input type="hidden" id="todo_list" name="todo_list" value="{{ old('todo_list', '[]') }}">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#cf5b44] hover:bg-[#b84c38] text-white px-6 py-2 rounded-lg">
                        Create Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editor
        var quill = new Quill('#editor-container', {
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Write your program description here...',
            theme: 'snow'
        });
        
        // Set initial content if available
        const initialContent = "{{ old('description') }}";
        if (initialContent) {
            quill.clipboard.dangerouslyPasteHTML(initialContent);
        }
        
        // Update hidden form value before submit
        const form = document.getElementById('program-form');
        form.addEventListener('submit', function() {
            document.getElementById('description').value = quill.root.innerHTML;
            updateTodoListInput(); // Add this line to ensure todo list is updated before submission
        });
        
        // Todo List Functionality
        const todoItems = document.getElementById('todo-items');
        const newTodoInput = document.getElementById('new-todo-item');
        const addTodoBtn = document.getElementById('add-todo-btn');
        const todoListInput = document.getElementById('todo_list');
        
        // Initialize todo list from previous input if available
        let todoList = [];
        try {
            todoList = JSON.parse(todoListInput.value);
            renderTodoItems();
        } catch (e) {
            todoList = [];
        }
        
        // Add new todo item
        addTodoBtn.addEventListener('click', function() {
            const todoText = newTodoInput.value.trim();
            if (todoText) {
                todoList.push(todoText);
                newTodoInput.value = '';
                renderTodoItems();
                updateTodoListInput();
            }
        });
        
        // Allow pressing Enter to add todo item
        newTodoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTodoBtn.click();
            }
        });
        
        // Render todo items
        function renderTodoItems() {
            todoItems.innerHTML = '';
            todoList.forEach((item, index) => {
                const todoItem = document.createElement('div');
                todoItem.className = 'flex items-center justify-between bg-gray-50 p-3 rounded';
                todoItem.innerHTML = `
                    <span>${item}</span>
                    <button type="button" class="text-red-500 hover:text-red-700" data-index="${index}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                todoItems.appendChild(todoItem);
                
                // Add delete event listener
                todoItem.querySelector('button').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    todoList.splice(index, 1);
                    renderTodoItems();
                    updateTodoListInput();
                });
            });
        }
        
        // Update hidden input with JSON todo list
        function updateTodoListInput() {
            todoListInput.value = JSON.stringify(todoList);
        }
    });
</script>
@endsection