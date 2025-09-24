<?php

namespace Tests\Unit;

use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    /**
     * Test the switch method sets the correct locale.
     *
     * @return void
     */
    public function test_switch_sets_locale()
    {
        $controller = new LanguageController();
        
        // Test with English locale
        $response = $controller->switch('en');
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('en', App::getLocale());
        $this->assertEquals('en', Session::get('locale'));
        
        // Test with Urdu locale
        $response = $controller->switch('ur');
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('ur', App::getLocale());
        $this->assertEquals('ur', Session::get('locale'));
        
        // Test with invalid locale (should default to English)
        $response = $controller->switch('invalid');
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('en', App::getLocale());
        $this->assertEquals('en', Session::get('locale'));
    }
}