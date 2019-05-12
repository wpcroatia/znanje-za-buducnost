
# Change Log for the Eightshift WordPress Boilerplate
All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](https://semver.org/) and [Keep a CHANGELOG](https://keepachangelog.com/).

## [Unreleased]

_No documentation available about unreleased changes as of yet._

## [4.0.0] - TBA
### Added
- Implementing Eightshift-libs
- Updating docs
- Adding type hinting
- Updating npm packages
- New file for shortcodes
- New file for manifest
- Complete webpack config refactoring


### Changed
- Changing folder structure to src
- 

### Removed
- Removing a lot of stuff that is not part of boilerplate like utilities and some hooks and implementations
- Removed general helper
- Removed object helper
- Removed Media implementations of svg upload
- Unecesery Javascrip files

## [3.0.1] - 2019-04-23

### Added

- Added code of conduct
- Minor phpcs fixes
- Added changelog
- Added widget class
- Minor updates to setup script
- Added flex grid mixin

### Changed

- phpcs.xml.dist ruleset name change
- Refactored scss assets
- Minor refactor in excerpt class

### Removed

- Remove jQuery override so that the theme obey wordpress.org rules

### Fixed

- Minor webpack config fix

## [3.0.0] - 2019-01-03

### Added

- Added setup wizard guide for easier theme setup

### Changed

- Travis update
- phpcs fixes
- Renamed Infinum -> Eightshift, since that is our new brand
- Updates in package.json and composer.json
- phpcs.xml.dist updates
- Added husky for precommit scripts
- Added object helper
- Cleaned assets

### Deprecated

- Boilerplate acts as a standalone theme now

### Removed

- Replaced `file_get_contents` with `file` (for support)

### Fixed

## [2.1.1] - 2018-05-03

### Added

- Travis integration
- Issue and contributing template
- Change color admin based on the environment (dev, staging, production)
- Added phpcs.xml.dist for the project
- Added validate xml helper for svg uploads
- Added lazy loading images feature

### Changed

- License update
- Small codebase changes
- Changes in @since tags

### Removed

- ACF functionality from the boilerplate
- jQuery webpack exposing due to admin issues

### Fixed

- Autoloader path fix
- Fixed setup script
- Fixed rename script
- Minor phpcs fixes

### Security

## [2.0.1] - 2018-02-07

### Added

- Locale class for translation handling
- Assets cache busting

### Changed

- Updated readme
- Updated eslintrc
- Updated stylelintrc
- Updated .gitignore
- Updated coding standards, added composer scripts

### Removed

- Removed ACF class from the boilerplate
- Removed unnecessary register_global_theme_options_variable method that set global variable

## [2.0.0] - 2018-01-19

This build is a breaking change in comparison to v1.0.0 (procedural -> OOP)

### Added

- Added namespaces, autoloader, webpack 3+
- Added import/export scripts
- Added project setup script
- Added util class
- Added ACF class
- Added theme options and helpers

### Changed

- Changed codebase to OOP
- Readme update
- Updated documentation
- .gitignore file update
- Asset update

### Deprecated

- Removed procedural code and updated the codebase to OOP

### Removed

- Removed jQuery from WP (used webpack to bundle it)

### Fixed

- Rename scripts minor fix with theme package name (shell script)
- Indentation fix

## [1.0.0] - 2018-01-03

Initial tagged release.

[Unreleased]: https://github.com/infinum/wp-boilerplate/compare/master...HEAD
[3.0.1]: https://github.com/infinum/wp-boilerplate/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/infinum/wp-boilerplate/compare/2.1.1...3.0.0
[2.1.1]: https://github.com/infinum/wp-boilerplate/compare/2.0.1...2.1.1
[2.0.1]: https://github.com/infinum/wp-boilerplate/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/infinum/wp-boilerplate/compare/1.0.0...2.0.0
[1.0.0]: https://github.com/infinum/wp-boilerplate/compare/26115acf804876208a03dc39298b70476dcc780f...1.0.0
