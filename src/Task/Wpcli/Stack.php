<?php

namespace iMi\RoboWpcli\Task\Wpcli;

use Robo\Exception\TaskException;
use Robo\Task\CommandStack;

/**
 * Runs Wpcli commands in stack. You can use `stopOnFail()` to point that stack should be terminated on first fail.
 *
 * ``` php
 * <?php
 * $this->taskWpcliStack()
 *  ->stopOnFail()
 *  ->exec('db create')
 *  ->run()
 *
 * ?>
 * ```
 */
class Stack extends CommandStack {
    /**
     * Path of wordpress installation
     *
     * @var
     */
    protected $path = 'public';

    /**
     * @param null|string $pathToWpcli
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct( $pathToWpcli = null ) {
        $this->executable = $pathToWpcli;
        if ( ! $this->executable ) {
            $this->executable = $this->findExecutablePhar( 'wp-cli' );
        }
        if ( ! $this->executable ) {
            $this->executable = $this->findExecutablePhar( 'wp' );
        }
        if ( ! $this->executable ) {
            throw new TaskException( __CLASS__, "Neither local wp-cli.phar nor global wp installation could be found." );
        }
    }

    /**
     * Set wordpress path
     *
     * @param $path
     *
     * @return $this
     */
    public function setPath( $path ) {
        $this->path = $path;

        return $this;
    }

    public function exec( $command ) {
        if ( $this->path ) {
            $command = '--path=' . $this->path . ' ' . $command;
        }

        return parent::exec( $command );
    }

    /**
     * {@inheritdoc}
     */
    public function run() {
        $this->printTaskInfo( "Running Wpcli commands..." );

        return parent::run();
    }

    /**
     * Exec Db dump
     *
     * @param $parameters
     */
    public function execDbDump( $parameters ) {
        $this->exec( 'db export --single-transaction --quick ' . $parameters );
    }

    /**
     * Exec human readable dump
     *
     * @param $parameters
     */
    public function execHumanReadableDbDump( $parameters ) {
        $parameters .= '--complete-insert --skip-extended-insert ';
        $this->execDbDump( $parameters );
    }

    public function execSearchReplace($old, $new, $parameters = '--recurse-objects --skip-columns=guid') {
        $this->exec( 'search-replace ' . escapeshellarg($old) . ' ' . escapeshellarg($new) . ' ' . $parameters);
    }

    public function execSearchReplaceBaseUrl($old, $new, $parameters = '--recurse-objects --skip-columns=guid') {
        $old = rtrim($old, '/') . '/';
        $new = rtrim($new, '/') . '/';
        $this->exec( 'search-replace ' . escapeshellarg($old) . ' ' . escapeshellarg($new) . ' ' . $parameters);
    }


}
