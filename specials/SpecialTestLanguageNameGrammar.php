<?php
/**
 * A special page to show a message with all language names.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @author Amir E. Aharoni
 * @copyright Copyright © 2014, Amir E. Aharoni
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2 or later
 */

/**
 * A form for testing a message and a grammar form with all language names
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */

class SpecialTestLanguageNameGrammar extends SpecialPage {
	public function __construct() {
		parent::__construct( 'TestLanguageNameGrammar' );
	}

	public function execute( $parameters ) {
		$this->setHeaders();
		$this->outputHeader();

		/*
		$context = $this->getContext();
		$form = new HtmlForm(
			$this->getDataModel(),
			$context,
			'testlanguagenamegrammar'
		);
		$form->setId( 'testlanguagenamegrammar-form' );
		$form->setSubmitText( $context->msg( 'testlanguagenamegrammar-submit' )->text() );
		$form->setSubmitID( 'testlanguagenamegrammar-submit' );
		$form->setSubmitCallback( array( $this, 'formSubmit' ) );
		*/

		$out = $this->getOutput();

		$out->addHtml( $this->getFormsTable(
			'ru',
			'languageadverb',
			'Она говорит {{GRAMMAR:languageadverb|$1}}'
		) );

		return;
	}

	private function getDataModel() {
		$m = array();

		$m['grammarform'] = array(
			'type' => 'info',
			'label-message' => 'testlanguagenamegrammar-grammarform',
		);

		$m['message'] = array(
			'type' => 'info',
			'label-message' => 'testlanguagenamegrammar-message',
		);

		return $m;
	}

	private function getFormsTable( $langCode, $form, $message ) {
		$languageNames = Language::fetchLanguageNames( $langCode );
		$rows = '';
		$lang = Language::factory( $langCode );
		$dir = $lang->getDir();
		$out = $this->getOutput();

		foreach( array_keys( $languageNames ) as $outputCode ) {
			$codeCell = Html::element(
				'td',
				array(),
				$outputCode
			);
			$nameCell = Html::element(
				'td',
				array(
					'dir' => $dir,
					'lang' => $langCode,
				),
				$languageNames[$outputCode]
			);

			$currentMessage = str_replace( '$1', $languageNames[$outputCode], $message );
			$messageCell = Html::element(
				'td',
				array(
					'dir' => $dir,
					'lang' => $langCode,
				),
				$out->parse( $currentMessage, false, false, $lang )
			);

			$rows .= Html::rawElement( 'tr', array(), $codeCell . $nameCell . $messageCell );
		}

		$table = Html::rawElement(
			'table',
			array( 'class' => 'wikitable' ),
			$rows
		);

		return $table;
	}
}
