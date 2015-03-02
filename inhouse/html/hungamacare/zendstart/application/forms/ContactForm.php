<?php
class ContactForm extends Zend_Form 
{ 
    public function __construct($options = null) 
    { 
        $this->addElementPrefixPath('App', 'App/');
        parent::__construct($options);
        $this->setName('upload');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $description = new Zend_Form_Element_Text('description');
        $description->setLabel('Description')
                  ->setRequired(true)
                  ->addValidator('NotEmpty');

        $file = new App_Form_Element_File('file');
        $file->setLabel('File')
                 ->setRequired(true)
                 ->addValidator('NotEmpty');
             

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Upload');
        
        $this->addElements(array($description, $file, $submit));
            

    } 
} 
?>