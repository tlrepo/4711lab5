<?php
/**
 * @author Terence
 */

class XML_Model extends Memory_Model
{
        protected $tasks = array();
        
	/**
	 * Constructor.
	 * @param string $origin Filename of the CSV file
	 * @param string $keyfield  Name of the primary key field
	 * @param string $entity	Entity name meaningful to the persistence
	 */
	function __construct($origin = null, $keyfield = 'id', $entity = null)
	{
		parent::__construct();
                
                // guess at persistent name if not specified
		if ($origin == null){
			$this->_origin = get_class($this);
                }
		else{
			$this->_origin = $origin;
                }
                
                // remember the other constructor fields
		$this->_keyfield = $keyfield;
		$this->_entity = $entity;

		// start with an empty collection
		$this->_data = array(); // an array of objects
		$this->fields = array(); // an array of strings
		// and populate the collection
		$this->load();
	}

	/**
	 * Load the collection state appropriately, depending on persistence choice.
	 * OVER-RIDE THIS METHOD in persistence choice implementations
	 */
	protected function load()
	{   
            //load xml
            $tasks = simplexml_load_file($this->_origin);
                
            //load array of field for keys
            foreach($tasks->children() as $field) {
                array_push($this->fields, $field);
            }
            
            //for each task
            foreach ($tasks->children() as $task){     
                // build object from a row
                $record = new stdClass();
                $record->id = (int)$task->id;
                $record->task_name = (string)$task->task_name;
                $record->priority = (int)$task->priority;
                $record->size = (int)$task->size;
                $record->group = (int)$task->group;
                $record->deadline = (int)$task->deadline;
                $record->status = (int)$task->status;
                $record->flag = (string)$task->flag;
                
                //give data appropriate key and value
                $key = $record->{$this->_keyfield};
                $this->_data[$key] = $record;
            }
                
            // --------------------
            // rebuild the keys table
            $this->reindex();
	}

	/**
	 * Store the collection state appropriately, depending on persistence choice.
	 * OVER-RIDE THIS METHOD in persistence choice implementations
	 */
        /*
	protected function store()
	{
		// rebuild the keys table
		$this->reindex();
		//---------------------
		if (($handle = fopen($this->_origin, "w")) !== FALSE)
		{
			fputcsv($handle, $this->_fields);
			foreach ($this->_data as $key => $record)
				fputcsv($handle, array_values((array) $record));
			fclose($handle);
		}
		// --------------------
	}
        */

}
