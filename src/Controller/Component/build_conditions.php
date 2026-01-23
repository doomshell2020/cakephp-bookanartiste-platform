<?php
/**
 *
 * Build conditions for search
 * @author Geneller Naranjo
 * @version 1.0
 * @license This content is released under the MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 */
namespace App\Controller\Component;

use Cake\Controller\Component;

class BuildConditionsComponent extends Component
{

    function initialize(&$controller) {
        $this->controller =& $controller;
    }

    function startup(&$controller) {}


    /**
     *
     * Funcion que arma las condiciones para los buscadores.
     * Tener cuidado, solo usar para listados que usan el like como comparador.
     * @param Strin $modelName Modelo con las condiciones.
     */
    function buildConditions($modelName) { 
        $conditions = array();
        foreach ($this->controller->data['Search'] as $field => $value) {
            if(!empty($value)) {
                if(substr($field, -3, 3) == '_id') {
                    $conditions["$modelName.$field"] = $value;
                } else {
                    $conditions[] = "$modelName.$field like '$value%'";
                }
                
            }
        }
        return $conditions;
    }

    /**
     *
     * Funcion que arma las condiciones para los buscadores.
     * Tener cuidado, solo usar para listados que usan el like como comparador.
     * Arma las condiciones dependiendo de los campos del formulario.
     */
    function buildComplexConditions() {
        $conditions = array();
        foreach ($this->controller->data['Search'] as $model => $fields) {
            foreach ($fields as $field => $value) {
                if(!empty($value)) {
                    if(substr($field, -3, 3) == '_id') {
                        $conditions["$model.$field"] = $value;
                    } else {
                        $conditions[] = "$model.$field like '$value%'";
                    }
                }
            }
        }
        return $conditions;
    }

}
?>
