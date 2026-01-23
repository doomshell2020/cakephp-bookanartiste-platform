<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {

    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */

    $routes->connect('/', ['controller' => 'Homes', 'action' => 'index']);
    $routes->connect('/login', ['controller' => 'users', 'action' => 'login']);
    $routes->connect('/signup/*', ['controller' => 'users', 'action' => 'signup']);
    $routes->connect('/keep-alive', ['controller' => 'Users', 'action' => 'keepAlive']);
    $routes->connect('/sociallogin', ['controller' => 'users', 'action' => 'sociallogin']);
    $routes->connect('/talent-manager/talent-partners', ['controller' => 'talentadmin', 'action' => 'subadmins']);
    $routes->connect('/talent-partner/upload-profile', ['controller' => 'talentadmin', 'action' => 'refertalent']);
    $routes->connect('/talent-partner/create-talent-partner', ['controller' => 'talentadmin', 'action' => 'addsubadmin']);
    $routes->connect('/talent-partner/upload-profiles', ['controller' => 'talentadmin', 'action' => 'refers']);
    $routes->connect('/saveprofile', ['controller' => 'profile', 'action' => 'savedprofile']);
    $routes->connect('/changepassword', ['controller' => 'users', 'action' => 'changepassword']);
    $routes->connect('/currentlocation', ['controller' => 'users', 'action' => 'currentlocation']);
    $routes->connect('/profile', ['controller' => 'profile', 'action' => 'profile']);
    $routes->connect('/professionalsummary', ['controller' => 'profile', 'action' => 'professionalsummary']);
    $routes->connect('/performance', ['controller' => 'profile', 'action' => 'performance']);
    $routes->connect('/galleries', ['controller' => 'profile', 'action' => 'galleries']);
    $routes->connect('galleries/video', ['controller' => 'profile', 'action' => 'video']);
    $routes->connect('featuredartist', ['controller' => 'homes', 'action' => 'featuredartist']);
    $routes->connect('featuredjob', ['controller' => 'homes', 'action' => 'featuredjob']);
    $routes->connect('calendars', ['controller' => 'calendar', 'action' => 'calendar']);
    $routes->connect('calendars/addtocalendar', ['controller' => 'calendar', 'action' => 'addtocalendar']);
    $routes->connect('showjob/:slug', ['controller' => 'Jobpost', 'action' => 'showJobapplied'], ['pass' => ['slug']]);
    $routes->connect('showjob/selected', ['controller' => 'Jobpost', 'action' => 'showJobselected']);
    $routes->connect('galleries/audio', ['controller' => 'profile', 'action' => 'audio']);
    $routes->connect('jobpost', ['controller' => 'Jobpost', 'action' => 'jobpost']);
    $routes->connect('verify', ['controller' => 'users', 'action' => 'verify']);
    $routes->connect('privacy', ['controller' => 'static', 'action' => 'privacy']);
    $routes->connect('termsandconditions', ['controller' => 'static', 'action' => 'termsandconditions']);
    $routes->connect('/vitalstatistics', ['controller' => 'profile', 'action' => 'vitalstatistics']);
    $routes->connect('/picture', ['controller' => 'profile', 'action' => 'picture']);
    $routes->connect('/banner', ['controller' => 'package', 'action' => 'banner']);
    $routes->connect('/advrtise-my-requirment', ['controller' => 'package', 'action' => 'advrtiseMyRequirment']);
    $routes->connect('/advertiseprofile', ['controller' => 'package', 'action' => 'advertiseprofile']);
    // View Profile
    $routes->connect('/viewprofile/*', ['controller' => 'profile', 'action' => 'viewprofile']);
    $routes->connect('/profiledetails/*', ['controller' => 'profile', 'action' => 'profiledetails']);
    $routes->connect('/viewprofessionalsummary/*', ['controller' => 'profile', 'action' => 'viewprofessionalsummary']);
    $routes->connect('/viewperformance/*', ['controller' => 'profile', 'action' => 'viewperformance']);
    $routes->connect('/myrequirement/*', ['controller' => 'requirement', 'action' => 'requirement']);
    $routes->connect('/viewgalleries/*', ['controller' => 'profile', 'action' => 'viewgalleries']);
    $routes->connect('viewimages/*', ['controller' => 'profile', 'action' => 'viewimages']);
    $routes->connect('viewvideos/*', ['controller' => 'profile', 'action' => 'viewvideos']);
    $routes->connect('viewreviews/*', ['controller' => 'profile', 'action' => 'viewreviews']);
    $routes->connect('viewschedule/*', ['controller' => 'profile', 'action' => 'viewschedule']);
    $routes->connect('viewaudios/*', ['controller' => 'profile', 'action' => 'viewaudios']);
    $routes->connect('forgotpassword', ['controller' => 'users', 'action' => 'forgotpassword']);
    $routes->connect('/viewvitalstatistics/*', ['controller' => 'profile', 'action' => 'viewvitalstatistics']);
    $routes->connect('/personalpage/*', ['controller' => 'profile', 'action' => 'personalpage']);
    $routes->connect('/viewpersonalpage/*', ['controller' => 'profile', 'action' => 'viewpersonalpage']);
    $routes->connect('/imagecrop/*', ['controller' => 'profile', 'action' => 'imagecrop']);
    $routes->connect('/testingalerts/*', ['controller' => 'testingalerts', 'action' => 'index']);
    $routes->connect('allcontacts/*', ['controller' => 'profile', 'action' => 'allcontacts']);
    $routes->connect('savejobs/*', ['controller' => 'search', 'action' => 'savejobresult']);
    //  $routes->connect('myalerts/*', ['controller' => 'myalerts', 'action' =>'alerts']);
    // Packages list
    $routes->connect('/requirementpackage/', ['controller' => 'package', 'action' => 'allpackages', 'requirementpackage'], ['pass' => ['slug']]);
    $routes->connect('/profilepackage/', ['controller' => 'package', 'action' => 'allpackages', 'profilepackage'], ['pass' => ['slug']]);
    $routes->connect('/recruiterepackage/*', ['controller' => 'package', 'action' => 'allpackages', 'recruiterepackage'], ['pass' => ['slug']]);
    Router::connect('/calendarlist/:id', [
        'controller' => 'calendar',
        'action' => 'calendarlist'
    ]);
    $routes->connect('/jobposting/', ['controller' => 'package', 'action' => 'jobposting'], ['pass' => ['slug']]);
    /** * ...and connect the rest of 'Pages' controller's URLs. */

    // Apply Job
    $routes->connect('applyjob/:slug', ['controller' => 'Jobpost', 'action' => 'applyjob'], ['pass' => ['slug']]);
    $routes->connect('/admin', ['controller' => 'Logins', 'action' => 'index', 'admin' => true]);
    //$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    Router::prefix('Admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
    $routes->connect('/test/', ['controller' => 'test', 'action' => 'index']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});






/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();


Plugin::routes('ADmad/HybridAuth', ['path' => '/hybrid-auth'], function ($routes) {
    $routes->connect(
        '/endpoint',
        ['controller' => 'HybridAuth', 'action' => 'endpoint']
    );
    $routes->connect(
        '/authenticated',
        ['controller' => 'HybridAuth', 'action' => 'authenticated']
    );
});
