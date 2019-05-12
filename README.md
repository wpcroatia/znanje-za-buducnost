# Znanje za buducnost

Theme for the https://znanjezabuducnost.com/ site

## Development and deployment

The development is done and is tested in the `develop` branch of the repository. When a new feature needs to be developed, a `feature/` needs to be created off the `develop` branch.

Once the feature is ready, a PR to `develop` branch needs to be created.

Once a certain set of features is developed, a PR should be created from the `develop` to `master` branch.

Merging to `master` branch will trigger a Travis CI deploy to the test site, where a new feature can be tested.

Every set of features should be listed in the `CHANGELOG.md`, and tagged appropriately using [semver](https://semver.org/)
