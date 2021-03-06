<?php
/**
 * Implements MessageChecker for EOL.
 *
 * @file
 * @author Niklas Laxström
 * @license GPL-2.0-or-later
 */

/**
 * Message checks for EOL
 *
 * @ingroup MessageCheckers
 */
class EOLMessageChecker extends MessageChecker {
	/**
	 * Checks for missing and unknown variables in translations.
	 *
	 * @param $messages \array Iterable list of TMessage objects.
	 * @param $code \string Language code of the translations.
	 * @param $warnings \array Array where warnings are appended to.
	 */
	protected function EOLVariablesCheck( $messages, $code, &$warnings ) {
		return parent::parameterCheck( $messages, $code, $warnings, '/%{[a-zA-Z_]+}/' );
	}
}
