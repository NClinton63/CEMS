# CEMS API Documentation

Base URL: `http://localhost:8000/api`

## Authentication

All authenticated endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## Authentication Endpoints

### Register User
**POST** `/auth/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "role": "student"
}
```

**Response (201):**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": "uuid",
    "name": "John Doe",
    "email": "john@example.com",
    "role": "student"
  },
  "token": "access_token_here"
}
```

---

### Login
**POST** `/auth/login`

**Request Body:**
```json
{
  "email": "admin@cems.local",
  "password": "password"
}
```

**Response (200):**
```json
{
  "message": "Login successful",
  "user": {
    "id": "uuid",
    "name": "Admin User",
    "email": "admin@cems.local",
    "role": "administrator"
  },
  "token": "access_token_here"
}
```

---

### Logout
**POST** `/auth/logout`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "message": "Logged out successfully"
}
```

---

### Refresh Token
**POST** `/auth/refresh`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "message": "Token refreshed successfully",
  "token": "new_access_token_here"
}
```

---

### Get Current User
**GET** `/auth/me`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "user": {
    "id": "uuid",
    "name": "Admin User",
    "email": "admin@cems.local",
    "role": "administrator"
  }
}
```

---

## Event Endpoints

### List Events
**GET** `/events`

**Query Parameters:**
- `search` - Search in title and description
- `category` - Filter by category
- `organizer_id` - Filter by organizer
- `page` - Page number (default: 1)

**Response (200):**
```json
{
  "data": [
    {
      "id": "uuid",
      "title": "Campus Event 1",
      "description": "Event description",
      "start_time": "2024-02-15T10:00:00Z",
      "end_time": "2024-02-15T12:00:00Z",
      "location": "Main Auditorium",
      "location_type": "physical",
      "capacity": 50,
      "category": "Workshop",
      "status": "published",
      "organizer": {
        "id": "uuid",
        "name": "Admin User"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 10
  }
}
```

---

### Get Event Details
**GET** `/events/{id}`

**Response (200):**
```json
{
  "event": {
    "id": "uuid",
    "title": "Campus Event 1",
    "description": "Event description",
    "start_time": "2024-02-15T10:00:00Z",
    "end_time": "2024-02-15T12:00:00Z",
    "location": "Main Auditorium",
    "location_type": "physical",
    "capacity": 50,
    "category": "Workshop",
    "status": "published",
    "organizer": {
      "id": "uuid",
      "name": "Admin User"
    }
  },
  "available_spots": 45,
  "is_full": false
}
```

---

### Create Event
**POST** `/events`

**Headers:** `Authorization: Bearer {token}` (Administrator only)

**Request Body:**
```json
{
  "title": "New Workshop",
  "description": "Workshop description",
  "start_time": "2024-03-01T14:00:00",
  "end_time": "2024-03-01T16:00:00",
  "location": "Room 101",
  "location_type": "physical",
  "capacity": 30,
  "category": "Workshop",
  "status": "published"
}
```

**Response (201):**
```json
{
  "message": "Event created successfully",
  "event": {
    "id": "uuid",
    "title": "New Workshop",
    ...
  }
}
```

---

### Update Event
**PUT** `/events/{id}`

**Headers:** `Authorization: Bearer {token}` (Administrator/Organizer only)

**Request Body:** (all fields optional)
```json
{
  "title": "Updated Title",
  "capacity": 40,
  "status": "published"
}
```

**Response (200):**
```json
{
  "message": "Event updated successfully",
  "event": {
    "id": "uuid",
    ...
  }
}
```

---

### Delete Event
**DELETE** `/events/{id}`

**Headers:** `Authorization: Bearer {token}` (Administrator/Organizer only)

**Response (200):**
```json
{
  "message": "Event deleted successfully"
}
```

---

### Get My Events
**GET** `/my-events`

**Headers:** `Authorization: Bearer {token}` (Administrator only)

**Response (200):**
```json
{
  "data": [
    {
      "id": "uuid",
      "title": "My Event",
      ...
    }
  ]
}
```

---

## Registration Endpoints

### Register for Event
**POST** `/events/{id}/register`

**Headers:** `Authorization: Bearer {token}`

**Response (201):**
```json
{
  "message": "Successfully registered for event",
  "registration": {
    "id": "uuid",
    "user_id": "uuid",
    "event_id": "uuid",
    "status": "registered",
    "event": {
      "title": "Campus Event 1",
      ...
    }
  }
}
```

---

### Cancel Registration
**DELETE** `/events/{id}/register`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "message": "Registration cancelled successfully"
}
```

---

### Get My Registrations
**GET** `/my-registrations`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
  "data": [
    {
      "id": "uuid",
      "status": "registered",
      "created_at": "2024-01-15T10:00:00Z",
      "event": {
        "id": "uuid",
        "title": "Campus Event 1",
        ...
      }
    }
  ]
}
```

---

### Get Event Registrations
**GET** `/events/{id}/registrations`

**Headers:** `Authorization: Bearer {token}` (Administrator/Organizer only)

**Response (200):**
```json
{
  "data": [
    {
      "id": "uuid",
      "status": "registered",
      "created_at": "2024-01-15T10:00:00Z",
      "user": {
        "id": "uuid",
        "name": "Student User",
        "email": "student@cems.local"
      }
    }
  ]
}
```

---

### Mark Attendance
**POST** `/events/{id}/attendance`

**Headers:** `Authorization: Bearer {token}` (Administrator/Organizer only)

**Request Body:**
```json
{
  "user_id": "uuid"
}
```

**Response (200):**
```json
{
  "message": "Attendance marked successfully",
  "registration": {
    "id": "uuid",
    "status": "attended",
    "attended_at": "2024-01-15T14:30:00Z"
  }
}
```

---

## Error Responses

### 400 Bad Request
```json
{
  "message": "Validation error",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
  "message": "This action is unauthorized."
}
```

### 404 Not Found
```json
{
  "message": "Resource not found."
}
```

### 422 Unprocessable Entity
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "capacity": ["The capacity must be at least 1."]
  }
}
```

### 500 Internal Server Error
```json
{
  "message": "Server error occurred."
}
```

---

## Rate Limiting

API endpoints are rate-limited to:
- **60 requests per minute** for authenticated users
- **30 requests per minute** for guest users

Rate limit headers:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
```

---

## Pagination

List endpoints return paginated results:

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15, max: 100)

**Response Structure:**
```json
{
  "data": [...],
  "links": {
    "first": "url",
    "last": "url",
    "prev": null,
    "next": "url"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 15,
    "to": 15,
    "total": 75
  }
}
```

---

## Status Codes

- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Unprocessable Entity
- `500` - Internal Server Error
