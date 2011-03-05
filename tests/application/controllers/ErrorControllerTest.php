<?php

class ErrorControllerTest extends ControllerTestCase
{
    public function testErrorAction()
    {
        $this->dispatch('/404');
        $this->assertModule('boo');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(404);
    }

}
