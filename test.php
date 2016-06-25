<?php
PMVC\Load::plug(['controller'=>'']);
PMVC\addPlugInFolders(['../']);
class FilterTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'filter';
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testToEmail()
    {
        $plug = PMVC\plug($this->_plug);
        $fm = new \PMVC\ActionForm();
        $email = 'ddaaa@gmail.com ';
        $fm['email'] = $email;
        $this->assertTrue($plug->toEmail($fm->email));
        $this->assertEquals($fm['email'], trim($email));
    }

    function testToUsername()
    {
        $plug = PMVC\plug($this->_plug);
        $fm = new \PMVC\ActionForm();
        $username = 'aaa.bbb';
        $fm['username'] = $username;
        $this->assertTrue($plug->toUsername($fm->username));
    }

    function testInvalidUsername()
    {
        $plug = PMVC\plug($this->_plug);
        $fm = new \PMVC\ActionForm();
        $username = 'aaabbb_';
        $fm['username'] = $username;
        $this->assertFalse($plug->toUsername($fm->username));
    }
}
