<?php
namespace iMi\RoboWpcli\Task\Wpcli;

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
}
