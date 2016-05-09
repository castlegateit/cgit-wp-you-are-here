<?php

namespace Cgit;

class YouAreHere
{
    /**
     * Singleton instance
     *
     * @var YouAreHere
     */
    private static $instance;

    /**
     * Default CSS
     *
     * @var array
     */
    private $css = [
        'background' => '#c33',
        'border-radius' => '4px',
        'color' => '#fff',
        'font-family' => 'sans-serif',
        'font-size' => '12px',
        'font-style' => 'normal',
        'font-weight' => 'normal',
        'padding' => '10px 15px',
        'position' => 'fixed',
        'transition' => 'opacity 400ms ease',
        'z-index' => '9999',
    ];

    /**
     * Private constructor
     *
     * @return void
     */
    private function __construct()
    {
        // Environment message must be defined
        if (!defined('CGIT_YOU_ARE_HERE')) {
            return;
        }

        // Additional criteria to show message
        $conditions = apply_filters('cgit_you_are_here_conditions', []);

        foreach ($conditions as $condition) {
            if (!$condition()) {
                return;
            }
        }

        // Set CSS
        $this->setColors();
        $this->setPosition();

        // Filter CSS
        $this->css = apply_filters('cgit_you_are_here_css', $this->css);

        // Add message and CSS
        add_action('wp_head', [$this, 'head']);
        add_action('wp_footer', [$this, 'footer']);
        add_action('admin_head', [$this, 'head']);
        add_action('admin_footer', [$this, 'footer']);
    }

    /**
     * Return instance
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Add styles to head
     *
     * @return void
     */
    public function head()
    {
        ?>
        <style>

            .cgit-wp-you-are-here {
                <?= $this->getCss() ?>
            }

            .cgit-wp-you-are-here:hover {
                cursor: default;
                opacity: 0.25;
            }

        </style>
        <?php
    }

    /**
     * Add message to footer
     *
     * @return void
     */
    public function footer()
    {
        ?>
        <div class="cgit-wp-you-are-here"><?= CGIT_YOU_ARE_HERE ?></div>
        <?php
    }

    /**
     * Set colours
     *
     * @return void
     */
    private function setColors()
    {
        if (defined('CGIT_YOU_ARE_HERE_BACKGROUND')) {
            $this->css['background-color'] = CGIT_YOU_ARE_HERE_BACKGROUND;
        }

        if (defined('CGIT_YOU_ARE_HERE_COLOR')) {
            $this->css['color'] = CGIT_YOU_ARE_HERE_COLOR;
        }
    }

    /**
     * Set position
     *
     * @return void
     */
    private function setPosition()
    {
        // Default position in bottom right corner
        if (!defined('CGIT_YOU_ARE_HERE_POSITION')) {
            $this->css['right'] = '20px';
            $this->css['bottom'] = '20px';

            return;
        }

        // Custom position
        $pos = CGIT_YOU_ARE_HERE_POSITION;

        // Make sure custom position is an array
        if (!is_array($pos)) {
            $pos = explode(' ', $pos);
        }

        // Positions can only have two offsets, e.g. "top left"
        $pos = array_slice($pos, 0, 2);

        // Add positions to CSS
        foreach ($pos as $key) {
            $this->css[$key] = '20px';
        }

        // Adjust top position to account for admin bar
        if (in_array('top', $pos) && is_user_logged_in()) {
            $this->css['top'] = '52px';
        }
    }

    /**
     * Get complete CSS
     *
     * @return string
     */
    private function getCss()
    {
        $str = '';

        foreach ($this->css as $key => $value) {
            $str .= $key . ': ' . $value . ';' . PHP_EOL;
        }

        return $str;
    }
}
