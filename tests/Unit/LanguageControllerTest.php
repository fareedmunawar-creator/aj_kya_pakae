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
        
        // Mock the request and session
        $this->mock(Request::class, function ($mock) {
            $mock->shouldReceive('back')->once()->andReturn(response());
        });
        
        // Test with English locale
        $controller->switch('en');
        $this->assertEquals('en', App::getLocale());
        $this->assertEquals('en', Session::get('locale'));
        
        // Test with Urdu locale
        $controller->switch('ur');
        $this->assertEquals('ur', App::getLocale());
        $this->assertEquals('ur', Session::get('locale'));
        
        // Test with invalid locale (should default to English)
        $controller->switch('invalid');
        $this->assertEquals('en', App::getLocale());
        $this->assertEquals('en', Session::get('locale'));
    }
}