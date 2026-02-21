#!/bin/bash

echo "🚀 Starting CEMS Application..."
echo ""

# Start MySQL container
echo "📦 Starting MySQL container..."
docker-compose up -d

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
sleep 5

# Start Laravel development server
echo "🌐 Starting Laravel development server..."
echo ""
echo "✅ Application ready at: http://localhost:8000"
echo ""
echo "🔑 Test Credentials:"
echo "   Admin: admin@cems.local / password"
echo "   Student: student@cems.local / password"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

php artisan serve
