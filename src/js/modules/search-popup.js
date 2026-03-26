import { trapFocus } from '../utils/focus-trap.js';

/**
 * Accessible search popup.
 * Expects #search-button, #search-popup, #s, #close-search-popup in the DOM.
 */
export function initSearchPopup() {
	const searchBtn  = document.getElementById( 'search-button' );
	const searchPopup = document.getElementById( 'search-popup' );
	const searchField = document.getElementById( 's' );
	const closeBtn   = document.getElementById( 'close-search-popup' );
	const submitBtn  = document.getElementById( 'search-submit' );

	if ( ! searchBtn || ! searchPopup || ! searchField || ! closeBtn ) return;

	let releaseTrap = null;

	function openPopup() {
		searchBtn.setAttribute( 'aria-expanded', 'true' );
		searchPopup.setAttribute( 'aria-hidden', 'false' );
		searchPopup.removeAttribute( 'inert' );
		searchField.focus();
		releaseTrap = trapFocus( searchPopup );
	}

	function closePopup() {
		searchBtn.setAttribute( 'aria-expanded', 'false' );
		searchPopup.setAttribute( 'aria-hidden', 'true' );
		searchPopup.setAttribute( 'inert', '' );
		if ( releaseTrap ) { releaseTrap(); releaseTrap = null; }
		searchBtn.focus();
	}

	searchBtn.addEventListener( 'click', () => {
		const isOpen = searchBtn.getAttribute( 'aria-expanded' ) === 'true';
		isOpen ? closePopup() : openPopup();
	} );

	closeBtn.addEventListener( 'click', closePopup );

	document.addEventListener( 'keydown', ( e ) => {
		if ( e.key === 'Escape' && searchBtn.getAttribute( 'aria-expanded' ) === 'true' ) {
			closePopup();
		}
	} );

	// Submit on Enter inside the search field
	if ( submitBtn ) {
		searchField.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Enter' ) { e.preventDefault(); submitBtn.click(); }
		} );
	}
}
