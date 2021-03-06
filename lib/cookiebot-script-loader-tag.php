<?php

namespace cookiebot_addons_framework\lib;

class Cookiebot_Script_Loader_Tag {

	/**
	 * List of tags to load in cookiebot attributes
	 *
	 * @var array
	 *
	 * @since 1.1.0
	 */
	private $tags = array();

	/**
	 * @var   Cookiebot_Script_Loader_Tag The single instance of the class
	 *
	 * @since 1.1.0
	 */
	protected static $_instance = null;

	/**
	 * Returns instance of this class
	 *
	 * @return Cookiebot_Script_Loader_Tag
	 *
	 * @since 1.1.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Cookiebot_Script_Loader_Tag constructor.
	 * Adds filter to enhance script attribute
	 *
	 * @since 1.1.0
	 */
	public function __construct() {
		add_filter( 'script_loader_tag', array( $this, 'cookiebot_add_consent_attribute_to_tag' ), 10, 3 );
	}

	/**
	 * Adds enqueue script handle tag to the array of tags.
	 * So that the script can be updated with cookieconsent attribute.
	 *
	 * @param $tag  string  Enqueue script handle name
	 * @param $type string
	 *
	 * @since 1.2.0
	 */
	public function add_tag( $tag, $type ) {
		$this->tags[$tag] = $type;
	}

	/**
	 * Modifies external links to google analytics
	 *
	 * @param $tag
	 * @param $handle
	 * @param $src
	 *
	 * @return string
	 *
	 * @since 1.2.0
	 */
	public function cookiebot_add_consent_attribute_to_tag( $tag, $handle, $src ) {
		if ( array_key_exists( $handle, $this->tags ) ) {
			return '<script src="' . $src . '" type="text/plain" data-cookieconsent="' . $this->tags[ $handle ] . '"></script>';
		}

		return $tag;
	}
}