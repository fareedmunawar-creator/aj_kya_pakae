<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class LanguageSwitchTest extends TestCase
{
    /**
     * Test language switching to English.
     *
     * @return void
     */
    public function test_switch_to_english()
    {
        $response = $this->get('/language/en');
        
        $response->assertStatus(302); // Redirect status
        $this->assertEquals('en', app()->getLocale());
    }

    /**
     * Test language switching to Urdu.
     *
     * @return void
     */
    public function test_switch_to_urdu()
    {
        $response = $this->get('/language/ur');
        
        $response->assertStatus(302); // Redirect status
        $this->assertEquals('ur', app()->getLocale());
    }

    /**
     * Test invalid language fallback to English.
     *
     * @return void
     */
    public function test_invalid_language_fallback()
    {
        $response = $this->get('/language/invalid');
        
        $response->assertStatus(302); // Redirect status
        $this->assertEquals('en', app()->getLocale());
    }
}