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
 * @license GPL-2.0-or-later
 */

use MediaWiki\Html\Html;
use MediaWiki\Languages\LanguageFactory;
use MediaWiki\Languages\LanguageNameUtils;

/**
 * A form for testing a message and a grammar form with all language names
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */

class SpecialTestLanguageNameGrammar extends SpecialPage {
	/** @var LanguageFactory */
	private $languageFactory;

	/** @var LanguageNameUtils */
	private $languageNameUtils;

	public function __construct(
		LanguageFactory $languageFactory,
		LanguageNameUtils $languageNameUtils
	) {
		parent::__construct( 'TestLanguageNameGrammar' );
		$this->languageFactory = $languageFactory;
		$this->languageNameUtils = $languageNameUtils;
	}

	public function execute( $parameters ) {
		$this->setHeaders();
		$this->outputHeader();

		$context = $this->getContext();
		$form = new HTMLForm(
			$this->getDataModel(),
			$context,
			'testlanguagenamegrammar'
		);
		$form->setId( 'testlanguagenamegrammar-form' );
		$form->setSubmitText( $context->msg( 'testlanguagenamegrammar-submit' )->text() );
		$form->setSubmitID( 'testlanguagenamegrammar-submit' );
		$form->setSubmitCallback( [ $this, 'formSubmit' ] );

		$form->show();
	}

	private function getDataModel() {
		$model = [];

		$model['language'] = [
			'type' => 'text',
			'label-message' => 'testlanguagenamegrammar-language',
		];

		$model['grammarform'] = [
			'type' => 'text',
			'label-message' => 'testlanguagenamegrammar-grammarform',
		];

		return $model;
	}

	public function formSubmit( $formData ) {
		$language = $formData['language'];
		$grammarForm = $formData['grammarform'];

		$out = $this->getOutput();

		$out->addHtml( $this->getFormsTable( $language, $grammarForm ) );
	}

	public function getFormsTable( $langCode, $form ) {
		$languageNames = $this->languageNameUtils->getLanguageNames( $langCode );
		$lang = $this->languageFactory->getLanguage( $langCode );
		$rows = '';
		$dir = $lang->getDir();
		$out = $this->getOutput();

		foreach ( $languageNames as $outputCode => $name ) {
			$codeCell = Html::element(
				'td',
				[],
				$outputCode
			);

			$nameCell = Html::element(
				'td',
				[
					'dir' => $dir,
					'lang' => $langCode,
				],
				$name
			);

			$currentMessage = "{{GRAMMAR:$form|$name}}";

			$messageCell = Html::rawElement(
				'td',
				[
					'dir' => $dir,
					'lang' => $langCode,
				],
				$out->parseAsInterface( $currentMessage, false, false, $lang )
			);

			$rows .= Html::rawElement( 'tr', [], $codeCell . $nameCell . $messageCell );
		}

		$table = Html::rawElement(
			'table',
			[ 'class' => 'wikitable' ],
			$rows
		);

		return $table;
	}
}
