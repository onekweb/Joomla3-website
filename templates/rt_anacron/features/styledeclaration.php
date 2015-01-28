<?php
/**
 * @version   $Id: styledeclaration.php 18303 2014-01-30 16:37:06Z arifin $
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2014 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
    var $_feature_name = 'styledeclaration';

    function isEnabled() {
		global $gantry;
        $menu_enabled = $this->get('enabled');

        if (1 == (int)$menu_enabled) return true;
        return false;
    }

	function init() {
		global $gantry;
		$browser = $gantry->browser;

        // Logo
    	$css = $this->buildLogo();

        // Less Variables
    	$lessVariables = array(
            'logo-type'                     => $gantry->get('logo-type',                    'preset1'),

            'accent-color1'                 => $gantry->get('accent-color1',                '#E03D1F'),
            'accent-color2'                 => $gantry->get('accent-color2',                '#3091CF'),
            'accent-color3'                 => $gantry->get('accent-color3',                '#888888'),

            'header-overlay'                => $gantry->get('header-overlay',               'light'),
            'header-text-color'             => $gantry->get('header-text-color',            '#080808'),
            'header-background'             => $gantry->get('header-background',            '#EFEFEF'),

            'showcase-overlay'              => $gantry->get('showcase-overlay',             'dark'),
            'showcase-link-color'           => $gantry->get('showcase-link-color',          '#07659E'),
            'showcase-text-color'           => $gantry->get('showcase-text-color',          '#EFEFEF'),
            'showcase-background'           => $gantry->get('showcase-background',          '#E03D1F'),
            'showcase-type'                 => $gantry->get('showcase-type',                'preset1'),

            'top-overlay'                   => $gantry->get('top-overlay',                  'light'),
            'top-text-color'                => $gantry->get('top-text-color',               '#8B8B8B'),
            'top-background'                => $gantry->get('top-background',               '#F5F6F8'),

            'utility-overlay'               => $gantry->get('utility-overlay',              'light'),
            'utility-text-color'            => $gantry->get('utility-text-color',           '#6E6E6E'),
            'utility-background'            => $gantry->get('utility-background',           '#FFFFFF'),

            'feature-overlay'               => $gantry->get('feature-overlay',              'light'),
            'feature-text-color'            => $gantry->get('feature-text-color',           '#8B8B8B'),
            'feature-background'            => $gantry->get('feature-background',           '#F5F6F8'),
            'feature-type'                  => $gantry->get('feature-type',                 'preset1'),

            'maintop-overlay'               => $gantry->get('maintop-overlay',              'light'),
            'maintop-text-color'            => $gantry->get('maintop-text-color',           '#8B8B8B'),
            'maintop-background'            => $gantry->get('maintop-background',           '#F5F6F8'),

            'expandedtop-overlay'           => $gantry->get('expandedtop-overlay',          'light'),
            'expandedtop-text-color'        => $gantry->get('expandedtop-text-color',       '#6E6E6E'),
            'expandedtop-background'        => $gantry->get('expandedtop-background',       '#FFFFFF'),

            'mainbody-overlay'              => $gantry->get('mainbody-overlay',             'light'),

            'expandedbottom-overlay'        => $gantry->get('expandedbottom-overlay',       'light'),
            'expandedbottom-text-color'     => $gantry->get('expandedbottom-text-color',    '#8B8B8B'),
            'expandedbottom-background'     => $gantry->get('expandedbottom-background',    '#F5F6F8'),

            'mainbottom-overlay'            => $gantry->get('mainbottom-overlay',           'light'),
            'mainbottom-text-color'         => $gantry->get('mainbottom-text-color',        '#6E6E6E'),
            'mainbottom-background'         => $gantry->get('mainbottom-background',        '#FFFFFF'),

            'extension-overlay'             => $gantry->get('extension-overlay',            'dark'),
            'extension-link-color'          => $gantry->get('extension-link-color',         '#07659E'),
            'extension-text-color'          => $gantry->get('extension-text-color',         '#2A6A8F'),
            'extension-background'          => $gantry->get('extension-background',         '#E03D1F'),
            'extension-type'                => $gantry->get('extension-type',               'preset1'),

            'bottom-overlay'                => $gantry->get('bottom-overlay',               'dark'),
            'bottom-text-color'             => $gantry->get('bottom-text-color',            '#41A4DD'),
            'bottom-background'             => $gantry->get('bottom-background',            '#2A6A8F'),

            'footer-overlay'                => $gantry->get('footer-overlay',               'dark'),
            'footer-text-color'             => $gantry->get('footer-text-color',            '#8F8F8F'),
            'footer-background'             => $gantry->get('footer-background',            '#35363A'),

            'copyright-overlay'             => $gantry->get('copyright-overlay',            'dark'),
            'copyright-text-color'          => $gantry->get('copyright-text-color',         '#5F5F5F'),
            'copyright-background'          => $gantry->get('copyright-background',         '#2D2D2D')
    	);

        // Section Background Images
        $positions  = array('showcase-customshowcase-image', 'feature-customfeature-image', 'extension-customextension-image');
        $source     = "";

        foreach ($positions as $position) {
            $data = $gantry->get($position, false) ? json_decode(str_replace("'", '"', $gantry->get($position))) : false;
            if ($data) $source = $data->path;
            if (!preg_match('/^\//', $source)) $source = JURI::root(true).'/'.$source;
            $lessVariables[$position] = $data ? 'url(' . $source . ')' : 'none';
        }

        $gantry->addInlineStyle($css);

       	$gantry->addLess('global.less', 'master.css', 7, $lessVariables);

	    $this->_disableRokBoxForiPhone();

        if ($gantry->get('layout-mode')=="responsive") $gantry->addLess('mediaqueries.less');
        if ($gantry->get('layout-mode')=="960fixed")   $gantry->addLess('960fixed.less');
        if ($gantry->get('layout-mode')=="1200fixed")  $gantry->addLess('1200fixed.less');

        // RTL
        if ($gantry->get('rtl-enabled')) $gantry->addLess('rtl.less', 'rtl.css', 8, $lessVariables);

        // Demo Styling
        if ($gantry->get('demo')) $gantry->addLess('demo.less', 'demo.css', 9, $lessVariables);

        // Third Party (k2)
        if ($gantry->get('k2')) $gantry->addLess('thirdparty-k2.less', 'thirdparty-k2.css', 10, $lessVariables);

        // Chart Script
        if ($gantry->get('chart-enabled')) $gantry->addScript('chart.js');

    }

    function buildLogo(){
		global $gantry;

        if ($gantry->get('logo-type')!="custom") return "";

        $source = $width = $height = "";

        $logo = str_replace("&quot;", '"', str_replace("'", '"', $gantry->get('logo-custom-image')));
        $data = json_decode($logo);

        if (!$data){
            if (strlen($logo)) $source = $logo;
            else return "";
        } else {
            $source = $data->path;
        }

        if (substr($gantry->baseUrl, 0, strlen($gantry->baseUrl)) == substr($source, 0, strlen($gantry->baseUrl))){
            $file = JPATH_ROOT . '/' . substr($source, strlen($gantry->baseUrl));
        } else {
            $file = JPATH_ROOT . '/' . $source;
        }

        if (isset($data->width) && isset($data->height)){
            $width = $data->width;
            $height = $data->height;
        } else {
            $size = @getimagesize($file);
            $width = $size[0];
            $height = $size[1];
        }

        if (!preg_match('/^\//', $source))
        {
            $source = JURI::root(true).'/'.$source;
        }

        $source = str_replace(' ', '%20', $source);

        $output = "";
        $output .= "#rt-logo {background: url(".$source.") 50% 0 no-repeat !important;}"."\n";
        $output .= "#rt-logo {width: ".$width."px;height: ".$height."px;}"."\n";

        $file = preg_replace('/\//i', DIRECTORY_SEPARATOR, $file);

        return (file_exists($file)) ?$output : '';
    }

	function _disableRokBoxForiPhone() {
		global $gantry;

		if ($gantry->browser->platform == 'iphone' || $gantry->browser->platform == 'android') {
			$gantry->addInlineScript("window.addEvent('domready', function() {\$\$('a[rel^=rokbox]').removeEvents('click');});");
		}
	}
}
