Robo Wrapper for WP-CLI
============================

This is  wrapper around WP-CLI for using it in the
Robo task runner.

## Wordpress installation folder

The package assumes that wordpress is installed in the `public` sub folder.
If this is not the case, use

    $this->taskWpcliStack()->setPath('')->exec($command)->run();

## Template

The package contains a robofile template with database import, export and preserving the site url during the database
import.

## Commands

### Execute wpcli

    $this->taskWpcliStack()->exec($command)->run();
    
Shortcut for the above:
    
    $this->_wp($command);
 
### Write wp-config File

Writes the wp-config file with the values from the setup.
Of course you can add additional mappings as a secound parameter.

Currently RegExp replacing is done.  Sooner or later we might use  https://github.com/nordcode/robo-parameters
for this task (which does not keep comments, that's why we use the own method)
 
    $this->_writeWpConfigFile($this->askSetup());
    
### Get current base URL 

    $currentBase = $this->taskWpcliExecWithResult()->getCurrentBaseUrl();
    
    
### Replace base URL

This is done via wp cli, search and replace functionality.

    $this->taskWpcliStack()->execSearchReplaceBaseUrl($currentBase, $newBase)->run();


