<div class="card">
    <div class="card-header">
        <h2>{{ $spot->name }}</h2>
    </div>
    <div class="card-body">
        @if($spot->picture)
            <div class="mb-3">
                <img src="{{ asset($spot->picture) }}" alt="{{ $spot->name }}" class="img-fluid" style="max-width: 400px;">
            </div>
        @endif
        <p><strong>Location:</strong> {{ $spot->location }}</p>
        <p><strong>Capacity:</strong> {{ $spot->capacity }}</p>
        @if($spot->description)
            <p><strong>Description:</strong> {{ $spot->description }}</p>
        @endif
    </div>
</div>

<form action="{{ route('spots.destroy', $spot->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger delete-btn">Delete Spot</button>
</form>

<!-- Add this JavaScript for confirmation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                if (confirm('Are you sure you want to delete this Spot?')) {
                    this.submit();
                }
            });
        });
    });
</script>