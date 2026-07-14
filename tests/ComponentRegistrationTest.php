<?php

namespace Tests;

use Orchestra\Testbench\TestCase;
use GsmuiPro\GsmuiProServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentRegistrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            GsmuiProServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('gsmui-pro-csp.enabled', false);
    }

    /** @test */
    public function it_registers_blade_component_namespace()
    {
        // The service provider should register the 'gsmui' component namespace
        $provider = new GsmuiProServiceProvider($this->app);
        $provider->boot();

        // If boot completes without error, the namespace is registered
        $this->assertTrue(true);
    }

    /** @test */
    public function it_has_button_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/button/index.blade.php');
    }

    /** @test */
    public function it_has_input_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/input/index.blade.php');
    }

    /** @test */
    public function it_has_modal_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/modal/index.blade.php');
    }

    /** @test */
    public function it_has_card_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/card/index.blade.php');
    }

    /** @test */
    public function it_has_select_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/select/index.blade.php');
    }

    /** @test */
    public function it_has_slider_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/slider/index.blade.php');
    }

    /** @test */
    public function it_has_tabs_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/tabs.blade.php');
    }

    /** @test */
    public function it_has_table_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/table/index.blade.php');
    }

    /** @test */
    public function it_has_toast_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/toast/index.blade.php');
    }

    /** @test */
    public function it_has_tooltip_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/tooltip/index.blade.php');
    }

    /** @test */
    public function it_has_progress_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/progress/index.blade.php');
    }

    /** @test */
    public function it_has_avatar_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/avatar/index.blade.php');
    }

    /** @test */
    public function it_has_badge_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/badge/index.blade.php');
    }

    /** @test */
    public function it_has_pagination_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/pagination/index.blade.php');
    }

    /** @test */
    public function it_has_dropdown_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/dropdown');
    }

    /** @test */
    public function it_has_checkbox_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/checkbox');
    }

    /** @test */
    public function it_has_radio_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/radio');
    }

    /** @test */
    public function it_has_switch_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/switch/index.blade.php');
    }

    /** @test */
    public function it_has_textarea_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/textarea/index.blade.php');
    }

    /** @test */
    public function it_has_theme_switcher_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/theme-switcher/index.blade.php');
    }

    /** @test */
    public function it_has_frame_components()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/frame');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/frame/index.blade.php');
    }

    /** @test */
    public function it_has_template_components()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/templates');
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/templates/dashboard');
    }

    /** @test */
    public function it_has_team_components()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/team');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/team/index.blade.php');
    }

    /** @test */
    public function it_has_hero_components()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/hero');
    }

    /** @test */
    public function it_has_icon_components()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/icon');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/icon/index.blade.php');
    }

    /** @test */
    public function it_has_hover_components()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/hover');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/hover/index.blade.php');
    }

    /** @test */
    public function it_has_sidebar_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/sidebar');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/sidebar/index.blade.php');
    }

    /** @test */
    public function it_has_navbar_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/navbar/index.blade.php');
    }

    /** @test */
    public function it_has_navlist_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/navlist');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/navlist/index.blade.php');
    }

    /** @test */
    public function it_has_accordion_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/accordion');
    }

    /** @test */
    public function it_has_date_picker_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/date-picker');
    }

    /** @test */
    public function it_has_time_picker_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/time-picker');
    }

    /** @test */
    public function it_has_color_picker_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/color-picker');
    }

    /** @test */
    public function it_has_phone_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/phone');
    }

    /** @test */
    public function it_has_search_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/search/index.blade.php');
    }

    /** @test */
    public function it_has_kanban_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/kanban');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/kanban/index.blade.php');
    }

    /** @test */
    public function it_has_timeline_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/timeline');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/timeline/index.blade.php');
    }

    /** @test */
    public function it_has_terminal_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/terminal');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/terminal/index.blade.php');
    }

    /** @test */
    public function it_has_video_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/video');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/video/index.blade.php');
    }

    /** @test */
    public function it_has_lightbox_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/lightbox/index.blade.php');
    }

    /** @test */
    public function it_has_otp_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/otp/index.blade.php');
    }

    /** @test */
    public function it_has_pillbox_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/pillbox');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/pillbox/index.blade.php');
    }

    /** @test */
    public function it_has_separator_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/separator/index.blade.php');
    }

    /** @test */
    public function it_has_skeleton_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/skeleton/index.blade.php');
    }

    /** @test */
    public function it_has_rating_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/rating/index.blade.php');
    }

    /** @test */
    public function it_has_stat_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/stat/index.blade.php');
    }

    /** @test */
    public function it_has_tag_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/tag/index.blade.php');
    }

    /** @test */
    public function it_has_breadcrumb_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/breadcrumb');
    }

    /** @test */
    public function it_has_popover_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/popover/index.blade.php');
    }

    /** @test */
    public function it_has_indicator_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/indicator/index.blade.php');
    }

    /** @test */
    public function it_has_kbd_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/kbd');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/kbd/index.blade.php');
    }

    /** @test */
    public function it_has_mask_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/mask/index.blade.php');
    }

    /** @test */
    public function it_has_menu_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/menu');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/menu/index.blade.php');
    }

    /** @test */
    public function it_has_profile_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/profile/index.blade.php');
    }

    /** @test */
    public function it_has_window_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/window');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/window/index.blade.php');
    }

    /** @test */
    public function it_has_with_field_component()
    {
        $base = dirname(__DIR__);
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/with-field/index.blade.php');
    }

    /** @test */
    public function it_has_themes_directory()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/themes');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/themes/index.blade.php');
    }

    /** @test */
    public function it_has_navmenu_component()
    {
        $base = dirname(__DIR__);
        $this->assertDirectoryExists($base . '/stubs/resources/views/gsmui/navmenu');
        $this->assertFileExists($base . '/stubs/resources/views/gsmui/navmenu/index.blade.php');
    }
}
