# search

Creative Commons Search Portal

## Code of Conduct

[`CODE_OF_CONDUCT.md`](CODE_OF_CONDUCT.md):

> The Creative Commons team is committed to fostering a welcoming community.
> This project and all other Creative Commons open source projects are governed
> by our [Code of Conduct][code_of_conduct]. Please report unacceptable
> behavior to [conduct@creativecommons.org](mailto:conduct@creativecommons.org)
> per our [reporting guidelines][reporting_guide].

[code_of_conduct]: https://opensource.creativecommons.org/community/code-of-conduct/
[reporting_guide]: https://opensource.creativecommons.org/community/code-of-conduct/enforcement/

## Contributing

See [`CONTRIBUTING.md`](CONTRIBUTING.md).

## Setting up the Project

Perform the following steps to create a copy of this repository on your local machine:

1. Fork the CC Search Portal repository:

- Log into GitHub (or create a GitHub account and then log into it).

  - Go to the [creativecommons repository](https://github.com/creativecommons/search).
  - Click the **Fork** button at the top of the screen.
  - Choose the user for the fork from the options you are given, usually your GitHub ID.

  A copy of this repository is available in your GitHub account.

2.  Get the string to use when cloning your fork:

    - Click the green "Code" button on the UI page.
    - Select the protocol to use for this clone (either HTTPS or SSH).
    - A box is displayed that gives the URL for the selected protocol.

    Click the icon at the right end of that box to copy that URL.

3.  Clone the forked repository from the shell in a local directory with the **git clone** command, pasting in the URl you saved in the previous step:

    ```
    git clone https://github.com/<UserName>/search.git
    ```

    or

    ```
    git clone git@github.com:<UserName>/search.github.io.git
    ```

    Where <_UserName_> is your GitHub username. The search.github.io directory is now available in the local directory.

4.  Remember to sync your fork with the main branch regularly.

    To Perform the same:-

    Go to GitHub and copy the url of the main creativecommons/search repo:

    ```
    https://github.com/creativecommons/search.git
    ```

    make sure to be in the root folder of the project and the branch should be main branch and type:

    ```
    git remote add upstream https://github.com/creativecommons/search.git
    ```

    Now you have your upstream setup in your local machine, whenever you need to make a new branch for making changes make sure your main branch is in sync with the main repository, to do this, make sure to be in the main branch:

    ```
    git pull upstream main
    git push origin main
    ```

## Docker Compose Setup

Use the following instructions to start the Project with docker compose.

1. Install Docker (https://docs.docker.com/engine/install/)
2. Navigate to the creativecommon/search Project that you have cloned
3. **Run the containers**

   ```
   docker compose up
   ```

4. After running the Above command, Docker will use the docker-compose.yml file and Build a local enivronment for you
5. Navigate to http://localhost:8080 in your browser and the app would be running.
6. **stop the containers**

   To stop the app from running, simply open an another instance of terminal and type

   ```
   docker compose down
   ```

   or

   You can simply revisit the existing terminal which is running the container and type `CTRL + C`

## Deployment

SSH into the **`search`** server and run:

```
cd /var/www/html
sudo git pull
```

## License

### Code

[`LICENSE`](LICENSE): the code within this repository is licensed under the Expat/[MIT][mit] license.

[mit]: http://www.opensource.org/licenses/MIT "The MIT License | Open Source Initiative"

### Content/Text

[![CC BY 4.0 license button][cc-by-png]][cc-by]

The content/text within the project is licensed under a [Creative Commons
Attribution 4.0 International License][cc-by].

[cc-by-png]: https://licensebuttons.net/l/by/4.0/88x31.png#floatleft "CC BY 4.0 license button"
[cc-by]: https://creativecommons.org/licenses/by/4.0/ "Creative Commons Attribution 4.0 International License"
