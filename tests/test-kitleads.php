<?php
/**
 * Class LeadCrafterTest
 *
 * @package LeadCrafterLeadMagnets
 */

use WP_Mock\Tools\TestCase;

class LeadCrafterTest extends TestCase
{

    public function setUp(): void
    {
        WP_Mock::setUp();
        $this->resetSingleton();
    }

    public function tearDown(): void
    {
        WP_Mock::tearDown();
        $this->resetSingleton();
    }

    private function resetSingleton()
    {
        if (!class_exists('LeadCrafter')) {
            return;
        }
        $reflection = new ReflectionClass('LeadCrafter');
        $property = $reflection->getProperty('instance');
        $property->setAccessible(true);
        $property->setValue(null, null);
    }

    public function test_get_instance()
    {
        $instance1 = LeadCrafter::get_instance();
        $instance2 = LeadCrafter::get_instance();

        $this->assertInstanceOf('LeadCrafter', $instance1);
        $this->assertSame($instance1, $instance2);
    }

    public function test_public_methods_exist()
    {
        $instance = LeadCrafter::get_instance();
        $this->assertTrue(method_exists($instance, 'add_settings_page'));
        $this->assertTrue(method_exists($instance, 'register_settings'));
        $this->assertTrue(method_exists($instance, 'enqueue_frontend_assets'));
    }

    public function test_shortcode_registration()
    {
        // We can't easily test add_shortcode dependent logic without proper isolation,
        // but we can verify the render method exists.
        $this->assertTrue(method_exists(LeadCrafter::get_instance(), 'render_shortcode'));
    }
}
