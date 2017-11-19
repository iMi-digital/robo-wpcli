<?php
namespace iMi\RoboWpcli\Task\Wpcli;

use Robo\Task\File\Replace;
use Robo\Task\Filesystem\FilesystemStack;

trait loadShortcuts
{
    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _wp($action)
    {
        return $this->taskWpcliStack()->exec($action)->run();
    }

    protected function _writeWpConfigFile(
        $data,
        $mapVariablesToValues = [
            'dbName'     => 'DB_NAME',
            'dbHost'     => 'DB_HOST',
            'dbUser'     => 'DB_USER',
            'dbPassword' => 'DB_PASSWORD',
        ]
    ) {
        $fileSystemTask = $this->task( FilesystemStack::class );
        $fileSystemTask->copy( 'public/wp-config-sample.php', 'public/wp-config.php' )->run();
        foreach ( $mapVariablesToValues as $dataKey => $configKey ) {
            $value = isset( $data[ $dataKey ] ) ? $data[ $dataKey ] : '';
            $replaceTask = $this->task( Replace::class, 'public/wp-config.php' );
            $replaceTask->regex("/define\('$configKey', '.+'\);/")->to("define('$configKey', '$value');")->run();
        }
    }
}
