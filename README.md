# Task Manager API

Простой CRUD на Laravel

## 📮 Примеры запросов

### Получить все задачи
```http
GET /api/tasks
```

### Создать задачу
```http
POST /api/tasks
Content-Type: application/json

{
  "title": "Новая задача",
  "description": "Описание задачи",
  "status": "pending"
}
```

### Обновить задачу
```http
PATCH /api/tasks/1
Content-Type: application/json

{
  "title": "Обновлённая задача"
}
```

### Удалить задачу
```http
DELETE /api/tasks/1
```
