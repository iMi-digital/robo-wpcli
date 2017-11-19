<?php
namespace iMi\RoboWpcli\Task\Wpcli;

trait loadTasks
{
    /**
     * @param string $pathToWpcli
     *
     * @return \iMi\RoboWpcli\Task\Wpcli\Stack
     */
    protected function taskWpcliStack($pathToWpcli = null)
    {
        return $this->task(Stack::class, $pathToWpcli);
    }

    protected function taskWpcliExecWithResult($pathToWpcli = null)
    {
        return $this->task(ExecWithResult::class, $pathToWpcli);
    }
}
