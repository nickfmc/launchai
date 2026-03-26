import { trapFocus } from '../utils/focus-trap.js';

/**
 * Initialises the modal navigation overlay.
 * Expects #open-modal-nav, #close-modal-nav, and .c-modal-nav-wrap in the DOM.
 */
export function initModalNav() {
	const html     = document.documentElement;
	const openBtn  = document.getElementById( 'open-modal-nav' );
	const closeBtn = document.getElementById( 'close-modal-nav' );
	const navWrap  = document.querySelector( '.c-modal-nav-wrap' );

	if ( ! openBtn || ! closeBtn || ! navWrap ) return;

	let releaseTrap = null;

	function open() {
		html.classList.add( 'has-modal-nav-open' );
		openBtn.setAttribute( 'aria-expanded', 'true' );
		releaseTrap = trapFocus( navWrap );
	}

	function close() {
		html.classList.remove( 'has-modal-nav-open' );
		openBtn.setAttribute( 'aria-expanded', 'false' );
		if ( releaseTrap ) { releaseTrap(); releaseTrap = null; }
		openBtn.focus();
	}

	openBtn.addEventListener( 'click', open );
	closeBtn.addEventListener( 'click', close );

	document.addEventListener( 'keydown', ( e ) => {
		if ( e.key === 'Escape' && html.classList.contains( 'has-modal-nav-open' ) ) close();
	} );

	document.addEventListener( 'click', ( e ) => {
		if (
			html.classList.contains( 'has-modal-nav-open' ) &&
			! e.target.closest( '#open-modal-nav' ) &&
			! e.target.closest( '.c-modal-nav-wrap' )
		) {
			close();
		}
	} );
}
