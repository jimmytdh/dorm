@echo off
cd /d "%~dp0"  :: Change to the directory where the .bat file is located
echo Adding all changes...
git add .
echo Committing changes with message: "update from bat"
git commit -m "update from bat"
echo Pushing to the remote 'main' branch...
git push origin main
echo Done! Your changes have been pushed to the 'main' branch.
pause
