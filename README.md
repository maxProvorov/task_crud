# To Do List API

A simple to do list API built with Laravel.

## 🔐 Authentication

All routes require authentication via a Bearer token.

### Register
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password"
}
```

The response includes `api_token`. Use it in the `Authorization` header:

```
Authorization: Bearer YOUR_API_TOKEN
```

---

## ✅ Tasks

### Get All Tasks
```http
GET /api/tasks
```

### Get a Single Task
```http
GET /api/tasks/1
```

### Create a Task
```http
POST /api/tasks
Content-Type: application/json

{
  "title": "New Task",
  "text": "Task description",
  "tags": [1, 2]
}
```

### Update a Task
```http
PATCH /api/tasks/1
Content-Type: application/json

{
  "title": "Updated Title",
  "tags": [3]
}
```

### Delete a Task
```http
DELETE /api/tasks/1
```

---

## 🏷️ Tags

### Get All Tags
```http
GET /api/tags
```

### Create a Tag
```http
POST /api/tags
Content-Type: application/json

{
  "title": "Urgent"
}
```

### Get a Tag
```http
GET /api/tags/1
```
### Update a Tag
```http
PATCH /api/tags/1
Content-Type: application/json

{
  "title": "Urgent"
}
```

### Delete a Tag
```http
DELETE /api/tags/1
```
## Test API via cURL

### 1. Register a User

```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'
```

### 2. Obtain a Token (Login)
```bash
curl -X POST http://localhost:8000/api/login \
-H "Content-Type: application/json" \
-d '{
"email": "test@example.com",
"password": "password"
}'
```
### 3. Get List of Tasks
```bash
curl -X GET http://localhost:8000/api/tasks \
  -H "Authorization: Bearer your_token" \
  -H "Accept: application/json"
```

### 4. Create a New Task
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer your_token" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "New Task",
    "description": "Task description",
    "status": "pending"
  }'
```
