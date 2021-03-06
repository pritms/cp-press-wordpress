<?php
/**
 * @package       WPChop.Controller
 * @subpackage Controller
 * @copyright    Copyright (C) Copyright (c) 2007 Marco Trognoni. All rights reserved.
 * @license        GNU/GPLv3, see LICENSE
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


/**
 * Controller
 *
 * Controller defines the inerface to access MVC Controller
 *
 * @author Marco Trognoni, <mtrognon@commonhelp.it>
 */
namespace CpPressOnePage;
\import('util.Set');

class AdminContentTypeController extends Controller{

	protected $uses = array('Section', 'Post', 'Page', 'Settings', 'PostMeta', 'PostType');
	
	protected $baseTemplate = array('slidethumb');
	
	private $fontAwesome = 'a:479:{s:9:"fa-adjust";s:5:"\f042";s:6:"fa-adn";s:5:"\f170";s:15:"fa-align-center";s:5:"\f037";s:16:"fa-align-justify";s:5:"\f039";s:13:"fa-align-left";s:5:"\f036";s:14:"fa-align-right";s:5:"\f038";s:12:"fa-ambulance";s:5:"\f0f9";s:9:"fa-anchor";s:5:"\f13d";s:10:"fa-android";s:5:"\f17b";s:12:"fa-angellist";s:5:"\f209";s:20:"fa-angle-double-down";s:5:"\f103";s:20:"fa-angle-double-left";s:5:"\f100";s:21:"fa-angle-double-right";s:5:"\f101";s:18:"fa-angle-double-up";s:5:"\f102";s:13:"fa-angle-down";s:5:"\f107";s:13:"fa-angle-left";s:5:"\f104";s:14:"fa-angle-right";s:5:"\f105";s:11:"fa-angle-up";s:5:"\f106";s:8:"fa-apple";s:5:"\f179";s:10:"fa-archive";s:5:"\f187";s:13:"fa-area-chart";s:5:"\f1fe";s:20:"fa-arrow-circle-down";s:5:"\f0ab";s:20:"fa-arrow-circle-left";s:5:"\f0a8";s:22:"fa-arrow-circle-o-down";s:5:"\f01a";s:22:"fa-arrow-circle-o-left";s:5:"\f190";s:23:"fa-arrow-circle-o-right";s:5:"\f18e";s:20:"fa-arrow-circle-o-up";s:5:"\f01b";s:21:"fa-arrow-circle-right";s:5:"\f0a9";s:18:"fa-arrow-circle-up";s:5:"\f0aa";s:13:"fa-arrow-down";s:5:"\f063";s:13:"fa-arrow-left";s:5:"\f060";s:14:"fa-arrow-right";s:5:"\f061";s:11:"fa-arrow-up";s:5:"\f062";s:9:"fa-arrows";s:5:"\f047";s:13:"fa-arrows-alt";s:5:"\f0b2";s:11:"fa-arrows-h";s:5:"\f07e";s:11:"fa-arrows-v";s:5:"\f07d";s:11:"fa-asterisk";s:5:"\f069";s:5:"fa-at";s:5:"\f1fa";s:11:"fa-backward";s:5:"\f04a";s:6:"fa-ban";s:5:"\f05e";s:12:"fa-bar-chart";s:5:"\f080";s:10:"fa-barcode";s:5:"\f02a";s:7:"fa-bars";s:5:"\f0c9";s:7:"fa-beer";s:5:"\f0fc";s:10:"fa-behance";s:5:"\f1b4";s:17:"fa-behance-square";s:5:"\f1b5";s:7:"fa-bell";s:5:"\f0f3";s:9:"fa-bell-o";s:5:"\f0a2";s:13:"fa-bell-slash";s:5:"\f1f6";s:15:"fa-bell-slash-o";s:5:"\f1f7";s:10:"fa-bicycle";s:5:"\f206";s:13:"fa-binoculars";s:5:"\f1e5";s:16:"fa-birthday-cake";s:5:"\f1fd";s:12:"fa-bitbucket";s:5:"\f171";s:19:"fa-bitbucket-square";s:5:"\f172";s:7:"fa-bold";s:5:"\f032";s:7:"fa-bolt";s:5:"\f0e7";s:7:"fa-bomb";s:5:"\f1e2";s:7:"fa-book";s:5:"\f02d";s:11:"fa-bookmark";s:5:"\f02e";s:13:"fa-bookmark-o";s:5:"\f097";s:12:"fa-briefcase";s:5:"\f0b1";s:6:"fa-btc";s:5:"\f15a";s:6:"fa-bug";s:5:"\f188";s:11:"fa-building";s:5:"\f1ad";s:13:"fa-building-o";s:5:"\f0f7";s:11:"fa-bullhorn";s:5:"\f0a1";s:11:"fa-bullseye";s:5:"\f140";s:6:"fa-bus";s:5:"\f207";s:13:"fa-calculator";s:5:"\f1ec";s:11:"fa-calendar";s:5:"\f073";s:13:"fa-calendar-o";s:5:"\f133";s:9:"fa-camera";s:5:"\f030";s:15:"fa-camera-retro";s:5:"\f083";s:6:"fa-car";s:5:"\f1b9";s:13:"fa-caret-down";s:5:"\f0d7";s:13:"fa-caret-left";s:5:"\f0d9";s:14:"fa-caret-right";s:5:"\f0da";s:22:"fa-caret-square-o-down";s:5:"\f150";s:22:"fa-caret-square-o-left";s:5:"\f191";s:23:"fa-caret-square-o-right";s:5:"\f152";s:20:"fa-caret-square-o-up";s:5:"\f151";s:11:"fa-caret-up";s:5:"\f0d8";s:5:"fa-cc";s:5:"\f20a";s:10:"fa-cc-amex";s:5:"\f1f3";s:14:"fa-cc-discover";s:5:"\f1f2";s:16:"fa-cc-mastercard";s:5:"\f1f1";s:12:"fa-cc-paypal";s:5:"\f1f4";s:12:"fa-cc-stripe";s:5:"\f1f5";s:10:"fa-cc-visa";s:5:"\f1f0";s:14:"fa-certificate";s:5:"\f0a3";s:15:"fa-chain-broken";s:5:"\f127";s:8:"fa-check";s:5:"\f00c";s:15:"fa-check-circle";s:5:"\f058";s:17:"fa-check-circle-o";s:5:"\f05d";s:15:"fa-check-square";s:5:"\f14a";s:17:"fa-check-square-o";s:5:"\f046";s:22:"fa-chevron-circle-down";s:5:"\f13a";s:22:"fa-chevron-circle-left";s:5:"\f137";s:23:"fa-chevron-circle-right";s:5:"\f138";s:20:"fa-chevron-circle-up";s:5:"\f139";s:15:"fa-chevron-down";s:5:"\f078";s:15:"fa-chevron-left";s:5:"\f053";s:16:"fa-chevron-right";s:5:"\f054";s:13:"fa-chevron-up";s:5:"\f077";s:8:"fa-child";s:5:"\f1ae";s:9:"fa-circle";s:5:"\f111";s:11:"fa-circle-o";s:5:"\f10c";s:17:"fa-circle-o-notch";s:5:"\f1ce";s:14:"fa-circle-thin";s:5:"\f1db";s:12:"fa-clipboard";s:5:"\f0ea";s:10:"fa-clock-o";s:5:"\f017";s:8:"fa-cloud";s:5:"\f0c2";s:17:"fa-cloud-download";s:5:"\f0ed";s:15:"fa-cloud-upload";s:5:"\f0ee";s:7:"fa-code";s:5:"\f121";s:12:"fa-code-fork";s:5:"\f126";s:10:"fa-codepen";s:5:"\f1cb";s:9:"fa-coffee";s:5:"\f0f4";s:6:"fa-cog";s:5:"\f013";s:7:"fa-cogs";s:5:"\f085";s:10:"fa-columns";s:5:"\f0db";s:10:"fa-comment";s:5:"\f075";s:12:"fa-comment-o";s:5:"\f0e5";s:11:"fa-comments";s:5:"\f086";s:13:"fa-comments-o";s:5:"\f0e6";s:10:"fa-compass";s:5:"\f14e";s:11:"fa-compress";s:5:"\f066";s:12:"fa-copyright";s:5:"\f1f9";s:14:"fa-credit-card";s:5:"\f09d";s:7:"fa-crop";s:5:"\f125";s:13:"fa-crosshairs";s:5:"\f05b";s:7:"fa-css3";s:5:"\f13c";s:7:"fa-cube";s:5:"\f1b2";s:8:"fa-cubes";s:5:"\f1b3";s:10:"fa-cutlery";s:5:"\f0f5";s:11:"fa-database";s:5:"\f1c0";s:12:"fa-delicious";s:5:"\f1a5";s:10:"fa-desktop";s:5:"\f108";s:13:"fa-deviantart";s:5:"\f1bd";s:7:"fa-digg";s:5:"\f1a6";s:15:"fa-dot-circle-o";s:5:"\f192";s:11:"fa-download";s:5:"\f019";s:11:"fa-dribbble";s:5:"\f17d";s:10:"fa-dropbox";s:5:"\f16b";s:9:"fa-drupal";s:5:"\f1a9";s:8:"fa-eject";s:5:"\f052";s:13:"fa-ellipsis-h";s:5:"\f141";s:13:"fa-ellipsis-v";s:5:"\f142";s:9:"fa-empire";s:5:"\f1d1";s:11:"fa-envelope";s:5:"\f0e0";s:13:"fa-envelope-o";s:5:"\f003";s:18:"fa-envelope-square";s:5:"\f199";s:9:"fa-eraser";s:5:"\f12d";s:6:"fa-eur";s:5:"\f153";s:11:"fa-exchange";s:5:"\f0ec";s:14:"fa-exclamation";s:5:"\f12a";s:21:"fa-exclamation-circle";s:5:"\f06a";s:23:"fa-exclamation-triangle";s:5:"\f071";s:9:"fa-expand";s:5:"\f065";s:16:"fa-external-link";s:5:"\f08e";s:23:"fa-external-link-square";s:5:"\f14c";s:6:"fa-eye";s:5:"\f06e";s:12:"fa-eye-slash";s:5:"\f070";s:13:"fa-eyedropper";s:5:"\f1fb";s:11:"fa-facebook";s:5:"\f09a";s:18:"fa-facebook-square";s:5:"\f082";s:16:"fa-fast-backward";s:5:"\f049";s:15:"fa-fast-forward";s:5:"\f050";s:6:"fa-fax";s:5:"\f1ac";s:9:"fa-female";s:5:"\f182";s:14:"fa-fighter-jet";s:5:"\f0fb";s:7:"fa-file";s:5:"\f15b";s:17:"fa-file-archive-o";s:5:"\f1c6";s:15:"fa-file-audio-o";s:5:"\f1c7";s:14:"fa-file-code-o";s:5:"\f1c9";s:15:"fa-file-excel-o";s:5:"\f1c3";s:15:"fa-file-image-o";s:5:"\f1c5";s:9:"fa-file-o";s:5:"\f016";s:13:"fa-file-pdf-o";s:5:"\f1c1";s:20:"fa-file-powerpoint-o";s:5:"\f1c4";s:12:"fa-file-text";s:5:"\f15c";s:14:"fa-file-text-o";s:5:"\f0f6";s:15:"fa-file-video-o";s:5:"\f1c8";s:14:"fa-file-word-o";s:5:"\f1c2";s:10:"fa-files-o";s:5:"\f0c5";s:7:"fa-film";s:5:"\f008";s:9:"fa-filter";s:5:"\f0b0";s:7:"fa-fire";s:5:"\f06d";s:20:"fa-fire-extinguisher";s:5:"\f134";s:7:"fa-flag";s:5:"\f024";s:17:"fa-flag-checkered";s:5:"\f11e";s:9:"fa-flag-o";s:5:"\f11d";s:8:"fa-flask";s:5:"\f0c3";s:9:"fa-flickr";s:5:"\f16e";s:11:"fa-floppy-o";s:5:"\f0c7";s:9:"fa-folder";s:5:"\f07b";s:11:"fa-folder-o";s:5:"\f114";s:14:"fa-folder-open";s:5:"\f07c";s:16:"fa-folder-open-o";s:5:"\f115";s:7:"fa-font";s:5:"\f031";s:10:"fa-forward";s:5:"\f04e";s:13:"fa-foursquare";s:5:"\f180";s:10:"fa-frown-o";s:5:"\f119";s:11:"fa-futbol-o";s:5:"\f1e3";s:10:"fa-gamepad";s:5:"\f11b";s:8:"fa-gavel";s:5:"\f0e3";s:6:"fa-gbp";s:5:"\f154";s:7:"fa-gift";s:5:"\f06b";s:6:"fa-git";s:5:"\f1d3";s:13:"fa-git-square";s:5:"\f1d2";s:9:"fa-github";s:5:"\f09b";s:13:"fa-github-alt";s:5:"\f113";s:16:"fa-github-square";s:5:"\f092";s:9:"fa-gittip";s:5:"\f184";s:8:"fa-glass";s:5:"\f000";s:8:"fa-globe";s:5:"\f0ac";s:9:"fa-google";s:5:"\f1a0";s:14:"fa-google-plus";s:5:"\f0d5";s:21:"fa-google-plus-square";s:5:"\f0d4";s:16:"fa-google-wallet";s:5:"\f1ee";s:17:"fa-graduation-cap";s:5:"\f19d";s:11:"fa-h-square";s:5:"\f0fd";s:14:"fa-hacker-news";s:5:"\f1d4";s:14:"fa-hand-o-down";s:5:"\f0a7";s:14:"fa-hand-o-left";s:5:"\f0a5";s:15:"fa-hand-o-right";s:5:"\f0a4";s:12:"fa-hand-o-up";s:5:"\f0a6";s:8:"fa-hdd-o";s:5:"\f0a0";s:9:"fa-header";s:5:"\f1dc";s:13:"fa-headphones";s:5:"\f025";s:8:"fa-heart";s:5:"\f004";s:10:"fa-heart-o";s:5:"\f08a";s:10:"fa-history";s:5:"\f1da";s:7:"fa-home";s:5:"\f015";s:13:"fa-hospital-o";s:5:"\f0f8";s:8:"fa-html5";s:5:"\f13b";s:6:"fa-ils";s:5:"\f20b";s:8:"fa-inbox";s:5:"\f01c";s:9:"fa-indent";s:5:"\f03c";s:7:"fa-info";s:5:"\f129";s:14:"fa-info-circle";s:5:"\f05a";s:6:"fa-inr";s:5:"\f156";s:12:"fa-instagram";s:5:"\f16d";s:10:"fa-ioxhost";s:5:"\f208";s:9:"fa-italic";s:5:"\f033";s:9:"fa-joomla";s:5:"\f1aa";s:6:"fa-jpy";s:5:"\f157";s:11:"fa-jsfiddle";s:5:"\f1cc";s:6:"fa-key";s:5:"\f084";s:13:"fa-keyboard-o";s:5:"\f11c";s:6:"fa-krw";s:5:"\f159";s:11:"fa-language";s:5:"\f1ab";s:9:"fa-laptop";s:5:"\f109";s:9:"fa-lastfm";s:5:"\f202";s:16:"fa-lastfm-square";s:5:"\f203";s:7:"fa-leaf";s:5:"\f06c";s:10:"fa-lemon-o";s:5:"\f094";s:13:"fa-level-down";s:5:"\f149";s:11:"fa-level-up";s:5:"\f148";s:12:"fa-life-ring";s:5:"\f1cd";s:14:"fa-lightbulb-o";s:5:"\f0eb";s:13:"fa-line-chart";s:5:"\f201";s:7:"fa-link";s:5:"\f0c1";s:11:"fa-linkedin";s:5:"\f0e1";s:18:"fa-linkedin-square";s:5:"\f08c";s:8:"fa-linux";s:5:"\f17c";s:7:"fa-list";s:5:"\f03a";s:11:"fa-list-alt";s:5:"\f022";s:10:"fa-list-ol";s:5:"\f0cb";s:10:"fa-list-ul";s:5:"\f0ca";s:17:"fa-location-arrow";s:5:"\f124";s:7:"fa-lock";s:5:"\f023";s:18:"fa-long-arrow-down";s:5:"\f175";s:18:"fa-long-arrow-left";s:5:"\f177";s:19:"fa-long-arrow-right";s:5:"\f178";s:16:"fa-long-arrow-up";s:5:"\f176";s:8:"fa-magic";s:5:"\f0d0";s:9:"fa-magnet";s:5:"\f076";s:7:"fa-male";s:5:"\f183";s:13:"fa-map-marker";s:5:"\f041";s:9:"fa-maxcdn";s:5:"\f136";s:11:"fa-meanpath";s:5:"\f20c";s:9:"fa-medkit";s:5:"\f0fa";s:8:"fa-meh-o";s:5:"\f11a";s:13:"fa-microphone";s:5:"\f130";s:19:"fa-microphone-slash";s:5:"\f131";s:8:"fa-minus";s:5:"\f068";s:15:"fa-minus-circle";s:5:"\f056";s:15:"fa-minus-square";s:5:"\f146";s:17:"fa-minus-square-o";s:5:"\f147";s:9:"fa-mobile";s:5:"\f10b";s:8:"fa-money";s:5:"\f0d6";s:9:"fa-moon-o";s:5:"\f186";s:8:"fa-music";s:5:"\f001";s:14:"fa-newspaper-o";s:5:"\f1ea";s:9:"fa-openid";s:5:"\f19b";s:10:"fa-outdent";s:5:"\f03b";s:12:"fa-pagelines";s:5:"\f18c";s:14:"fa-paint-brush";s:5:"\f1fc";s:14:"fa-paper-plane";s:5:"\f1d8";s:16:"fa-paper-plane-o";s:5:"\f1d9";s:12:"fa-paperclip";s:5:"\f0c6";s:12:"fa-paragraph";s:5:"\f1dd";s:8:"fa-pause";s:5:"\f04c";s:6:"fa-paw";s:5:"\f1b0";s:9:"fa-paypal";s:5:"\f1ed";s:9:"fa-pencil";s:5:"\f040";s:16:"fa-pencil-square";s:5:"\f14b";s:18:"fa-pencil-square-o";s:5:"\f044";s:8:"fa-phone";s:5:"\f095";s:15:"fa-phone-square";s:5:"\f098";s:12:"fa-picture-o";s:5:"\f03e";s:12:"fa-pie-chart";s:5:"\f200";s:13:"fa-pied-piper";s:5:"\f1a7";s:17:"fa-pied-piper-alt";s:5:"\f1a8";s:12:"fa-pinterest";s:5:"\f0d2";s:19:"fa-pinterest-square";s:5:"\f0d3";s:8:"fa-plane";s:5:"\f072";s:7:"fa-play";s:5:"\f04b";s:14:"fa-play-circle";s:5:"\f144";s:16:"fa-play-circle-o";s:5:"\f01d";s:7:"fa-plug";s:5:"\f1e6";s:7:"fa-plus";s:5:"\f067";s:14:"fa-plus-circle";s:5:"\f055";s:14:"fa-plus-square";s:5:"\f0fe";s:16:"fa-plus-square-o";s:5:"\f196";s:12:"fa-power-off";s:5:"\f011";s:8:"fa-print";s:5:"\f02f";s:15:"fa-puzzle-piece";s:5:"\f12e";s:5:"fa-qq";s:5:"\f1d6";s:9:"fa-qrcode";s:5:"\f029";s:11:"fa-question";s:5:"\f128";s:18:"fa-question-circle";s:5:"\f059";s:13:"fa-quote-left";s:5:"\f10d";s:14:"fa-quote-right";s:5:"\f10e";s:9:"fa-random";s:5:"\f074";s:8:"fa-rebel";s:5:"\f1d0";s:10:"fa-recycle";s:5:"\f1b8";s:9:"fa-reddit";s:5:"\f1a1";s:16:"fa-reddit-square";s:5:"\f1a2";s:10:"fa-refresh";s:5:"\f021";s:9:"fa-renren";s:5:"\f18b";s:9:"fa-repeat";s:5:"\f01e";s:8:"fa-reply";s:5:"\f112";s:12:"fa-reply-all";s:5:"\f122";s:10:"fa-retweet";s:5:"\f079";s:7:"fa-road";s:5:"\f018";s:9:"fa-rocket";s:5:"\f135";s:6:"fa-rss";s:5:"\f09e";s:13:"fa-rss-square";s:5:"\f143";s:6:"fa-rub";s:5:"\f158";s:11:"fa-scissors";s:5:"\f0c4";s:9:"fa-search";s:5:"\f002";s:15:"fa-search-minus";s:5:"\f010";s:14:"fa-search-plus";s:5:"\f00e";s:8:"fa-share";s:5:"\f064";s:12:"fa-share-alt";s:5:"\f1e0";s:19:"fa-share-alt-square";s:5:"\f1e1";s:15:"fa-share-square";s:5:"\f14d";s:17:"fa-share-square-o";s:5:"\f045";s:9:"fa-shield";s:5:"\f132";s:16:"fa-shopping-cart";s:5:"\f07a";s:10:"fa-sign-in";s:5:"\f090";s:11:"fa-sign-out";s:5:"\f08b";s:9:"fa-signal";s:5:"\f012";s:10:"fa-sitemap";s:5:"\f0e8";s:8:"fa-skype";s:5:"\f17e";s:8:"fa-slack";s:5:"\f198";s:10:"fa-sliders";s:5:"\f1de";s:13:"fa-slideshare";s:5:"\f1e7";s:10:"fa-smile-o";s:5:"\f118";s:7:"fa-sort";s:5:"\f0dc";s:17:"fa-sort-alpha-asc";s:5:"\f15d";s:18:"fa-sort-alpha-desc";s:5:"\f15e";s:18:"fa-sort-amount-asc";s:5:"\f160";s:19:"fa-sort-amount-desc";s:5:"\f161";s:11:"fa-sort-asc";s:5:"\f0de";s:12:"fa-sort-desc";s:5:"\f0dd";s:19:"fa-sort-numeric-asc";s:5:"\f162";s:20:"fa-sort-numeric-desc";s:5:"\f163";s:13:"fa-soundcloud";s:5:"\f1be";s:16:"fa-space-shuttle";s:5:"\f197";s:10:"fa-spinner";s:5:"\f110";s:8:"fa-spoon";s:5:"\f1b1";s:10:"fa-spotify";s:5:"\f1bc";s:9:"fa-square";s:5:"\f0c8";s:11:"fa-square-o";s:5:"\f096";s:17:"fa-stack-exchange";s:5:"\f18d";s:17:"fa-stack-overflow";s:5:"\f16c";s:7:"fa-star";s:5:"\f005";s:12:"fa-star-half";s:5:"\f089";s:14:"fa-star-half-o";s:5:"\f123";s:9:"fa-star-o";s:5:"\f006";s:8:"fa-steam";s:5:"\f1b6";s:15:"fa-steam-square";s:5:"\f1b7";s:16:"fa-step-backward";s:5:"\f048";s:15:"fa-step-forward";s:5:"\f051";s:14:"fa-stethoscope";s:5:"\f0f1";s:7:"fa-stop";s:5:"\f04d";s:16:"fa-strikethrough";s:5:"\f0cc";s:14:"fa-stumbleupon";s:5:"\f1a4";s:21:"fa-stumbleupon-circle";s:5:"\f1a3";s:12:"fa-subscript";s:5:"\f12c";s:11:"fa-suitcase";s:5:"\f0f2";s:8:"fa-sun-o";s:5:"\f185";s:14:"fa-superscript";s:5:"\f12b";s:8:"fa-table";s:5:"\f0ce";s:9:"fa-tablet";s:5:"\f10a";s:13:"fa-tachometer";s:5:"\f0e4";s:6:"fa-tag";s:5:"\f02b";s:7:"fa-tags";s:5:"\f02c";s:8:"fa-tasks";s:5:"\f0ae";s:7:"fa-taxi";s:5:"\f1ba";s:16:"fa-tencent-weibo";s:5:"\f1d5";s:11:"fa-terminal";s:5:"\f120";s:14:"fa-text-height";s:5:"\f034";s:13:"fa-text-width";s:5:"\f035";s:5:"fa-th";s:5:"\f00a";s:11:"fa-th-large";s:5:"\f009";s:10:"fa-th-list";s:5:"\f00b";s:13:"fa-thumb-tack";s:5:"\f08d";s:14:"fa-thumbs-down";s:5:"\f165";s:16:"fa-thumbs-o-down";s:5:"\f088";s:14:"fa-thumbs-o-up";s:5:"\f087";s:12:"fa-thumbs-up";s:5:"\f164";s:9:"fa-ticket";s:5:"\f145";s:8:"fa-times";s:5:"\f00d";s:15:"fa-times-circle";s:5:"\f057";s:17:"fa-times-circle-o";s:5:"\f05c";s:7:"fa-tint";s:5:"\f043";s:13:"fa-toggle-off";s:5:"\f204";s:12:"fa-toggle-on";s:5:"\f205";s:8:"fa-trash";s:5:"\f1f8";s:10:"fa-trash-o";s:5:"\f014";s:7:"fa-tree";s:5:"\f1bb";s:9:"fa-trello";s:5:"\f181";s:9:"fa-trophy";s:5:"\f091";s:8:"fa-truck";s:5:"\f0d1";s:6:"fa-try";s:5:"\f195";s:6:"fa-tty";s:5:"\f1e4";s:9:"fa-tumblr";s:5:"\f173";s:16:"fa-tumblr-square";s:5:"\f174";s:9:"fa-twitch";s:5:"\f1e8";s:10:"fa-twitter";s:5:"\f099";s:17:"fa-twitter-square";s:5:"\f081";s:11:"fa-umbrella";s:5:"\f0e9";s:12:"fa-underline";s:5:"\f0cd";s:7:"fa-undo";s:5:"\f0e2";s:13:"fa-university";s:5:"\f19c";s:9:"fa-unlock";s:5:"\f09c";s:13:"fa-unlock-alt";s:5:"\f13e";s:9:"fa-upload";s:5:"\f093";s:6:"fa-usd";s:5:"\f155";s:7:"fa-user";s:5:"\f007";s:10:"fa-user-md";s:5:"\f0f0";s:8:"fa-users";s:5:"\f0c0";s:15:"fa-video-camera";s:5:"\f03d";s:15:"fa-vimeo-square";s:5:"\f194";s:7:"fa-vine";s:5:"\f1ca";s:5:"fa-vk";s:5:"\f189";s:14:"fa-volume-down";s:5:"\f027";s:13:"fa-volume-off";s:5:"\f026";s:12:"fa-volume-up";s:5:"\f028";s:8:"fa-weibo";s:5:"\f18a";s:9:"fa-weixin";s:5:"\f1d7";s:13:"fa-wheelchair";s:5:"\f193";s:7:"fa-wifi";s:5:"\f1eb";s:10:"fa-windows";s:5:"\f17a";s:12:"fa-wordpress";s:5:"\f19a";s:9:"fa-wrench";s:5:"\f0ad";s:7:"fa-xing";s:5:"\f168";s:14:"fa-xing-square";s:5:"\f169";s:8:"fa-yahoo";s:5:"\f19e";s:7:"fa-yelp";s:5:"\f1e9";s:10:"fa-youtube";s:5:"\f167";s:15:"fa-youtube-play";s:5:"\f16a";s:17:"fa-youtube-square";s:5:"\f166";}';
	
	
	public function post($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('title', 'post');
		$this->assign('type', 'post');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'post');
		$this->assign('content', $content);
		if(!empty($content) && ($content['id'] == 'extended' || $content['id'] == 'advanced'))
			$this->assign('advanced_options', CpOnePage::dispatch_template ('AdminContentType', 'postadvanced', array($row, $col, $content)));
		else
			$this->assign('advanced_options', '');
		$posts = $this->Post->findAll();
		$this->assign('items', \Set::combine($posts->posts, '{n}.ID', '{n}.post_title'));
	}

	public function postadvanced($row='', $col='', $content=array()){
		if($row==''){
			$this->isAjax = true;
			$this->assign('row', $this->post['row']);
			$this->assign('col', $this->post['col']);
		}else{
			$this->assign('row', $row);
			$this->assign('col', $col);
		}
		$this->assign('content', $content);
	}
	
	public function post_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$cp_post_options = get_post_meta($content['id'], 'cp-press-post-options', true);
		$this->assign('cp_post_options', $cp_post_options);
		if(isset($content['hidethumb']) && $content['hidethumb'])
			$this->assign('hide_thumb', true);
		else
			$this->assign('hide_thumb', false);
		if($content['id'] != 'extended')
			$this->assign('cp_post', $this->Post->find(array('p' => $content['id'], 'post_type' => 'post')));
		else{
			$options = $content['advanced'];
			$args = array(
				'post_type'			=> 'post',
				'posts_per_page'	=> $options['limit'],
				'category__in'		=> isset($options['categories']) ? $options['categories'] : array(),
				'tag__in'			=> isset($options['tags']) ? $options['tags'] : array(),
				'offset'			=> $options['offset'],
				'order'				=> $options['order'],
				'orderby'			=> $options['orderby'],
				/* Set it to false to allow WPML modifying the query. */
				'suppress_filters' => false
			);
			$this->assign('post_title', isset($options['title']) ? $options['title'] : '');
			$this->assign('cp_post', $this->Post->find($args));
		}
		return $this->render(array('controller' => 'Index'));
	}

	public function text($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content) && isset($content['text'])){
			$dom = new \DOMDocument();
			$dom->encoding = 'utf-8';
			$dom->loadHTML(utf8_decode($content['text']));
			$content['text'] = $dom->saveHTML($dom->documentElement->childNodes->item(0)->childNodes->item(0));
		}
		$this->assign('content', $content);
		$this->assign('type', 'text_box');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'text');
	}
	
	public function faicon_modal(){
		$this->isAjax = true;
		$this->assign('row', $this->post['row']);
		$this->assign('col', $this->post['col']);
		$this->assign('fontawesome', unserialize($this->fontAwesome));
	}
	
	public function text_box_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$this->assign('content', $content);
		$iconClass = '';
		$iconStyle = '';
		$hasIcon = false;
		if(isset($content['icon'])){
			$hasIcon = true;
			if(isset($content['iconclass'])){
				$iconClass = 'class="'.$content['iconclass'].'"'; 
			}
			if(isset($content['iconcolor'])){
				$iconStyle = 'style="color:'.$content['iconcolor'].'"';
			}
		}
		$textClass = 'class="cp-box-text';
		if(isset($content['containerclass'])){
			$textClass .= ' '.$content['containerclass'];
		}
		
		$textClass .= '"';
		$containerClass = 'class="cp-box-container '.$content['section_name'].'-box"';
		$this->assign('containerClass', apply_filters('cp-textbox-containerclass', $containerClass, $content['section_name'], $hasIcon));
		$this->assign('textClass', apply_filters('cp-textbox-textclass', $textClass, $content['section_name'], $hasIcon));
		$this->assign('iconClass', apply_filters('cp-textbox-iconclass', $iconClass, $content['section_name'], $hasIcon));
		$this->assign('iconStyle', apply_filters('cp-textbox-iconstyle', $iconStyle, $content['section_name'], $hasIcon));
		$modView = apply_filters('cp-text-modify-view', '', $content);
		if(null !== $modView){
			if(isset($modView['isChild']) && $modView['isChild']){
				$this->isChildView = true;
			}
			if(isset($modView['view'])){
				$this->template = $modView['view'];
			}
		}
		
		return $this->render(array('controller' => 'Index'));
	}
	
	public function navigation($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('type', 'Navigation');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'navigation');
		$this->assign('content', $content);
		$this->assign('registered_menues', get_registered_nav_menus());
	}
	
	public function navigation_view($row='', $col='', $content=array()){
		$this->assign('menu', \CpPressOnePage\CpOnePage::dispatch_template('Menu', 'navbar', array($content['id'])));
	}

	public function page($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content)){
			$args = array(
				'p'			=> $content['id'],
				'post_type'	=> 'page'
			);
			$post = $this->PostType->findAll($args);
			$content['post'] = $post->posts[0];
		}
		$this->assign('content', $content);
		$this->assign('title', 'page');
		$this->assign('type', 'page');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'page');
		$pages = $this->Page->findAll();
		$this->assign('items', \Set::combine($pages->posts, '{n}.ID', '{n}.post_title'));
	}
	
	public function page_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		if(isset($content['hidethumb']) && $content['hidethumb'])
			$this->assign('hide_thumb', true);
		else
			$this->assign('hide_thumb', false);
		if(isset($content['hidetitle']) && $content['hidetitle'])
			$this->assign('hide_title', true);
		else
			$this->assign('hide_title', false);
		$page = $this->Post->find(array('p' => $content['id'], 'post_type' => 'page'));
		$pageTemplate = $this->PostMeta->find(array($page->posts[0]->ID, '_wp_page_template'));
		$pageTemplate = basename($pageTemplate, '.php');
		if($pageTemplate == 'default'){
			$pageTemplate = 'page';
		}else if(!in_array($pageTemplate, $this->baseTemplate)){
			$this->isChildView = true;
		}
		$this->assign('cp_page', $page);
		return $this->render(array('controller' => 'Index', 'action' => $pageTemplate.'_view'));
	}

	public function sidebar($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		$this->assign('content', $content);
		$this->assign('title', 'sidebar');
		$this->assign('type', 'sidebar');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'sidebar');
	}

	public function sidebar_view($row='', $col='', $content=array()){
		//global $wp_registered_sidebars;

		$this->autoRender = false;
		$this->assign('sidebar', $content);
		return $this->render(array('controller' => 'Index'));
	}
	
	public function type($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content)){
			$args = array(
				'p'			=> $content['id'],
				'post_type'	=> $content['type']
			);
			$post = $this->PostType->findAll($args);
			$content['post'] = $post->posts[0];
		}
		$this->assign('content', $content);
		$this->assign('title', 'type');
		$this->assign('type', 'type');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'type');
	}
	
	public function type_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		if(!empty($content)){
			$args = array(
				'p'			=> $content['id'],
				'post_type'	=> $content['type']
			);
			$post = $this->PostType->findAll($args);
			$content['post'] = $post;
		}
		$this->assign('content', $content);
		return $this->render(array('controller' => 'Index'));
	}
	
	public function type_modal(){
		$this->isAjax = true;
		$this->assign('row', $this->post['row']);
		$this->assign('col', $this->post['col']);
		$types = array();
		if($this->post['type'] == 'all'){
			$ptypes = get_post_types(array('_builtin' => false));
		}else{
			$ptypes = array($this->post['type']);
		}
		foreach($ptypes as $type){
			if(post_type_supports($type, 'editor')){
				$types[] = $type;
			}
		}
		$validPostTypesObj = array();
		foreach($types as $key => $postType){
			$obj  = get_post_type_object($postType);
			$posts = $this->PostType->findAll(array('post_type' => $postType));
			$validPostTypesObj[$key]['label'] = $obj->labels->singular_name;
			$validPostTypesObj[$key]['name'] = $obj->name;
			$validPostTypesObj[$key]['posts'] = \Set::combine($posts->posts, '{n}.ID', '{n}.post_title');
			$validPostTypesObj[$key]['contents'] = \Set::combine($posts->posts, '{n}.ID', '{n}.post_content');
		}
		
		$this->assign('types', $validPostTypesObj);
	}
	
	public function media($row='', $col='', $content=array()){
		$this->assign('row', $row);
		$this->assign('col', $col);
		if(!empty($content)){
			$this->assign('media_uri', reset(wp_get_attachment_image_src($content['id'], 'full')));
			$this->assign('media', wp_get_attachment_metadata( $content['id'], true));
		}
		$this->assign('content', $content);
		$this->assign('title', 'media');
		$this->assign('type', 'media');
		$this->assign('ns', '\CpPressOnePage\CpOnePage');
		$this->assign('controller', 'AdminContentType');
		$this->assign('action', 'media');
	}
	
	public function add_media_content(){
		$this->isAjax = true;
		$this->assign('row', $this->post['row']);
		$this->assign('col', $this->post['col']);
		$this->assign('media', $this->post['media']);
	}
	
	public function media_view($row='', $col='', $content=array()){
		$this->autoRender = false;
		$this->assign('content', $content);
		if(!empty($content)){
			$this->assign('media_uri', reset(wp_get_attachment_image_src($content['id'], 'full')));
			$media = wp_get_attachment_metadata( $content['id'], true);
			$this->assign('media', $media);
			$class = '';
			if($content['size'] == 'responsive'){
				$class .= 'img-responsive ';
				$content['size'] ==  'full';
			}
			switch($content['alignment']){
				case 'center':
					$class .= 'aligncenter';
					break;
				case 'left':
					$class .= 'alignleft';
					break;
				case 'right':
					$class .= 'alignright';
					break;
			}
			$this->assign('class', $class);
			if($content['size'] == 'full'){
				$this->assign('width', $media['width']);
				$this->assign('height', $media['height']);
			}else{
				$this->assign('width', $media['sizes'][$content['size']]['width']);
				$this->assign('height', $media['sizes'][$content['size']]['height']);
			}
		}
		return $this->render(array('controller' => 'Index'));
	}
	
	public function shortcode($attr=array(), $content=''){
		$defaults = array(
			'type' => 'post',
			'field' => 'post_title',
			'action' => 'link'
		);
		$options = shortcode_atts($defaults, $attr);
		$p = $this->Post->find(array('post_type' => $options['type']));
		$this->assign('posts', \Set::combine($p->posts, '{n}.ID', '{n}.'.$options['field']));
		$this->assign('action', $options['action']);
	}
	
	public function category($row, $col, $content=array()){
		$args = array(
			'hide_empty'	=> 0,
			'taxonomy'		=> $content['taxonomy']
		);
	
		$this->assign('set', isset($content['category']) ? $content['category'] : '');
		$this->assign('label', $content['label']);
		$this->assign('categories', get_categories($args));
		$this->assign('row', $row);
		$this->assign('col', $col);
	}
}

?>
