<?php
namespace iMi\RoboWpcli\Task\Wpcli;

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
class Stack extends CommandStack
{
	/**
	 * @param null|string $pathToWpcli
	 *
	 * @throws \Robo\Exception\TaskException
	 */
	public function __construct($pathToWpcli = null)
	{
		$this->executable = $pathToWpcli;
		if (!$this->executable) {
			$this->executable = $this->findExecutablePhar('wp-cli');
		}
		if (!$this->executable) {
			$this->executable = $this->findExecutablePhar('wp');
		}
		if (!$this->executable) {
			throw new TaskException(__CLASS__, "Neither local wp-cli.phar nor global wp installation could be found.");
		}
	}

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo("Running Wpcli commands...");
        return parent::run();
    }
}
