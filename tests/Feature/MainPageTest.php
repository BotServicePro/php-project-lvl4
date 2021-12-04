<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMainIndex()
    {
        $response = $this->get('/');
        $response->assertOk();
    }
}
