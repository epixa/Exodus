<?php
/**
 * Epixa - Cards
 */

namespace Exodus\Form;

use Epixa\Form\BaseForm,
    Core\Validator\AlnumUnderscore as AlnumValidator;

/**
 * This form contains all of the base fields for users with their default 
 * requirements.
 * 
 * @category   Module
 * @package    Exodus
 * @subpackage Form
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Cards/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Identity extends BaseForm
{
    public function init()
    {
        $alnumValidator = new AlnumValidator();
        $this->addElement('text', 'username', array(
            'required' => true,
            'label' => 'Username',
            'validators' => array(
                array('StringLength', true, array(1, 15)),
                $alnumValidator
            )
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Retrieve'
        ));
    }
}