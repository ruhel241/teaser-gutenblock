# === Teaser Gutenburg Block ===
Contributors: (@adrock42, @hadamlenz)
Tags: wordpress, gutenburg
Requires at least: 4.9
Tested up to: 4.9.2
Stable tag: 4.9.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

![block in the editor](https://github.com/hadamlenz/teaser-gutenblock/blob/master/images/teaser-in-editor.jpg?raw=true "Teaser in the Editor")

## == Description ==
This is a gutenburg block that uses an autocomplete ([react-select](https://github.com/JedWatson/react-select)) to query the WordPress REST API and search for posts.  The post data is returned to a template file so that you can use in-the-loop template functions.  This is still in development and might change drasticly depending on the development of gutenberg. 

## == Prerequisits
1. Until gutenburg is released in core, the [gutenburg](https://wordpress.org/plugins/gutenberg/) plugin in needed
2. Composer for installing the template loader
3. Node.js and NPM for development

## == Installation ==
1. `cd /wp-content/plugins` - change directory to your plugin folder
2. `git clone https://github.com/hadamlenz/teaser-gutenblock` - grab the plugin
3. `cd teaser-gutenblock` - change directory to the plugin folder
4. `composer install` - install the template loader
5. Enable the plugin in the wp-admin plugins

## == Developing == 
This project was bootstrapped with thee excelent [Create Guten Block](https://github.com/ahmadawais/create-guten-block) by Ahmad Awais.  Look there for working with his commands.  You will need Node.js and NPM to download the node_modules and run the building process.  I suggest running `npm install` in the plugin directory to get all of the packages needed to build this project.  The files you will need to edit are in src

## == Templates == 
The aim of this plugin is not to just include a link to another post, but to allow you to theme the content from a post into any other form you wish, creating something a-kin to a newspaper [teaser](http://www.herald.co.zw/teasers-in-newspapers/). It uses Gamajo [Template Loader](https://github.com/GaryJones/Gamajo-Template-Loader) to add a default templates folder to the plugin.  If you wish to create more templates, you should create a folder called "reference-block-templates" in your theme.  Template files should be named block-reference-{description} and should include a header with a "Template Name:" property. 

When creating templates, all of the attributes from the block are available in an object named blockVars on the template.

 ## == Future plans == 
 1. Accepting ideas and issues in the [issues section](https://github.com/hadamlenz/teaser-gutenblock/issues)