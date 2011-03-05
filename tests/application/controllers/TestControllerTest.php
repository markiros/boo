<?php

class TestControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch("/test/");
        $this->assertController("test");
        $this->assertAction("index");
        $this->assertResponseCode(200);
    }

    public function testTestingAction()
    {
        $this->dispatch("/test/testing/");
        $this->assertController("test");
        $this->assertAction("testing");
        //$this->assertSetParam('id', 2);
        //$this->assertResponseCode(200);
    }
    
}
