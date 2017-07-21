<?php

namespace Cgit\YouAreHere;

class Indicator
{
    /**
     * Indicator styles
     *
     * @var array
     */
    private $styles = [
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
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        if ($this->forbidden()) {
            return;
        }

        $this->updateStyles();

        add_action('wp_head', [$this, 'insertStyles']);
        add_action('admin_head', [$this, 'insertStyles']);
        add_action('wp_footer', [$this, 'insert']);
        add_action('admin_footer', [$this, 'insert']);
    }

    /**
     * Should the current user be able to see the environment indicator?
     *
     * @return boolean
     */
    private function forbidden()
    {
        $conditions = apply_filters('cgit_you_are_here_conditions', []);

        foreach ($conditions as $condition) {
            if (!$condition()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Make changes to the default styles
     *
     * @return void
     */
    private function updateStyles()
    {
        $this->updateColorStyles();
        $this->updatePositionStyles();
    }

    /**
     * Customize the default text and background colours
     *
     * @return void
     */
    private function updateColorStyles()
    {
        if (defined('CGIT_YOU_ARE_HERE_BACKGROUND')) {
            $this->styles['background-color'] = CGIT_YOU_ARE_HERE_BACKGROUND;
        }

        if (defined('CGIT_YOU_ARE_HERE_COLOR')) {
            $this->styles['color'] = CGIT_YOU_ARE_HERE_COLOR;
        }
    }

    /**
     * Set and/or update the default indicator position styles
     *
     * A custom position can be set as a string consisting of two words, such as
     * "top left". A 20px offset from the edge of the window will be added
     * automatically.
     *
     * @return void
     */
    private function updatePositionStyles()
    {
        if (!defined('CGIT_YOU_ARE_HERE_POSITION')) {
            $this->styles['right'] = '20px';
            $this->styles['bottom'] = '20px';

            return;
        }

        $position = CGIT_YOU_ARE_HERE_POSITION;
        $position = is_array($position) ? $position : explode($position);
        $position = array_slice($position, 0, 2);

        foreach ($position as $property) {
            $this->styles[$property] = '20px';
        }

        if (in_array('top', $position) && is_user_logged_in()) {
            $this->style['top'] = '52px';
        }
    }

    /**
     * Insert the indicator
     *
     * @return void
     */
    public function insert()
    {
        ?>
        <div class="cgit-wp-you-are-here">
            <?= CGIT_YOU_ARE_HERE ?>
        </div>
        <?php
    }

    /**
     * Insert the indicator CSS
     *
     * @return void
     */
    public function insertStyles()
    {
        ?>
        <style>
            .cgit-wp-you-are-here {
                <?= $this->styles() ?>
            }

            .cgit-wp-you-are-here:hover {
                cursor: default;
                opacity: 0.25;
            }
        </style>
        <?php
    }

    /**
     * Return styles as neatly formatted CSS
     *
     * @return string
     */
    private function styles()
    {
        $css = '';

        foreach ($this->styles as $property => $value) {
            $css .= $property . ': ' . $value . ';' . PHP_EOL;
        }

        return $css;
    }
}
