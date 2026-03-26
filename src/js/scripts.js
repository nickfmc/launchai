/**
 * LaunchPad theme — main script entry point.
 * Imports and initialises all modules on DOMContentLoaded.
 */

import AccessibilityWidget        from './modules/accessibility.js';
import { AccessibilityEnhancer }  from './modules/accessibility-enhancer.js';
import { initModalNav }           from './modules/modal-nav.js';
import { initMobileMenu }         from './modules/mobile-menu.js';
import { initSearchPopup }        from './modules/search-popup.js';
import { initDropdownMenu }       from './modules/dropdown-menu.js';

document.addEventListener( 'DOMContentLoaded', () => {
	// Accessibility widget (floating panel)
	if ( document.getElementById( 'a11y-widget' ) ) {
		new AccessibilityWidget();
	}

	// Auto-label external / new-tab / PDF links
	const enhancer = new AccessibilityEnhancer();
	enhancer.enhanceLinks();
	enhancer.observe();

	// Navigation
	initModalNav();
	initMobileMenu();
	initSearchPopup();
	initDropdownMenu();
} );
