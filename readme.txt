
=== Plugin Name ===
Contributors: millswebdevelopment
Tags: MotoPress, 
Requires at least: 4.7
Tested up to: 5.7.2
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin Will allow the addition of a three step progress bar to the MotoPress hotel booking process.

== Description ==

This plugin will automatically add a three step progress bar to the MotoPress hotel booking process.  It requires the MotoPress Hotel Bookings plugin to be installed.

The progress bar consists of three steps showing the users where they are in the booking process. The progress bar will be displayed above the MotoPress content on the following pages:
1. Search Results
2. Booking Details
3. Booking Confirmation (and Reservation Submitted if bookings are not directly confirmed)

You can change the default text of each step and colors of the progress bar under the plugin settings (Settings > Booking Progress Bar).  By changing the text of the last step you can also use this plugin with bookings that require user or admin booking confirmation.

== Frequently Asked Questions ==

= Can I change the colors of the elements? =

Yes, in the plugin settings you can change the default colors of the borders and circles. The font color will be inherited from the theme styling, so you can use the theme settings or custom CSS to change this if needed.

= How can I change or translate the text? =

In the plugin settings (Settings > Booking Progress Bar) you can change the text and basic formatting of each step. This is useful if you would like to translate the text into another language or would like to change the text. For example, if your confirmation mode is by admin manually, you make like to change step 3 text to 'Booking request sent' instead of 'Booking confirmed'.

= Can I add extra styling like margin and padding? =

Yes, using custom CSS and the selector '#progressBar' you can style the progress bar. For example:
#progressBar{
    margin-bottom: 20px;
}

== Screenshots ==

1. The progress bar on the search results page.
2. The progress bar on the booking confirmation (checkout) page.
3. The progress bar on the booking confirmed page.
4. Example of alternative colors and text - in this case the booking is confirmed by the guest. 
5. The admin settings of the plugin, found under Settings > Booking Progress Bar

== Changelog ==

= 1.0 =
* Initial release
