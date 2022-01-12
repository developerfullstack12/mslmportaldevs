<?php
namespace BooklyCollaborativeServices\Lib;

/**
 * Class Installer
 * @package BooklyCollaborativeServices\Lib
 */
class Installer extends Base\Installer
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->options = array(
            'bookly_collaborative_hide_staff' => '1',
        );
    }
}