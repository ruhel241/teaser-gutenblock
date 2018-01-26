# === Reference Gutenburg Block ===
Contributors: (@adrock42, @hadamlenz)
Tags: wordpress, gutenburg
Requires at least: 4.9
Tested up to: 4.9.2
Stable tag: 4.9.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

## == Description ==
This is a gutenburg block that uses an autocomplete ([react-select](https://github.com/JedWatson/react-select)) to query the WordPress REST API and search for posts.  This is still in development

## == Prerequisits
1. Until gutenburg is released in core, the [gutenburg](https://wordpress.org/plugins/gutenberg/) plugin in needed
2. Composer
3. Node.js for development

## == Installation ==
1. Download or Clone the Repository
2. Remove .master from the foldr name
3. Put the folder in /wp-content/plugins
4. You will need to run 'composer install' to get the template loader
5. Enable the plugin in the wp-admin plugins

## == Developing == 
This project was bootstrapped with thee excelent [Create Guten Block](https://github.com/ahmadawais/create-guten-block) by Ahmad Awais.  Look there for working with his commands.  You will need Node.js and NPM to build from source.  I suggest running `npm install` in the plugin directory to get all of the packages needed to build this project.  The files you will need to edit are in src.

## == Templates == 
The templates folder holds a template for the reference block.  The aim of this plugin is not to just include the link, but allow you to theme the link into a tout.  Go edit the template and make it work.  All of the attributes from the block are available in an object named blockVars on the template.

 ## == Future plans == 
 1. Ability to change the template in gutenburg