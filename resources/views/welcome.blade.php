<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .task-item {
            cursor: move;
            transition: all 0.3s;
        }
        .task-item:hover {
            background-color: #f8f9fa;
        }
        .completed {
            text-decoration: line-through;
            color: #6c757d;
        }
        .tag-badge {
            font-size: 0.8rem;
            margin-right: 5px;
        }
        #auth-section, #app-section {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-4">
    <!-- Auth Section -->
    <div id="auth-section">
        <div class="card shadow">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register">Register</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="login">
                        <form id="login-form">
                            <div class="mb-3">
                                <label for="login-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="login-email" required>
                            </div>
                            <div class="mb-3">
                                <label for="login-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="login-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register">
                        <form id="register-form">
                            <div class="mb-3">
                                <label for="register-name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="register-name" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="register-email" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="register-password" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-password-confirm" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="register-password-confirm" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- App Section (hidden by default) -->
    <div id="app-section" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Task Manager</h2>
            <div>
                <span id="user-name" class="me-3"></span>
                <button id="logout-btn" class="btn btn-outline-danger">Logout</button>
            </div>
        </div>

        <!-- Tags Section -->
        <div class="card mb-4 shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tags</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tagModal">
                    <i class="bi bi-plus"></i> Add Tag
                </button>
            </div>
            <div class="card-body" id="tags-container">
                <div class="d-flex flex-wrap" id="tags-list">
                </div>
            </div>
        </div>

        <!-- Tasks Section -->
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tasks</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
                    <i class="bi bi-plus"></i> Add Task
                </button>
            </div>
            <div class="card-body">
                <div class="list-group" id="tasks-list">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalTitle">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="task-form">
                    <input type="hidden" id="task-id">
                    <div class="mb-3">
                        <label for="task-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="task-title" required minlength="3" maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label for="task-text" class="form-label">Description</label>
                        <textarea class="form-control" id="task-text" rows="3" maxlength="200"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div id="tags-checkboxes" class="d-flex flex-wrap gap-3">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tag Modal -->
<div class="modal fade" id="tagModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tag-form">
                    <div class="mb-3">
                        <label for="tag-title" class="form-label">Tag Name</label>
                        <input type="text" class="form-control" id="tag-title" required minlength="3" maxlength="20">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
@vite(['resources/js/app.js', 'resources/css/app.css'])
</body>
</html>
