<?php
/**
 * Epixa - Cards
 */

namespace Exodus\Form;

use Epixa\Form\BaseForm,
    Core\Validator\AlnumUnderscore as AlnumValidator,
    Zend_View_Interface as View;

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
        
        $this->getElement('username')->removeDecorator('Errors');
        
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'attribs' => array(
                'class' => 'button'
            ),
            'label' => 'Retrieve'
        ));
    }
    
    /**
     * {@inheritdoc}
     * 
     * In addition, the errors decorator is removed from the username element
     * 
     * @param  null|View $view
     * @return string
     */
    public function render(View $view = null)
    {
        $username = $this->getElement('username');
        if ($username) {
            if ($username->hasErrors()) {
                $this->addError('Please enter a valid twitter username');
            }
            
            $username->removeDecorator('Errors');
        }
        
        return parent::render($view);
    }
}