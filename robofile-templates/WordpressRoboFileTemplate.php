<?php

// INSERT: IROBO_BOILERPLATE //

class RoboFile extends \Robo\Tasks {
    use \iMi\RoboPack\LoadTasks;

    /**
     * It is important to stop execution if there was an error
     */
    public function __construct() {
        $this->stopOnFail();
    }

    /**
     * Project setup
     */
    public function setup()
    {
        $data = $this->askSetup();
        $this->_writeWpConfigFile($data);
        $this->dbReplace('master.sql', $data['baseUrl']);
    }

    public function updateBaseUrl($newBase = null)
    {
        if ($newBase == null) {
            $newBase = $this->askBaseUrl();
        }
        $currentBase = $this->taskWpcliExecWithResult()->getCurrentBaseUrl();
        $this->taskWpcliStack()->execSearchReplaceBaseUrl($currentBase, $newBase)->run();
    }

    public function dbReplace($fileName = 'master.sql', $baseUrlToSet = null)
    {
        if (!$baseUrlToSet) {
            $baseUrlToSet = $this->taskWpcliExecWithResult()->getCurrentBaseUrl();
        }
        $this->say('Preserving base URL: ' . $baseUrlToSet);
        $this->_wp('db import sql/' . $fileName);
        $this->updateBaseUrl($baseUrlToSet);
    }

    /**
     * Dump DB to Master
     */
    public function dbDump($fileName = 'master.sql') {

        $this->taskWpcliStack()->execHumanReadableDbDump( 'sql/' . $fileName, true)->run();
    }

    public function setupDev()
    {
        $this->_wp('wp user create dev_admin dev_admin@example.com --role=administrator --user_pass=dev');
    }

    /**
     * Update the project
     */
    public function update()
    {
        $this->taskGitStack()
             ->pull()->run();
    }
}
