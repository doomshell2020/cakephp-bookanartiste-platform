<?php
namespace App\Controller;

use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use brain\brain;
use brain\Exception;
use Cake\Log\Log;

class DashboardController extends AppController
{
	
	
    public function initialize(){
	parent::initialize();
    }
    
    // Showing Dashboard
    public function index()
    {
    
    }
    
    // A- Showing Visitors Graph
    public function visitors()
    {
    
    }
    
    // B Social Graph
    public function social()
    {
    
    }
    
    // C Showing Work Alerts Graph
    public function workalerts()
    {
    
    }
    
    // D Showing My Requirements Graph
    public function myrequirements()
    {
    
    }
    
    // E Showing Promotions Graph
    public function promotions()
    {
    
    }
    
    // F Showing Ratings Graph
    public function ratings()
    {
    
    }
    
    
    
	
}
