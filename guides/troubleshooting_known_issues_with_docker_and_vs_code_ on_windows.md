# Troubleshooting known issues with Docker and VS Code on Windows
This guide will suggest possible solutions to known issues contributors might face when setting up Docker and VC Code on windows. The guide assumes that you have already followed the instructions ([here](https://github.com/creativecommons/search#readme))

## #1 Docker Desktop Stopped 
This often occur immediately after fresh installations :

- Ensure you restart your system after installation

- Ensure you used the WSL 2 option on the Configuration page, only use Hper-V if you are very sure of you choice.

([Ensure WSL 2 is installed on your computer ](https://learn.microsoft.com/en-us/windows/wsl/install))
- Ensure you are running Docker as an administrator 

- Ensure you restart you system after any of  these processes 

## #2 Configuration not found when running "docker compose build"
This error might occur when you trying to run the “`docker compose build“` outside your project folder :

- Navigate to the absolute path of your project using "CD" command then run the "docker compose build" command

## #3 Docker Desktop failed to start 

- Uninstall Docker Desktop

- Restart computer

- Install Docker Desktop with Admin right
