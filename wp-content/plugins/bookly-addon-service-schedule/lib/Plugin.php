<?php
namespace BooklyServiceSchedule\Lib;

use BooklyServiceSchedule\Backend as Backend;

/**
 * Class Plugin
 * @package BooklyServiceSchedule\Lib
 */
abstract class Plugin extends \Bookly\Lib\Base\Plugin
{
    protected static $prefix;
    protected static $title;
    protected static $version;
    protected static $slug;
    protected static $directory;
    protected static $main_file;
    protected static $basename;
    protected static $text_domain;
    protected static $root_namespace;
    protected static $embedded;

    /**
     * @inheritdoc
     */
    protected static function init()
    {
        // Init ajax.
        Backend\Components\Dialogs\Service\Edit\Ajax::init();

        // Init proxy.
        Backend\Components\Dialogs\Appointment\Edit\ProxyProviders\Local::init();
        Backend\Components\Dialogs\Appointment\Edit\ProxyProviders\Shared::init();
        Backend\Components\Dialogs\Service\Edit\ProxyProviders\Local::init();
        Backend\Components\Dialogs\Service\Edit\ProxyProviders\Shared::init();
        Backend\Modules\Services\ProxyProviders\Shared::init();
        ProxyProviders\Local::init();
    }
}