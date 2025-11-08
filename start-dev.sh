#!/bin/bash

# Wardrobe App - Development Setup Script

echo "🚀 Starting Wardrobe Application Development Servers..."

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Backend directory
BACKEND_DIR="/home/infinity/coding/laravel/Uzapoint/Wardrobe"

# Frontend directory
FRONTEND_DIR="/home/infinity/coding/laravel/Uzapoint/wardrobe-FE"

# Function to start backend
start_backend() {
    echo -e "${BLUE}Starting Laravel Backend...${NC}"
    cd "$BACKEND_DIR"
    php artisan serve &
    BACKEND_PID=$!
    echo -e "${GREEN}✓ Backend started on http://127.0.0.1:8000 (PID: $BACKEND_PID)${NC}"
}

# Function to start frontend
start_frontend() {
    echo -e "${BLUE}Starting React Frontend...${NC}"
    cd "$FRONTEND_DIR"
    npm run dev &
    FRONTEND_PID=$!
    echo -e "${GREEN}✓ Frontend started on http://localhost:5173 (PID: $FRONTEND_PID)${NC}"
}

# Trap CTRL+C to stop both servers
trap ctrl_c INT

function ctrl_c() {
    echo -e "\n${BLUE}Shutting down servers...${NC}"
    kill $BACKEND_PID 2>/dev/null
    kill $FRONTEND_PID 2>/dev/null
    echo -e "${GREEN}✓ Servers stopped${NC}"
    exit 0
}

# Start both servers
start_backend
sleep 2
start_frontend

echo -e "\n${GREEN}========================================${NC}"
echo -e "${GREEN}🎉 Both servers are running!${NC}"
echo -e "${GREEN}========================================${NC}"
echo -e "Backend:  ${BLUE}http://127.0.0.1:8000${NC}"
echo -e "Frontend: ${BLUE}http://localhost:5173${NC}"
echo -e "API:      ${BLUE}http://127.0.0.1:8000/api${NC}"
echo -e "\n${BLUE}Press CTRL+C to stop both servers${NC}\n"

# Wait for user to press CTRL+C
wait
