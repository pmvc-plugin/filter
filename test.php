<?php
PMVC\Load::plug();
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
        $email = 'ddaaa@gmail.com ';
        $this->assertTrue($plug->one('Email',[&$email]));
        $this->assertEquals(trim($email), $email);
    }

    function testToEmailPassObject()
    {
        $plug = PMVC\plug($this->_plug);
        $email = 'ddaaa@gmail.com ';
        $this->assertTrue($plug->one('Email',[new \PMVC\Object($email)]));
        $this->assertEquals(trim($email), $email);
    }

    function testToUsername()
    {
        $plug = PMVC\plug($this->_plug);
        $username = 'aaa.bbb';
        $this->assertTrue($plug->one('username',[$username]));
    }

    function testInvalidUsername()
    {
        $plug = PMVC\plug($this->_plug);
        $username = 'aaabbb_';
        $this->assertFalse($plug->one('username',[$username]));
    }

    function testRegularExpression()
    {
        $plug = PMVC\plug($this->_plug);
        $reg = '/()/';
        $this->assertTrue($plug->one('regexp',[$reg]));
    }

    function testInvalidRegularExpression()
    {
        $plug = PMVC\plug($this->_plug);
        $reg = '/~InvalidRegular)Expression~/';
        $this->assertFalse($plug->one('regexp',[$reg]));
        $lastError = 'Compilation failed: unmatched parentheses at offset 15. PREG Fail: [NO_ERROR]';
        $this->assertContains($lastError, $plug['lastError']);
    }

    function testVerifyAll()
    {
        $arr = [
            'max1'=>'22',
            'max3'=>'333',
        ];
        $params = [
            'max1'=>[
                'String',
                'max'=>1
            ],
            'max3'=>[
                'String',
                'max'=>3
            ]
        ];
        $plug = PMVC\plug($this->_plug);
        $actual = $plug->all(
            $arr,
            $params
        ); 
        $expected = [
            'max1'=>false,
            'max3'=>true
        ];
        $this->assertEquals($expected, $actual);
    }
}
