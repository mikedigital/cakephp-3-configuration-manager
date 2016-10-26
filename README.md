# Cake PHP 3 Configuration Manager
Create and manage your configuration settings with an accompanying form. No database needed. I just wanted this to be as easy as possible so we're leveraging nothing but Cake's built in Configuration utility. It will automatically update the configuration file when you edit it as well as timestamp the newest entry.

## Prerequisites
* Cake 3
* Limited patience

## Installation
Download or clone to `plugins/ConfigManager`
Add the following to your `config/bootstrap.php`
Make sure that you include `use Cake\Core\Configure;` at the top of any controllers you are using. This is basic Cake stuff but I've forgotten many times.

```
Plugin::load('ConfigManager', [
  'autoload' => true,
  'bootstrap' => true,
  'routes' => true
]);
```

Create a configuration file at `config/config_manager.php`
There is a sample file in `plugins/ConfigManager/config/config_manager_example.php`

## How To Use
Once setup, you should be able to go to `/config-manager/configs` and see the list of all your settings. Essentially, it's just an array of values you wish to have as configuration variables with editable values. We've developed dozens of sites that require us to have to change these variables so we decided to help ourselves by making this little plugin. We've make it so you can add limited options to a simple array to have an easily usable form for either you or any end user.

Any time you need a config value, just call it using the default Cake way of `Configuration::read('ConfigManager.[key].value');`

## Configuration
All settings are configured through the single config file. Everything is in an array key titled `ConfigManager`. The key to each array option is the name of the value. There is a `value` key that is/are the value(s) you want set. The other options you can set are `type` and `options`. I'll describe those below.

### Types
If you leave the `type` key out, it will default to a string with a regular input box in the editor.

#### List
Adding the type `list` allows you to enter multiple values using new lines as the separator. It will save out as an array.

#### Multi
Adding the type `multi` will allow you to give the end user the ability to choose out of multiple options. Adding to the `options` array will present the user with the list of available ones. They will save to `values` as an array.

#### Select
Adding the type `select` will allow you to show the end users a list of options you can pick one from. It's a dropdown. We all know how dropdown boxes work. All options are stored, you guessed it, in the `options` array. It will save as a single value.

## Conclusion
This is not 100% done and probably needs work. If you see something you'd like to make better, make it better. We're all in this together.