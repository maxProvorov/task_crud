import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const authSection = document.getElementById('auth-section');
    const appSection = document.getElementById('app-section');
    const userNameSpan = document.getElementById('user-name');
    const logoutBtn = document.getElementById('logout-btn');
    const tasksList = document.getElementById('tasks-list');
    const tagsList = document.getElementById('tags-list');

    // Forms
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const taskForm = document.getElementById('task-form');
    const tagForm = document.getElementById('tag-form');

    // Modal elements
    const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
    const tagModal = new bootstrap.Modal(document.getElementById('tagModal'));
    const taskModalTitle = document.getElementById('taskModalTitle');
    const taskIdInput = document.getElementById('task-id');
    const taskTitleInput = document.getElementById('task-title');
    const taskTextInput = document.getElementById('task-text');
    const tagTitleInput = document.getElementById('tag-title');
    const tagsCheckboxes = document.getElementById('tags-checkboxes');

    // State
    let currentUser = null;
    let tasks = [];
    let tags = [];
    let sortable = null;

    // Initialize the app
    init();

    function init() {
        setupEventListeners();
        checkAuth();
    }

    function setupEventListeners() {
        // Auth forms
        loginForm.addEventListener('submit', handleLogin);
        registerForm.addEventListener('submit', handleRegister);
        logoutBtn.addEventListener('click', handleLogout);

        // Task and tag forms
        taskForm.addEventListener('submit', handleTaskSubmit);
        tagForm.addEventListener('submit', handleTagSubmit);

        // Modal hidden events
        document.getElementById('taskModal').addEventListener('hidden.bs.modal', resetTaskForm);
    }

    function checkAuth() {
        const token = localStorage.getItem('api_token');
        if (token) {
            setAuthHeader(token);
            fetchUser();
        }
    }

    function setAuthHeader(token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    function fetchUser() {
        axios.get('/api/user')
            .then(response => {
                if (!response.data?.user) {
                    throw new Error('Invalid user data');
                }
                currentUser = response.data.user;
                showAppSection();
                fetchTasks();
                fetchTags();
            })
            .catch(error => {
                console.error('User fetch error:', error);
                if (error.response?.status === 401) {
                    localStorage.removeItem('api_token');
                    window.location.reload();
                }
            });
    }

    function fetchTasks() {
        axios.get('/api/tasks')
            .then(response => {
                tasks = response.data;
                renderTasks();
                initSortable();
            })
            .catch(handleApiError);
    }

    function fetchTags() {
        axios.get('/api/tags')
            .then(response => {
                tags = response.data;
                renderTags();
                renderTagCheckboxes();
            })
            .catch(handleApiError);
    }

    function renderTasks() {
        tasksList.innerHTML = '';

        tasks.forEach(task => {
            const taskElement = document.createElement('div');
            taskElement.className = 'list-group-item task-item d-flex justify-content-between align-items-center';
            taskElement.dataset.id = task.id;

            const isCompleted = task.status === 'completed';
            const completedClass = isCompleted ? 'completed' : '';

            taskElement.innerHTML = `
                <div class="form-check flex-grow-1">
                    <input class="form-check-input task-checkbox" type="checkbox" ${isCompleted ? 'checked' : ''}>
                    <label class="form-check-label ${completedClass}">
                        ${task.title}
                    </label>
                    <div class="text-muted small mt-1">${task.text}</div>
                    <div class="mt-2">
                        ${task.tags.map(tag => `<span class="badge bg-secondary tag-badge">${tag.title}</span>`).join('')}
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary me-1 edit-task-btn">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-task-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

            tasksList.appendChild(taskElement);

            taskElement.querySelector('.task-checkbox').addEventListener('change', () => toggleTaskStatus(task.id));
            taskElement.querySelector('.edit-task-btn').addEventListener('click', () => editTask(task));
            taskElement.querySelector('.delete-task-btn').addEventListener('click', () => deleteTask(task.id));
        });
    }

    function renderTags() {
        tagsList.innerHTML = '';

        tags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'badge bg-primary me-2 mb-2';
            tagElement.textContent = tag.title;
            tagsList.appendChild(tagElement);
        });
    }

    function renderTagCheckboxes() {
        tagsCheckboxes.innerHTML = '';

        tags.forEach(tag => {
            const div = document.createElement('div');
            div.className = 'form-check';

            div.innerHTML = `
                <input class="form-check-input" type="checkbox" value="${tag.id}" id="tag-${tag.id}">
                <label class="form-check-label" for="tag-${tag.id}">
                    ${tag.title}
                </label>
            `;

            tagsCheckboxes.appendChild(div);
        });
    }

    function initSortable() {
        if (sortable) {
            sortable.destroy();
        }

        sortable = new Sortable(tasksList, {
            animation: 150,
            handle: '.form-check-label',
            onEnd: function() {
                const taskIds = Array.from(tasksList.children).map(el => parseInt(el.dataset.id));
                updateTaskOrder(taskIds);
            }
        });
    }

    function updateTaskOrder(taskIds) {
        const orderedTasks = taskIds.map((id, index) => ({ id, order: index + 1 }));

        axios.post('/api/tasks/update-order', { tasks: orderedTasks })
            .then(() => fetchTasks())
            .catch(handleApiError);
    }

    function showAppSection() {
        authSection.style.display = 'none';
        appSection.style.display = 'block';
        userNameSpan.textContent = currentUser.name;
    }

    function showAuthSection() {
        authSection.style.display = 'block';
        appSection.style.display = 'none';
        currentUser = null;
        tasks = [];
        tags = [];
    }

    // Event Handlers
    function handleLogin(e) {
        e.preventDefault();

        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-password').value;

        axios.post('/api/login', { email, password })
            .then(response => {
                localStorage.setItem('api_token', response.data.token);
                setAuthHeader(response.data.token);
                currentUser = response.data.user;
                showAppSection();
                fetchTasks();
                fetchTags();
                loginForm.reset();
            })
            .catch(error => {
                alert(error.response?.data?.message || 'Login failed');
            });
    }

    function handleRegister(e) {
        e.preventDefault();

        const name = document.getElementById('register-name').value;
        const email = document.getElementById('register-email').value;
        const password = document.getElementById('register-password').value;
        const passwordConfirm = document.getElementById('register-password-confirm').value;

        if (password !== passwordConfirm) {
            alert('Passwords do not match');
            return;
        }

        axios.post('/api/register', { name, email, password, password_confirmation: passwordConfirm })
            .then(response => {
                localStorage.setItem('api_token', response.data.token);
                setAuthHeader(response.data.token);
                currentUser = response.data.user;
                showAppSection();
                fetchTasks();
                fetchTags();
                registerForm.reset();
                document.querySelector('#login-tab').click();
            })
            .catch(error => {
                const errors = error.response?.data?.errors;
                if (errors) {
                    alert(Object.values(errors).join('\n'));
                } else {
                    alert('Registration failed');
                }
            });
    }

    function handleLogout() {
        axios.post('/api/logout')
            .then(() => {
                localStorage.removeItem('api_token');
                delete axios.defaults.headers.common['Authorization'];
                showAuthSection();
            })
            .catch(handleApiError);
    }

    function handleTaskSubmit(e) {
        e.preventDefault();

        const title = taskTitleInput.value;
        const text = taskTextInput.value;
        const selectedTags = Array.from(tagsCheckboxes.querySelectorAll('input:checked')).map(cb => parseInt(cb.value));
        const taskId = taskIdInput.value;

        const taskData = {
            title,
            text,
            tags: selectedTags
        };

        const request = taskId
            ? axios.put(`/api/tasks/${taskId}`, taskData)
            : axios.post('/api/tasks', taskData);

        request.then(() => {
            fetchTasks();
            taskModal.hide();
        })
            .catch(handleApiError);
    }

    function handleTagSubmit(e) {
        e.preventDefault();

        const title = tagTitleInput.value;

        axios.post('/api/tags', { title })
            .then(() => {
                fetchTags();
                tagModal.hide();
                tagForm.reset();
            })
            .catch(handleApiError);
    }

    function toggleTaskStatus(taskId) {
        const task = tasks.find(t => t.id === taskId);
        const newStatus = task.status === 'completed' ? 'pending' : 'completed';

        axios.put(`/api/tasks/${taskId}`, { status: newStatus })
            .then(() => fetchTasks())
            .catch(handleApiError);
    }

    function editTask(task) {
        taskModalTitle.textContent = 'Edit Task';
        taskIdInput.value = task.id;
        taskTitleInput.value = task.title;
        taskTextInput.value = task.text;

        // Clear all checkboxes first
        tagsCheckboxes.querySelectorAll('input').forEach(cb => {
            cb.checked = false;
        });

        // Check the tags that this task has
        task.tags.forEach(tag => {
            const checkbox = document.getElementById(`tag-${tag.id}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        taskModal.show();
    }

    function deleteTask(taskId) {
        if (confirm('Are you sure you want to delete this task?')) {
            axios.delete(`/api/tasks/${taskId}`)
                .then(() => fetchTasks())
                .catch(handleApiError);
        }
    }

    function resetTaskForm() {
        taskModalTitle.textContent = 'Add New Task';
        taskForm.reset();
        taskIdInput.value = '';
    }

    function handleApiError(error) {
        console.error('API Error:', error);
        if (error.response?.status === 401) {
            localStorage.removeItem('api_token');
            showAuthSection();
        }
        alert(error.response?.data?.message || 'An error occurred');
    }
});
