<?php
namespace iMi\RoboWpcli\Task\Wpcli;

/**
 * Runs Magerun commands  and obtains the result
 */
class ExecWithResult extends Stack
{
    /**
     * Pull command from normal exec stack and execute
     *
     * @param $parameters
     *
     * @return array|string
     */
	public function execAndGetResult($parameters)
	{
        $this->exec($parameters);
        $results = [];

        foreach($this->exec as $exec) {
            $results[] = exec($exec, $result);
        }

		return $results;
	}

	/**
	 * Pass format=json, execute and get decoded json result,
	 * @param $parameters
	 *
	 * @return string
	 */
	public function execAndGetString($parameters)
	{
		$result = $this->execAndGetResult($parameters);
		$result = trim(implode(PHP_EOL, $result));
		return $result;
	}

	/**
	 * Get the currently configured base URL
	 * @return string
	 */
	public function getCurrentBaseUrl()
	{
	    return $this->execAndGetString('option get siteurl');
	}

}
