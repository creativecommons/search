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


## Development


### Setting up the Project

For information on learning and installing the prerequisite technologies for this project, please see [Foundational technologies — Creative Commons Open Source][found-tech].

[found-tech]: https://opensource.creativecommons.org/contributing-code/foundational-tech/

### Docker Compose Setup

Use the following instructions to start the Project with docker compose.

1. Navigate to the creativecommon/search Project that you have cloned
2. **Run the containers**

   ```shell
   docker compose up
   ```

3. After running the Above command, Docker will use the docker-compose.yml file
   and Build a local enivronment for you
4. Navigate to http://localhost:8080 in your browser and the app would be
   running.
5. **stop the containers**

   To stop the app from running, simply open an another instance of terminal
   and type

   ```shell
   docker compose down
   ```

   or

   You can simply revisit the existing terminal which is running the container
   and type `CTRL + C`


### Format with Prettier
Run the following command to format files with Prettier:
```shell
docker compose exec node prettier --write src/
```


## License


### Code

[`LICENSE`](LICENSE): the code within this repository is licensed under the
Expat/[MIT][mit] license.

[mit]: http://www.opensource.org/licenses/MIT "The MIT License | Open Source Initiative"


### Content/Text

[![CC BY 4.0 license button][cc-by-png]][cc-by]

The content/text within the project is licensed under a [Creative Commons
Attribution 4.0 International License][cc-by].

[cc-by-png]: https://licensebuttons.net/l/by/4.0/88x31.png#floatleft "CC BY 4.0 license button"
[cc-by]: https://creativecommons.org/licenses/by/4.0/ "Creative Commons Attribution 4.0 International License"
