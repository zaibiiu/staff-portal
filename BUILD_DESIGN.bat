@echo off
echo ========================================
echo   Building Modern Design Assets
echo ========================================
echo.

echo [1/4] Installing dependencies...
call npm install
echo.

echo [2/4] Building assets...
call npm run build
echo.

echo [3/4] Clearing caches...
call php artisan optimize:clear
call php artisan filament:cache-components
echo.

echo [4/4] Done!
echo.
echo ========================================
echo   Design Build Complete!
echo ========================================
echo.
echo Your Staff Portal now has a beautiful modern design!
echo.
echo To start the server, run:
echo   php artisan serve
echo.
echo Then visit: http://localhost:8000/admin
echo.
pause
