<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">Player Dashboard</div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h2 class="text-center">Hello Player!</h2>
                            <p class="text-center">Welcome to your player dashboard.</p>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <h4>Player Controls</h4>
                                <p>This is where player-specific functionality will be implemented.</p>
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>