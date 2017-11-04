<?php
// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase') &&
    class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', 'PHPUnit\Framework\TestCase');
}

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2017-11-04
 * Time: 1:50 PM
 */

class TaskListTest extends PHPUnit_Framework_TestCase{
    private $CI;

    public function setUp() {
        $this->CI = &get_instance();
    }

    public function testNumberOfTasks() {
        $tasks = $this->CI->tasks->all();
        $countIncompleteTasks = 0;
        $countCompleteTasks = 0;

        foreach ($tasks as $task) {
            // Check if the task is not complete
            if ($task->status != 2)
                $countIncompleteTasks++;
            else
                $countCompleteTasks++;
        }

        /* Check if the number of incomplete tasks is greater than the number
           of complete tasks */
        $this->assertGreaterThan($countCompleteTasks, $countIncompleteTasks);
    }
}