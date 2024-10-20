@echo off
cd /d "%~dp0"  :: Change to the directory where the .bat file is located
echo Fetching latest changes from remote...
git fetch origin
echo Resetting local branch to match remote 'main' branch...
git reset --hard origin/main
echo Pulling latest changes from 'main' branch...
git pull origin main
echo Done! Your local 'main' branch is up-to-date.
pause
