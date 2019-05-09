# Castlegate IT WP You Are Here #

You can use this plugin to add a visible, fixed position message to your website to indicate which environment you are looking at (local, staging, production, etc.). By default the plugin displays nothing. If you define the constant `CGIT_YOU_ARE_HERE`, then the value of that constant will be displayed on the site. For example:

~~~ php
define('CGIT_YOU_ARE_HERE', 'foo');
~~~

Using different `wp-config.php` files in different environments means that each environment can have its own visible label.

## Appearance ##

By default, the message will be in the bottom right corner of the screen, with white text on a red background. The position and the colours can be changed using constants:

~~~ php
define('CGIT_YOU_ARE_HERE_BACKGROUND', '#fc0');
define('CGIT_YOU_ARE_HERE_COLOR', 'black');
define('CGIT_YOU_ARE_HERE_POSITION', 'top left');
~~~

## Conditions ##

You can use the `cgit_you_are_here_conditions` filter to hide the message when certain conditions are met. For example, you might want to only show the message when users are logged in and when the site is viewed from a particular IP address:

~~~ php
add_filter('cgit_you_are_here_conditions', function($conditions) {
    $conditions[] = function() {
        return is_user_logged_in();
    };

    $conditions[] = function() {
        return $_SERVER['REMOTE_ADDR'] == '192.168.56.1';
    };

    return $conditions;
});
~~~

These conditions can be used, for example, to display a message to developers but not users on a production site.

## License

Copyright (c) 2019 Castlegate IT. All rights reserved.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.
