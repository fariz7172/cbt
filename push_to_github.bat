@echo off
echo ==========================================
echo  Pushing CBT Online to GitHub
echo ==========================================

cd /d "%~dp0"

echo [1/6] Initializing Git...
if not exist .git (
    git init
) else (
    echo Git repository already initialized.
)

echo [2/6] Adding files...
git add .

echo [3/6] Committing changes...
git commit -m "Auto-commit: Prepare for Hostinger deployment"

echo [4/6] Setting up main branch...
git branch -M main

echo [5/6] Configuring remote...
git remote remove origin 2>nul
git remote add origin https://github.com/fariz7172/cbt.git

echo [6/6] Pushing to GitHub...
echo.
echo NOTE: You may be asked to sign in to GitHub in the browser.
echo.
git push -u origin main

echo.
echo ==========================================
if %ERRORLEVEL% EQU 0 (
    echo  SUCCESS! Code pushed to GitHub.
) else (
    echo  ERROR: Failed to push. Please checks errors above.
)
echo ==========================================
pause
