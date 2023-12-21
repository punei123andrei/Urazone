== Description ==

This plugin creates a custom WordPress page to display an HTML table listing users fetched from the JSONPlaceholder API. The table includes user details such as ID, name, and username. Clicking on any user's details triggers an request to the API's "user details" endpoint, showing the details without reloading the page.

* Contributors: Andrei Punei
* Tags: wordpress, plugin, JSONPlaceholder, API
* Requires at least: 5.0
* Tested up to: 6.4
* Stable tag: trunk
*

== Requirements ==

- [Composer](https://getcomposer.org/doc/00-intro.md)
- [Node.js](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)

== Setup ==

1. Run `composer install` to setup the files needed for namespacing and testing
2. run `npm install` to setup the files needed for compiling scripts
3. run `npm run start` for compilation process
3. run `npm run build` to build the files for production which will be found in `/dist/` folder

== Frequently Asked Questions ==

= How does the plugin fetch user data? =

The plugin makes HTTP requests from the server-side (PHP) to the JSONPlaceholder API (/users endpoint) to fetch user data.

= Can I customize the endpoint URL and data retrieval? =

Yes, you can customize the endpoint URL and choose the data to retrieve. Visit the plugin's settings page in the WordPress admin dashboard to set your preferred endpoint URL and configure the number of users to import, along with other custom data.

Note: The default endpoint URL is set as `https://jsonplaceholder.typicode.com` in the file `src/Ajax/ApiBase.php`.

== File structure ==

You can add your own new class files by naming them correctly and putting the files in the most appropriate location,
see other files for examples. Composer's Autoloader will include the class and you can instantiate it via inpsyde.php.

```
## First level files
├── urazone.php                   # Main entry file for the plugin
├── composer.json                 # Composer dependencies & scripts
├── package.json                  # (incl. when using webpack) Node.js dependencies & scripts (NPM functions)

## Folders
├── src                           # Holds all the plugin PHP classes
│   ├── Ajax                      # Holds the plugin AJAX request functionality
│   │   ├── AjaxRequest.php       # Processes AJAX requests to the API based on definitions
│   │   ├── ApiBase.php           # The API information for getting the users list
│   │   └── RequestHelper.php     # Class for caching or getting the data from the API
│   ├── RequestDefinitions        # Contains definitions to be executed by AJAX requests
│   │   ├── RequestDefinition.php # Defines the interface that will be implemented by request entities
│   │   ├── DefinitionSingleUsers.php # Defines the Single User entity
│   │   └── DefinitionUsersList.php   # Defines the Users List entity
│   ├── Setup                      # Contains all the classes needed for the setup
│   │   ├── Setup.php              # Plugin setup hooks (enqueue, localize, addOptionPage)
│   │   ├── Activation.php         # Runs hooks upon activating the plugin
│   │   ├── Deactivate.php         # Runs hooks upon deactivating the plugin
│   │   └── OptionsHelper.php      # Adds an option for the API base
├── assets                        # Holds source assets
│   ├── index.js                  # Main index for including modules
│   ├── css                       # Holds files for styling the plugin content
│   │   └── style.css             # Main file for styling content
│   ├── modules
│   │   ├── PrintHtml.php         # Class that prints HTML based on the request
│   │   └── Request.php           # Handles AJAX requests
└── build                         # WordPress default language map in Plugins & Themes
    ├── index.js                  # Compiled JS files will be generated here
    ├── index.js.map              # Responsible for mapping JS logic
    ├── style.index.css           # Compiled CSS files will be generated here
    └── style.index.css.map       # Responsible for mapping CSS logic
```

== Development and Testing Dependencies ==

1. roave/security-advisories: It helps ensure that project's dependencies do not have known security vulnerabilities.

2. phpcompatibility/phpcompatibility-wp: It helps ensure that plugin is compatible with the targeted WordPress version.

3. phpunit/phpunit: Tests are essential for ensuring the correctness and stability of your plugin.

4. brain/monkey: It helps create isolated unit tests for code without relying on a full WordPress environment.


