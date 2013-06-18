<?php

namespace ZfcUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;

class Base extends ProvidesEventsForm
{
    public $sm; 
    
    public function __construct()
    {
        
        parent::__construct();

        $acl = $this->sm->get('BjyAuthorize\Service\Authorize');
        
        $this->add(array(
            'name' => 'username',
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        
        $this->add(array(
            'name' => 'f_name',
            'options' => array(
                'label' => 'First name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name' => 'l_name',
            'options' => array(
                'label' => 'Last name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Display Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        
        if($acl->isAllowed('user_role','change')) {
           
            $this->add(array(
                'name'=>'role_id',
                'type'=>'Zend\Form\Element\Select',
                'options'=>array(
                    'label'=>'Role',
                    'value_options'=> $this->sm->get('drop_down')->getRoles()
                ),
                'attributes'=> array('type'=>'select')
            ));
            
            
        }
        
        $this->add(array(
            'name'=>'job_function_id',
            'type'=>'Zend\Form\Element\Select',
            'options'=>array(
                'label'=>'Job Function Type',
                'value_options'=> $this->sm->get('drop_down')->getJobTypes()
            ),
            'attributes'=> array('type'=>'select')
        ));
        
        $this->add(array(
            'name' => 'title',
            'options' => array(
                'label' => 'Job Title',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name' => 'company',
            'options' => array(
                'label' => 'Company',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        
   
        

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'label' => 'Password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));
        
        $this->add(array(
            'name' => 'passwordVerify',
            'options' => array(
                'label' => 'Password Verify',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));
        
        
        $this->add(array(
            'name' => 'address1',
            'type' =>'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Address',
            ),
            'attributes' => array(
                'type' => 'textarea'
            ),
        ));
        
        
        $this->add(array(
            'name' => 'zip',
            'options' => array(
                'label' => 'Zip Code',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name'=>'state_province_code',
            'type'=>'Zend\Form\Element\Select',
            'options'=>array(
                'label'=>'State Province Code',
                'value_options'=> $this->sm->get('drop_down')->getStateCodes()
            ),
            'attributes'=> array('type'=>'select')
        ));
         
        
        $this->add(array(
            'name'=>'country_code',
            'type'=>'Zend\Form\Element\Select',
            'options'=>array(
                'label'=>'Country Code',
                'value_options'=> $this->sm->get('drop_down')->getCountryCodes()
            ),
            'attributes'=> array('type'=>'select')
        ));
         
        


        
     $this->add(array(
         'name'=>'business_type_id',
         'type'=>'Zend\Form\Element\Select',
         'options'=>array(
             'label'=>'Business Type',
             'value_options'=> $this->sm->get('drop_down')->getBusinessTypes()
     ),
         'attributes'=> array('type'=>'select')
     ));   
     
     
   
        
        if ($this->getRegistrationOptions()->getUseRegistrationFormCaptcha()) {
            $this->add(array(
                'name' => 'captcha',
                'type' => 'Zend\Form\Element\Captcha',
                'options' => array(
                    'label' => 'Please type the following text',
                    'captcha' => $this->getRegistrationOptions()->getFormCaptchaOptions(),
                ),
            ));
        }

      /*   $submitElement = new Element\Button('submit');
        $submitElement
            //->setLabel('Submit')
            ->setAttributes(array(
                'type'  => 'submit',
            )); */
            
    

        $this->add(array(
        
            'name'=>'submit',
        
            'attributes'=>array('type'=>'submit','value'=>'Register'),
        
        
        ), array(
            'priority' => -100,
        ));

        $this->add(array(
            'name' => 'userId',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        // @TODO: Fix this... getValidator() is a protected method.
        //$csrf = new Element\Csrf('csrf');
        //$csrf->getValidator()->setTimeout($this->getRegistrationOptions()->getUserFormTimeout());
        //$this->add($csrf);
    }
}
